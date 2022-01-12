<?php

namespace Components\Contract\Contract\Application\Policies;

use App\Models\Addworking\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CaptureInvoicePolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        if (! $user->hasAccessFor($user->enterprise, User::ACCESS_TO_CONTRACT)) {
            return Response::deny("You don't have acces to contract");
        }

        if (! $user->hasRoleFor($user->enterprise, User::ROLE_ACCOUNTING_MONITORING)) {
            return Response::deny("You don't have a role for read this informations");
        }

        return Response::allow();
    }

    public function delete(User $user)
    {
        if (! $user->hasAccessFor($user->enterprise, User::ACCESS_TO_CONTRACT)) {
            return Response::deny("You don't have acces to contract");
        }

        if (! $user->hasRoleFor($user->enterprise, User::ROLE_ACCOUNTING_MONITORING)) {
            return Response::deny("You don't have a role for read this informations");
        }

        return Response::allow();
    }

    public function edit(User $user)
    {
        if (! $user->hasAccessFor($user->enterprise, User::ACCESS_TO_CONTRACT)) {
            return Response::deny("You don't have acces to contract");
        }

        if (! $user->hasRoleFor($user->enterprise, User::ROLE_ACCOUNTING_MONITORING)) {
            return Response::deny("You don't have a role for read this informations");
        }

        return Response::allow();
    }
}
