<?php

namespace App\Models\Addworking\User\OnboardingProcess;

class CreateIban extends Step
{
    /**
     * @var string
     */
    protected $description = "Renseignez votre IBAN";

    /**
     * @var string
     */
    protected $displayName = "Création de l'IBAN";

    /**
     * @var string
     */
    protected $message = "Vous n'avez pas encore renseigné votre IBAN";

    /**
     * @var string
     */
    protected $callToAction = "Mettre à jour mon IBAN";

    /**
     * @inheritdoc
     */
    public function passes(): bool
    {
        return $this->user()->enterprise->iban->exists;
    }
    /**
     * @inheritdoc
     */
    public function action(): string
    {
        return  route('enterprise.iban.create', $this->user()->enterprise);
    }
}
