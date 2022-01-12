<?php

namespace App\Providers\Support\Billing;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class BillingRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers\Support\Billing';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapVatRate();
        $this->mapDeadlineType();
        $this->mapInboundInvoice();
    }

    public function mapVatRate()
    {
        Route::middleware(['support'])
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('support/vat_rate', [
                    'uses' => "VatRateController@index",
                    'as'   => "support.billing.vat_rate.index"
                ]);

                Route::get('support/vat_rate/create', [
                    'uses' => "VatRateController@create",
                    'as'   => "support.billing.vat_rate.create",
                ]);

                Route::post('support/vat_rate', [
                    'uses' => "VatRateController@store",
                    'as'   => "support.billing.vat_rate.store",
                ]);

                Route::get('support/vat_rate/{vat_rate}', [
                    'uses' => "VatRateController@show",
                    'as'   => "support.billing.vat_rate.show",
                ]);

                Route::get('support/vat_rate/{vat_rate}/edit', [
                    'uses' => "VatRateController@edit",
                    'as'   => "support.billing.vat_rate.edit",
                ]);

                Route::put('support/vat_rate/{vat_rate}', [
                    'uses' => "VatRateController@update",
                    'as'   => "support.billing.vat_rate.update",
                ]);

                Route::delete('support/vat_rate/{vat_rate}', [
                    'uses' => "VatRateController@destroy",
                    'as'   => "support.billing.vat_rate.destroy",
                ]);
            });
    }

    public function mapDeadlineType()
    {
        Route::middleware(['support'])
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('support/deadline_type', [
                    'uses' => "DeadlineTypeController@index",
                    'as'   => "support.billing.deadline_type.index",
                ]);

                Route::get('support/deadline_type/create', [
                    'uses' => "DeadlineTypeController@create",
                    'as'   => "support.billing.deadline_type.create",
                ]);

                Route::post('support/deadline_type', [
                    'uses' => "DeadlineTypeController@store",
                    'as'   => "support.billing.deadline_type.store",
                ]);

                Route::get('support/deadline_type/{deadline_type}', [
                    'uses' => "DeadlineTypeController@show",
                    'as'   => "support.billing.deadline_type.show",
                ]);

                Route::get('support/deadline_type/{deadline_type}/edit', [
                    'uses' => "DeadlineTypeController@edit",
                    'as'   => "support.billing.deadline_type.edit",
                ]);

                Route::put('support/deadline_type/{deadline_type}', [
                    'uses' => "DeadlineTypeController@update",
                    'as'   => "support.billing.deadline_type.update",
                ]);

                Route::delete('support/deadline_type/{deadline_type}', [
                    'uses' => "DeadlineTypeController@destroy",
                    'as'   => "support.billing.deadline_type.destroy",
                ]);
            });
    }

    public function mapInboundInvoice()
    {
        Route::middleware(['support'])
            ->namespace($this->namespace)
            ->prefix('support')
            ->group(function () {
                Route::get('inbound_invoice', [
                    'uses' => "InboundInvoiceController@index",
                    'as'   => "support.billing.inbound_invoice.index",
                ]);

                Route::get('inbound_invoice/export', [
                    'uses' => "InboundInvoiceController@export",
                    'as'   => "support.billing.inbound_invoice.export",
                ]);
            });
    }
}
