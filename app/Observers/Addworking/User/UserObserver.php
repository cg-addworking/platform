<?php

namespace App\Observers\Addworking\User;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\NotificationPreferences;
use App\Models\Addworking\User\OnboardingProcess;
use App\Models\Addworking\User\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @deprecated v0.32.2 this observer's behavior should be implemented in UserRepository
 */
class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param  \App\Addworking\User\User  $user
     * @return void
     */
    public function created(User $user)
    {
        logger()->debug("[addworking.user.user.created] {$user->id}");

        try {
            $enterprise = $this->getEnterpriseFromSubdomain();
        } catch (ModelNotFoundException $e) {
            logger()->notice("[addworking.user.user.created] no enterprise for onboarding process");
            return;
        }

        (new OnboardingProcess)
            ->enterprise()->associate($enterprise)
            ->user()->associate($user)
            ->save();

        (new NotificationPreferences)
            ->user()->associate($user)
            ->save();
    }

    public function getEnterpriseFromSubdomain(): Enterprise
    {
        if (subdomain('sogetrel')) {
            return Enterprise::fromName('SOGETREL');
        }

        if (subdomain('edenred')) {
            return Enterprise::fromName('EDENRED');
        }

        return Enterprise::fromName('ADDWORKING');
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\Addworking\User\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\Addworking\User\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\Addworking\User\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\Addworking\User\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
