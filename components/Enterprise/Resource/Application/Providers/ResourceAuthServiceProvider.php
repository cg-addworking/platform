<?php

namespace Components\Enterprise\Resource\Application\Providers;

use Components\Enterprise\Resource\Application\Models\ActivityPeriod;
use Components\Enterprise\Resource\Application\Models\Resource;
use Components\Enterprise\Resource\Application\Policies\ActivityPeriodPolicy;
use Components\Enterprise\Resource\Application\Policies\ResourcePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class ResourceAuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        ActivityPeriod::class => ActivityPeriodPolicy::class,
        Resource::class       => ResourcePolicy::class,

    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
