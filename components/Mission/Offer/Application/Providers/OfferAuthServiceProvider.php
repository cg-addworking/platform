<?php

namespace Components\Mission\Offer\Application\Providers;

use Components\Mission\Offer\Application\Models\Offer;
use Components\Mission\Offer\Application\Models\Response;
use Components\Mission\Offer\Application\Policies\OfferPolicy;
use Components\Mission\Offer\Application\Policies\ResponsePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class OfferAuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Offer::class => OfferPolicy::class,
        Response::class => ResponsePolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
