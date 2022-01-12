<?php

namespace Components\Sogetrel\Passwork\Application\Providers;

use Components\Sogetrel\Passwork\Application\Models\Acceptation;
use Components\Sogetrel\Passwork\Application\Models\AcceptationContractType;
use Components\Sogetrel\Passwork\Application\Repositories\AcceptationContractTypeRepository;
use Components\Sogetrel\Passwork\Application\Repositories\AcceptationRepository;
use Components\Sogetrel\Passwork\Application\Repositories\EnterpriseRepository;
use Components\Sogetrel\Passwork\Application\Repositories\UserRepository;
use Components\Sogetrel\Passwork\Domain\Interfaces\Entities\AcceptationContractTypeEntityInterface;
use Components\Sogetrel\Passwork\Domain\Interfaces\Entities\AcceptationEntityInterface;
use Components\Sogetrel\Passwork\Domain\Interfaces\Repositories\AcceptationContractTypeRepositoryInterface;
use Components\Sogetrel\Passwork\Domain\Interfaces\Repositories\AcceptationRepositoryInterface;
use Components\Sogetrel\Passwork\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;
use Components\Sogetrel\Passwork\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Components\Sogetrel\Passwork\Domain\UseCases\CreateAcceptationContractType;
use Components\Sogetrel\Passwork\Domain\UseCases\CreateAcceptationFromPasswork;
use Components\Sogetrel\Passwork\Domain\UseCases\ListAcceptation;
use Illuminate\Support\ServiceProvider;

class PassworkServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../Views', 'sogetrel_passwork');

        $this->loadTranslationsFrom(__DIR__.'/../Langs', 'sogetrel_passwork');
    }

    public function register()
    {
        $this->bindEntityInterfaces();

        $this->bindRepositoryInterfaces();

        $this->bindUseCases();
    }

    private function bindEntityInterfaces()
    {
        $this->app->bind(
            AcceptationEntityInterface::class,
            Acceptation::class
        );

        $this->app->bind(
            AcceptationContractTypeEntityInterface::class,
            AcceptationContractType::class
        );
    }

    private function bindRepositoryInterfaces()
    {
        $this->app->bind(
            AcceptationRepositoryInterface::class,
            AcceptationRepository::class
        );

        $this->app->bind(
            AcceptationContractTypeRepositoryInterface::class,
            AcceptationContractTypeRepository::class
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
        $this->bindCreateAcceptationFromPasswork();
        $this->bindCreateAcceptationContractType();
        $this->bindListAcceptation();
    }

    private function bindCreateAcceptationFromPasswork()
    {
        $this->app->bind(
            CreateAcceptationFromPasswork::class,
            function ($app) {
                return new CreateAcceptationFromPasswork(
                    $app->make(AcceptationRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                );
            }
        );
    }

    private function bindCreateAcceptationContractType()
    {
        $this->app->bind(
            CreateAcceptationContractType::class,
            function ($app) {
                return new CreateAcceptationContractType(
                    $app->make(AcceptationContractTypeRepositoryInterface::class)
                );
            }
        );
    }

    private function bindListAcceptation()
    {
        $this->app->bind(
            ListAcceptation::class,
            function ($app) {
                return new ListAcceptation(
                    $app->make(AcceptationRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                );
            }
        );
    }
}
