<?php

namespace Components\Enterprise\Resource\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\Resource\Domain\Repositories\EnterpriseRepositoryInterface;

class EnterpriseRepository implements EnterpriseRepositoryInterface
{
    public function find(string $id)
    {
        return Enterprise::where('id', $id)->first();
    }

    public function isVendor(Enterprise $enterprise): bool
    {
        return $enterprise->is_vendor;
    }

    public function isCustomer(Enterprise $enterprise): bool
    {
        return $enterprise->is_customer;
    }
}
