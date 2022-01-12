<?php

namespace App\Policies\Addworking\Common;

use App\Models\Addworking\Common\File;
use App\Models\Addworking\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class FilePolicy
{
    use HandlesAuthorization;

    public function index(User $user)
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

    public function show(User $user)
    {
        return $user->isSupport();
    }

    public function edit(User $user, File $file)
    {
        return $user->isSupport();
    }

    public function update(User $user, File $file)
    {
        return $user->isSupport();
    }

    public function destroy(User $user, File $file)
    {
        return $user->isSupport();
    }

    public function download(User $user, File $file)
    {
        if (! $file->exists) {
            return Response::deny("le fichier n'existe pas");
        }

        return Response::allow();
    }

    public function iframe(User $user, File $file)
    {
        return true;
    }

    public function ocrScan(User $user)
    {
        return $user->isSupport();
    }
}
