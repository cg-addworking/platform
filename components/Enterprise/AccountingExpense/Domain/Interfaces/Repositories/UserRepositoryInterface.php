<?php

namespace Components\Enterprise\AccountingExpense\Domain\Interfaces\Repositories;

use App\Models\Addworking\User\User;

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?User;
    public function connectedUser(): User;
    public function isSupport(User $user): bool;
}
