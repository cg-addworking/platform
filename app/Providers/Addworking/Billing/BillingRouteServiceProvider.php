<?php

namespace App\Providers\Addworking\Billing;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class BillingRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers\Addworking\Billing';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapInboundInvoice();
        $this->mapInboundInvoiceItem();
    }

    public function mapInboundInvoice()
    {
        Route::middleware(['web', 'auth'])
            ->prefix('addworking')
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('enterprise/{enterprise}/inbound-invoice', [
                    'uses' => 'InboundInvoiceController@index',
                    'as' => 'addworking.billing.inbound_invoice.index'
                ]);

                Route::post('enterprise/{enterprise}/inbound-invoice/get-vendor-deadlines', [
                    'uses' => 'InboundInvoiceController@ajaxGetVendorDeadlines',
                    'as' => 'addworking.billing.inbound_invoice.get_vendor_deadlines'
                ]);

                Route::post('enterprise/{enterprise}/inbound-invoice/get-tracking-lines', [
                    'uses' => 'InboundInvoiceController@ajaxGetTrackingLines',
                    'as' => 'addworking.billing.inbound_invoice.get_tracking_lines'
                ]);

                Route::get('enterprise/{enterprise}/inbound-invoice/create', [
                    'uses' => 'InboundInvoiceController@create',
                    'as' => 'addworking.billing.inbound_invoice.create'
                ]);

                Route::post('enterprise/{enterprise}/inbound-invoice/store', [
                    'uses' => 'InboundInvoiceController@store',
                    'as' => 'addworking.billing.inbound_invoice.store'
                ]);

                Route::get('enterprise/{enterprise}/inbound-invoice/{inbound_invoice}/show', [
                    'uses' => 'InboundInvoiceController@show',
                    'as' => 'addworking.billing.inbound_invoice.show'
                ]);

                Route::get('enterprise/{enterprise}/inbound-invoice/{inbound_invoice}/edit', [
                    'uses' => 'InboundInvoiceController@edit',
                    'as' => 'addworking.billing.inbound_invoice.edit'
                ]);

                Route::put('enterprise/{enterprise}/inbound-invoice/{inbound_invoice}/update', [
                    'uses' => 'InboundInvoiceController@update',
                    'as' => 'addworking.billing.inbound_invoice.update'
                ]);

                Route::delete('enterprise/{enterprise}/inbound-invoice/{inbound_invoice}/destroy', [
                    'uses' => 'InboundInvoiceController@destroy',
                    'as' => 'addworking.billing.inbound_invoice.destroy'
                ]);

                Route::patch('enterprise/{enterprise}/inbound-invoice/{inbound_invoice}/validation', [
                    'uses' => 'InboundInvoiceController@validation',
                    'as' => 'addworking.billing.inbound_invoice.validation'
                ]);

                Route::patch('enterprise/{enterprise}/inbound-invoice/{inbound_invoice}/compliance_status', [
                    'uses' => 'InboundInvoiceController@updateComplianceStatus',
                    'as' => 'addworking.billing.inbound_invoice.compliance_status'
                ]);
            });
    }

    public function mapInboundInvoiceItem()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->prefix('addworking/enterprise/{enterprise}/inbound_invoice/{inbound_invoice}')
            ->group(function () {
                Route::get('/inbound_invoice_item', [
                    'uses' => "InboundInvoiceItemController@index",
                    'as'   => "addworking.billing.inbound_invoice_item.index",
                ]);

                Route::get('/inbound_invoice_item/create', [
                    'uses' => "InboundInvoiceItemController@create",
                    'as'   => "addworking.billing.inbound_invoice_item.create",
                ]);

                Route::get('/inbound_invoice_item/create-from-tracking-line', [
                    'uses' => "InboundInvoiceItemController@createFromTrackingLines",
                    'as'   => "addworking.billing.inbound_invoice_item.create_from_tracking_line",
                ]);

                Route::post('/inbound_invoice_item/store-from-tracking-line', [
                    'uses' => "InboundInvoiceItemController@storeFromTrackingLines",
                    'as'   => "addworking.billing.inbound_invoice_item.store_from_tracking_line",
                ]);

                Route::post('/inbound_invoice_item', [
                    'uses' => "InboundInvoiceItemController@store",
                    'as'   => "addworking.billing.inbound_invoice_item.store",
                ]);

                Route::get('/inbound_invoice_item/{inbound_invoice_item}', [
                    'uses' => "InboundInvoiceItemController@show",
                    'as'   => "addworking.billing.inbound_invoice_item.show",
                ]);

                Route::get('/inbound_invoice_item/{inbound_invoice_item}/edit', [
                    'uses' => "InboundInvoiceItemController@edit",
                    'as'   => "addworking.billing.inbound_invoice_item.edit",
                ]);

                Route::put('/inbound_invoice_item/{inbound_invoice_item}', [
                    'uses' => "InboundInvoiceItemController@update",
                    'as'   => "addworking.billing.inbound_invoice_item.update",
                ]);

                Route::delete('/inbound_invoice_item/{inbound_invoice_item}', [
                    'uses' => "InboundInvoiceItemController@destroy",
                    'as'   => "addworking.billing.inbound_invoice_item.destroy",
                ]);
            });
    }
}
