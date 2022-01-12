<?php

namespace App\Providers\Everial\Mission;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class MissionAuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Everial\Mission\Referential' => 'App\Policies\Everial\Mission\ReferentialPolicy',
        'App\Models\Everial\Mission\Price'   => 'App\Policies\Everial\Mission\PricePolicy',
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
