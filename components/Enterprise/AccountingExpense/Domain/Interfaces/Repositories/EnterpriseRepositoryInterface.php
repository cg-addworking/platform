<?php

namespace Components\Enterprise\AccountingExpense\Domain\Interfaces\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\BusinessTurnover\Domain\Interfaces\Entities\BusinessTurnoverEntityInterface;

interface EnterpriseRepositoryInterface
{
    public function make($data = []): Enterprise;
    public function find(string $id): ?Enterprise;
    public function findBySiret(string $siret): ?Enterprise;
}
