<?php

namespace App\Providers\Edenred\Common;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class CommonRouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers\Edenred\Common';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        Route::middleware(['web', 'auth'])
            ->prefix('edenred')
            ->name('edenred.common.')
            ->namespace($this->namespace)
            ->group(function () {
                Route::resource('code', 'CodeController');
                Route::resource('code.average_daily_rate', 'AverageDailyRateController');
            });
    }
}
