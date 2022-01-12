<?php

namespace App\Providers\Spie\Enterprise;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class EnterpriseRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers\Spie\Enterprise';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->prefix('spie')
            ->name('spie.enterprise.')
            ->group(function () {
                Route::resource('enterprise', 'EnterpriseController');
                Route::resource('coverage_zone', 'CoverageZoneController');
                Route::resource('enterprise.qualification', 'QualificationController');
                Route::resource('enterprise.order', 'OrderController');
            });
    }
}
