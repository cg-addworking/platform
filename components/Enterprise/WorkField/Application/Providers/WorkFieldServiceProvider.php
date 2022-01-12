<?php

namespace Components\Enterprise\WorkField\Application\Providers;

use Illuminate\Support\ServiceProvider;
use Components\Enterprise\WorkField\Application\Models\Sector;
use Components\Enterprise\WorkField\Application\Models\WorkField;
use Components\Enterprise\WorkField\Domain\UseCases\AttachContributorToWorkField;
use Components\Enterprise\WorkField\Domain\UseCases\DetachContributorToWorkField;
use Components\Enterprise\WorkField\Domain\UseCases\EditWorkField;
use Components\Enterprise\WorkField\Domain\UseCases\ShowWorkField;
use Components\Enterprise\WorkField\Domain\UseCases\CreateWorkField;
use Components\Enterprise\WorkField\Domain\UseCases\DeleteWorkField;
use Components\Enterprise\WorkField\Domain\Interfaces\Entities\SectorEntityInterface;
use Components\Enterprise\WorkField\Domain\Interfaces\Entities\WorkFieldEntityInterface;
use Components\Enterprise\WorkField\Application\Repositories\UserRepository;
use Components\Enterprise\WorkField\Application\Repositories\SectorRepository;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldRepository;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldContributorRepository;
use Components\Enterprise\WorkField\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\WorkField\Application\Presenters\WorkFieldShowPresenter;
use Components\Enterprise\WorkField\Domain\Interfaces\Presenters\WorkFieldShowPresenterInterface;
use Components\Enterprise\WorkField\Domain\Interfaces\Repositories\SectorRepositoryInterface;
use Components\Enterprise\WorkField\Domain\Interfaces\Repositories\WorkFieldRepositoryInterface;
use Components\Enterprise\WorkField\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Components\Enterprise\WorkField\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;
use Components\Enterprise\WorkField\Domain\Interfaces\Repositories\WorkFieldContributorRepositoryInterface;

class WorkFieldServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom([
            __DIR__ . '/../Views'
        ], 'work_field');

        $this->loadTranslationsFrom(__DIR__.'/../Langs', 'work_field');
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
            WorkFieldEntityInterface::class,
            WorkField::class
        );

        $this->app->bind(
            SectorEntityInterface::class,
            Sector::class
        );
    }

    private function bindPresenterInterfaces()
    {
        $this->app->bind(
            WorkFieldShowPresenterInterface::class,
            WorkFieldShowPresenter::class
        );
    }

    private function bindRepositoryInterfaces()
    {
        $this->app->bind(
            WorkFieldRepositoryInterface::class,
            WorkFieldRepository::class
        );

        $this->app->bind(
            WorkFieldContributorRepositoryInterface::class,
            WorkFieldContributorRepository::class
        );

        $this->app->bind(
            SectorRepositoryInterface::class,
            SectorRepository::class
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
        $this->bindCreateWorkFieldUseCase();
        $this->bindAttachContributorToWorkFieldUseCase();
        $this->bindEditWorkFieldUseCase();
        $this->bindShowWorkFieldUseCase();
        $this->bindDetachContributorToWorkFieldUseCase();
        $this->bindDeleteWorkFieldUseCase();
    }

    private function bindCreateWorkFieldUseCase()
    {
        $this->app->bind(
            CreateWorkField::class,
            function ($app) {
                return new CreateWorkField(
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(SectorRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                    $app->make(WorkFieldRepositoryInterface::class)
                );
            }
        );
    }

    private function bindAttachContributorToWorkFieldUseCase()
    {
        $this->app->bind(
            AttachContributorToWorkField::class,
            function ($app) {
                return new AttachContributorToWorkField(
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(SectorRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                    $app->make(WorkFieldRepositoryInterface::class),
                    $app->make(WorkFieldContributorRepositoryInterface::class)
                );
            }
        );
    }

    private function bindEditWorkFieldUseCase()
    {
        $this->app->bind(
            EditWorkField::class,
            function ($app) {
                return new EditWorkField(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(WorkFieldRepositoryInterface::class),
                    $app->make(WorkFieldContributorRepositoryInterface::class)
                );
            }
        );
    }

    private function bindShowWorkFieldUseCase()
    {
        $this->app->bind(
            ShowWorkField::class,
            function ($app) {
                return new ShowWorkField(
                    $app->make(WorkFieldRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                    $app->make(WorkFieldContributorRepositoryInterface::class)
                );
            }
        );
    }

    private function bindDetachContributorToWorkFieldUseCase()
    {
        $this->app->bind(
            DetachContributorToWorkField::class,
            function ($app) {
                return new DetachContributorToWorkField(
                    $app->make(WorkFieldRepositoryInterface::class),
                    $app->make(WorkFieldContributorRepositoryInterface::class)
                );
            }
        );
    }

    private function bindDeleteWorkFieldUseCase()
    {
        $this->app->bind(
            DeleteWorkField::class,
            function ($app) {
                return new DeleteWorkField(
                    $app->make(WorkFieldRepositoryInterface::class),
                    $app->make(WorkFieldContributorRepositoryInterface::class)
                );
            }
        );
    }
}
