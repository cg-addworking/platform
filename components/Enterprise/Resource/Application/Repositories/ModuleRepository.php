<?php

namespace Components\Enterprise\Resource\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\Resource\Domain\Repositories\ModuleRepositoryInterface;

class ModuleRepository implements ModuleRepositoryInterface
{
    public function hasAccessToResource(Enterprise $enterprise): bool
    {
        // TODO: Implement hasAccessToBilling() method when ACL project finished.
        return true;
    }
}
