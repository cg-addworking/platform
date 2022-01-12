<?php

namespace Components\Sogetrel\Passwork\Application\Providers;

use Components\Enterprise\WorkField\Application\Models\WorkField;
use Components\Enterprise\WorkField\Application\Policies\WorkFieldPolicy;
use Components\Sogetrel\Passwork\Application\Models\Acceptation;
use Components\Sogetrel\Passwork\Application\Policies\AcceptationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class PassworkAuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Acceptation::class => AcceptationPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
