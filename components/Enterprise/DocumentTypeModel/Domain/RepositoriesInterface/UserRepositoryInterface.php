<?php

namespace Components\Enterprise\DocumentTypeModel\Domain\RepositoriesInterface;

use App\Models\Addworking\User\User;

interface UserRepositoryInterface
{
    public function make();
    public function findByEmail(string $email);
    public function connectedUser();
    public function isSupport(User $user): bool;
}
