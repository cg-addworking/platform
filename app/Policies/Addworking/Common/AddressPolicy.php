<?php

namespace App\Policies\Addworking\Common;

use App\Models\Addworking\User\User;
use App\Models\Addworking\Common\Address;
use Illuminate\Auth\Access\HandlesAuthorization;

class AddressPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return true;
    }

    public function show(User $user, Address $model)
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

    public function edit(User $user, Address $model)
    {
        return true;
    }

    public function destroy(User $user, Address $model)
    {
        return true;
    }

    public function detach(User $user, Address $model)
    {
        return $user->isSupport();
    }
}
