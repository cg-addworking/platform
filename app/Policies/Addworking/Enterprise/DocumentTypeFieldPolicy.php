<?php

namespace App\Policies\Addworking\Enterprise;

use App\Models\Addworking\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Addworking\Enterprise\DocumentTypeField;

class DocumentTypeFieldPolicy
{
    use HandlesAuthorization;

    public function store(User $user)
    {
        return $user->isSupport();
    }

    public function update(User $user, DocumentTypeField $model)
    {
        return $user->isSupport();
    }

    public function destroy(User $user, DocumentTypeField $model)
    {
        return $user->isSupport();
    }
}
