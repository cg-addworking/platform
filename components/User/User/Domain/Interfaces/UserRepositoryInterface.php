<?php

namespace Components\User\User\Domain\Interfaces;

use App\Models\Addworking\User\User;

interface UserRepositoryInterface
{
    public function findByEmail(string $email);
    public function connectedUser();
}
