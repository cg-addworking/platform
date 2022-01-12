<?php

namespace Components\Mission\Mission\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\WorkField\Application\Models\Sector;
use Components\Enterprise\WorkField\Domain\Interfaces\Entities\SectorEntityInterface;
use Components\Mission\Mission\Domain\Interfaces\Repositories\SectorRepositoryInterface;

class SectorRepository implements SectorRepositoryInterface
{
    public function belongsToConstructionSector(Enterprise $enterprise): bool
    {
        $construction_sector = Sector::where('name', 'construction')->first();

        $enterprise_sectors = $enterprise->sectors()->get();

        return $enterprise_sectors->contains($construction_sector);
    }

    public function findByNumber(int $number): ?SectorEntityInterface
    {
        return Sector::where('number', $number)->first();
    }
}
