<?php

namespace Components\Enterprise\BusinessTurnover\Application\Providers;

use Components\Enterprise\BusinessTurnover\Application\Models\BusinessTurnover;
use Components\Enterprise\BusinessTurnover\Application\Policies\BusinessTurnoverPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class BusinessTurnoverAuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        BusinessTurnover::class => BusinessTurnoverPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
