<?php
namespace Components\Billing\PaymentOrder\Domain\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;

interface EnterpriseRepositoryInterface
{
    public function findBySiret(string $siret);

    public function findByName(string $name);

    public function isCustomer(Enterprise $enterprise): bool;
}
