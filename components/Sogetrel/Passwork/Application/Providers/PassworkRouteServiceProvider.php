<?php

namespace Components\Sogetrel\Passwork\Application\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class PassworkRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Components\Sogetrel\Passwork\Application\Controllers';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapAcceptationRoutes();
    }

    private function mapAcceptationRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "sogetrel";

                Route::get("{$base}/passwork-acceptation", [
                    'uses' => 'AcceptationController@index', 'as' => 'sogetrel.passwork.acceptation.index'
                ]);

                Route::get("{$base}/passwork/{passwork}/acceptation/create", [
                    'uses' => 'AcceptationController@create', 'as' => 'sogetrel.passwork.acceptation.create'
                ]);

                Route::get("{$base}/passwork/{passwork}/acceptation/{acceptation}/optional-monitoring-data", [
                    'uses' => 'AcceptationController@viewOperationalMonitoringData',
                    'as' => 'sogetrel.passwork.acceptation.optional_monitoring_data'
                ]);
            });
    }
}
