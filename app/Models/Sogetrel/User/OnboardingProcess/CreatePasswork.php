<?php

namespace App\Models\Sogetrel\User\OnboardingProcess;

use App\Models\Addworking\User\OnboardingProcess\Step;

class CreatePasswork extends Step
{
    /**
     * @var string
     */
    protected $description = "addworking.user.dashboard._onboarding.step.create_passwork.description";

    /**
     * @var string
     */
    protected $message = "addworking.user.dashboard._onboarding.step.create_passwork.message";

    /**
     * @var string
     */
    protected $callToAction = "addworking.user.dashboard._onboarding.step.create_passwork.call_to_action";

    /**
     * @inheritdoc
     */
    public function passes(): bool
    {
        return $this->user()->sogetrelPasswork->exists;
    }

    /**
     * @inheritdoc
     */
    public function action(): string
    {
        return route('sogetrel.passwork.create');
    }
}
