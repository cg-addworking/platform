<?php

namespace Components\Module\Module\Application\Providers;

use Components\Module\Module\Application\Repositories\ModuleRepository;
use Components\Module\Module\Domain\Interfaces\ModuleRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->bindRepositoryInterfaces();
    }

    private function bindRepositoryInterfaces()
    {
        $this->app->bind(
            ModuleRepositoryInterface::class,
            ModuleRepository::class
        );
    }
}
