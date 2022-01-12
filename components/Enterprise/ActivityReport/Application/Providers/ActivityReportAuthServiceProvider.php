<?php

namespace Components\Enterprise\ActivityReport\Application\Providers;

use Components\Enterprise\ActivityReport\Application\Models\ActivityReport;
use Components\Enterprise\ActivityReport\Application\Policies\ActivityReportPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class ActivityReportAuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        ActivityReport::class => ActivityReportPolicy::class
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
