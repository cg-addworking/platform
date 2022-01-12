<?php

namespace App\Providers\Support\Mission;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class MissionRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers\Support\Mission';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        Route::middleware('support')
            ->prefix('support')
            ->name('support.')
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('enterprise/offer', [
                    'uses' => "OfferController@index",
                    'as'   => "enterprise.offer",
                ]);

                Route::get('enterprise/mission/tracking/line', [
                    'uses' => "MissionTrackingLineController@index",
                    'as' => 'enterprise.mission.tracking.line'
                ]);

                Route::get('enterprise/mission/tracking/line/export', [
                    'uses' => "MissionTrackingLineController@export",
                    'as' => 'enterprise.mission.tracking.line.export'
                ]);
            });
    }
}
