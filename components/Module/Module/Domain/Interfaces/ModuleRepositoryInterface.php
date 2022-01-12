<?php

namespace Components\Module\Module\Domain\Interfaces;

use App\Models\Addworking\Enterprise\Enterprise;

interface ModuleRepositoryInterface
{
    public function hasAccessToActivityReport(Enterprise $enterprise): bool;
}
