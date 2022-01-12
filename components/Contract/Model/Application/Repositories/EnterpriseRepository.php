<?php

namespace Components\Contract\Model\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Contract\Model\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;

class EnterpriseRepository implements EnterpriseRepositoryInterface
{
    public function findBySiret(string $siret)
    {
        return Enterprise::where('identification_number', $siret)->first();
    }

    public function make()
    {
        return new Enterprise();
    }

    public function find(string $id)
    {
        return Enterprise::where('id', $id)->first();
    }
}
