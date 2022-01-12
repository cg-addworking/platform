<?php

namespace App\Policies\Everial\Mission;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PricePolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->isSupport()
            || ($user->hasRoleFor($user->enterprise, [User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY])
                && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_MISSION])
                && ($user->enterprise->isEverial() || $user->enterprise->isVendorOf(Enterprise::fromName('EVERIAL'))));
    }
}
