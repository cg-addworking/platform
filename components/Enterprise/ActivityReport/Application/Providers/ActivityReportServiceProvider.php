<?php

namespace Components\Enterprise\ActivityReport\Application\Providers;

use Components\Enterprise\ActivityReport\Application\Commands\RequestActivityReport;
use Components\Enterprise\ActivityReport\Application\Commands\SendActivityReports;
use Components\Enterprise\ActivityReport\Application\Models\ActivityReport;
use Components\Enterprise\ActivityReport\Application\Models\ActivityReportCustomer;
use Components\Enterprise\ActivityReport\Application\Models\ActivityReportMission;
use Components\Enterprise\ActivityReport\Application\Repositories\ActivityReportCustomerRepository;
use Components\Enterprise\ActivityReport\Application\Repositories\ActivityReportMissionRepository;
use Components\Enterprise\ActivityReport\Application\Repositories\ActivityReportRepository;
use Components\Enterprise\ActivityReport\Domain\Classes\ActivityReportCustomerInterface;
use Components\Enterprise\ActivityReport\Domain\Classes\ActivityReportInterface;
use Components\Enterprise\ActivityReport\Domain\Classes\ActivityReportMissionInterface;
use Components\Enterprise\ActivityReport\Domain\Interfaces\ActivityReportCustomerRepositoryInterface;
use Components\Enterprise\ActivityReport\Domain\Interfaces\ActivityReportMissionRepositoryInterface;
use Components\Enterprise\ActivityReport\Domain\Interfaces\ActivityReportRepositoryInterface;
use Components\Enterprise\ActivityReport\Domain\UseCases\CreateActivityReport;
use Components\Enterprise\Enterprise\Domain\Interfaces\EnterpriseRepositoryInterface;
use Components\Mission\Mission\Domain\Interfaces\MissionRepositoryInterface;
use Components\Module\Module\Domain\Interfaces\ModuleRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class ActivityReportServiceProvider extends ServiceProvider
{
    protected $commands = [
        RequestActivityReport::class,
        SendActivityReports::class
    ];

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        $this->loadViewsFrom([
            __DIR__ . '/../Views'
        ], 'activity_report');

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
        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }
    }

    private function bindRepositoryInterfaces()
    {
        $this->app->bind(
            ActivityReportRepositoryInterface::class,
            ActivityReportRepository::class
        );

        $this->app->bind(
            ActivityReportCustomerRepositoryInterface::class,
            ActivityReportCustomerRepository::class
        );

        $this->app->bind(
            ActivityReportMissionRepositoryInterface::class,
            ActivityReportMissionRepository::class
        );
    }

    private function bindModelInterfaces()
    {
        $this->app->bind(
            ActivityReportInterface::class,
            ActivityReport::class
        );

        $this->app->bind(
            ActivityReportCustomerInterface::class,
            ActivityReportCustomer::class
        );

        $this->app->bind(
            ActivityReportMissionInterface::class,
            ActivityReportMission::class
        );
    }

    private function bindUseCases()
    {
        $this->bindCreateActivityReportUseCase();
    }

    private function bindCreateActivityReportUseCase()
    {
        $this->app->bind(
            CreateActivityReport::class,
            function ($app) {
                return new CreateActivityReport(
                    $app->make(ActivityReportCustomerRepositoryInterface::class),
                    $app->make(ActivityReportMissionRepositoryInterface::class),
                    $app->make(ActivityReportRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(MissionRepositoryInterface::class),
                    $app->make(ModuleRepositoryInterface::class),
                );
            }
        );
    }
}
