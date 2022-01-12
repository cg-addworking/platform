<?php

namespace Components\Enterprise\WorkField\Application\Providers;

use Components\Enterprise\WorkField\Application\Models\WorkField;
use Components\Enterprise\WorkField\Application\Policies\WorkFieldPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class WorkFieldAuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        WorkField::class => WorkFieldPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
