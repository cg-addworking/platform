<?php

namespace Components\Enterprise\AccountingExpense\Domain\Interfaces\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;

interface MemberRepositoryInterface
{
    public function isMemberOf(User $user, Enterprise $enterprise): bool;
}
