<?php

namespace Components\Billing\PaymentOrder\Application\Repositories;

use App\Models\Addworking\User\User;
use Components\Billing\PaymentOrder\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryInterface
{
    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function connectedUser()
    {
        return Auth::user();
    }

    public function isSupport(User $user): bool
    {
        return $user->isSupport();
    }
}
