<?php

namespace Components\Mission\Offer\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Mission\Offer\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;

class EnterpriseRepository implements EnterpriseRepositoryInterface
{
    public function find(string $id): ?Enterprise
    {
        return Enterprise::where('id', $id)->first();
    }

    public function getAllEnterprises()
    {
        return Enterprise::orderBy('name', 'asc')->cursor();
    }

    public function getEnterprisesOf(User $user)
    {
        return $user->enterprises()->orderBy('name', 'asc')->cursor();
    }

    public function findBySiret(string $siret): ?Enterprise
    {
        return Enterprise::where('identification_number', $siret)->first();
    }

    public function getVendorsOf(Enterprise $enterprise)
    {
        return $enterprise->vendors()->orderBy('name', 'asc')->cursor();
    }
}
