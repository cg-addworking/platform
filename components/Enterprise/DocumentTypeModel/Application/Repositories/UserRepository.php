<?php

namespace Components\Enterprise\DocumentTypeModel\Application\Repositories;

use App\Models\Addworking\User\User;
use Components\Enterprise\DocumentTypeModel\Domain\RepositoriesInterface\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryInterface
{
    public function make()
    {
        return new User;
    }

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
