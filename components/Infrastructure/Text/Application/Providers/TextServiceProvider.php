<?php

namespace Components\Infrastructure\Text\Application\Providers;

use Components\Infrastructure\Image\Application\Services\ImageTextExtractor;
use Components\Infrastructure\Pdf\Application\Services\PdfImageConverter;
use Components\Infrastructure\Pdf\Application\Services\PdfImageExtractor;
use Components\Infrastructure\Pdf\Application\Services\PdfTextExtractor;
use Components\Infrastructure\Text\Application\Services\TextExtractorService;
use Components\Infrastructure\Text\Domain\Interfaces\TextExtractorServiceInterface;
use Illuminate\Support\ServiceProvider;

class TextServiceProvider extends ServiceProvider
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
            TextExtractorServiceInterface::class,
            function ($app) {
                return new TextExtractorService(
                    new PdfTextExtractor,
                    new PdfImageExtractor,
                    new PdfImageConverter,
                    new ImageTextExtractor
                );
            }
        );
    }

    private function bindUseCases()
    {
        //
    }
}
