<?php

namespace App\Policies\Edenred\Common;

use App\Models\Addworking\User\User;
use App\Models\Edenred\Common\AverageDailyRate;
use Illuminate\Auth\Access\HandlesAuthorization;

class AverageDailyRatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can index the average daily rate.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\Models\Edenred\Common\AverageDailyRate  $averageDailyRate
     * @return mixed
     */
    public function index(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the average daily rate.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\Models\Edenred\Common\AverageDailyRate  $averageDailyRate
     * @return mixed
     */
    public function view(User $user, AverageDailyRate $averageDailyRate)
    {
        return true;
    }

    /**
     * Determine whether the user can create average daily rates.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the average daily rate.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\Models\Edenred\Common\AverageDailyRate  $averageDailyRate
     * @return mixed
     */
    public function update(User $user, AverageDailyRate $averageDailyRate)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the average daily rate.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\Models\Edenred\Common\AverageDailyRate  $averageDailyRate
     * @return mixed
     */
    public function delete(User $user, AverageDailyRate $averageDailyRate)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the average daily rate.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\Models\Edenred\Common\AverageDailyRate  $averageDailyRate
     * @return mixed
     */
    public function restore(User $user, AverageDailyRate $averageDailyRate)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the average daily rate.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\Models\Edenred\Common\AverageDailyRate  $averageDailyRate
     * @return mixed
     */
    public function forceDelete(User $user, AverageDailyRate $averageDailyRate)
    {
        return true;
    }
}
