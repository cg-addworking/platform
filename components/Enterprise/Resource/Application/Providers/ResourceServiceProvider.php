<?php

namespace Components\Enterprise\Resource\Application\Providers;

use Components\Enterprise\Resource\Application\Models\ActivityPeriod;
use Components\Enterprise\Resource\Application\Models\Resource;
use Components\Enterprise\Resource\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\Resource\Application\Repositories\ModuleRepository;
use Components\Enterprise\Resource\Application\Repositories\ResourceRepository;
use Components\Enterprise\Resource\Application\Repositories\UserRepository;
use Components\Enterprise\Resource\Domain\Classes\ActivityPeriodInterface;
use Components\Enterprise\Resource\Domain\Classes\ResourceInterface;
use Components\Enterprise\Resource\Domain\Repositories\EnterpriseRepositoryInterface;
use Components\Enterprise\Resource\Domain\Repositories\ModuleRepositoryInterface;
use Components\Enterprise\Resource\Domain\Repositories\ResourceRepositoryInterface;
use Components\Enterprise\Resource\Domain\Repositories\UserRepositoryInterface;
use Components\Enterprise\Resource\Domain\UseCases\CreateResourceForVendor;
use Illuminate\Support\ServiceProvider;

class ResourceServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        $this->loadViewsFrom([
            __DIR__ . '/../Views'
        ], 'resource');

        $this->loadFactoriesFrom(__DIR__.'/../Factories');

        $this->bootDirectives();
    }

    public function register()
    {
        $this->bindModelInterfaces();

        $this->bindRepositoryInterfaces();

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

    private function bindRepositoryInterfaces()
    {
        $this->app->bind(
            EnterpriseRepositoryInterface::class,
            EnterpriseRepository::class
        );

        $this->app->bind(
            ModuleRepositoryInterface::class,
            ModuleRepository::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            ResourceRepositoryInterface::class,
            ResourceRepository::class
        );
    }

    private function bindModelInterfaces()
    {
        $this->app->bind(
            ResourceInterface::class,
            Resource::class
        );

        $this->app->bind(
            ActivityPeriodInterface::class,
            ActivityPeriod::class
        );
    }

    private function bindUseCases()
    {
        $this->bindCreateResourceForVendorUseCase();
    }

    private function bindCreateResourceForVendorUseCase()
    {
        $this->app->bind(
            CreateResourceForVendor::class,
            function ($app) {
                return new CreateResourceForVendor(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(ResourceInterface::class),
                    $app->make(ModuleRepositoryInterface::class),
                    $app->make(ResourceRepositoryInterface::class)
                );
            }
        );
    }
}
