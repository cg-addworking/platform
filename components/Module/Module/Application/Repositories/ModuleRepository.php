<?php

namespace Components\Module\Module\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Module\Module\Domain\Interfaces\ModuleRepositoryInterface;

class ModuleRepository implements ModuleRepositoryInterface
{
    public function hasAccessToActivityReport(Enterprise $enterprise): bool
    {
        // TODO: Implement hasAccessToBilling() method when ACL project finished.
        return true;
    }
}
