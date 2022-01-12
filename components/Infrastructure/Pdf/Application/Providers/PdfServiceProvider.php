<?php

namespace Components\Infrastructure\Pdf\Application\Providers;

use Components\Infrastructure\Pdf\Application\Services\PdfImageConverter;
use Components\Infrastructure\Pdf\Application\Services\PdfImageExtractor;
use Components\Infrastructure\Pdf\Application\Services\PdfTextExtractor;
use Components\Infrastructure\Pdf\Domain\Interfaces\PdfImageConverterInterface;
use Components\Infrastructure\Pdf\Domain\Interfaces\PdfImageExtractorInterface;
use Components\Infrastructure\Pdf\Domain\Interfaces\PdfTextExtractorInterface;
use Illuminate\Support\ServiceProvider;

class PdfServiceProvider extends ServiceProvider
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
            PdfImageConverterInterface::class,
            PdfImageConverter::class,
        );

        $this->app->bind(
            PdfTextExtractorInterface::class,
            PdfTextExtractor::class,
        );

        $this->app->bind(
            PdfImageExtractorInterface::class,
            PdfImageExtractor::class,
        );
    }

    private function bindUseCases()
    {
        //
    }
}
