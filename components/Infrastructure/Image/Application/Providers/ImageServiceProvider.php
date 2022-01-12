<?php

namespace Components\Infrastructure\Image\Application\Providers;

use Components\Infrastructure\Image\Application\Services\ImageTextExtractor;
use Components\Infrastructure\Image\Domain\Interfaces\ImageTextExtractorInterface;
use Illuminate\Support\ServiceProvider;

class ImageServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        // $this->loadViewsFrom([
        //     __DIR__ . '/../Views'
        // ], 'common');

        // $this->loadFactoriesFrom(__DIR__ . '/../Factories');

        $this->bootDirectives();
    }

    public function register()
    {
        $this->bindModelInterfaces();

        $this->bindRepositoryInterfaces();

        $this->bindServicesInterfaces();

        $this->bindUseCases();
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
        //
    }

    private function bindModelInterfaces()
    {
        //
    }

    private function bindRepositoryInterfaces()
    {
        //
    }

    private function bindServicesInterfaces()
    {
        $this->app->bind(
            ImageTextExtractorInterface::class,
            ImageTextExtractor::class,
        );
    }

    private function bindUseCases()
    {
        //
    }
}
