<?php

namespace Components\Mission\Offer\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\WorkField\Application\Models\Sector;
use Components\Enterprise\WorkField\Domain\Interfaces\Entities\SectorEntityInterface;

use Components\Mission\Offer\Domain\Interfaces\Repositories\SectorRepositoryInterface;

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

    public function hasCustomerInConstructionSector(Enterprise $vendor)
    {
        $construction_sector = Sector::where('name', 'construction')->first();

        foreach ($vendor->customers()->get() as $customer) {
            $sectors = $customer->sectors()->get();
            if ($sectors->count() > 0 && $sectors->contains($construction_sector)) {
                return true;
            }
        }

        return false;
    }
}
