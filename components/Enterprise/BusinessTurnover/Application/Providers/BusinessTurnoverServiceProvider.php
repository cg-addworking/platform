<?php

namespace Components\Enterprise\BusinessTurnover\Application\Providers;

use Components\Enterprise\BusinessTurnover\Application\Models\BusinessTurnover;
use Components\Enterprise\BusinessTurnover\Application\Repositories\BusinessTurnoverRepository;
use Components\Enterprise\BusinessTurnover\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\BusinessTurnover\Application\Repositories\UserRepository;
use Components\Enterprise\BusinessTurnover\Domain\Interfaces\Entities\BusinessTurnoverEntityInterface;
use Components\Enterprise\BusinessTurnover\Domain\Interfaces\Repositories\BusinessTurnoverRepositoryInterface;
use Components\Enterprise\BusinessTurnover\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;
use Components\Enterprise\BusinessTurnover\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Components\Enterprise\BusinessTurnover\Domain\UseCases\CreateBusinessTurnover;
use Illuminate\Support\ServiceProvider;

class BusinessTurnoverServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom([
            __DIR__ . '/../Views'
        ], 'business_turnover');

        $this->loadTranslationsFrom(__DIR__.'/../Langs', 'business_turnover');
    }

    public function register()
    {
        $this->bindEntityInterfaces();
        $this->bindPresenterInterfaces();
        $this->bindRepositoryInterfaces();
        $this->bindUseCases();
    }

    private function bindEntityInterfaces()
    {
        $this->app->bind(
            BusinessTurnoverEntityInterface::class,
            BusinessTurnover::class
        );
    }

    private function bindPresenterInterfaces()
    {
        //
    }

    private function bindRepositoryInterfaces()
    {
        $this->app->bind(
            BusinessTurnoverRepositoryInterface::class,
            BusinessTurnoverRepository::class
        );

        $this->app->bind(
            EnterpriseRepositoryInterface::class,
            EnterpriseRepository::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
    }

    private function bindUseCases()
    {
        $this->bindCreateBusinessTurnoverUseCase();
    }

    private function bindCreateBusinessTurnoverUseCase()
    {
        $this->app->bind(
            CreateBusinessTurnover::class,
            function ($app) {
                return new CreateBusinessTurnover(
                    $app->make(BusinessTurnoverRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class)
                );
            }
        );
    }
}
