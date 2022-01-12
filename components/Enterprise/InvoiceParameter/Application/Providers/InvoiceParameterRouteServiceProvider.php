<?php

namespace Components\Enterprise\InvoiceParameter\Application\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class InvoiceParameterRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Components\Enterprise\InvoiceParameter\Application\Controllers';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        Route::middleware(['web', 'auth'])
            ->prefix('addworking')
            ->namespace($this->namespace)
            ->group(function () {
                $base = "enterprise/{enterprise}/invoice-parameter";

                Route::get('enterprise/{enterprise}/invoice-parameter', [
                    'uses' => 'InvoiceParameterController@index',
                    'as' => 'addworking.enterprise.parameter.index'
                ]);

                Route::get('enterprise/{enterprise}/invoice-parameter/create', [
                    'uses' => 'InvoiceParameterController@create',
                    'as' => 'addworking.enterprise.parameter.create'
                ]);

                Route::post('enterprise/{enterprise}/invoice-parameter/store', [
                    'uses' => 'InvoiceParameterController@store',
                    'as' => 'addworking.enterprise.parameter.store'
                ]);

                Route::get('enterprise/{enterprise}/invoice-parameter/{invoice_parameter}', [
                    'uses' => 'InvoiceParameterController@show',
                    'as' => 'addworking.enterprise.parameter.show'
                ]);

                Route::get("{$base}/{invoice_parameter}/edit", [
                    'uses' => 'InvoiceParameterController@edit',
                    'as' => 'addworking.enterprise.parameter.edit'
                ]);

                Route::put("{$base}/{invoice_parameter}/update", [
                    'uses' => 'InvoiceParameterController@update',
                    'as' => 'addworking.enterprise.parameter.update'
                ]);
            });
    }
}
