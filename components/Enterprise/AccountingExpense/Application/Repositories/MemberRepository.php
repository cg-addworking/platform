<?php

namespace Components\Enterprise\AccountingExpense\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Enterprise\AccountingExpense\Domain\Interfaces\Repositories\MemberRepositoryInterface;

class MemberRepository implements MemberRepositoryInterface
{
    public function isMemberOf(User $user, Enterprise $enterprise): bool
    {
        return $enterprise->users->contains($user);
    }
}
