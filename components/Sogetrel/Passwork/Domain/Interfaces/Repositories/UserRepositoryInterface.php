<?php

namespace Components\Sogetrel\Passwork\Domain\Interfaces\Repositories;

use App\Models\Addworking\User\User;

interface UserRepositoryInterface
{
    public function isSupport(User $user): bool;
}
