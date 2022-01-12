<?php

namespace Components\Enterprise\Export\Application\Providers;

use Components\Enterprise\Export\Application\Commands\SendEnterprisesExportsToAddworkingMail;
use Illuminate\Support\ServiceProvider;

class ExportServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        $this->loadViewsFrom([
            __DIR__ . '/../Views'
        ], 'export');
        
        $this->bootDirectives();
    }

    public function register()
    {
        //
    }

    public function provides()
    {
        //
    }

    protected function bootDirectives()
    {
        //
    }

    protected function bootForConsole()
    {
        $this->commands([SendEnterprisesExportsToAddworkingMail::class]);
    }
}
