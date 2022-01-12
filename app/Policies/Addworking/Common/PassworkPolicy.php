<?php

namespace App\Policies\Addworking\Common;

use App\Models\Addworking\Common\Passwork;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PassworkPolicy
{
    use HandlesAuthorization;

    public function index(User $user, Enterprise $enterprise)
    {
        if ($user->isSupport()) {
            return Response::allow();
        }

        if (! $enterprise->isVendor()) {
            return Response::deny("You cannot access passworks because your enterprise is not vendor");
        }

        if (! $enterprise->customers()->exists()) {
            return Response::deny("You cannot access passworks because you have no customers");
        }

        return Response::allow();
    }

    public function create(User $user, Enterprise $enterprise)
    {
        $parent = $this->index($user, $enterprise);

        if (! $parent->allowed()) {
            return $parent;
        }

        if (! $user->isAdminFor($enterprise)) {
            return Response::deny("You cannot create a passwork because you are not admin of {$enterprise->name}");
        }

        return Response::allow();
    }

    public function view(User $user, Passwork $passwork)
    {
        if ($user->isSupport()) {
            return Response::allow();
        }

        $passworkable = $passwork->passworkable;

        if (is_null($passworkable)) {
            return Response::deny("This passwork is not associated to anything");
        }

        if ($passworkable instanceof User && $passworkable->is($user)) {
            return Response::allow();
        }

        if ($passworkable instanceof Enterprise && $user->enterprise->isCustomerOf($passworkable)) {
            return Response::allow();
        }

        if ($passworkable instanceof Enterprise && $user->isAdminFor($passworkable)) {
            return Response::allow();
        }

        return Response::deny("You are not allowed to view this passwork");
    }

    public function update(User $user, Passwork $passwork)
    {
        if ($user->isSupport()) {
            return Response::allow();
        }

        $passworkable = $passwork->passworkable;

        if (is_null($passworkable)) {
            return Response::deny("This passwork is not associated to anything");
        }

        if ($passworkable instanceof User && $passworkable->is($user)) {
            return Response::allow();
        }

        if ($passworkable instanceof Enterprise && $user->isAdminFor($passworkable)) {
            return Response::allow();
        }

        return Response::deny("You are not allowed to update this passwork");
    }

    public function delete(User $user, Passwork $passwork)
    {
        return $this->update($user, $passwork);
    }

    public function restore(User $user, Passwork $passwork)
    {
        return $user->isSupport();
    }

    public function forceDelete(User $user, Passwork $passwork)
    {
        return $user->isSupport();
    }
}
