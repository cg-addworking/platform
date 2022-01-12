<?php

namespace Components\Enterprise\WorkField\Application\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class WorkFieldRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Components\Enterprise\WorkField\Application\Controllers';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapWorkFieldRoutes();
        $this->mapWorkFieldAjaxRoutes();
        $this->mapWorkFieldContributorRoutes();
    }

    private function mapWorkFieldRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "workfield";

                Route::get("{$base}/create", [
                    'uses' => 'WorkFieldController@create', 'as' => 'work_field.create'
                ]);

                Route::post("{$base}/store", [
                    'uses' => 'WorkFieldController@store', 'as' => 'work_field.store'
                ]);

                Route::get("{$base}/{work_field}/edit", [
                    'uses' => 'WorkFieldController@edit', 'as' => 'work_field.edit'
                ]);

                Route::put("{$base}/{work_field}/update", [
                    'uses' => 'WorkFieldController@update', 'as' => 'work_field.update'
                ]);

                Route::get("{$base}/{work_field}", [
                    'uses' => 'WorkFieldController@show', 'as' => 'work_field.show'
                ]);

                Route::delete("{$base}/{work_field}/delete", [
                    'uses' => 'WorkFieldController@delete', 'as' => 'work_field.delete'
                ]);

                Route::get("{$base}", [
                    'uses' => 'WorkFieldController@index', 'as' => 'work_field.index'
                ]);

                Route::get("{$base}/{work_field}/archive", [
                    'uses' => 'WorkFieldController@archive', 'as' => 'work_field.archive'
                ]);
            });
    }

    private function mapWorkFieldAjaxRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "workfield/ajax";

                Route::post("{$base}/get-contributors", [
                    'uses' => 'WorkFieldAjaxController@getContributors', 'as' => 'work_field.get_contributors'
                ]);

                Route::post("{$base}/get-contributors-without-creator", [
                    'uses' => 'WorkFieldAjaxController@getContributorsWithoutCreator',
                    'as' => 'work_field.get_contributors_without_creator'
                ]);

                Route::post("{$base}/detach-contributor", [
                    'uses' => 'WorkFieldAjaxController@detachContributor',
                    'as' => 'work_field.detach_contributor'
                ]);

                Route::post("{$base}/{work_field}/set-administrator", [
                    'uses' => 'WorkFieldAjaxController@setAdministrator',
                    'as' => 'work_field.set_administrator'
                ]);

                Route::post("{$base}/{work_field}/set-contract-validator", [
                    'uses' => 'WorkFieldAjaxController@setContractValidator',
                    'as' => 'work_field.set_contract_validator'
                ]);

                Route::post("{$base}/{work_field}/set-contract-validation-order", [
                    'uses' => 'WorkFieldAjaxController@setContractValidationOrder',
                    'as' => 'work_field.contract_validation_order'
                ]);

                Route::post("{$base}/set-role", [
                    'uses' => 'WorkFieldAjaxController@setRole',
                    'as' => 'work_field.set_contributoer_role'
                ]);

                Route::post("{$base}/attach-contributor", [
                    'uses' => 'WorkFieldAjaxController@attachContributor',
                    'as' => 'work_field.attach_contributor'
                ]);
            });
    }

    private function mapWorkFieldContributorRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "workfield/{work_field}";
                Route::get("{$base}/manage-contributors", [
                    'uses' => 'WorkFieldContributorController@manageContributors',
                    'as' => 'work_field_contributor.manage_contributors'
                ]);
            });
    }
}
