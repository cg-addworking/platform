<?php

namespace App\Policies\Spie\Enterprise;

use App\Models\Addworking\User\User;
use App\Models\Spie\Enterprise\Enterprise;
use Illuminate\Auth\Access\HandlesAuthorization;

class EnterprisePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Enterprise $enterprise)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Enterprise $enterprise)
    {
        return true;
    }

    public function delete(User $user, Enterprise $enterprise)
    {
        return true;
    }

    public function restore(User $user, Enterprise $enterprise)
    {
        return true;
    }

    public function forceDelete(User $user, Enterprise $enterprise)
    {
        return true;
    }
}
