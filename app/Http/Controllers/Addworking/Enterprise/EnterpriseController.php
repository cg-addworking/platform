<?php

namespace App\Http\Controllers\Addworking\Enterprise;

use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use App\Http\Controllers\Addworking\Common\AddressController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Enterprise\CreateVendorRequest;
use App\Http\Requests\Addworking\Enterprise\Enterprise\StoreEnterpriseRequest;
use App\Http\Requests\Addworking\Enterprise\UpdateEnterpriseRequest;
use App\Http\Requests\Addworking\SaveAddressRequest;
use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\Department;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\EnterpriseActivity;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Enterprise\EnterpriseRepository;
use Components\Contract\Contract\Domain\UseCases\CreateCps2;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use ZipArchive;

class EnterpriseController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(EnterpriseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $this->authorize('index', Enterprise::class);

        $items = $this->getPaginatorFromRequest($request, function ($query) use ($request) {
            $query->with('phoneNumbers')->ofNonSupportUser($request->user());
        });

        return view('addworking.enterprise.enterprise.index', @compact('items'));
    }

    public function create()
    {
        $this->authorize('create', Enterprise::class);

        $enterprise          = new Enterprise;
        $enterprise_activity = new EnterpriseActivity;
        $address             = new Address;
        $phone_number        = new PhoneNumber;

        if (app()->environment('local')) {
            $enterprise                       = factory(Enterprise::class)->make();
            $enterprise_activity              = factory(EnterpriseActivity::class)->make();
            $address                          = factory(Address::class)->make();
            $phone_number                     = factory(PhoneNumber::class)->make();
            $enterprise_activity->departments = Department::inRandomOrder()->take(3)->get();
        }

        $enterprise->activities   = new Collection([$enterprise_activity]);
        $enterprise->addresses    = new Collection([$address]);
        $enterprise->phoneNumbers = new Collection([$phone_number]);

        return view('addworking.enterprise.enterprise.create', @compact(
            'enterprise',
            'enterprise_activity',
            'address',
            'phone_number'
        ));
    }

    public function store(StoreEnterpriseRequest $request)
    {
        $enterprise = $this->repository->createFromRequest($request);

        return redirect_when($enterprise->exists, route('dashboard'));
    }

    public function show(Enterprise $enterprise)
    {
        $this->authorize('show', $enterprise);

        return view('addworking.enterprise.enterprise.show', @compact('enterprise'));
    }

    public function edit(Enterprise $enterprise)
    {
        $this->authorize('edit', $enterprise);

        return view('addworking.enterprise.enterprise.edit', @compact('enterprise'));
    }

    public function update(UpdateEnterpriseRequest $request, Enterprise $enterprise)
    {
        $this->authorize('edit', $enterprise);

        $saved = $this->repository->updateFromRequest($enterprise, $request);

        session()->flash('saved_enterprise', $enterprise);

        if (!$saved) {
            return redirect()->back()->with(error_status(__('enterprise.enterprise.not_saved')));
        }

        $status = success_status(__('enterprise.enterprise.saved', ['name' => $enterprise->name]));

        return $enterprise->activities()->count()
            ? redirect()->route('enterprise.show', $enterprise)->with($status)
            : redirect()->route('enterprise.activity.create', ['enterprise' => $enterprise->id])->with($status);
    }

    public function destroy(Enterprise $enterprise)
    {
        $this->authorize('destroy', $enterprise);

        $deleted = $enterprise->delete();

        return redirect()->back()->with(
            $deleted
                ? success_status(__('enterprise.enterprise.delete_ok'))
                : error_status(__('enterprise.enterprise.delete_nok'))
        );
    }

    public function downloadDocuments(Enterprise $enterprise)
    {
        $this->authorize('zip', $enterprise);

        return response()->download($this->repository->generateZipFromDocuments($enterprise));
    }

    protected function createVendor(CreateVendorRequest $request)
    {
        return User::create([
            'gender' => $request->input('gender'),
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'password' => Hash::make($password = str_random(8)),
        ]);
    }

    public function finder(Request $request)
    {
        if (! $request->ajax()) {
            abort(400, 'AJAX request only'); // Bad Request
        }

        $validated = $request->validate([
            'search' => "required|string|max:255",
            'filter' => "nullable|array",
        ]);

        $enterprises = Enterprise::query()
            ->where('name', 'like', strtoupper("%{$validated['search']}%"))
            ->when($validated['filter'] ?? null, fn($q, $filter) => $q->where($filter))
            ->pluck('name', 'id');

        return response()->json($enterprises);
    }

    public function createCps2(Enterprise $enterprise)
    {
        $this->authorize('createCps2', $enterprise);

        $contract = App::make(CreateCps2::class)->handle($enterprise);

        return $this->redirectWhen($contract->exists, $contract->routes->show);
    }
}
