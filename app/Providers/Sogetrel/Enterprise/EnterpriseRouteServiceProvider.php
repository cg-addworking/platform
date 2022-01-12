<?php

namespace App\Providers\Sogetrel\Enterprise;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class EnterpriseRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers\Sogetrel\Enterprise';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('/enterprise/{enterprise}/synchronize-navibat', 'EnterpriseController@synchronizeNavibat')
                ->name('enterprise.synchronize-navibat');

                Route::get('sogetrel/attachment-search', 'EnterpriseController@airtableIframe')
                ->name('sogetrel.iframe.show');

                Route::post('/enterprise/set-oracle-id', 'EnterpriseController@setOracleId')
                ->name('enterprise.set_oracle_id');
            });
    }
}
