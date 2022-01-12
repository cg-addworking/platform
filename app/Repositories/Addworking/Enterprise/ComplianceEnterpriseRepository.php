<?php

namespace App\Repositories\Addworking\Enterprise;

use App\Contracts\RepositoryInterface;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Illuminate\Database\Eloquent\Relations\Relation;

class ComplianceEnterpriseRepository implements RepositoryInterface
{
    public function getCustomerComplianceManagers(Enterprise $enterprise): Relation
    {
        return $enterprise->users()->wherePivot(User::IS_CUSTOMER_COMPLIANCE_MANAGER, true);
    }

    public function getVendorComplianceManagers(Enterprise $enterprise): Relation
    {
        return $enterprise->users()->wherePivot(User::IS_VENDOR_COMPLIANCE_MANAGER, true);
    }
}
