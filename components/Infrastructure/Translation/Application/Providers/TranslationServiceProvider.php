<?php

namespace Components\Infrastructure\Translation\Application\Providers;

use Components\Infrastructure\Translation\Application\Commands\AddMissingKeys;
use Components\Infrastructure\Translation\Application\Commands\Check;
use Components\Infrastructure\Translation\Application\Commands\Check\EmptyKeys;
use Components\Infrastructure\Translation\Application\Commands\Check\Untranslated;
use Components\Infrastructure\Translation\Application\Commands\Check\UnusedKeys;
use Components\Infrastructure\Translation\Application\Commands\Dump;
use Components\Infrastructure\Translation\Application\Commands\Fix;
use Components\Infrastructure\Translation\Application\Commands\Keys;
use Components\Infrastructure\Translation\Application\Commands\Summary;
use Components\Infrastructure\Translation\Domain\Classes\TransformerFactoryInterface;
use Components\Infrastructure\Translation\Domain\Factories\TransformerFactory;
use Illuminate\Support\ServiceProvider;

class TranslationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                EmptyKeys::class,
                UnusedKeys::class,
                AddMissingKeys::class,
                Check::class,
                Dump::class,
                Fix::class,
                Keys::class,
                Summary::class,
            ]);
        }
    }

    public function register()
    {
        //
    }
}
