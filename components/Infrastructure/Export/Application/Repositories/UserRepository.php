<?php

namespace Components\Infrastructure\Export\Application\Repositories;

use App\Models\Addworking\User\User;
use Components\Infrastructure\Export\Domain\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryInterface
{
    public function connectedUser(): User
    {
        return Auth::user();
    }
}
