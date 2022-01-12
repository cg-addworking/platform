<?php

namespace Components\Enterprise\Resource\Domain\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;

interface EnterpriseRepositoryInterface
{
    public function find(string $id);

    public function isVendor(Enterprise $enterprise): bool;

    public function isCustomer(Enterprise $enterprise): bool;
}
