<?php

namespace Components\Enterprise\AccountingExpense\Application\Repositories;

use App\Models\Addworking\Mission\Milestone;
use Components\Enterprise\AccountingExpense\Domain\Interfaces\Repositories\MilestoneRepositoryInterface;

class MilestoneRepository implements MilestoneRepositoryInterface
{
    public function make($data = []): Milestone
    {
        return new Milestone($data);
    }
}
