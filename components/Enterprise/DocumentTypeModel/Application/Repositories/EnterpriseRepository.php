<?php

namespace Components\Enterprise\DocumentTypeModel\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\DocumentTypeModel\Domain\RepositoriesInterface\EnterpriseRepositoryInterface;

class EnterpriseRepository implements EnterpriseRepositoryInterface
{
    public function make()
    {
        return new Enterprise;
    }

    public function findBySiret(string $siret)
    {
        return Enterprise::where('identification_number', $siret)->first();
    }
}
