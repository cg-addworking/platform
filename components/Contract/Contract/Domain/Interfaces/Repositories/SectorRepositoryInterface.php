<?php

namespace Components\Contract\Contract\Domain\Interfaces\Repositories;

interface SectorRepositoryInterface
{
    public function entreprisesBelongsToConstructionSector($enterprises): bool;
}
