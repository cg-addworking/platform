<?php

namespace Components\Mission\Mission\Domain\Interfaces\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;

interface EnterpriseRepositoryInterface
{
    public function find(?string $id): ?Enterprise;
    public function findBySiret(string $siret): ?Enterprise;
    public function getAllCustomers();
    public function getEnterprisesOf(User $user);
    public function isVendor(Enterprise $enterprise): bool;
    public function isCustomer(Enterprise $enterprise): bool;
}
