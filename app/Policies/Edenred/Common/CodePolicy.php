<?php

namespace App\Policies\Edenred\Common;

use App\Models\Addworking\User\User;
use App\Models\Edenred\Common\Code;
use Illuminate\Auth\Access\HandlesAuthorization;

class CodePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list codes.
     *
     * @param  User  $user
     * @return mixed
     */
    public function index(User $user)
    {
        $enterprise = auth()->user()->enterprise;

        return $user->isSupport()
            || ($user->hasRoleFor($enterprise, [User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY])
                && $enterprise->isEdenred());
    }

    /**
     * Determine whether the user can view the code.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\Models\Edenred\Common\Code  $code
     * @return mixed
     */
    public function view(User $user, Code $code)
    {
        return true;
    }

    /**
     * Determine whether the user can create codes.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the code.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\Models\Edenred\Common\Code  $code
     * @return mixed
     */
    public function update(User $user, Code $code)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the code.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\Models\Edenred\Common\Code  $code
     * @return mixed
     */
    public function delete(User $user, Code $code)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the code.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\Models\Edenred\Common\Code  $code
     * @return mixed
     */
    public function restore(User $user, Code $code)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the code.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\Models\Edenred\Common\Code  $code
     * @return mixed
     */
    public function forceDelete(User $user, Code $code)
    {
        return true;
    }
}
