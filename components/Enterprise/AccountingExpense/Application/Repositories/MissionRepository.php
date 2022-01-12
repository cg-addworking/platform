<?php

namespace Components\Enterprise\AccountingExpense\Application\Repositories;

use App\Models\Addworking\Mission\Mission;
use Components\Enterprise\AccountingExpense\Domain\Interfaces\Repositories\MissionRepositoryInterface;

class MissionRepository implements MissionRepositoryInterface
{
    public function make($data = []): Mission
    {
        return new Mission($data);
    }

    public function findByNumber(int $number): ?Mission
    {
        return Mission::where('number', $number)->first();
    }
}
