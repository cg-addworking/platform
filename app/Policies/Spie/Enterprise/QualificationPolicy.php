<?php

namespace App\Policies\Spie\Enterprise;

use App\Models\Addworking\User\User;
use App\Models\Spie\Enterprise\Qualification;
use Illuminate\Auth\Access\HandlesAuthorization;

class QualificationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any qualifications.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the qualification.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\App\Models\Spie\Enterprise\Qualification  $qualification
     * @return mixed
     */
    public function view(User $user, Qualification $qualification)
    {
        //
    }

    /**
     * Determine whether the user can create qualifications.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the qualification.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\App\Models\Spie\Enterprise\Qualification  $qualification
     * @return mixed
     */
    public function update(User $user, Qualification $qualification)
    {
        //
    }

    /**
     * Determine whether the user can delete the qualification.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\App\Models\Spie\Enterprise\Qualification  $qualification
     * @return mixed
     */
    public function delete(User $user, Qualification $qualification)
    {
        //
    }

    /**
     * Determine whether the user can restore the qualification.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\App\Models\Spie\Enterprise\Qualification  $qualification
     * @return mixed
     */
    public function restore(User $user, Qualification $qualification)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the qualification.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\App\Models\Spie\Enterprise\Qualification  $qualification
     * @return mixed
     */
    public function forceDelete(User $user, Qualification $qualification)
    {
        //
    }
}
