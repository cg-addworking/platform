<?php

namespace App\Http\Controllers\Addworking\Enterprise;

use Components\Enterprise\Enterprise\Application\Jobs\VendorsCsvBuilderJob;
use Components\Enterprise\InvoiceParameter\Application\Models\CustomerBillingDeadline;
use Components\Infrastructure\Export\Application\Repositories\ExportRepository;
use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use App\Http\Controllers\Controller;
use App\Jobs\Addworking\Enterprise\ImportVendorsJob;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Common\Skill;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Notifications\Addworking\Enterprise\VendorDetachedNotification;
use App\Repositories\Addworking\Enterprise\FamilyEnterpriseRepository;
use App\Repositories\Addworking\Enterprise\VendorRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Webpatser\Uuid\Uuid;

class VendorController extends Controller
{
    use HandlesIndex;

    protected $repository;
    protected $familyEnterpriseRepository;
    protected $exportRepository;

    public function __construct(
        VendorRepository $repository,
        FamilyEnterpriseRepository $familyEnterpriseRepository,
        ExportRepository $exportRepository
    ) {
        $this->repository = $repository;
        $this->familyEnterpriseRepository = $familyEnterpriseRepository;
        $this->exportRepository = $exportRepository;
    }

    public function index(Request $request, Enterprise $enterprise)
    {
        $this->authorize('viewAnyVendor', $enterprise);

        $items = $this->getPaginatorFromRequest($request, function ($query) use ($enterprise, $request) {
            return $query->whereIsVendor()->vendorOf($enterprise)
                ->when($request->has('show-my-vendors'), function ($query) use ($enterprise) {
                    $query->ofReferent($enterprise->id, Auth::user()->id);
                })
                ->when(! $request->has('sort-by'), function ($query) {
                    $query->orderBy('name', 'ASC');
                });
        });

        return view('addworking.enterprise.vendor.index', @compact('enterprise', 'items'));
    }

    public function indexDivisionBySkills(Enterprise $enterprise)
    {
        $enterprise_family = $this->familyEnterpriseRepository->getAncestors($enterprise, true)->pluck('id');

        $items = Skill::whereHas('job', function ($query) use ($enterprise_family) {
            return $query->whereHas('enterprise', function ($query) use ($enterprise_family) {
                return $query->whereIn('id', $enterprise_family);
            });
        })->paginate(25);

        return view('addworking.enterprise.vendor.index_division_by_skills', @compact('enterprise', 'items'));
    }

    public function attach(Request $request, Enterprise $enterprise)
    {
        $this->authorize('attachVendor', $enterprise);

        $vendors = Enterprise::where('is_vendor', true)
            ->whereNotIn('id', $enterprise->vendors->pluck('id'))
            ->orderBy('name', 'asc')
            ->pluck('name', 'id');

        return view('addworking.enterprise.vendor.attach', @compact('vendors', 'enterprise'));
    }

    public function storeAttach(Request $request, Enterprise $enterprise)
    {
        $this->authorize('storeAttachVendor', $enterprise);

        $request->validate([
            'vendor.id'     => "required|array",
        ]);

        $enterprise->vendors()->syncWithoutDetaching($request->input('vendor.id'));

        foreach ($request->input('vendor.id') as $id) {
            $vendor = Enterprise::find($id);
            $enterprise->vendors()
                ->updateExistingPivot($id, [
                    'activity_starts_at' => Carbon::now(),
                    'updated_by' => $request->user()->id
                ]);
            // add billing deadlines by default
            $deadlines_by_default = CustomerBillingDeadline::whereHas('enterprise', function ($q) use ($enterprise) {
                $q->where('id', $enterprise->id);
            })->get();

            foreach ($deadlines_by_default as $deadline_by_default) {
                //attach $deadline_by_default to $vendor
                $vendor->authorizedDeadlineForVendor()->attach(
                    $deadline_by_default->getDeadline(),
                    ['customer_id' => $enterprise->id]
                );
            }
        }
        return redirect_when($enterprise->exists, route('enterprise.show', $enterprise));
    }

    public function export(Request $request, Enterprise $enterprise)
    {
        $this->authorize('exportVendor', $enterprise);

        $export = $this->exportRepository->create(
            $request->user(),
            "export_vendors_".Carbon::now()->format('Ymd_His'),
            $request->input('filter') ?? []
        );

        VendorsCsvBuilderJob::dispatch(
            $export,
            $enterprise
        );

        return redirect()->back()->with(success_status(
            __('common.infrastructure.export.application.views.export.build_csv.csv_is_building')
        ));
    }

    public function import(Enterprise $enterprise)
    {
        $this->authorize('importVendor', $enterprise);

        return view('addworking.enterprise.vendor.import', compact('enterprise'));
    }

    public function detach(Request $request, Enterprise $enterprise, Enterprise $vendor)
    {
        $this->authorize('detachVendor', $enterprise);

        $pivot = $enterprise->vendors->only(['id' => $vendor->id])->first()->pivot;

        $removed = $enterprise->vendors()->detach($vendor);

        if ($removed) {
            DB::table('addworking_enterprise_enterprises_deleted_partners')->insert([
                'id' => (string) Uuid::generate(4),
                'customer_id' => $pivot->customer_id,
                'vendor_id' => $pivot->vendor_id,
                'activity_starts_at' => $pivot->activity_starts_at,
                'activity_ends_at' => Carbon::now(),
                'deleted_at' => Carbon::now(),
                'deleted_by' => $request->user()->id,
                'created_at' => $pivot->created_at,
                'updated_at' => $pivot->updated_at,
            ]);
            Notification::route('mail', 'support@addworking.com')
                ->notify(new VendorDetachedNotification($vendor, Auth::user(), $enterprise));
        }

        return redirect()->back()->with(
            $removed
                ? success_status(__('enterprise.enterprise_vendors.remove_relationship_success'))
                : error_status(__('enterprise.enterprise_vendors.remove_relationship_failed'))
        );
    }

    public function load(Enterprise $enterprise, Request $request)
    {
        $this->authorize('importVendor', $enterprise);

        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:4000|min:1',
        ]);

        ImportVendorsJob::dispatch(File::from($request->file('file'))->saveAndGet(), $enterprise);

        return redirect($enterprise->routes->show)->with(success_status('import en cours'));
    }

    public function editPartnership(Enterprise $enterprise, Enterprise $vendor)
    {
        $this->authorize('viewAnyVendor', $enterprise);
        $partnership = $enterprise->vendors()->wherePivot('vendor_id', $vendor->id)->first()->pivot;

        return view(
            'addworking.enterprise.vendor.partnership.edit',
            @compact('vendor', 'enterprise', 'partnership')
        );
    }

    public function updatePartnership(Enterprise $enterprise, Enterprise $vendor, Request $request)
    {
        $this->authorize('viewAnyVendor', $enterprise);
        $updated = $enterprise->vendors()
            ->updateExistingPivot(
                $vendor->id,
                $request->input('partnership') + ['updated_by' => $request->user()->id]
            );

        return redirect_when($updated, route('addworking.enterprise.vendor.index', $enterprise));
    }
}
