<?php

namespace App\Models\Edenred\User\OnboardingProcess;

use App\Models\Addworking\User\OnboardingProcess;
use App\Models\Addworking\User\OnboardingProcess\ConfirmEmail;
use App\Models\Addworking\User\OnboardingProcess\CreateEnterprise;
use App\Models\Addworking\User\OnboardingProcess\CreateEnterpriseActivity;
use App\Models\Addworking\User\OnboardingProcess\Scenario;
use App\Models\Addworking\User\OnboardingProcess\UploadLegalDocument;
use App\Models\Edenred\User\OnboardingProcess\AcceptTermsOfService;
use Illuminate\Support\Collection;

class EdenredScenario extends Scenario
{
    /**
     * @var array
     */
    protected $steps = [
        ConfirmEmail::class,
        AcceptTermsOfService::class,
        CreateEnterprise::class,
        CreateEnterpriseActivity::class,
        UploadLegalDocument::class,
    ];
}
