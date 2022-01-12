<?php

namespace Components\Infrastructure\ElectronicSignature\Application\Providers;

use Illuminate\Support\ServiceProvider;

class ElectronicSignatureServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom([
            __DIR__ . '/../Views'
        ], 'electronic_signature');
    }

    public function register()
    {
        //
    }

    public function provides()
    {
        //
    }
}
