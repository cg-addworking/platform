<?php

namespace App\Models\Edenred\User\OnboardingProcess;

use App\Models\Addworking\User\OnboardingProcess\Step;

class AcceptTermsOfService extends Step
{
    /**
     * @var string
     */
    protected $description = "Acceptez les conditions génerales d'utilisation pour continuer";

    /**
     * @var string
     */
    protected $message = "Vous n'avez pas encore Accepté les conditions génerales d'utilisation";

    /**
     * @var string
     */
    protected $callToAction = "Voir les CGU";

    /**
     * @inheritdoc
     */
    public function passes(): bool
    {
        return $this->user()->hasAcceptedTermsOfService();
    }

    /**
     * @inheritdoc
     */
    public function action(): string
    {
        return route('terms_of_use.show');
    }
}
