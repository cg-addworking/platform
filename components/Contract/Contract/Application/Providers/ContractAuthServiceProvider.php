<?php

namespace Components\Contract\Contract\Application\Providers;

use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Models\ContractPart;
use Components\Contract\Contract\Application\Models\ContractParty;
use Components\Contract\Contract\Application\Models\ContractVariable;
use Components\Contract\Contract\Application\Policies\ContractPartPolicy;
use Components\Contract\Contract\Application\Policies\ContractPartyPolicy;
use Components\Contract\Contract\Application\Policies\ContractPolicy;
use Components\Contract\Contract\Application\Policies\ContractVariablePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class ContractAuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Contract::class => ContractPolicy::class,
        ContractPart::class => ContractPartPolicy::class,
        ContractParty::class => ContractPartyPolicy::class,
        ContractVariable::class => ContractVariablePolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
