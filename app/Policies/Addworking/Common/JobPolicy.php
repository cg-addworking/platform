<?php

namespace App\Policies\Addworking\Common;

use App\Models\Addworking\Common\Job;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobPolicy
{
    use HandlesAuthorization;

    public function index(User $user, Enterprise $enterprise)
    {
        return $user->isSupport()
        || $enterprise->isCustomer();
    }

    public function create(User $user, Enterprise $enterprise)
    {
        return true;
    }

    public function view(User $user, Job $job)
    {
        return true;
    }

    public function update(User $user, Job $job)
    {
        return true;
    }

    public function delete(User $user, Job $job)
    {
        return true;
    }

    public function restore(User $user, Job $job)
    {
        return true;
    }

    public function forceDelete(User $user, Job $job)
    {
        return true;
    }
}
