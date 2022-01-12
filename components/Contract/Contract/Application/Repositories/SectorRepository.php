<?php

namespace Components\Contract\Contract\Application\Repositories;

use Components\Contract\Contract\Domain\Interfaces\Repositories\SectorRepositoryInterface;
use Components\Enterprise\WorkField\Application\Models\Sector;

class SectorRepository implements SectorRepositoryInterface
{
    public function entreprisesBelongsToConstructionSector($enterprises): bool
    {
        $construction_sector = Sector::where('name', 'construction')->first();

        foreach ($enterprises as $enterprise) {
            $enterprise_sectors = $enterprise->sectors()->get();

            if ($enterprise_sectors->contains($construction_sector)) {
                return true;
            }
        }

        return false;
    }
}
