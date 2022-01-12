<?php

namespace Components\Enterprise\WorkField\Domain\Interfaces\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;

interface EnterpriseRepositoryInterface
{
    public function make(): Enterprise;
    public function find(string $id): ?Enterprise;
    public function findBySiret(string $siret): ?Enterprise;
    public function getOwnerAndDescendants(Enterprise $enterprise);
}
