<?php

namespace Components\User\User\Application\Repositories;

use App\Models\Addworking\User\User;
use Components\User\User\Domain\Interfaces\UserRepositoryInterface;
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
}
