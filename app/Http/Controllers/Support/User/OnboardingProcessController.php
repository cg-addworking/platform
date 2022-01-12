<?php

namespace App\Http\Controllers\Support\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\User\OnboardingProcess\StoreOnboardingProcessRequest;
use App\Models\Addworking\User\OnboardingProcess;
use App\Models\Addworking\User\OnboardingProcessCsvBuilder;
use App\Repositories\Addworking\User\OnboardingProcessRepository;
use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use Illuminate\Http\Request;

class OnboardingProcessController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(OnboardingProcessRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $this->authorize('index', OnboardingProcess::class);

        $items = $this->getPaginatorFromRequest($request, null);

        return view($this->views['index'] ?? 'addworking.user.onboarding_process.index', @compact('items'));
    }

    public function create()
    {
        $this->authorize('create', OnboardingProcess::class);

        $onboarding_process = $this->repository->factory();

        return view('addworking.user.onboarding_process.create', @compact('onboarding_process'));
    }

    public function store(StoreOnboardingProcessRequest $request)
    {
        $onboarding_process = $this->repository->createFromRequest($request);

        return redirect_when(
            (bool)$onboarding_process,
            route('support.user.onboarding_process.show', $onboarding_process)
        );
    }

    public function show(OnboardingProcess $onboarding_process)
    {
        $this->authorize('show', $onboarding_process);

        return view('addworking.user.onboarding_process.show', @compact('onboarding_process'));
    }

    public function edit(OnboardingProcess $onboarding_process)
    {
        $this->authorize('edit', $onboarding_process);

        return view('addworking.user.onboarding_process.edit', @compact('onboarding_process'));
    }

    public function update(Request $request, OnboardingProcess $onboarding_process)
    {
        $this->authorize('update', $onboarding_process);

        $request->validate([
            'onboarding_process.id'            => "required|uuid|exists:addworking_user_onboarding_processes,id",
            'onboarding_process.user'          => "required|uuid|exists:addworking_user_users,id",
            'onboarding_process.enterprise'    => "required|uuid|exists:addworking_enterprise_enterprises,id",
            'onboarding_process.complete'      => "required|numeric",
            'onboarding_process.current_step'      => "required|numeric",
        ]);

        $saved = $onboarding_process
            ->fill($request->input('onboarding_process'))
            ->save();

        return redirect_when($saved, route('support.user.onboarding_process.show', $onboarding_process));
    }

    public function destroy(OnboardingProcess $onboarding_process)
    {
        $this->authorize('destroy', $onboarding_process);

        $deleted = $onboarding_process->delete();

        return redirect_when($deleted, route('support.user.onboarding_process.index'));
    }

    public function export(Request $request, OnboardingProcessCsvBuilder $builder)
    {
        $items = $this->repository->list($request->input('search'), $request->input('filter'))->cursor();

        return $builder->addAll($items)->download();
    }
}
