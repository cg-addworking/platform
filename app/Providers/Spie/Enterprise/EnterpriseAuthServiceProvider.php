<?php

namespace App\Providers\Spie\Enterprise;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class EnterpriseAuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        'App\Models\Spie\Enterprise\CoverageZone' => 'App\Policies\Spie\Enterprise\CoverageZonePolicy',
        'App\Models\Spie\Enterprise\Enterprise' => 'App\Policies\Spie\Enterprise\EnterprisePolicy',
        'App\Models\Spie\Enterprise\Order' => 'App\Policies\Spie\Enterprise\OrderPolicy',
        'App\Models\Spie\Enterprise\Qualification' => 'App\Policies\Spie\Enterprise\QualificationPolicy',
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
