<?php

namespace App\Models\Edenred\User\OnboardingProcess;

use App\Models\Addworking\User\OnboardingProcess\Step;
use App\Models\Addworking\Common\Passwork;
use App\Models\Addworking\Enterprise\Enterprise;

class CreatePasswork extends Step
{
    /**
     * @var string
     */
    protected $description = "Renseignez votre passwork";

    /**
     * @var string
     */
    protected $message = "Vous n'avez pas encore créé de passwork Edenred";

    /**
     * @var string
     */
    protected $callToAction = "Je crée mon passwork Edenred";

    /**
     * @inheritdoc
     */
    public function passes(): bool
    {
        return $this->user()->enterprise->passworks()->count() > 0;
    }

    /**
     * @inheritdoc
     */
    public function action(): string
    {
        $passwork = new Passwork;
        $edenred = Enterprise::fromName('EDENRED');
        $this->user()->enterprise->customers()->attach($edenred);
        $passwork->customer()->associate($edenred);
        $passwork->passworkable()->associate($this->user()->enterprise)->save();

        return route('addworking.common.enterprise.passwork.edit', [$this->user()->enterprise, $passwork]);
    }
}
