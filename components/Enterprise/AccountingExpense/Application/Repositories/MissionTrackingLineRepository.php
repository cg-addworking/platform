<?php

namespace Components\Enterprise\AccountingExpense\Application\Repositories;

use App\Models\Addworking\Mission\MissionTracking;
use App\Models\Addworking\Mission\MissionTrackingLine;
use Components\Enterprise\AccountingExpense\Application\Models\AccountingExpense;
use Components\Enterprise\AccountingExpense\Domain\Interfaces\Repositories\MissionTrackingLineRepositoryInterface;

class MissionTrackingLineRepository implements MissionTrackingLineRepositoryInterface
{
    public function make($data = []): MissionTrackingLine
    {
        return new MissionTrackingLine($data);
    }

    public function getAvailableAccountingExpenses(MissionTracking $tracking): array
    {
        return AccountingExpense::query()
            ->where('enterprise_id', $tracking->mission->customer->id)
            ->pluck('display_name', 'id')
            ->toArray();
    }
}
