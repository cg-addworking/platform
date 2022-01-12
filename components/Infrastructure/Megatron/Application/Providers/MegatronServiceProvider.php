<?php

namespace Components\Infrastructure\Megatron\Application\Providers;

use Components\Infrastructure\Megatron\Application\Commands\Run;
use Components\Infrastructure\Megatron\Domain\Classes\TransformerFactoryInterface;
use Components\Infrastructure\Megatron\Domain\Factories\TransformerFactory;
use Illuminate\Support\ServiceProvider;

class MegatronServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([Run::class]);
        }
    }

    public function register()
    {
        $this->app->bind(TransformerFactoryInterface::class, function ($app) {
            return new TransformerFactory($app, $app['config']->get('megatron.transformers', []));
        });
    }
}
