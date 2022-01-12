<?php

namespace Components\Enterprise\WorkField\Domain\Interfaces\Repositories;

use App\Models\Addworking\User\User;
use App\Models\Addworking\Enterprise\Enterprise;

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?User;
    public function connectedUser(): User;
    public function isSupport(User $user): bool;
    public function find(string $id): ?User;
    public function make(): User;
    public function isAdminOf(User $user, Enterprise $enterprise): bool;
    public function hasWorkfieldCreatorRole(User $user, Enterprise $enterprise): bool;
}
