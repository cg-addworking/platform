<?php

namespace App\Policies\Addworking\Enterprise\Concerns\Enterprise;

use App\Models\Addworking\User\User;
use App\Models\Addworking\Enterprise\Enterprise;

trait HasVendorPolicy
{
    public function viewAnyVendor(User $user, Enterprise $enterprise)
    {
        return $user->isSupport()
            || ($user->hasRoleFor($enterprise, [User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY])
                && $user->hasAccessFor($enterprise, [User::ACCESS_TO_ENTERPRISE])
                && $enterprise->isCustomer());
    }

    public function exportVendor(User $user, Enterprise $enterprise)
    {
        return $user->isSupport()
            || ($user->hasRoleFor($enterprise, [User::IS_ADMIN, User::IS_OPERATOR])
                && $user->hasAccessFor($enterprise, [User::ACCESS_TO_ENTERPRISE])
                && $enterprise->isCustomer());
    }

    public function importVendor(User $user, Enterprise $enterprise)
    {
        return $enterprise->isCustomer() && $user->isSupport();
    }

    public function detachVendor(User $user, Enterprise $enterprise)
    {
        return $user->isSupport()
            || ($user->hasRoleFor($enterprise, [User::IS_ADMIN])
                && $user->hasAccessFor($enterprise, [User::ACCESS_TO_ENTERPRISE])
                && $enterprise->isCustomer());
    }

    public function attachVendor(User $user, Enterprise $enterprise)
    {
        return $user->isSupport();
    }

    public function storeAttachVendor(User $user, Enterprise $enterprise)
    {
        return $this->attachVendor($user, $enterprise);
    }

    public function viewAnyBillingDeadlineVendor(User $user, Enterprise $enterprise, Enterprise $vendor)
    {
        return $user->isSupport();
    }

    public function editBillingDeadlineVendor(User $user, Enterprise $enterprise, Enterprise $vendor)
    {
        return $this->viewAnyBillingDeadlineVendor($user, $enterprise, $vendor);
    }

    public function updateBillingDeadlineVendor(User $user, Enterprise $enterprise, Enterprise $vendor)
    {
        return $this->viewAnyBillingDeadlineVendor($user, $enterprise, $vendor);
    }
}
