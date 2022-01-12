<?php

namespace Components\Billing\PaymentOrder\Application\Repositories;

use Components\Billing\PaymentOrder\Domain\Repositories\ModuleRepositoryInterface;
use App\Models\Addworking\Enterprise\Enterprise;

class ModuleRepository implements ModuleRepositoryInterface
{
    public function hasAccessToBilling(Enterprise $enterprise): bool
    {
        // TODO: Implement hasAccessToBilling() method when ACL project finished.
        return true;
    }
}
