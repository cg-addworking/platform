<?php

namespace Components\Billing\Inbound\Domain\Repositories;

use App\Models\Addworking\User\User;

interface UserRepositoryInterface
{
    public function findByEmail(string $email);

    public function connectedUser();

    public function isSupport(User $user): bool;
}
