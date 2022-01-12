<?php

namespace App\Models\Addworking\User\OnboardingProcess;

class CreateEnterpriseActivity extends Step
{
    /**
     * @var string
     */
    protected $description = "addworking.user.dashboard._onboarding.step.create_enterprise_activity.description";

    /**
     * @var string
     */
    protected $displayName = "Création de l'activité de l'entreprise";

    /**
     * @var string
     */
    protected $message = "addworking.user.dashboard._onboarding.step.create_enterprise_activity.message";

    /**
     * @var string
     */
    protected $callToAction = "addworking.user.dashboard._onboarding.step.create_enterprise_activity.call_to_action";

    /**
     * @inheritdoc
     */
    public function passes(): bool
    {
        return $this->user()->enterprise->activities()->count() > 0;
    }

    /**
     * @inheritdoc
     */
    public function action(): string
    {
        return route('enterprise.activity.create', $this->user()->enterprise);
    }
}
