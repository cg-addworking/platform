<?php

namespace Components\Billing\Outbound\Application\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class OutboundInvoiceRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Components\Billing\Outbound\Application\Controllers';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapOutboundInvoice();
        $this->mapOutboundInvoiceSupport();
        $this->mapOutboundInvoiceItem();
        $this->mapFee();
        $this->mapCreditNote();
    }

    public function mapOutboundInvoice()
    {
        Route::middleware(['web', 'auth'])
            ->prefix('addworking')
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('enterprise/{enterprise}/outbound-invoice', [
                    'uses' => 'OutboundInvoiceController@index',
                    'as' => 'addworking.billing.outbound.index'
                ]);
                Route::get('enterprise/{enterprise}/outbound-invoice/create', [
                    'uses' => 'OutboundInvoiceController@create',
                    'as' => 'addworking.billing.outbound.create'
                ]);
                Route::post('enterprise/{enterprise}/outbound-invoice/store', [
                    'uses' => 'OutboundInvoiceController@store',
                    'as' => 'addworking.billing.outbound.store'
                ]);
                Route::get('enterprise/{enterprise}/outbound-invoice/{outbound_invoice}/edit', [
                    'uses' => 'OutboundInvoiceController@edit',
                    'as' => 'addworking.billing.outbound.edit'
                ]);
                Route::put('enterprise/{enterprise}/outbound-invoice/{outbound_invoice}/update', [
                    'uses' => 'OutboundInvoiceController@update',
                    'as' => 'addworking.billing.outbound.update'
                ]);
                Route::get('enterprise/{enterprise}/outbound-invoice/{outbound_invoice}', [
                    'uses' => 'OutboundInvoiceController@show',
                    'as' => 'addworking.billing.outbound.show'
                ]);
                Route::get('enterprise/{enterprise}/outbound-invoice/{outbound_invoice}/associate', [
                    'uses' => 'OutboundInvoiceController@indexAssociate',
                    'as' => 'addworking.billing.outbound.associate'
                ]);
                Route::post('enterprise/{enterprise}/outbound-invoice/{outbound_invoice}/associate/store', [
                    'uses' => 'OutboundInvoiceController@storeAssociate',
                    'as' => 'addworking.billing.outbound.associate.store'
                ]);
                Route::get('enterprise/{enterprise}/outbound-invoice/{outbound_invoice}/dissociate', [
                    'uses' => 'OutboundInvoiceController@indexDissociate',
                    'as' => 'addworking.billing.outbound.dissociate'
                ]);
                Route::post('enterprise/{enterprise}/outbound-invoice/{outbound_invoice}/dissociate/store', [
                    'uses' => 'OutboundInvoiceController@storeDissociate',
                    'as' => 'addworking.billing.outbound.dissociate.store'
                ]);
                Route::get('enterprise/{enterprise}/outbound-invoice/{outbound_invoice}/generate-file', [
                    'uses' => 'OutboundInvoiceController@createGenerateFile',
                    'as' => 'addworking.billing.outbound.generate_file.create'
                ]);
                Route::post('enterprise/{enterprise}/outbound-invoice/{outbound_invoice}/generate-file/store', [
                    'uses' => 'OutboundInvoiceController@storeGenerateFile',
                    'as' => 'addworking.billing.outbound.generate_file.store'
                ]);
                Route::get('enterprise/{enterprise}/outbound-invoice/{outbound_invoice}/publish', [
                    'uses' => 'OutboundInvoiceController@publish',
                    'as' => 'addworking.billing.outbound.publish'
                ]);
                Route::get('enterprise/{enterprise}/outbound-invoice/{outbound_invoice}/unpublish', [
                    'uses' => 'OutboundInvoiceController@unpublish',
                    'as' => 'addworking.billing.outbound.unpublish'
                ]);
                Route::get('enterprise/{enterprise}/outbound-invoice/{outbound_invoice}/export', [
                    'uses' => 'OutboundInvoiceController@export',
                    'as' => 'addworking.billing.outbound.export'
                ]);

                Route::get('enterprise/{enterprise}/outbound-invoice/create/inbound-invoice/{inbound_invoice}', [
                    'uses' => 'OutboundInvoiceController@createFromInboundInvoice',
                    'as' => 'addworking.billing.outbound.create.inbound_invoice'
                ]);
                Route::post('enterprise/{enterprise}/outbound-invoice/store/inbound-invoice/{inbound_invoice}', [
                    'uses' => 'OutboundInvoiceController@storeFromInboundInvoice',
                    'as' => 'addworking.billing.outbound.store.inbound_invoice'
                ]);

                Route::get('outbound-invoice/autocomplete-search', [
                    'uses' => 'OutboundInvoiceController@search',
                    'as' => 'addworking.billing.outbound.search'
                ]);

                Route::get('enterprise/{enterprise}/outbound-invoice/{outbound_invoice}/validate', [
                    'uses' => 'OutboundInvoiceController@validateInvoice',
                    'as' => 'addworking.billing.outbound.validate'
                ]);
            });
    }

    public function mapOutboundInvoiceSupport()
    {
        Route::middleware(['web', 'auth'])
            ->prefix('support')
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('outbound-invoice', [
                    'uses' => 'SupportOutboundInvoiceController@index',
                    'as' => 'support.billing.outbound.index'
                ]);
            });
    }

    public function mapOutboundInvoiceItem()
    {
        Route::middleware(['web', 'auth'])
            ->prefix('addworking')
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('enterprise/{enterprise}/outbound-invoice/{outbound_invoice}/item', [
                    'uses' => 'OutboundInvoiceItemController@index',
                    'as' => 'addworking.billing.outbound.item.index'
                ]);
                Route::get('enterprise/{enterprise}/outbound-invoice/{outbound_invoice}/item/create', [
                    'uses' => 'OutboundInvoiceItemController@create',
                    'as' => 'addworking.billing.outbound.item.create'
                ]);
                Route::post('enterprise/{enterprise}/outbound-invoice/{outbound_invoice}/item/store', [
                    'uses' => 'OutboundInvoiceItemController@store',
                    'as' => 'addworking.billing.outbound.item.store'
                ]);
                Route::delete(
                    'enterprise/{enterprise}/outbound-invoice/{outbound_invoice}/item/{outbound_invoice_item}/delete',
                    [
                        'uses' => 'OutboundInvoiceItemController@delete',
                        'as' => 'addworking.billing.outbound.item.delete'
                    ]
                );
            });
    }

    public function mapFee()
    {
        Route::middleware(['web', 'auth'])
            ->prefix('addworking')
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('enterprise/{enterprise}/outbound-invoice/{outbound_invoice}/fee', [
                    'uses' => 'FeeController@index',
                    'as' => 'addworking.billing.outbound.fee.index'
                ]);
                Route::get('enterprise/{enterprise}/outbound-invoice/{outbound_invoice}/fee/calculate', [
                    'uses' => 'FeeController@createCalculate',
                    'as' => 'addworking.billing.outbound.fee.create_calculate'
                ]);
                Route::post('enterprise/{enterprise}/outbound-invoice/{outbound_invoice}/fee/calculate/store', [
                    'uses' => 'FeeController@storeCalculate',
                    'as' => 'addworking.billing.outbound.fee.store_calculate'
                ]);
                Route::get('enterprise/{enterprise}/outbound-invoice/{outbound_invoice}/fee/create', [
                    'uses' => 'FeeController@create',
                    'as' => 'addworking.billing.outbound.fee.create'
                ]);
                Route::post('enterprise/{enterprise}/outbound-invoice/{outbound_invoice}/fee/store', [
                    'uses' => 'FeeController@store',
                    'as' => 'addworking.billing.outbound.fee.store'
                ]);
                Route::delete('enterprise/{enterprise}/outbound-invoice/{outbound_invoice}/fee/{fee}/delete', [
                    'uses' => 'FeeController@delete',
                    'as' => 'addworking.billing.outbound.fee.delete'
                ]);
                Route::get('enterprise/{enterprise}/outbound-invoice/{outbound_invoice}/fee/export', [
                    'uses' => 'FeeController@export',
                    'as' => 'addworking.billing.outbound.fee.export'
                ]);
            });
    }

    public function mapCreditNote()
    {
        Route::middleware(['web', 'auth'])
            ->prefix('addworking')
            ->namespace($this->namespace)
            ->group(function () {
                Route::get('enterprise/{enterprise}/outbound-invoice/{outbound_invoice}/credit-note/store', [
                    'uses' => 'CreditNoteController@store',
                    'as' => 'addworking.billing.outbound.credit_note.store'
                ]);
                Route::get(
                    'enterprise/{enterprise}/outbound-invoice/{outbound_invoice}/credit-note',
                    ['uses' => 'CreditNoteController@index',
                    'as' => 'addworking.billing.outbound.credit_note.index']
                );
                Route::get(
                    'enterprise/{enterprise}/outbound-invoice/{outbound_invoice}/credit-note/index-associate',
                    ['uses' => 'CreditNoteController@indexAssociate',
                    'as' => 'addworking.billing.outbound.credit_note.index_associate']
                );
                Route::post(
                    'enterprise/{enterprise}/outbound-invoice/{outbound_invoice}/credit-note/associate',
                    ['uses' => 'CreditNoteController@associate',
                    'as' => 'addworking.billing.outbound.credit_note.associate']
                );
                Route::get(
                    'enterprise/{enterprise}/outbound-invoice/{outbound_invoice}/credit-note/fees',
                    ['uses' => 'CreditNoteController@indexFees',
                    'as' => 'addworking.billing.outbound.credit_note.index_fees']
                );
                Route::get(
                    'enterprise/{enterprise}/outbound-invoice/{outbound_invoice}/credit-note/index-associate-fees',
                    ['uses' => 'CreditNoteController@indexAssociateFees',
                    'as' => 'addworking.billing.outbound.credit_note.index_associate_fees']
                );
                Route::post(
                    'enterprise/{enterprise}/outbound-invoice/{outbound_invoice}/credit-note/associate-fees',
                    ['uses' => 'CreditNoteController@associateFees',
                    'as' => 'addworking.billing.outbound.credit_note.associate_fees']
                );
            });
    }
}
