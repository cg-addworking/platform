<?php

namespace Components\Billing\Outbound\Domain\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;

interface EnterpriseRepositoryInterface
{
    public function find(string $id);

    public function findBySiret(string $siret);

    public function findByName(string $name);

    public function isCustomer(Enterprise $enterprise): bool;

    public function hasPartnershipWith(Enterprise $customer, Enterprise $vendor): bool;

    public function hasCustomManagementFeesTag(Enterprise $customer, Enterprise $vendor): bool;

    public function getActiveVendors(Enterprise $customer, string $month);
}
