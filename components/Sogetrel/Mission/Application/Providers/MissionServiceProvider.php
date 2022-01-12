<?php

namespace Components\Sogetrel\Mission\Application\Providers;

use Components\Sogetrel\Mission\Application\Models\MissionTrackingLineAttachment;
use Components\Sogetrel\Mission\Application\Repositories\MissionTrackingLineAttachmentRepository;
use Components\Sogetrel\Mission\Domain\Interfaces\MissionTrackingLineAttachmentEntityInterface;
use Components\Sogetrel\Mission\Domain\Interfaces\MissionTrackingLineAttachmentRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class MissionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        $this->loadViewsFrom([
            __DIR__ . '/../Views'
        ], 'sogetrel_mission');

        $this->loadFactoriesFrom(__DIR__ . '/../Factories');

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

    private function bindModelInterfaces()
    {
        $this->app->bind(
            MissionTrackingLineAttachmentEntityInterface::class,
            MissionTrackingLineAttachment::class
        );
    }

    private function bindRepositoryInterfaces()
    {
        $this->app->bind(
            MissionTrackingLineAttachmentRepositoryInterface::class,
            MissionTrackingLineAttachmentRepository::class,
        );
    }

    private function bindUseCases()
    {
        //
    }
}
