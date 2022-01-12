<?php

namespace Components\Enterprise\WorkField\Domain\Interfaces\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\WorkField\Domain\Interfaces\Entities\SectorEntityInterface;

interface SectorRepositoryInterface
{
    public function make($data = []): SectorEntityInterface;
    public function save(SectorEntityInterface $sector): SectorEntityInterface;
    public function findByNumber(int $number): ?SectorEntityInterface;
    public function belongsToConstructionSector(Enterprise $enterprise): bool;
    public function getAvailableSectors(): Array;
}
