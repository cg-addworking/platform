<?php

namespace Components\Mission\Mission\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Mission\Mission\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;

class EnterpriseRepository implements EnterpriseRepositoryInterface
{
    public function find(?string $id): ?Enterprise
    {
        return Enterprise::where('id', $id)->first();
    }

    public function getAllCustomers()
    {
        return Enterprise::where('is_customer', true)->orderBy('name', 'asc')->cursor();
    }

    public function getEnterprisesOf(User $user)
    {
        return $user->enterprises()->orderBy('name', 'asc')->cursor();
    }

    public function findBySiret(string $siret): ?Enterprise
    {
        return Enterprise::where('identification_number', $siret)->first();
    }

    public function isVendor(Enterprise $enterprise): bool
    {
        return $enterprise->isVendor();
    }

    public function isCustomer(Enterprise $enterprise): bool
    {
        return $enterprise->isCustomer();
    }
}
