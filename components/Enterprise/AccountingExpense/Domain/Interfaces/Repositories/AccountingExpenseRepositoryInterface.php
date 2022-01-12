<?php

namespace Components\Enterprise\AccountingExpense\Domain\Interfaces\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\AccountingExpense\Domain\Interfaces\Entities\AccountingExpenseEntityInterface;

interface AccountingExpenseRepositoryInterface
{
    public function find(string $id): ?AccountingExpenseEntityInterface;
    public function findByNumber(int $number): ?AccountingExpenseEntityInterface;
    public function make($data = []): AccountingExpenseEntityInterface;
    public function save(AccountingExpenseEntityInterface $accounting_expense): AccountingExpenseEntityInterface;
    public function list(
        Enterprise $enterprise,
        ?array $filter = null,
        ?string $search = null,
        ?int $page = null,
        ?string $operator = null,
        ?string $field_name = null
    );
    public function getSearchableAttributes(): array;
    public function delete(AccountingExpenseEntityInterface $accounting_expense): bool;
    public function isDeleted(string $number): bool;
}
