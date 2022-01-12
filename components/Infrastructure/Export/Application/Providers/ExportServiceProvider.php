<?php

namespace Components\Infrastructure\Export\Application\Providers;

use Components\Infrastructure\Export\Application\Repositories\ExportRepository;
use Components\Infrastructure\Export\Domain\Interfaces\ExportRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class ExportServiceProvider extends ServiceProvider
{

    public function boot()
    {
        //
    }

    public function register()
    {
        $this->bindRepositoryInterfaces();
    }

    private function bindRepositoryInterfaces()
    {
        $this->app->bind(
            ExportRepositoryInterface::class,
            ExportRepository::class
        );
    }
}
