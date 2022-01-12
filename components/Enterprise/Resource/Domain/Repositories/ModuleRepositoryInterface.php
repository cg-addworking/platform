<?php

namespace Components\Enterprise\Resource\Domain\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;

interface ModuleRepositoryInterface
{
    public function hasAccessToResource(Enterprise $enterprise): bool;
}
