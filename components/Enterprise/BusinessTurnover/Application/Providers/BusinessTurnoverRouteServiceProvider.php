<?php

namespace Components\Enterprise\BusinessTurnover\Application\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class BusinessTurnoverRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Components\Enterprise\BusinessTurnover\Application\Controllers';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapBusinessTurnoverRoutes();
    }

    private function mapBusinessTurnoverRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "business-turnover";

                Route::get("{$base}/create", [
                    'uses' => 'BusinessTurnoverController@create', 'as' => 'business_turnover.create'
                ]);

                Route::get("{$base}/skip", [
                    'uses' => 'BusinessTurnoverController@skip', 'as' => 'business_turnover.skip'
                ]);

                Route::post("{$base}/store", [
                    'uses' => 'BusinessTurnoverController@store', 'as' => 'business_turnover.store'
                ]);
            });
    }
}
