<?php

namespace Components\User\User\Application\Providers;

use Components\User\User\Application\Repositories\UserRepository;
use Components\User\User\Application\Services\UserService;
use Components\User\User\Domain\Interfaces\UserRepositoryInterface;
use Components\User\User\Domain\Interfaces\UserServiceInterface;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->bindRepositoryInterfaces();
    }

    private function bindRepositoryInterfaces()
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            UserServiceInterface::class,
            UserService::class
        );
    }
}
