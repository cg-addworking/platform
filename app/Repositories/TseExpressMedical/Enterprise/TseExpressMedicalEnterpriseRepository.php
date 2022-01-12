<?php

namespace App\Repositories\TseExpressMedical\Enterprise;

use App\Contracts\RepositoryInterface;
use App\Models\Addworking\Enterprise\Enterprise;

class TseExpressMedicalEnterpriseRepository implements RepositoryInterface
{
    public function isTseExpressMedical(Enterprise $enterprise): bool
    {
        return $enterprise->name == 'TSE EXPRESS MEDICAL';
    }
}
