<?php

namespace Components\Infrastructure\DatabaseCommands\Providers;

use Components\Infrastructure\DatabaseCommands\Commands\Database\Drop;
use Components\Infrastructure\DatabaseCommands\Commands\Database\PgCopy;
use Components\Infrastructure\DatabaseCommands\Commands\Database\Reset;
use Components\Infrastructure\DatabaseCommands\Commands\Database\Table;
use Components\Infrastructure\DatabaseCommands\Commands\Database\Tables;
use Components\Infrastructure\DatabaseCommands\Helpers\ClassFinder;
use Components\Infrastructure\DatabaseCommands\Helpers\ModelFinder;
use Illuminate\Support\ServiceProvider;

class DatabaseCommandsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->commands([
                Drop::class,
                PgCopy::class,
                Reset::class,
                Table::class,
                Tables::class,
            ]);
        }

        $this->app->make('class-finder');
        $this->app->make('laravel-models')->registerFunctions();
    }

    public function register()
    {
        $this->app->singleton('class-finder', function ($app) {
            return ClassFinder::usingAutoload(base_path());
        });

        $this->app->singleton('laravel-models', function ($app) {
            return $app->make(ModelFinder::class)
                ->setDirectories($app['config']->get('models.directories'))
                ->setAliases($app['config']->get('models.aliases'))
                ->registerFunctions();
        });
    }

    public function provides()
    {
        return ['class-finder', 'laravel-models'];
    }

    protected function bootForConsole()
    {
        $this->publishes([], 'class-finder');

        $this->publishes([
            base_path('config/models.php') => config_path('models.php'),
        ], 'laravel-models');
    }
}
