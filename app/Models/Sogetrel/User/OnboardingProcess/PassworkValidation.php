<?php

namespace App\Models\Sogetrel\User\OnboardingProcess;

use App\Models\Addworking\User\OnboardingProcess\Step;

class PassworkValidation extends Step
{
    /**
     * @var string
     */
    protected $description = "addworking.user.dashboard._onboarding.step.validation_passwork.description";

    /**
     * @var string
     */
    protected $message = "addworking.user.dashboard._onboarding.step.validation_passwork.message";

    /**
     * @var string
     */
    protected $callToAction = "addworking.user.dashboard._onboarding.step.validation_passwork.call_to_action";

    /**
     * @inheritdoc
     */
    public function passes(): bool
    {
        return $this->user()->sogetrelPasswork->isAccepted();
    }

    /**
     * @inheritdoc
     */
    public function action(): string
    {
        if ($this->user()->sogetrelPasswork->exists) {
            return route('sogetrel.passwork.show', $this->user()->sogetrelPasswork);
        }

        return '#';
    }
}
