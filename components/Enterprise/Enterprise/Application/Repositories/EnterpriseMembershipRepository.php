<?php

namespace Components\Enterprise\Enterprise\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Enterprise\Enterprise\Domain\Interfaces\EnterpriseMembershipRepositoryInterface;

class EnterpriseMembershipRepository implements EnterpriseMembershipRepositoryInterface
{
    public function isMemberOf(User $user, Enterprise $enterprise): bool
    {
        return $enterprise->users->contains($user);
    }
}
