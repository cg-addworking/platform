<?php

namespace Components\Contract\Model\Domain\Interfaces\Repositories;

use App\Models\Addworking\User\User;

interface UserRepositoryInterface
{
    public function make();
    public function findByEmail(string $email);
    public function connectedUser();
    public function isSupport(User $user): bool;
}
