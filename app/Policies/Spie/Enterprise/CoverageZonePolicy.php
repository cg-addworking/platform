<?php

namespace App\Policies\Spie\Enterprise;

use App\Models\Addworking\User\User;
use App\Models\Spie\Enterprise\CoverageZone;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoverageZonePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any coverage zones.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the coverage zone.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\App\Models\Spie\Enterprise\CoverageZone  $coverageZone
     * @return mixed
     */
    public function view(User $user, CoverageZone $coverageZone)
    {
        //
    }

    /**
     * Determine whether the user can create coverage zones.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the coverage zone.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\App\Models\Spie\Enterprise\CoverageZone  $coverageZone
     * @return mixed
     */
    public function update(User $user, CoverageZone $coverageZone)
    {
        //
    }

    /**
     * Determine whether the user can delete the coverage zone.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\App\Models\Spie\Enterprise\CoverageZone  $coverageZone
     * @return mixed
     */
    public function delete(User $user, CoverageZone $coverageZone)
    {
        //
    }

    /**
     * Determine whether the user can restore the coverage zone.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\App\Models\Spie\Enterprise\CoverageZone  $coverageZone
     * @return mixed
     */
    public function restore(User $user, CoverageZone $coverageZone)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the coverage zone.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\App\Models\Spie\Enterprise\CoverageZone  $coverageZone
     * @return mixed
     */
    public function forceDelete(User $user, CoverageZone $coverageZone)
    {
        //
    }
}
