<?php

namespace Components\Enterprise\ActivityReport\Application\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class ActivityReportRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Components\Enterprise\ActivityReport\Application\Controllers';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->prefix('addworking')
            ->name('addworking.')
            ->group(function () {
                $base = "enterprise/{enterprise}/activity-report";

                Route::get("{$base}/create", [
                    'uses' => 'ActivityReportController@create', 'as' => 'enterprise.activity_report.create'
                ]);

                Route::post("{$base}/store", [
                    'uses' => 'ActivityReportController@store', 'as' => 'enterprise.activity_report.store'
                ]);
            });
    }
}
