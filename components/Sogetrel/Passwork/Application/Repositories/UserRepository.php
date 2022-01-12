<?php

namespace Components\Sogetrel\Passwork\Application\Repositories;

use App\Models\Addworking\User\User;
use Components\Sogetrel\Passwork\Domain\Interfaces\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function isSupport(User $user): bool
    {
        return $user->isSupport();
    }
}
