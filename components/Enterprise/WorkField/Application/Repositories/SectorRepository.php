<?php

namespace Components\Enterprise\WorkField\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\WorkField\Application\Models\Sector;
use Components\Enterprise\WorkField\Domain\Exceptions\SectorCreationFailedException;
use Components\Enterprise\WorkField\Domain\Interfaces\Entities\SectorEntityInterface;
use Components\Enterprise\WorkField\Domain\Interfaces\Repositories\SectorRepositoryInterface;

class SectorRepository implements SectorRepositoryInterface
{
    public function make($data = []): SectorEntityInterface
    {
        return new Sector($data);
    }

    public function save(SectorEntityInterface $sector): SectorEntityInterface
    {
        try {
            $sector->save();
        } catch (SectorCreationFailedException $exception) {
            throw $exception;
        }

        $sector->refresh();

        return $sector;
    }

    public function findByNumber(int $number): ?SectorEntityInterface
    {
        return Sector::where('number', $number)->first();
    }

    public function belongsToConstructionSector(Enterprise $enterprise): bool
    {
        $construction_sector = Sector::where('name', 'construction')->first();

        $enterprise_sectors = $enterprise->sectors()->get();

        return $enterprise_sectors->contains($construction_sector);
    }

    public function getAvailableSectors(): Array
    {
        return Sector::pluck('display_name', 'id')->toArray();
    }
}
