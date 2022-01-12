<?php

namespace Components\Enterprise\AccountingExpense\Application\Presenters;

use Components\Enterprise\AccountingExpense\Domain\Interfaces\Presenters\AccountingExpenseListPresenterInterface;

class AccountingExpenseListPresenter implements AccountingExpenseListPresenterInterface
{
    public function present($accounting_expenses)
    {
        return $accounting_expenses;
    }
}
