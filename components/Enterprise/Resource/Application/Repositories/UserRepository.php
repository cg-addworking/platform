<?php

namespace Components\Enterprise\Resource\Application\Repositories;

use App\Models\Addworking\User\User;
use Components\Enterprise\Resource\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryInterface
{
    public function connectedUser()
    {
        return Auth::user();
    }

    public function isSupport(User $user): bool
    {
        return $user->isSupport();
    }
}
