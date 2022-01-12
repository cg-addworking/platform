<?php

namespace App\Models\Addworking\User\OnboardingProcess;

class CreatePasswork extends Step
{
    /**
     * @var string
     */
    protected $description = 'addworking.user.dashboard._onboarding.step.create_passwork.description';

    /**
     * @var string
     */
    protected $displayName = "Création du passwork";

    /**
     * @var string
     */
    protected $message = 'addworking.user.dashboard._onboarding.step.create_passwork.message';

    /**
     * @var string
     */
    protected $callToAction = 'addworking.user.dashboard._onboarding.step.create_passwork.call_to_action';

    /**
     * @inheritdoc
     */
    public function passes(): bool
    {
        $customer = $this->process()->user->enterprise->customers()->firstOrNew([]);

        if (! $customer->exists) {
            return true;
        }

        if (! $customer->ancestors(true)->jobs()->exists()) {
            return true;
        }

        if ($this->user()->enterprise->passworks()->ofCustomer($customer)->whereHas('skills')->exists()) {
            return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function action(): string
    {
        return  route('addworking.common.enterprise.passwork.create', $this->user()->enterprise);
    }
}
