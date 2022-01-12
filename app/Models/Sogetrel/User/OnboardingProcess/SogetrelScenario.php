<?php

namespace App\Models\Sogetrel\User\OnboardingProcess;

use App\Models\Addworking\User\OnboardingProcess;
use App\Models\Addworking\User\OnboardingProcess\ConfirmEmail;
use App\Models\Addworking\User\OnboardingProcess\CreateEnterprise;
use App\Models\Addworking\User\OnboardingProcess\CreateEnterpriseActivity;
use App\Models\Addworking\User\OnboardingProcess\Scenario;
use App\Models\Addworking\User\OnboardingProcess\UploadLegalDocument;
use App\Models\Sogetrel\User\OnboardingProcess\CreatePasswork;
use App\Models\Sogetrel\User\OnboardingProcess\PassworkValidation;
use Illuminate\Support\Collection;

class SogetrelScenario extends Scenario
{
    /**
     * @var array
     */
    protected $steps = [
        ConfirmEmail::class,
        CreateEnterprise::class,
        CreateEnterpriseActivity::class,
        CreatePasswork::class,
        PassworkValidation::class,
        UploadLegalDocument::class,
    ];
}
