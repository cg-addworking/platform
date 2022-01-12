<?php

namespace Components\Billing\Outbound\Application\Providers;

use Components\Billing\Outbound\Application\Models\Fee;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\Outbound\Application\Models\OutboundInvoiceItem;
use Components\Billing\Outbound\Application\Policies\FeePolicy;
use Components\Billing\Outbound\Application\Policies\OutboundInvoiceItemPolicy;
use Components\Billing\Outbound\Application\Policies\OutboundInvoicePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class OutboundInvoiceAuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        OutboundInvoice::class     => OutboundInvoicePolicy::class,
        OutboundInvoiceItem::class => OutboundInvoiceItemPolicy::class,
        Fee::class                 => FeePolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
