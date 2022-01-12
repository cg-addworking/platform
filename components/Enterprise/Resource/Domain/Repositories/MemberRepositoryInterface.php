<?php

namespace Components\Enterprise\Resource\Domain\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;

interface MemberRepositoryInterface
{
    public function isMemberOf(User $user, Enterprise $enterprise): bool;
}
