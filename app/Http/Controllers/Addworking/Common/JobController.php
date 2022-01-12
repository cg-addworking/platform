<?php

namespace App\Http\Controllers\Addworking\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Common\Job\StoreJobRequest;
use App\Http\Requests\Addworking\Common\Job\UpdateJobRequest;
use App\Models\Addworking\Common\Job;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Common\JobRepository;
use Illuminate\Http\Request;

class JobController extends Controller
{
    protected $repository;

    public function __construct(JobRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request, Enterprise $enterprise)
    {
        $this->authorize('index', [Job::class, $enterprise]);

        $items = $this->repository
            ->list($request->input('search'), $request->input('filter'))
            ->ofEnterprise($enterprise)
            ->with('skills')
            ->latest()
            ->paginate(25);

        return view('addworking.common.job.index', @compact('enterprise', 'items'));
    }

    public function create(Enterprise $enterprise)
    {
        $this->authorize('create', [Job::class, $enterprise]);

        $job = $this->repository->make();
        $job->enterprise()->associate($enterprise);

        return view('addworking.common.job.create', @compact('enterprise', 'job'));
    }

    public function store(StoreJobRequest $request, Enterprise $enterprise)
    {
        $job = $this->repository->createFromRequest($request, $enterprise);

        return redirect_when($job->exists, route('addworking.common.enterprise.job.show', [$enterprise, $job]));
    }

    public function show(Enterprise $enterprise, Job $job)
    {
        $this->authorize('view', [$job, $enterprise]);

        return view('addworking.common.job.show', @compact('enterprise', 'job'));
    }

    public function edit(Enterprise $enterprise, Job $job)
    {
        $this->authorize('update', [$job, $enterprise]);

        return view('addworking.common.job.edit', @compact('enterprise', 'job'));
    }

    public function update(UpdateJobRequest $request, Enterprise $enterprise, Job $job)
    {
        $job = $this->repository->updateFromRequest($request, $enterprise, $job);

        return redirect_when($job->exists, route('addworking.common.enterprise.job.show', [$enterprise, $job]));
    }

    public function destroy(Enterprise $enterprise, Job $job)
    {
        $this->authorize('delete', [$job, $enterprise]);

        $deleted = $this->repository->delete($job);

        return redirect_when($deleted, route('addworking.common.enterprise.job.index', $enterprise));
    }
}
