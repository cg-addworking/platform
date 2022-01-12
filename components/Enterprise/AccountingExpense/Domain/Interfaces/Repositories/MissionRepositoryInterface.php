<?php

namespace Components\Enterprise\AccountingExpense\Domain\Interfaces\Repositories;

use App\Models\Addworking\Mission\Mission;

interface MissionRepositoryInterface
{
    public function make(array $data = []): Mission;
    public function findByNumber(int $number): ?Mission;
}
