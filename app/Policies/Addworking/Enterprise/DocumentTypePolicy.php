<?php

namespace App\Policies\Addworking\Enterprise;

use App\Models\Addworking\User\User;
use App\Models\Addworking\Enterprise\DocumentType;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentTypePolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->isSupport();
    }

    public function show(User $user, DocumentType $documentType)
    {
        return $user->isSupport();
    }

    public function create(User $user)
    {
        return $user->isSupport();
    }

    public function store(User $user)
    {
        return $user->isSupport();
    }

    public function update(User $user, DocumentType $documentType)
    {
        return $user->isSupport();
    }

    public function destroy(User $user, DocumentType $documentType)
    {
        return $user->isSupport();
    }

    public function download(User $user, DocumentType $documentType)
    {
        return $documentType->file->exists;
    }
}
