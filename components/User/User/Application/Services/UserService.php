<?php

namespace Components\User\User\Application\Services;

use Components\User\User\Domain\Exceptions\UnauthenticatedException;
use Components\User\User\Domain\Interfaces\UserEntityInterface;
use Components\User\User\Domain\Interfaces\UserServiceInterface;
use Illuminate\Support\Facades\Auth;

class UserService implements UserServiceInterface
{
    public function authenticated(): bool
    {
        return ! Auth::guest();
    }

    public function getAuthenticatedUser(): UserEntityInterface
    {
        if (! $this->authenticated()) {
            throw new UnauthenticatedException;
        }

        return Auth::user();
    }
}
