<?php

namespace Components\Common\Common\Application\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class CommonRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Components\Common\Common\Application\Controllers';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapCommonRoutes();
    }

    private function mapCommonRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->prefix('common')
            ->name('common.')
            ->group(function () {
                $base = "common";

                Route::post("{$base}/lazy-loading/load-action-html", [
                    'uses' => 'LazyLoadingController@loadActionHtml', 'as' => 'lazy_loading.load_action_html'
                ]);
            });
    }
}
