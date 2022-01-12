<?php

namespace Components\Mission\Mission\Application\Providers;

use App\Repositories\Addworking\Mission\MilestoneRepository;
use Components\Mission\Mission\Domain\Interfaces\MilestoneRepositoryInterface;
use Components\Mission\Mission\Domain\Interfaces\MissionRepositoryInterface as OldMissionRepositoryInterface;
use Components\Mission\Mission\Domain\Interfaces\TrackingLineRepositoryInterface;
use Components\Mission\Mission\Domain\Interfaces\TrackingRepositoryInterface;
use Components\Mission\Mission\Application\Repositories\NewMissionRepository;
use Components\Mission\Mission\Application\Repositories\EnterpriseRepository;
use Components\Mission\Mission\Application\Repositories\MissionRepository;
use Components\Mission\Mission\Application\Repositories\SectorRepository;
use Components\Mission\Mission\Application\Repositories\TrackingLineRepository;
use Components\Mission\Mission\Application\Repositories\TrackingRepository;
use Components\Mission\Mission\Application\Repositories\UserRepository;
use Components\Mission\Mission\Application\Repositories\WorkFieldRepository;
use Components\Mission\Mission\Domain\Interfaces\Repositories\MissionRepositoryInterface;
use Components\Mission\Mission\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;
use Components\Mission\Mission\Domain\Interfaces\Repositories\SectorRepositoryInterface;
use Components\Mission\Mission\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Components\Mission\Mission\Domain\Interfaces\Repositories\WorkFieldRepositoryInterface;
use Components\Mission\Mission\Domain\UseCases\CreateConstructionMission;
use Components\Mission\Offer\Domain\Interfaces\Repositories\CostEstimationRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class MissionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        $this->loadViewsFrom([__DIR__ . '/../Views'], 'mission');
        $this->loadTranslationsFrom(__DIR__.'/../Langs', 'mission');
        $this->bootDirectives();
    }

    protected function bootDirectives()
    {
        //
    }

    protected function bootForConsole()
    {
        //
    }

    public function register()
    {
        $this->bindRepositoryInterfaces();
        $this->bindNewRepositoryInterfaces();
        $this->bindUseCases();
    }

    private function bindNewRepositoryInterfaces()
    {
        $this->app->bind(
            MissionRepositoryInterface::class,
            NewMissionRepository::class,
        );

        $this->app->bind(
            EnterpriseRepositoryInterface::class,
            EnterpriseRepository::class,
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class,
        );

        $this->app->bind(
            WorkFieldRepositoryInterface::class,
            WorkFieldRepository::class,
        );

        $this->app->bind(
            SectorRepositoryInterface::class,
            SectorRepository::class,
        );
    }

    private function bindRepositoryInterfaces()
    {
        $this->app->bind(
            OldMissionRepositoryInterface::class,
            MissionRepository::class,
        );

        $this->app->bind(
            MilestoneRepositoryInterface::class,
            MilestoneRepository::class,
        );

        $this->app->bind(
            TrackingRepositoryInterface::class,
            TrackingRepository::class,
        );

        $this->app->bind(
            TrackingLineRepositoryInterface::class,
            TrackingLineRepository::class,
        );
    }

    protected function bindUseCases()
    {
        $this->bindCreateConstructionMissionUseCase();
    }

    protected function bindCreateConstructionMissionUseCase()
    {
        $this->app->bind(
            CreateConstructionMission::class,
            function ($app) {
                return new CreateConstructionMission(
                    $app->make(MissionRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                    $app->make(WorkFieldRepositoryInterface::class),
                    $app->make(SectorRepositoryInterface::class),
                    $app->make(CostEstimationRepositoryInterface::class),
                );
            }
        );
    }
}
