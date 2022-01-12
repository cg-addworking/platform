<?php

namespace App\Models\Addworking\User\OnboardingProcess;

use App\Models\Addworking\User\OnboardingProcess;
use App\Models\Addworking\User\OnboardingProcess\ConfirmEmail;
use App\Models\Addworking\User\OnboardingProcess\CreateEnterprise;
use App\Models\Addworking\User\OnboardingProcess\CreateEnterpriseActivity;
use App\Models\Addworking\User\OnboardingProcess\CreatePasswork;
use App\Models\Addworking\User\OnboardingProcess\UploadLegalDocument;
use Illuminate\Support\Collection;

class AddworkingScenario extends Scenario
{
    /**
     * @var array
     */
    protected $steps = [
        ConfirmEmail::class,
        CreateEnterprise::class,
        CreateEnterpriseActivity::class,
        CreatePasswork::class,
        UploadLegalDocument::class,
    ];
}
