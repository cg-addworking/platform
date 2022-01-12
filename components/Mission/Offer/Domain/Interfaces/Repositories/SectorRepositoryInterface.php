<?php

namespace Components\Mission\Offer\Domain\Interfaces\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\WorkField\Domain\Interfaces\Entities\SectorEntityInterface;

interface SectorRepositoryInterface
{
    public function belongsToConstructionSector(Enterprise $enterprise): bool;
    public function findByNumber(int $number): ?SectorEntityInterface;
}
