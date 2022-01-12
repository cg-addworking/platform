<?php

namespace Components\Infrastructure\Export\Application\Providers;

use Components\Infrastructure\Export\Application\Models\Export;
use Components\Infrastructure\Export\Application\Policies\ExportPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class ExportAuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Export::class => ExportPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        $this->loadViewsFrom([
            __DIR__ . '/../Views'
        ], 'export');
    }
}
