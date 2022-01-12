<?php

namespace Components\Enterprise\AccountingExpense\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\AccountingExpense\Domain\Interfaces\Entities\AccountingExpenseEntityInterface;
use Components\Enterprise\AccountingExpense\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;

class EnterpriseRepository implements EnterpriseRepositoryInterface
{
    public function make($data = []): Enterprise
    {
        return new Enterprise($data);
    }

    public function find(string $id): ?Enterprise
    {
        return Enterprise::where('id', $id)->first();
    }

    public function findBySiret(string $siret): ?Enterprise
    {
        return Enterprise::where('identification_number', $siret)->first();
    }

    public function getByDefaultAccountingExpense(Enterprise $enterprise) : ?AccountingExpenseEntityInterface
    {
        return $enterprise->accountingExpenses()->where('display_name', 'Prestation')->first();
    }
}
