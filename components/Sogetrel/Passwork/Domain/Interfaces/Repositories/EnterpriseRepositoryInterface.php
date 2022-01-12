<?php

namespace Components\Sogetrel\Passwork\Domain\Interfaces\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Support\Collection;

interface EnterpriseRepositoryInterface
{
    public function getCustomerComplianceManagers(Enterprise $enterprise): Collection;
}
