<?php

namespace App\Policies\Addworking\Enterprise;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\EnterpriseActivity;
use App\Models\Addworking\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EnterpriseActivityPolicy
{
    use HandlesAuthorization;

    public function index(User $user, Enterprise $enterprise)
    {
        return $user->isSupport()
            || $user->hasRoleFor($enterprise, User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY)
            && $user->hasAccessFor($enterprise, User::ACCESS_TO_ENTERPRISE);
    }

    public function show(User $user, EnterpriseActivity $model)
    {
        return $this->index($user, $model->enterprise);
    }

    public function create(User $user, Enterprise $enterprise)
    {
        return $user->isSupport()
            || $user->hasRoleFor($enterprise, User::IS_ADMIN, User::IS_OPERATOR)
            && $user->hasAccessFor($enterprise, User::ACCESS_TO_ENTERPRISE);
    }

    public function store(User $user, Enterprise $enterprise)
    {
        return $this->create($user, $enterprise);
    }

    public function edit(User $user, EnterpriseActivity $model)
    {
        return $this->create($user, $model->enterprise);
    }

    public function update(User $user, EnterpriseActivity $model)
    {
        return $this->edit($user, $model);
    }

    public function destroy(User $user, EnterpriseActivity $model)
    {
        return $user->isSupport();
    }
}
