<?php

namespace Components\Enterprise\AccountingExpense\Domain\Interfaces\Repositories;

use App\Models\Addworking\Mission\Milestone;

interface MilestoneRepositoryInterface
{
    public function make(array $data = []): Milestone;
}
