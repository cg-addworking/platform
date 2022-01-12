<?php

namespace App\Policies\Addworking\Common;

use App\Models\Addworking\Common\Job;
use App\Models\Addworking\Common\Skill;
use App\Models\Addworking\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SkillPolicy
{
    use HandlesAuthorization;

    public function index(User $user, Job $job)
    {
        return true;
    }

    public function create(User $user, Job $job)
    {
        return true;
    }

    public function view(User $user, Skill $skill)
    {
        return true;
    }

    public function update(User $user, Skill $skill)
    {
        return true;
    }

    public function delete(User $user, Skill $skill)
    {
        return true;
    }

    public function restore(User $user, Skill $skill)
    {
        return true;
    }

    public function forceDelete(User $user, Skill $skill)
    {
        return true;
    }
}
