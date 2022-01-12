<?php

namespace Components\Enterprise\AccountingExpense\Application\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class AccountingExpenseRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Components\Enterprise\AccountingExpense\Application\Controllers';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapAccountingExpenseRoutes();
    }

    private function mapAccountingExpenseRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "addworking/enterprise/{enterprise}/accounting-expense";

                Route::get("{$base}", [
                    'uses' => 'AccountingExpenseController@index',
                    'as' => 'addworking.enterprise.accounting_expense.index'
                ]);

                Route::get("{$base}/create", [
                    'uses' => 'AccountingExpenseController@create',
                    'as' => 'addworking.enterprise.accounting_expense.create'
                ]);

                Route::post("{$base}/store", [
                    'uses' => 'AccountingExpenseController@store',
                    'as' => 'addworking.enterprise.accounting_expense.store'
                ]);

                Route::get("{$base}/{accounting_expense}/edit", [
                    'uses' => 'AccountingExpenseController@edit',
                    'as' => 'addworking.enterprise.accounting_expense.edit'
                ]);

                Route::put("{$base}/{accounting_expense}/update", [
                    'uses' => 'AccountingExpenseController@update',
                    'as' => 'addworking.enterprise.accounting_expense.update'
                ]);

                Route::delete("{$base}/{accounting_expense}/delete", [
                    'uses' => 'AccountingExpenseController@delete',
                    'as' => 'addworking.enterprise.accounting_expense.delete'
                ]);
            });
    }
}
