<?php

namespace Components\Enterprise\AccountingExpense\Application\Repositories;

use App\Models\Addworking\Mission\MissionTracking;
use Components\Enterprise\AccountingExpense\Domain\Interfaces\Repositories\MissionTrackingRepositoryInterface;

class MissionTrackingRepository implements MissionTrackingRepositoryInterface
{
    public function make($data = []): MissionTracking
    {
        return new MissionTracking($data);
    }

    public function findByNumber(int $number): ?MissionTracking
    {
        return MissionTracking::where('number', $number)->first();
    }
}
