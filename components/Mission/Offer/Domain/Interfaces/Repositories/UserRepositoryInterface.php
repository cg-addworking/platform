<?php

namespace Components\Mission\Offer\Domain\Interfaces\Repositories;

use App\Models\Addworking\User\User;

interface UserRepositoryInterface
{
    public function find(string $id): ?User;
    public function connectedUser(): User;
    public function isSupport(User $user): bool;
    public function findByEmail(string $email): ?User;
    public function findByNumber(string $number): ?User;
}
