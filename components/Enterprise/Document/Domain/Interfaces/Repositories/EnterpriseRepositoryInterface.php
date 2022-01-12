<?php

namespace Components\Enterprise\Document\Domain\Interfaces\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;

interface EnterpriseRepositoryInterface
{
    public function findBySiret(string $siret): ?Enterprise;
}
