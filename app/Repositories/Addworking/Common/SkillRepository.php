<?php

namespace App\Repositories\Addworking\Common;

use App\Contracts\Models\Repository;
use App\Models\Addworking\Common\Job;
use App\Models\Addworking\Common\Skill;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

class SkillRepository extends BaseRepository
{
    protected $model = Skill::class;

    public function createFromRequest(Request $request, Enterprise $enterprise, Job $job): Skill
    {
        $name = str_slug($request->input('skill.display_name'));
        $skill = $this->make(@compact('name') + $request->input('skill'));
        $skill->job()->associate($job);
        $skill->save();

        return $skill;
    }

    public function updateFromRequest(Request $request, Enterprise $enterprise, Job $job, Skill $skill): Skill
    {
        $name = str_slug($request->input('skill.display_name'));
        $this->update($skill, @compact('name') + $request->input('skill'));

        return $skill;
    }
}
