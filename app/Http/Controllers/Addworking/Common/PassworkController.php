<?php

namespace App\Http\Controllers\Addworking\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Common\Passwork\StorePassworkRequest;
use App\Http\Requests\Addworking\Common\Passwork\UpdatePassworkRequest;
use App\Models\Addworking\Common\Job;
use App\Models\Addworking\Common\Passwork;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Common\PassworkRepository;
use Illuminate\Http\Request;

class PassworkController extends Controller
{
    protected $repository;

    public function __construct(PassworkRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request, Enterprise $enterprise)
    {
        $this->authorize('index', [Passwork::class, $enterprise]);

        $items = $this->repository
            ->list($request->input('search'), $request->input('filter'))
            ->when($enterprise->isVendor(), function ($q) use ($enterprise) {
                $q->ofVendor($enterprise);
            })
            ->when($enterprise->isCustomer(), function ($q) use ($enterprise) {
                $q->ofCustomer($enterprise);
            })
            ->latest()
            ->paginate(25);

        return view('addworking.common.passwork.index', compact('enterprise', 'items'));
    }

    public function create(Request $request, Enterprise $enterprise)
    {
        $this->authorize('create', [Passwork::class, $enterprise]);

        if ($enterprise->passworks->count() == 0 && $enterprise->customers->count() == 1) {
            $request->request->add(['customer' => ['id' =>  $enterprise->customers->first()->id]]);
            $passwork = $this->repository->createFromRequest($request, $enterprise);

            return redirect_when(
                $passwork->exists,
                route('addworking.common.enterprise.passwork.edit', [$enterprise, $passwork])
            );
        }

        $passwork = $this->repository->make()->passworkable()->associate($enterprise);

        return view('addworking.common.passwork.create', compact('enterprise', 'passwork'));
    }

    public function store(StorePassworkRequest $request, Enterprise $enterprise)
    {
        $this->authorize('create', [Passwork::class, $enterprise]);

        $passwork = $this->repository->createFromRequest($request, $enterprise);

        return redirect_when(
            $passwork->exists,
            route('addworking.common.enterprise.passwork.edit', [$enterprise, $passwork])
        );
    }

    public function show(Enterprise $enterprise, Passwork $passwork)
    {
        $this->authorize('view', [$passwork, $enterprise]);

        return view('addworking.common.passwork.show', compact('enterprise', 'passwork'));
    }

    public function edit(Enterprise $enterprise, Passwork $passwork)
    {
        $this->authorize('update', [$passwork, $enterprise]);

        $jobs = $passwork->customer->ancestors(true)->jobs()->get();

        return view('addworking.common.passwork.edit', compact('enterprise', 'passwork', 'jobs'));
    }

    public function update(UpdatePassworkRequest $request, Enterprise $enterprise, Passwork $passwork)
    {
        $passwork = $this->repository->updateFromRequest($request, $enterprise, $passwork);

        $route = $request->user()->onboardingProcesses->first()->complete ?
            'addworking.common.enterprise.passwork.show' :
            'dashboard';

        return redirect_when(
            $passwork->exists,
            route($route, [$enterprise, $passwork])
        );
    }

    public function destroy(Enterprise $enterprise, Passwork $passwork)
    {
        $this->authorize('delete', [$passwork, $enterprise]);

        $deleted = $this->repository->delete($passwork);

        return redirect_when($deleted, route('addworking.common.enterprise.passwork.index', $enterprise));
    }
}
