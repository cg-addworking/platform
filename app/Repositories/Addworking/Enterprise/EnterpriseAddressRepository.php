<?php

namespace App\Repositories\Addworking\Enterprise;

use App\Contracts\RepositoryInterface;
use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Enterprise\Enterprise;

class EnterpriseAddressRepository implements RepositoryInterface
{
    public function getFirstAddress(Enterprise $enterprise): string
    {
        return (string) ($enterprise->addresses()->first() ?? "");
    }

    public function getAddress(Enterprise $enterprise): Address
    {
        return $enterprise->addresses()->firstOrNew([]);
    }
}
