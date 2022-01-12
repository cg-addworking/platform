<?php

namespace Components\Infrastructure\FileDataExtractor\Application\Providers;

use Components\Infrastructure\FileDataExtractor\Application\Detectors\SogetrelAttachmentDetector;
use Components\Infrastructure\FileDataExtractor\Application\Detectors\DocumentDetectorAggregator;
use Components\Infrastructure\FileDataExtractor\Application\Detectors\KbisDetector;
use Components\Infrastructure\FileDataExtractor\Application\Detectors\PurchaseOrderSignatureSogetrelDetector;
use Components\Infrastructure\FileDataExtractor\Application\Detectors\PurchaseOrderSogetrelDetector;
use Components\Infrastructure\FileDataExtractor\Application\Extractors\AttachementSogetrelExtractor;
use Components\Infrastructure\FileDataExtractor\Application\Extractors\DocumentDataExtractorFactory;
use Components\Infrastructure\FileDataExtractor\Application\Extractors\KbisDataExtractor;
use Components\Infrastructure\FileDataExtractor\Application\Extractors\PurchaseOrderSignatureSogetrelExtractor;
use Components\Infrastructure\FileDataExtractor\Application\Extractors\PurchaseOrderSogetrelExtractor;
use Components\Infrastructure\FileDataExtractor\Application\Helpers\StringDataExtractorHelper;
use Components\Infrastructure\FileDataExtractor\Application\Services\DocumentDataExtractorService;
use Components\Infrastructure\FileDataExtractor\Application\Services\DocumentSplitterService;
use Components\Infrastructure\FileDataExtractor\Application\Services\DocumentValidatorService;
use Components\Infrastructure\FileDataExtractor\Application\Validators\DocumentValidatorFactory;
use Components\Infrastructure\FileDataExtractor\Application\Validators\ExtraitKbisValidator;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDataExtractorFactoryInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDataExtractorServiceInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDetectorAggregatorInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentSplitterServiceInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentValidatorFactoryInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentValidatorServiceInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\StringDataExtractorHelperInterface;
use Illuminate\Support\ServiceProvider;

class DocumentServiceProvider extends ServiceProvider
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
        // detection
        $this->app->bind(DocumentDetectorAggregatorInterface::class, function ($app) {
            return new DocumentDetectorAggregator([
                KbisDetector::class,
                SogetrelAttachmentDetector::class,
                PurchaseOrderSogetrelDetector::class,
                PurchaseOrderSignatureSogetrelDetector::class,
            ]);
        });

        // extraction
        $this->app->bind(DocumentDataExtractorFactoryInterface::class, function ($app) {
            return new DocumentDataExtractorFactory($app, [
                KbisDetector::class => KbisDataExtractor::class,
                SogetrelAttachmentDetector::class => AttachementSogetrelExtractor::class,
                PurchaseOrderSogetrelDetector::class => PurchaseOrderSogetrelExtractor::class,
                PurchaseOrderSignatureSogetrelDetector::class => PurchaseOrderSignatureSogetrelExtractor::class,
            ]);
        });

        $this->app->bind(DocumentDataExtractorServiceInterface::class, function ($app) {
            return new DocumentDataExtractorService(
                $app->make(DocumentDetectorAggregatorInterface::class),
                $app->make(DocumentDataExtractorFactoryInterface::class),
            );
        });

        // validation

        $this->app->bind(DocumentValidatorFactoryInterface::class, function ($app) {
            return new DocumentValidatorFactory($app, [
                KbisDetector::class => ExtraitKbisValidator::class,
            ]);
        });

        $this->app->bind(DocumentValidatorServiceInterface::class, function ($app) {
            return new DocumentValidatorService(
                $app->make(DocumentDetectorAggregatorInterface::class),
                $app->make(DocumentValidatorFactoryInterface::class),
            );
        });

        $this->app->bind(DocumentSplitterServiceInterface::class, function ($app) {
            return new DocumentSplitterService();
        });

        $this->app->bind(StringDataExtractorHelperInterface::class, function ($app) {
            return new StringDataExtractorHelper();
        });
    }

    private function bindUseCases()
    {
        //
    }
}
