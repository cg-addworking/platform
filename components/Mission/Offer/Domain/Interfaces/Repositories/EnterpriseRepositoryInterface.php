<?php

namespace Components\Mission\Offer\Domain\Interfaces\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;

interface EnterpriseRepositoryInterface
{
    public function find(string $id): ?Enterprise;
    public function findBySiret(string $siret): ?Enterprise;
    public function getAllEnterprises();
    public function getEnterprisesOf(User $user);
    public function getVendorsOf(Enterprise $enterprise);
}
