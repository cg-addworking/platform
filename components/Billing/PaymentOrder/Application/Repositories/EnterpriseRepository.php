<?php
namespace Components\Billing\PaymentOrder\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Billing\PaymentOrder\Domain\Repositories\EnterpriseRepositoryInterface;

class EnterpriseRepository implements EnterpriseRepositoryInterface
{
    public function findBySiret(string $siret)
    {
        return Enterprise::where('identification_number', $siret)->first();
    }

    public function findByName(string $name)
    {
        return Enterprise::where('name', $name)->first();
    }

    public function isCustomer(Enterprise $enterprise): bool
    {
        return $enterprise->is_customer;
    }
}
