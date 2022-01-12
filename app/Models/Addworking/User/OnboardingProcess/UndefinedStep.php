<?php

namespace App\Models\Addworking\User\OnboardingProcess;

class UndefinedStep extends Step
{
    protected $description = "undefined/step";

    protected $displayName = "Inconnu";

    protected $message = "undefined/step";

    protected $callToAction = "n/a";

    protected $action = "#";

    public function passes(): bool
    {
        return false;
    }
}
