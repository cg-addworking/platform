<?php

namespace Components\Enterprise\Resource\Domain\Repositories;

use App\Models\Addworking\User\User;

interface UserRepositoryInterface
{
    public function connectedUser();

    public function isSupport(User $user): bool;
}
