<?php

namespace App\Policies\Addworking\Enterprise\Concerns\Enterprise;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Illuminate\Auth\Access\Response;

trait HasReferentPolicy
{
    public function assignVendors(User $user, Enterprise $enterprise)
    {
        if ($user->isSupport()) {
            return Response::allow();
        }

        if (! $enterprise->isCustomer()) {
            return Response::deny('only customers can assign vendors');
        }

        return Response::allow();
    }

    public function seeMyVendors(User $user, Enterprise $enterprise)
    {
        if ($user->isSupport()) {
            return Response::deny('Support do not need to see this switch');
        }

        if (! $enterprise->isCustomer()) {
            return Response::deny('only customers can see their vendors');
        }

        if (! $user->referentVendorsOf($enterprise)->exists()) {
            return Response::deny('the referent do not have any assigned vendors');
        }

        return Response::allow();
    }
}
