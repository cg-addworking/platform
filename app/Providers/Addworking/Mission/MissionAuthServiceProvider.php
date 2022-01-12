<?php

namespace App\Providers\Addworking\Mission;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class MissionAuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Addworking\Mission\MissionTracking'     => 'App\Policies\Addworking\Mission\MissionTrackingPolicy',
        'App\Models\Addworking\Mission\MissionTrackingLine'
        => 'App\Policies\Addworking\Mission\MissionTrackingLinePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
