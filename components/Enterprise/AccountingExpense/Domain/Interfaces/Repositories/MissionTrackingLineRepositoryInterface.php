<?php

namespace Components\Enterprise\AccountingExpense\Domain\Interfaces\Repositories;

use App\Models\Addworking\Mission\MissionTracking;
use App\Models\Addworking\Mission\MissionTrackingLine;

interface MissionTrackingLineRepositoryInterface
{
    public function make(array $data = []): MissionTrackingLine;
    public function getAvailableAccountingExpenses(MissionTracking $tracking): array;
}
