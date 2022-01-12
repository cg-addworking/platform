<?php

namespace Components\Billing\Outbound\Application\Repositories;

use Components\Billing\Outbound\Domain\Repositories\ModuleRepositoryInterface;
use App\Models\Addworking\Enterprise\Enterprise;

class ModuleRepository implements ModuleRepositoryInterface
{
    public function hasAccessToBilling(Enterprise $enterprise): bool
    {
        // TODO: Implement hasAccessToBilling() method when ACL project finished.
        return true;
    }
}
