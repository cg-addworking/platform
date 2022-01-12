<?php

namespace App\Policies\Addworking\Mission;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\User\User;
use App\Models\Addworking\Mission\PurchaseOrder;
use Illuminate\Auth\Access\HandlesAuthorization;

class PurchaseOrderPolicy
{
    use HandlesAuthorization;

    public function index(User $user, Enterprise $enterprise)
    {
        return $user->isSupport()
            || $user->hasRoleFor($enterprise, [User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY])
            && $user->hasAccessFor($enterprise, [User::ACCESS_TO_MISSION_PURCHASE_ORDER]);
    }

    public function view(User $user, PurchaseOrder $model)
    {
        return $user->isSupport()
            ||
            (
                $user->hasRoleFor($model->mission->customer, [User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY])
                &&
                $user->hasAccessFor($model->mission->customer, [User::ACCESS_TO_MISSION_PURCHASE_ORDER])
            )
            ||
            (
                $user->hasRoleFor($model->mission->vendor, [User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY])
                &&
                $user->hasAccessFor($model->mission->vendor, [User::ACCESS_TO_MISSION_PURCHASE_ORDER])
            );
    }

    public function create(User $user, Mission $model)
    {
        return $user->isSupport()
            || $user->hasRoleFor($model->customer, [User::IS_ADMIN, User::IS_OPERATOR])
            && $user->hasAccessFor($model->customer, [User::ACCESS_TO_MISSION_PURCHASE_ORDER]);
    }

    public function delete(User $user, PurchaseOrder $model)
    {
        return ($user->isSupport()
                || ($user->hasRoleFor($model->mission->customer, [User::IS_ADMIN, User::IS_OPERATOR])
                    && $user->hasAccessFor($model->mission->customer, [User::ACCESS_TO_MISSION_PURCHASE_ORDER]))
            ) && $model->isDraft();
    }

    public function send(User $user, PurchaseOrder $model)
    {
        return $user->isSupport()
            || $user->hasRoleFor($model->mission->customer, [User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY])
            && $user->hasAccessFor($model->mission->customer, [User::ACCESS_TO_MISSION_PURCHASE_ORDER]);
    }
}
