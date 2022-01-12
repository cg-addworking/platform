<?php

namespace App\Policies\Addworking\User;

use App\Models\Addworking\User\User;
use App\Models\Addworking\User\UserLog;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserLogPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list the user log
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->isSupport();
    }

    /**
     * Determine whether the user can export the user log
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @return mixed
     */
    public function export(User $user)
    {
        return $user->isSupport();
    }
}
