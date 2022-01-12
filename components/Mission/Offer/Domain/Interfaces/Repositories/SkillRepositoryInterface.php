<?php

namespace Components\Mission\Offer\Domain\Interfaces\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;

interface SkillRepositoryInterface
{
    public function getSkillsList(Enterprise $enterprise): array;
}
