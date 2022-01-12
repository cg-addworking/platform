<?php

namespace Components\Enterprise\Document\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\Document\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;

class EnterpriseRepository implements EnterpriseRepositoryInterface
{
    public function findBySiret(string $siret): ?Enterprise
    {
        return Enterprise::where('identification_number', $siret)->first();
    }
}
