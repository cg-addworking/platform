<?php

namespace Components\Enterprise\Resource\Application\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class ResourceRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Components\Enterprise\Resource\Application\Controllers';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapResource();
        $this->mapAssignedResource();
    }

    public function mapResource()
    {
        Route::middleware(['web', 'auth'])
            ->prefix('addworking')
            ->namespace($this->namespace)
            ->group(function () {
                $base = "enterprise/{enterprise}/resource";

                Route::get("{$base}", [
                    'uses' => 'ResourceController@index',
                    'as'   => 'addworking.enterprise.resource.index'
                ]);

                Route::get("{$base}/create", [
                    'uses' => 'ResourceController@create',
                    'as'   => 'addworking.enterprise.resource.create'
                ]);

                Route::post("{$base}/store", [
                    'uses' => 'ResourceController@store',
                    'as'   => 'addworking.enterprise.resource.store'
                ]);

                Route::get("{$base}/{resource}", [
                    'uses' => 'ResourceController@show',
                    'as'   => 'addworking.enterprise.resource.show'
                ]);

                Route::get("{$base}/{resource}/edit", [
                    'uses' => 'ResourceController@edit',
                    'as'   => 'addworking.enterprise.resource.edit'
                ]);

                Route::put("{$base}/{resource}/update", [
                    'uses' => 'ResourceController@update',
                    'as'   => 'addworking.enterprise.resource.update'
                ]);

                Route::delete("{$base}/{resource}/destroy", [
                    'uses' => 'ResourceController@destroy',
                    'as'   => 'addworking.enterprise.resource.destroy'
                ]);

                Route::get("{$base}/{resource}/assign", [
                    'uses' => 'ResourceController@assign',
                    'as'   => 'addworking.enterprise.resource.assign'
                ]);

                Route::post("{$base}/{resource}/assign", [
                    'uses' => 'ResourceController@assignPost',
                    'as'   => 'addworking.enterprise.resource.assign_post'
                ]);

                Route::get("{$base}/{resource}/attach", [
                    'uses' => 'ResourceController@attach',
                    'as'   => 'addworking.enterprise.resource.attach'
                ]);

                Route::post("{$base}/{resource}/attach", [
                    'uses' => 'ResourceController@attachPost',
                    'as'   => 'addworking.enterprise.resource.attach_post'
                ]);

                Route::post("{$base}/{resource}/detach", [
                    'uses' => 'ResourceController@detach',
                    'as'   => 'addworking.enterprise.resource.detach'
                ]);
            });
    }

    public function mapAssignedResource()
    {
        Route::middleware(['web', 'auth'])
            ->prefix('addworking')
            ->namespace($this->namespace)
            ->group(function () {
                $base = "enterprise/{enterprise}/assigned_resource";

                Route::get("{$base}", [
                    'uses' => 'ActivityPeriodController@index',
                    'as'   => 'addworking.enterprise.assigned_resource.index'
                ]);
            });
    }
}
