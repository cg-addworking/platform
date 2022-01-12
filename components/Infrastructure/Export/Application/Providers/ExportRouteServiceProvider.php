<?php

namespace Components\Infrastructure\Export\Application\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class ExportRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Components\Infrastructure\Export\Application\Controllers';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapExportRoutes();
    }

    private function mapExportRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->name('infrastructure.')
            ->group(function () {
                $base = "export";

                Route::get("{$base}/{export}/download", [
                    'uses' => 'ExportController@download', 'as' => 'export.download'
                ]);

                Route::get("{$base}", [
                    'uses' => 'ExportController@index', 'as' => 'export.index'
                ]);
            });
    }
}
