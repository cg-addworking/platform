<?php

namespace App\Providers\Addworking\Contract;

use App\Policies\Addworking\Contract\ContractTemplatePartyDocumentTypePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class ContractAuthServiceProvider extends ServiceProvider
{
    protected $policies = [

        // --------------------------------------------------------------------
        // Contracts

        'App\Models\Addworking\Contract\Contract' =>
        'App\Policies\Addworking\Contract\ContractPolicy',

        'App\Models\Addworking\Contract\ContractAnnex' =>
        'App\Policies\Addworking\Contract\ContractAnnexPolicy',

        'App\Models\Addworking\Contract\ContractDocument' =>
        'App\Policies\Addworking\Contract\ContractDocumentPolicy',

        'App\Models\Addworking\Contract\ContractParty' =>
        'App\Policies\Addworking\Contract\ContractPartyPolicy',

        'App\Models\Addworking\Contract\ContractPartyDocumentType' =>
        'App\Policies\Addworking\Contract\ContractPartyDocumentTypePolicy',

        'App\Models\Addworking\Contract\ContractVariable' =>
        'App\Policies\Addworking\Contract\ContractVariablePolicy',

        // --------------------------------------------------------------------
        // Contract Templates

        'App\Models\Addworking\Contract\ContractTemplate' =>
        'App\Policies\Addworking\Contract\ContractTemplatePolicy',

        'App\Models\Addworking\Contract\ContractTemplateAnnex' =>
        'App\Policies\Addworking\Contract\ContractTemplateAnnexPolicy',

        'App\Models\Addworking\Contract\ContractTemplateParty' =>
        'App\Policies\Addworking\Contract\ContractTemplatePartyPolicy',

        'App\Models\Addworking\Contract\ContractTemplateVariable' =>
        'App\Policies\Addworking\Contract\ContractTemplateVariablePolicy',

        'App\Models\Addworking\Contract\ContractTemplatePartyDocumentType' =>
        'App\Policies\Addworking\Contract\ContractTemplatePartyDocumentTypePolicy',
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
