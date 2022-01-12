<?php

namespace Components\Enterprise\Enterprise\Domain\Interfaces;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;

interface EnterpriseMembershipRepositoryInterface
{
    public function isMemberOf(User $user, Enterprise $enterprise): bool;
}
