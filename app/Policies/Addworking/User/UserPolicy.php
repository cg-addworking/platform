<?php

namespace App\Policies\Addworking\User;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Lab404\Impersonate\Services\ImpersonateManager;

class UserPolicy
{
    use HandlesAuthorization,
        ProfilePolicy;

    public function index(User $user)
    {
        return $user->isSupport()
            || $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_USER]);
    }

    public function seeCounters(User $user)
    {
        if (! $user->isSupport()) {
            return Response::deny("vous devez faire partie du support AddWorking");
        }

        return Response::allow();
    }

    public function show(User $user, User $model)
    {
        return $this->index($user);
    }

    public function create(User $user)
    {
        return $user->isSupport()
            || $user->hasRoleFor($user->enterprise, [User::IS_ADMIN, User::IS_OPERATOR])
            && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_USER]);
    }

    public function store(User $user)
    {
        return $this->create($user);
    }

    public function edit(User $user, User $model)
    {
        return $user->isSupport() || $user->is($model);
    }

    public function update(User $user, User $model)
    {
        return $this->edit($user, $model);
    }

    public function destroy(User $user, User $model)
    {
        return $user->is_system_superadmin || $user->is_system_admin;
    }

    public function impersonate(User $user, User $model)
    {
        return $user->isSupport();
    }

    public function debug(User $user)
    {
        return $user->isSupport() || $user->isImpersonated();
    }

    public function swapEnterprise(User $user, User $model, Enterprise $enterprise)
    {
        return ($user->isSupport() || $user->is($model))
            && $user->enterprises->contains($enterprise);
    }

    public function activate(User $user, User $model)
    {
        return $user->isSupport() && ! $model->is_active;
    }

    public function deactivate(User $user, User $model)
    {
        return $user->isSupport() && $model->is_active;
    }
}
