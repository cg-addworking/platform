<?php

namespace App\Models\Addworking\User\OnboardingProcess;

class CreateEnterprise extends Step
{
    /**
     * @var string
     */
    protected $description = 'addworking.user.dashboard._onboarding.step.create_enterprise.description';

    /**
     * @var string
     */
    protected $displayName = "Création de l'entreprise";

    /**
     * @var string
     */
    protected $message = 'addworking.user.dashboard._onboarding.step.create_enterprise.message';

    /**
     * @var string
     */
    protected $callToAction = 'addworking.user.dashboard._onboarding.step.create_enterprise.call_to_action';

    /**
     * @inheritdoc
     */
    public function passes(): bool
    {
        return $this->user()->enterprise->exists
            && $this->user()->enterprise->identification_number;
    }

    /**
     * @inheritdoc
     */
    public function action(): string
    {
        return $this->user()->enterprise->exists
            ? route('enterprise.edit', $this->user()->enterprise)
            : route('enterprise.add');
    }
}
