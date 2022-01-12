<?php

namespace Components\Common\Common\Application\Providers;

use App\Models\Addworking\Common\File;
use Components\Common\Common\Application\Convertor\CsvToPdf;
use Components\Common\Common\Application\Observers\FileObserver;
use Components\Common\Common\Application\Repositories\ActionRepository;
use Components\Common\Common\Application\Repositories\FileRepository;
use Components\Common\Common\Application\Validator\PdfHeaderValidator;
use Components\Common\Common\Domain\Interfaces\ActionRepositoryInterface;
use Components\Common\Common\Domain\Interfaces\CsvToPdfConvertorInterface;
use Components\Common\Common\Domain\Interfaces\FileImmutableInterface;
use Components\Common\Common\Domain\Interfaces\FileRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class CommonServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        $this->loadViewsFrom([
            __DIR__ . '/../Views'
        ], 'common');

        // $this->loadFactoriesFrom(__DIR__ . '/../Factories');

        $this->bootDirectives();
        $this->bootValidator();

        File::observe(
            new FileObserver
        );
    }

    public function register()
    {
        $this->bindModelInterfaces();

        $this->bindRepositoryInterfaces();

        $this->bindUseCases();

        $this->bindConvertor();
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

    protected function bootValidator(): self
    {
        Validator::extend('file_header_is_pdf', function ($attribute, $value, $parameters, $validator) {
            return PdfHeaderValidator::validate(file_get_contents($value));
        });

        return $this;
    }

    private function bindModelInterfaces()
    {
        $this->app->bind(
            FileImmutableInterface::class,
            File::class
        );
    }

    private function bindRepositoryInterfaces()
    {
        $this->app->bind(
            FileRepositoryInterface::class,
            FileRepository::class,
        );
        $this->app->bind(
            ActionRepositoryInterface::class,
            ActionRepository::class,
        );
    }

    private function bindUseCases()
    {
        //
    }

    private function bindConvertor()
    {
        $this->app->bind(
            CsvToPdfConvertorInterface::class,
            CsvToPdf::class
        );
    }
}
