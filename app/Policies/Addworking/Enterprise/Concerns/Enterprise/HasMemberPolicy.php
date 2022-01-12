<?php

namespace App\Policies\Addworking\Enterprise\Concerns\Enterprise;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Illuminate\Auth\Access\Response;

trait HasMemberPolicy
{
    public function addMember(User $user, Enterprise $enterprise)
    {
        return $user->isSupport();
    }

    public function readMemberRoles(User $user, Enterprise $enterprise)
    {
        return $user->isSupport() || $user->isAdminFor($enterprise) || $user->isOperatorFor($enterprise);
    }

    public function readMemberAccess(User $user, Enterprise $enterprise)
    {
        return $user->isSupport() || $user->isAdminFor($enterprise);
    }

    public function editMember(User $user, Enterprise $enterprise)
    {
        return $user->isSupport() || $user->isAdminFor($enterprise);
    }

    public function removeMember(User $user, Enterprise $enterprise, User $deleteUser)
    {
        return !$deleteUser->isAdminFor($enterprise)
                && $enterprise->users()->count() > 1
                && ($user->isSupport() || $user->isAdminFor($enterprise));
    }

    public function indexMember(User $user, Enterprise $model)
    {
        if ($user->isSupport()) {
            return Response::allow();
        }

        if (! $user->enterprise->family()->contains($model)) {
            return Response::deny("you need to be in the family of {$model->name}");
        }

        return Response::allow();
    }

    public function showMember(User $user, Enterprise $model)
    {
        if (! $user->isSupport()) {
            return Response::allow();
        }
    }
}
