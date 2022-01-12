<?php

namespace Components\Enterprise\AccountingExpense\Domain\Interfaces\Repositories;

use App\Models\Addworking\Mission\MissionTracking;

interface MissionTrackingRepositoryInterface
{
    public function make(array $data = []): MissionTracking;
    public function findByNumber(int $number): ?MissionTracking;
}
