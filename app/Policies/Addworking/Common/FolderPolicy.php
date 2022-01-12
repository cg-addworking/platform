<?php

namespace App\Policies\Addworking\Common;

use App\Models\Addworking\Common\Folder;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;

class FolderPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, Enterprise $enterprise)
    {
        if (! $enterprise->exists) {
            return Response::deny("You need an enterprise for that");
        }

        if ($user->enterprise->id !== $enterprise->id) {
            return Response::deny("You aren't a member of this enterprise");
        }

        return Response::allow();
    }

    public function view(User $user, Folder $folder)
    {
        if ($user->enterprise->exists) {
            return Response::allow();
        }

        if ($folder->shared_with_vendors == true && $user->enterprise->isVendorOf($folder->enterprise)) {
            return Response::allow();
        }

        return Response::deny();
    }

    public function create(User $user, Enterprise $enterprise)
    {
        return true;
    }

    public function update(User $user, Folder $folder)
    {
        if ($user->enterprise->id !== $folder->enterprise->id) {
            return Response::deny("You aren't a member of this enterprise");
        }

        return Response::allow();
    }

    public function delete(User $user, Folder $folder)
    {
        if ($user->enterprise->id !== $folder->enterprise->id) {
            return Response::deny("You aren't a member of this enterprise");
        }

        return Response::allow();
    }

    public function restore(User $user, Folder $folder)
    {
        return true;
    }

    public function forceDelete(User $user, Folder $folder)
    {
        return true;
    }

    public function attach(User $user, Enterprise $enterprise, Model $model)
    {
        if ($user->isSupport()) {
            return Response::allow();
        }

        if (! $enterprise->folders()->exists()) {
            return Response::deny("Your enterprise has no folders");
        }

        return Response::allow();
    }

    public function link(User $user, Folder $folder, Model $model)
    {
        return true;
    }

    public function unlink(User $user, Folder $folder, Model $model)
    {
        return true;
    }
}
