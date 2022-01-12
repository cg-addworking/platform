<?php

namespace App\Contracts\Addworking\User\OnboardingProcess;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\OnboardingProcess;
use App\Models\Addworking\User\User;
use Illuminate\Http\RedirectResponse;

interface Step
{
    /**
     * @param OnboardingProcess $process
     */
    public function __construct(OnboardingProcess $process);

    /**
     * Get the onboarding process associated this step.
     *
     * @return OnboardingProcess
     */
    public function process(): OnboardingProcess;

    /**
     * Get the user in the onboarding process.
     *
     * @return User
     */
    public function user(): User;

    /**
     * Get the enterprise associated to this step.
     *
     * @return Enterprise
     */
    public function enterprise(): Enterprise;

    /**
     * Does the step test passes?
     *
     * @return bool
     */
    public function passes(): bool;

    /**
     * Does the step test fails (the opposite of passes)?
     *
     * @return bool
     */
    public function fails(): bool;

    /**
     * Describes the step.
     *
     * @return string
     */
    public function description(): string;

    /**
     * Notification message.
     *
     * @return string
     */
    public function message(): string;


    /**
     * The call to action.
     *
     * @return string
     */
    public function callToAction(): string;

    /**
     * The URL to redirect to in order to pass the step.
     *
     * @return string
     */
    public function action(): string;
}
