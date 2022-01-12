<?php

namespace App\Policies\Addworking\Mission;

use App\Models\Addworking\Mission\MissionTracking;
use App\Models\Addworking\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class MissionTrackingPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->isSupport()
            || $user->hasRoleFor($user->enterprise, [User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY])
            && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_MISSION]);
    }

    public function show(User $user, MissionTracking $model)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function store(User $user)
    {
        return true;
    }

    public function edit(User $user, MissionTracking $model)
    {
        return true;
    }

    public function update(User $user, MissionTracking $model)
    {
        return true;
    }

    public function destroy(User $user, MissionTracking $model)
    {
        return true;
    }

    public function restore(User $user, MissionTracking $model)
    {
        return true;
    }

    public function forceDelete(User $user, MissionTracking $model)
    {
        return true;
    }

    public function chooseNotification(User $user)
    {
        if (! $user->isSupport()) {
            return Response::deny("You cannot choose to send notifications if you aren't support");
        }
        
        return Response::allow();
    }
}
