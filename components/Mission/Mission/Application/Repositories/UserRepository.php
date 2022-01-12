<?php

namespace Components\Mission\Mission\Application\Repositories;

use App\Models\Addworking\User\User;
use Components\Mission\Mission\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryInterface
{
    public function find(?string $id): ?User
    {
        return User::where('id', $id)->first();
    }

    public function connectedUser(): User
    {
        return Auth::user();
    }

    public function isSupport(User $user): bool
    {
        return $user->isSupport();
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function findByNumber(string $number): ?User
    {
        return User::where('number', $number)->first();
    }

    public function getEnterprises(User $user)
    {
        return $user->enterprises()->get();
    }
}
