<?php

namespace Components\Billing\Inbound\Domain\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;

interface EnterpriseRepositoryInterface
{
    public function find(string $id);

    public function findBySiret(string $siret);

    public function getVendorsOfUserEnterprises(User $user);
}
