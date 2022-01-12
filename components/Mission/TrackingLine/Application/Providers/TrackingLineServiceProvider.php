<?php

namespace Components\Mission\TrackingLine\Application\Providers;

use Illuminate\Support\ServiceProvider;

class TrackingLineServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom([
            __DIR__ . '/../Views'
        ], 'tracking_line');

        $this->loadTranslationsFrom(__DIR__.'/../Langs', 'tracking_line');
    }
}
