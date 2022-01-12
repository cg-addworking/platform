<?php

namespace Components\Enterprise\WorkField\Application\Repositories;

use App\Models\Addworking\User\User;
use Components\Enterprise\WorkField\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Models\Addworking\Enterprise\Enterprise;

class UserRepository implements UserRepositoryInterface
{
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function connectedUser(): User
    {
        return Auth::user();
    }

    public function isSupport(User $user): bool
    {
        return $user->isSupport();
    }

    public function find(string $id): ?User
    {
        return User::where('id', $id)->first();
    }

    public function make(): User
    {
        return new User;
    }

    public function isAdminOf(User $user, Enterprise $enterprise): bool
    {
        return $user->hasRoleFor($enterprise, User::ROLE_ADMIN);
    }

    public function hasWorkfieldCreatorRole(User $user, Enterprise $enterprise): bool
    {
        return $user->hasRoleFor($enterprise, User::ROLE_WORKFIELD_CREATOR);
    }
}
