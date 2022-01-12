<?php

namespace Components\Mission\Mission\Application\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class MissionRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Components\Mission\Mission\Application\Controllers';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapMission();
        $this->mapAjaxMission();
    }

    public function mapMission()
    {
        Route::middleware(['web', 'auth'])
            ->prefix('sector')
            ->namespace($this->namespace)
            ->group(function () {
                $base = "mission";

                Route::get("{$base}/create", [
                    'uses' => 'MissionController@create',
                    'as' => 'sector.mission.create'
                ]);

                Route::post("{$base}/store", [
                    'uses' => 'MissionController@store',
                    'as' => 'sector.mission.store'
                ]);

                Route::get("{$base}/{mission}/edit", [
                    'uses' => 'MissionController@edit',
                    'as' => 'sector.mission.edit'
                ]);

                Route::put("{$base}/{mission}/update", [
                    'uses' => 'MissionController@update',
                    'as' => 'sector.mission.update'
                ]);

                Route::get("{$base}/{mission}", [
                    'uses' => 'MissionController@show',
                    'as' => 'sector.mission.show'
                ]);

                Route::delete("{$base}/{mission}/file/{file}/delete", [
                    'uses' => 'MissionController@deleteFile',
                    'as' => 'sector.mission.file.delete'
                ]);
            });
    }

    public function mapAjaxMission()
    {
        Route::middleware(['web', 'auth'])
            ->prefix('sector')
            ->namespace($this->namespace)
            ->group(function () {
                $base = "mission";

                Route::post("{$base}/get-referent", [
                    'uses' => 'MissionAjaxController@getReferentsOf',
                    'as' => 'sector.mission.get_referent'
                ]);

                Route::post("{$base}/get-vendor", [
                    'uses' => 'MissionAjaxController@getVendorsOf',
                    'as' => 'sector.mission.get_vendor'
                ]);

                Route::post("{$base}/get-workfield", [
                    'uses' => 'MissionAjaxController@getWorkfieldsOf',
                    'as' => 'sector.mission.get_workfield'
                ]);
            });
    }
}
