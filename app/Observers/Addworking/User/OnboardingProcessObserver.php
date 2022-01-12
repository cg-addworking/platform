<?php

namespace App\Observers\Addworking\User;

use App\Models\Addworking\User\OnboardingProcess;

class OnboardingProcessObserver
{
    /**
     * Handle the onboarding process "created" event.
     *
     * @param OnboardingProcess $process
     * @return void
     */
    public function created(OnboardingProcess $process)
    {
        logger()->debug("[addworking.user.onboarding_process.created] {$process->id}");
    }

    /**
     * Handle the OnboardingProcess "updated" event.
     *
     * @param OnboardingProcess $process
     * @return void
     */
    public function updated(OnboardingProcess $process)
    {
        if (!$process->complete && $process->current_step > $process->last_step) {
            logger()->debug("[addworking.user.onboarding_process.updated] process complete");
            $process->update(['complete' => true]);
        }
    }

    /**
     * Handle the OnboardingProcess "deleted" event.
     *
     * @param OnboardingProcess $process
     * @return void
     */
    public function deleted(OnboardingProcess $process)
    {
        //
    }
}
