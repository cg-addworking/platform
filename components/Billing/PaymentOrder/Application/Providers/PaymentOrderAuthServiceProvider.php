<?php

namespace Components\Billing\PaymentOrder\Application\Providers;

use Components\Billing\PaymentOrder\Application\Models\PaymentOrder;
use Components\Billing\PaymentOrder\Application\Models\ReceivedPayment;
use Components\Billing\PaymentOrder\Application\Policies\PaymentOrderPolicy;
use Components\Billing\PaymentOrder\Application\Policies\ReceivedPaymentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class PaymentOrderAuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        PaymentOrder::class    => PaymentOrderPolicy::class,
        ReceivedPayment::class => ReceivedPaymentPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
