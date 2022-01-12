<?php

namespace App\Http\Controllers\Addworking\Mission;

use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Mission\Mission\StoreMissionRequest;
use App\Http\Requests\Addworking\Mission\UpdateMissionNoteRequest;
use App\Models\Addworking\Billing\InboundInvoiceItem;
use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Milestone;
use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\Mission\MissionTracking;
use App\Repositories\Addworking\Mission\MilestoneRepository;
use App\Repositories\Addworking\Mission\MissionRepository;
use Carbon\Carbon;
use Components\Billing\Outbound\Application\Models\OutboundInvoiceItem;
use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MissionController extends Controller
{
    use HandlesIndex;

    protected $views = [];

    protected $redirects = [];

    protected $repository;

    protected $milestone;

    public function __construct(MissionRepository $repository, MilestoneRepository $milestone)
    {
        $this->repository = $repository;
        $this->milestone = $milestone;
    }

    public function index(Request $request)
    {
        $this->authorize('index', Mission::class);

        $enterprise = $request->user()->enterprise;

        switch (true) {
            case $enterprise->isHybrid() && !$request->user()->isSupport():
                $items = $this->getPaginatorFromRequest($request, function ($query) use ($enterprise) {
                    $query->ofEnterprise($enterprise);
                });
                break;
            case $enterprise->isVendor() && !$request->user()->isSupport():
                $items = $this->getPaginatorFromRequest($request, function ($query) use ($enterprise) {
                    $query->ofVendor($enterprise);
                });
                break;
            case $enterprise->isCustomer() && !$request->user()->isSupport():
                $items = $this->getPaginatorFromRequest($request, function ($query) use ($enterprise) {
                    $query->ofCustomer($enterprise);
                });
                break;
            default:
                $items = $this->getPaginatorFromRequest($request);
                break;
        }

        return view($this->views['index'] ?? 'addworking.mission.mission.index', @compact('items'));
    }

    public function create()
    {
        $this->authorize('create', Mission::class);

        $mission = new Mission();

        if (app()->environment('local')) {
            $mission = factory(Mission::class)->make();
        }

        $vendors   = $this->repository->getAvailableVendors(auth()->user())->pluck('name', 'id');
        $customers = $this->repository->getAvailableCustomers(auth()->user())->pluck('name', 'id');

        return view(
            $this->views['create'] ?? 'addworking.mission.mission.create',
            @compact('mission', 'vendors', 'customers')
        );
    }

    public function store(StoreMissionRequest $request)
    {
        $mission = $this->repository->createFromRequest($request);

        return redirect_when($mission->exists, route($this->redirects['store'] ?? 'mission.show', $mission));
    }

    public function show(Mission $mission)
    {
        $this->authorize('show', $mission);

        if (! is_null($mission->getWorkField())) {
            return redirect()
                ->route('sector.mission.show', $mission);
        }

        return view($this->views['show'] ?? 'addworking.mission.mission.show', @compact('mission'));
    }

    public function edit(Mission $mission)
    {
        $this->authorize('update', $mission);

        return view($this->views['edit'] ?? 'addworking.mission.mission.edit', @compact('mission'));
    }

    public function update(Request $request, Mission $mission)
    {
        $this->authorize('update', $mission);

        $mission->fill($request->input('mission'));

        $saved = $this->saveMissionData($request, $mission);

        return $saved
            ? redirect()
                ->route($this->redirects['update'] ?? 'mission.show', $mission)
                ->with(success_status('Mission enregistrée avec succès'))
            : redirect()
                ->back()
                ->with(error_status());
    }

    public function destroy(Mission $mission)
    {
        $this->authorize('destroy', $mission);

        $deleted = $mission->delete();

        return $deleted
            ? redirect()
                ->route($this->redirects['destroy'] ?? 'mission.index')
                ->with(success_status("Mission {$mission} supprimée avec succès"))
            : redirect()
                ->back()
                ->with(error_status());
    }

    public function createMilestoneType(Mission $mission)
    {
        $this->authorize('update', $mission);

        return view('addworking.mission.mission.create_milestone_type', @compact('mission'));
    }

    public function storeMilestoneType(Request $request, Mission $mission)
    {
        $this->authorize('update', $mission);

        $this->validate($request, [
            'mission.starts_at'      => 'required|date',
            'mission.ends_at'        => 'required_if:mission.milestone_type,end_of_mission',
            'mission.milestone_type' => 'required',
        ]);

        $mission->fill($request->input('mission'));
        $mission->save();

        $this->milestone->createFromMission($mission);

        return redirect_when($mission->exists, route('mission.show', $mission));
    }

    public function close(Request $request, Mission $mission)
    {
        $this->authorize('close', $mission);

        $closed = $this->repository->close($mission, $request->user());

        return $this->redirectWhen($closed, (new MissionTracking)->routes->create(compact('mission')));
    }

    public function note(UpdateMissionNoteRequest $request, Mission $mission)
    {
        $saved = $mission->update([
            'note' => $request->input('mission.note'),
        ]);

        return redirect()
            ->back()
            ->with($saved ? success_status("Mission '{$mission->label}' mis a jour avec succès") : error_status());
    }

    protected function saveMissionData(Request $request, Mission $mission)
    {
        if ($request->input('inbound_invoice_item.id')) {
            $item = InboundInvoiceItem::findOrFail($request->input('inbound_invoice_item.id'));
            $mission->inboundInvoiceItem()->associate($item);
        }

        if ($request->input('outbound_invoice_item.id')) {
            $item = OutboundInvoiceItem::findOrFail($request->input('outbound_invoice_item.id'));
            $mission->outboundInvoiceItem()->associate($item);
        }

        if ($request->input('contract.id')) {
            $contract = Contract::findOrFail($request->input('contract.id'));
            $mission->contract()->associate($contract);
        }

        if ($request->input('vendor.id')) {
            $enterprise = Enterprise::findOrFail($request->input('vendor.id'));
            $mission->vendor()->associate($enterprise);
        }

        if ($request->input('customer.id')) {
            $enterprise = Enterprise::findOrFail($request->input('customer.id'));
            $mission->customer()->associate($enterprise);
        }

        return $mission->save();
    }
}
