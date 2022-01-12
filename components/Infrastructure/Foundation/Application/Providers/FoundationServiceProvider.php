<?php

namespace Components\Infrastructure\Foundation\Application\Providers;

use Illuminate\Support\ServiceProvider;

class FoundationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom([
            __DIR__ . '/../Views'
        ], 'foundation');

        $this->loadTranslationsFrom(__DIR__.'/../Views/translations', 'foundation');
    }

    public function register()
    {
        //
    }
}
