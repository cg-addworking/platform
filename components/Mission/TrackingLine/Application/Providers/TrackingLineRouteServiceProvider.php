<?php

namespace Components\Mission\TrackingLine\Application\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class TrackingLineRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Components\Mission\TrackingLine\Application\Controllers';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapTrackingLineRoutes();
    }

    private function mapTrackingLineRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "tracking-line";

                Route::get("{$base}/import", [
                    'uses' => 'TrackingLineController@import', 'as' => 'tracking_line.import'
                ]);

                Route::post("{$base}/load", [
                    'uses' => 'TrackingLineController@load', 'as' => 'tracking_line.load'
                ]);
            });
    }
}
