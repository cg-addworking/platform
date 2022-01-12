<?php

namespace Components\Contract\Model\Application\Providers;

use Components\Contract\Model\Application\Models\ContractModel;
use Components\Contract\Model\Application\Models\ContractModelDocumentType;
use Components\Contract\Model\Application\Models\ContractModelPart;
use Components\Contract\Model\Application\Models\ContractModelVariable;
use Components\Contract\Model\Application\Policies\ContractModelDocumentTypePolicy;
use Components\Contract\Model\Application\Models\ContractModelParty;
use Components\Contract\Model\Application\Policies\ContractModelPartPolicy;
use Components\Contract\Model\Application\Policies\ContractModelPartyPolicy;
use Components\Contract\Model\Application\Policies\ContractModelPolicy;
use Components\Contract\Model\Application\Policies\ContractModelVariablePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class ContractModelAuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        ContractModel::class => ContractModelPolicy::class,
        ContractModelPart::class => ContractModelPartPolicy::class,
        ContractModelParty::class => ContractModelPartyPolicy::class,
        ContractModelDocumentType::class => ContractModelDocumentTypePolicy::class,
        ContractModelVariable::class => ContractModelVariablePolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
