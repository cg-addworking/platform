<?php

namespace App\Models\Addworking\User\OnboardingProcess;

class ConfirmEmail extends Step
{
    /**
     * @var string
     */
    protected $description = 'addworking.user.dashboard._onboarding.step.confirm_email.description';

    /**
     * @var string
     */
    protected $displayName = "Confirmation email";

    /**
     * @var string
     */
    protected $message = 'addworking.user.dashboard._onboarding.step.confirm_email.message';

    /**
     * @var string
     */
    protected $callToAction = 'addworking.user.dashboard._onboarding.step.confirm_email.call_to_action';

    /**
     * @inheritdoc
     */
    public function passes(): bool
    {
        return $this->user()->isConfirmed();
    }

    /**
     * @inheritdoc
     */
    public function action(): string
    {
        return route('confirmation.resend');
    }
}
