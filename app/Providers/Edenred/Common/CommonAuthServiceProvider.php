<?php

namespace App\Providers\Edenred\Common;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class CommonAuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Edenred\Common\Code' => 'App\Policies\Edenred\Common\CodePolicy',
        'App\Models\Edenred\Common\AverageDailyRate' => 'App\Policies\Edenred\Common\AverageDailyRatePolicy',
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
