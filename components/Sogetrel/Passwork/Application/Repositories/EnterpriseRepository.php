<?php

namespace Components\Sogetrel\Passwork\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Sogetrel\Passwork\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;
use Illuminate\Support\Collection;

class EnterpriseRepository implements EnterpriseRepositoryInterface
{
    public function getCustomerComplianceManagers(Enterprise $enterprise): Collection
    {
        return $enterprise
            ->users()
            ->wherePivot(User::IS_CUSTOMER_COMPLIANCE_MANAGER, true)
            ->get();
    }
}
