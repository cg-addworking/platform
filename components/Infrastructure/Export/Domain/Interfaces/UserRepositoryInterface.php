<?php

namespace Components\Infrastructure\Export\Domain\Interfaces;

use App\Models\Addworking\User\User;

interface UserRepositoryInterface
{
    public function connectedUser(): User;
}
