<?php

namespace Components\Enterprise\Enterprise\Domain\Interfaces;

use App\Models\Addworking\User\User;

interface UserRepositoryInterface
{
    public function findByEmail(string $email);
    public function connectedUser();
    public function isSupport(User $user): bool;
}
