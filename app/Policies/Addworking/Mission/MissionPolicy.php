<?php

namespace App\Policies\Addworking\Mission;

use App\Models\Addworking\User\User;
use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Auth\Access\HandlesAuthorization;

class MissionPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->isSupport()
            || $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_MISSION]);
    }

    public function show(User $user, Mission $model)
    {
        return $user->isSupport()
            || $user->hasRoleFor($model->vendor, [User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY])
            && $user->hasAccessFor($model->vendor, [User::ACCESS_TO_MISSION])
            || $user->hasRoleFor($model->customer, [User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY])
            && $user->hasAccessFor($model->customer, [User::ACCESS_TO_MISSION]);
    }

    public function create(User $user)
    {
        return $user->isSupport();
    }

    public function update(User $user, Mission $model)
    {
        return $user->isSupport()
            || $user->hasRoleFor($model->customer, [User::IS_ADMIN, User::IS_OPERATOR])
            && $user->hasAccessFor($model->customer, [User::ACCESS_TO_MISSION]);
    }

    public function destroy(User $user, Mission $model)
    {
        return $this->update($user, $model);
    }

    public function close(User $user, Mission $model)
    {
        return $this->update($user, $model)
            || $user->hasRoleFor($model->vendor, [User::IS_ADMIN, User::IS_OPERATOR])
            && $user->hasAccessFor($model->vendor, [User::ACCESS_TO_MISSION]);
    }

    public function linkMissionToContract(User $user, Mission $model)
    {
        return
            is_null($model->contract()->first()) &&
            (
                $user->isSupport()
                || $user->hasRoleFor($model->customer, [User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY])
                && $user->hasAccessFor($model->customer, [User::ACCESS_TO_MISSION])
            );
    }
}
