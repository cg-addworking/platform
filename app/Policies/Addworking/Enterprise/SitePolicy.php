<?php

namespace App\Policies\Addworking\Enterprise;

use App\Models\Addworking\Enterprise\Site;
use App\Models\Addworking\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SitePolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->isSupport()
            || ($user->hasRoleFor($user->enterprise, [User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY])
                && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_ENTERPRISE]));
    }

    public function show(User $user, Site $model)
    {
        return $this->index($user);
    }

    public function create(User $user)
    {
        return $user->isSupport()
            || ($user->hasRoleFor($user->enterprise, [User::IS_ADMIN, User::IS_OPERATOR])
                && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_ENTERPRISE]));
    }

    public function store(User $user)
    {
        return $this->create($user);
    }

    public function edit(User $user, Site $model)
    {
        return $this->create($user);
    }

    public function update(User $user, Site $model)
    {
        return $this->create($user);
    }

    public function destroy(User $user, site $model)
    {
        return $this->create($user);
    }

    public function removePhoneNumbers(User $user, site $model)
    {
        return $model->phoneNumbers->count() > 1 && $this->edit($user, $model);
    }
}
