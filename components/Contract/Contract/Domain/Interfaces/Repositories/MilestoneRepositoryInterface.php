<?php

namespace Components\Contract\Contract\Domain\Interfaces\Repositories;

use Components\Mission\Mission\Application\Models\Mission;
use Illuminate\Support\Collection;

interface MilestoneRepositoryInterface
{
    public function createFromMission(Mission $mission): Collection;
}
