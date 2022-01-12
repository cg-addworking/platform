<?php

namespace Components\Enterprise\Enterprise\Application\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class EnterpriseRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Components\Enterprise\Enterprise\Application\Controllers';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapEnterpriseRoutes();
        $this->mapCompanyRoutes();
    }

    private function mapEnterpriseRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "enterprise";

                Route::get("support/{$base}/", [
                    'uses' => 'EnterpriseController@indexSupport', 'as' => 'support.enterprise.index'
                ]);

                Route::post("{$base}/set-member-job-title", [
                    'uses' => 'EnterpriseAjaxController@setMemberJobTitle', 'as' => 'enterprise.set_member_job_title'
                ]);
            });
    }

    private function mapCompanyRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "company";

                Route::get("{$base}/", [
                    'uses' => 'CompanyController@index', 'as' => 'company.index'
                ]);

                Route::get("{$base}/{company}", [
                    'uses' => 'CompanyController@show', 'as' => 'company.show'
                ]);
            });
    }
}
