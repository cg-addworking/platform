<?php

namespace Components\Enterprise\AccountingExpense\Application\Repositories;

use App\Models\Addworking\User\User;
use Components\Enterprise\AccountingExpense\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

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
}
