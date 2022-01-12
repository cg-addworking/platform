<?php

namespace Components\User\User\Domain\Interfaces;

use Components\User\User\Domain\Interfaces\UserEntityInterface;

interface UserServiceInterface
{
    public function authenticated(): bool;

    public function getAuthenticatedUser(): UserEntityInterface;
}
