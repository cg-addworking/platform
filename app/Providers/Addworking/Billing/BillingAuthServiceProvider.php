<?php

namespace App\Providers\Addworking\Billing;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class BillingAuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        'App\Models\Addworking\Billing\InboundInvoiceItem'
        => "App\Policies\Addworking\Billing\InboundInvoiceItemPolicy",
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
