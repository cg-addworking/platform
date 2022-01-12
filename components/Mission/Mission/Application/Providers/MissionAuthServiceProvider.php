<?php

namespace Components\Mission\Mission\Application\Providers;

use Components\Mission\Mission\Application\Models\Mission;
use Components\Mission\Mission\Application\Policies\MissionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class MissionAuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Mission::class => MissionPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
