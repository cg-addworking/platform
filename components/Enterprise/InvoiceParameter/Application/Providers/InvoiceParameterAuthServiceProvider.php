<?php

namespace Components\Enterprise\InvoiceParameter\Application\Providers;

use Components\Enterprise\InvoiceParameter\Application\Models\InvoiceParameter;
use Components\Enterprise\InvoiceParameter\Application\Policies\InvoiceParameterPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class InvoiceParameterAuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        InvoiceParameter::class => InvoiceParameterPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
