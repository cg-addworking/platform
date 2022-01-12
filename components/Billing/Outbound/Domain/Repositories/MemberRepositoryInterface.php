<?php

namespace Components\Billing\Outbound\Domain\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;

interface MemberRepositoryInterface
{
    public function isMemberOf(User $user, Enterprise $enterprise): bool;
}
