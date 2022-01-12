<?php

namespace Components\Enterprise\AccountingExpense\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\AccountingExpense\Application\Models\AccountingExpense;
use Components\Enterprise\AccountingExpense\Domain\Exceptions\AccountingExpenseCreationFailedException;
use Components\Enterprise\AccountingExpense\Domain\Interfaces\Entities\AccountingExpenseEntityInterface;
use Components\Enterprise\AccountingExpense\Domain\Interfaces\Repositories\AccountingExpenseRepositoryInterface;

class AccountingExpenseRepository implements AccountingExpenseRepositoryInterface
{
    public function find(string $id): ?AccountingExpenseEntityInterface
    {
        return AccountingExpense::where('id', $id)->first();
    }

    public function findByNumber(int $number): ?AccountingExpenseEntityInterface
    {
        return AccountingExpense::where('number', $number)->first();
    }

    public function make($data = []): AccountingExpenseEntityInterface
    {
        return new AccountingExpense($data);
    }

    public function save(AccountingExpenseEntityInterface $accounting_expense): AccountingExpenseEntityInterface
    {
        try {
            $accounting_expense->save();
        } catch (AccountingExpenseCreationFailedException $exception) {
            throw $exception;
        }

        $accounting_expense->refresh();

        return $accounting_expense;
    }

    public function list(
        Enterprise $enterprise,
        ?array $filter = null,
        ?string $search = null,
        ?int $page = null,
        ?string $operator = null,
        ?string $field_name = null
    ) {
        return AccountingExpense::query()
            ->where(function ($query) use ($enterprise) {
                return $query->ofEnterprise($enterprise);
            })
            ->when($search ?? null, function ($query, $search) use ($operator, $field_name) {
                return $query->search($search, $operator, $field_name);
            })
            ->latest()
            ->paginate($page ?? 25);
    }

    public function getSearchableAttributes(): array
    {
        return [
            AccountingExpenseEntityInterface::SEARCHABLE_ATTRIBUTE_DISPLAY_NAME =>
                'accounting_expense::accounting_expense.index.search_field_display_name',
            AccountingExpenseEntityInterface::SEARCHABLE_ATTRIBUTE_ANALYTICAL_CODE =>
                'accounting_expense::accounting_expense.index.search_field_analytical_code',
        ];
    }

    public function delete(AccountingExpenseEntityInterface $accounting_expense): bool
    {
        return $accounting_expense->delete();
    }

    public function isDeleted(string $number): bool
    {
        return is_null(
            AccountingExpense::query()
            ->where('number', $number)
            ->first()
        );
    }
}
