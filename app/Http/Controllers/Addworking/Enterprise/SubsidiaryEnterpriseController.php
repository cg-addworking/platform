<?php

namespace App\Http\Controllers\Addworking\Enterprise;

use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Enterprise\Enterprise\StoreEnterpriseRequest;
use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\Department;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\EnterpriseActivity;
use App\Repositories\Addworking\Enterprise\EnterpriseRepository;
use Illuminate\Http\Request;

class SubsidiaryEnterpriseController extends Controller
{
    protected $repository;

    public function __construct(EnterpriseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Enterprise $enterprise)
    {
        $this->authorize('indexSubsidiaries', $enterprise);

        $items = $enterprise->children()->latest()->paginate(25);

        return view('addworking.enterprise.enterprise_subsidiaries.index', @compact('enterprise', 'items'));
    }

    public function create(Enterprise $enterprise)
    {
        $this->authorize('createSubsidiaries', $enterprise);

        $subsidiary = $this->repository->factory();

        return view('addworking.enterprise.enterprise_subsidiaries.create', @compact('enterprise', 'subsidiary'));
    }

    public function store(StoreEnterpriseRequest $request, Enterprise $enterprise)
    {
        $this->authorize('createSubsidiaries', $enterprise);

        $subsidiary = $this->repository->createSubsidiaryFromRequest($request, $enterprise);

        return redirect_when($subsidiary->exists, route('subsidiaries.index', @compact('enterprise')));
    }

    public function update(Request $request, Enterprise $enterprise, Enterprise $subsidiary)
    {
        abort(501); // Not Implemented
    }

    public function destroy(Enterprise $enterprise, Enterprise $subsidiary)
    {
        $this->authorize('destroySubsidiaries', [$enterprise, $subsidiary]);

        $saved = $subsidiary->parent()->dissociate()->save();

        return redirect_when($saved, route('subsidiaries.index', @compact('enterprise')));
    }
}
