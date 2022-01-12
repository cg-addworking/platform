<?php

namespace Components\Billing\Inbound\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Billing\Inbound\Domain\Repositories\EnterpriseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EnterpriseRepository implements EnterpriseRepositoryInterface
{
    public function find(string $id)
    {
        return Enterprise::where('id', $id)->first();
    }

    public function findBySiret(string $siret)
    {
        return Enterprise::where('identification_number', $siret)->first();
    }

    public function getVendorsOfUserEnterprises(User $user)
    {
        $enterprises = $user->enterprises()->get();
        $vendors = new Collection;
        foreach ($enterprises as $enterprise) {
            $vendors->push($enterprise->vendors()->get());
        }
        return $vendors->flatten()->unique('id')->sortBy('name');
    }
}
