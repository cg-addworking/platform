<?php

namespace App\Http\Controllers\Addworking\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Common\Skill\StoreSkillRequest;
use App\Http\Requests\Addworking\Common\Skill\UpdateSkillRequest;
use App\Models\Addworking\Common\Job;
use App\Models\Addworking\Common\Skill;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Common\SkillRepository;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    protected $repository;

    public function __construct(SkillRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request, Enterprise $enterprise, Job $job)
    {
        $this->authorize('index', [Skill::class, $job]);

        $items = $this->repository
            ->list($request->input('search'), $request->input('filter'))
            ->ofJob($job)
            ->latest()
            ->paginate(25);

        return view('addworking.common.skill.index', @compact('enterprise', 'job', 'items'));
    }

    public function create(Enterprise $enterprise, Job $job)
    {
        $this->authorize('create', [Skill::class, $job]);

        $skill = $this->repository->make();
        $skill->job()->associate($job);

        return view('addworking.common.skill.create', @compact('enterprise', 'job', 'skill'));
    }

    public function store(StoreSkillRequest $request, Enterprise $enterprise, Job $job)
    {
        $skill = $this->repository->createFromRequest($request, $enterprise, $job);

        return redirect_when(
            $skill->exists,
            route('addworking.common.enterprise.job.skill.show', [$enterprise, $job, $skill])
        );
    }

    public function show(Enterprise $enterprise, Job $job, Skill $skill)
    {
        $this->authorize('view', [$skill, $job]);

        return view('addworking.common.skill.show', @compact('enterprise', 'job', 'skill'));
    }

    public function edit(Enterprise $enterprise, Job $job, Skill $skill)
    {
        $this->authorize('update', [$skill, $job]);

        return view('addworking.common.skill.edit', @compact('enterprise', 'job', 'skill'));
    }

    public function update(UpdateSkillRequest $request, Enterprise $enterprise, Job $job, Skill $skill)
    {
        $skill = $this->repository->updateFromRequest($request, $enterprise, $job, $skill);

        return redirect_when(
            $skill->exists,
            route('addworking.common.enterprise.job.skill.show', [$enterprise, $job, $skill])
        );
    }

    public function destroy(Enterprise $enterprise, Job $job, Skill $skill)
    {
        $this->authorize('delete', [$skill, $job]);

        $deleted = $this->repository->delete($skill);

        return redirect_when($deleted, route('addworking.common.enterprise.job.skill.index', [$enterprise, $job]));
    }
}
