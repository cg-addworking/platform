<?php

namespace Components\Billing\PaymentOrder\Application\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class PaymentOrderRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Components\Billing\PaymentOrder\Application\Controllers';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapPaymentOrder();
        $this->mapReceivedPayment();
        $this->mapReceivedPaymentSupportRoutes();
    }

    public function mapPaymentOrder()
    {
        Route::middleware(['web', 'auth'])
            ->prefix('addworking')
            ->namespace($this->namespace)
            ->group(function () {
                $base = "enterprise/{enterprise}/payment-order";

                Route::get("{$base}/create", [
                    'uses' => 'PaymentOrderController@create',
                    'as' => 'addworking.billing.payment_order.create'
                ]);
                Route::post("{$base}/store", [
                    'uses' => 'PaymentOrderController@store',
                    'as' => 'addworking.billing.payment_order.store'
                ]);
                Route::get("{$base}/{payment_order}/edit", [
                    'uses' => 'PaymentOrderController@edit',
                    'as' => 'addworking.billing.payment_order.edit'
                ]);
                Route::put("{$base}/{payment_order}/update", [
                    'uses' => 'PaymentOrderController@update',
                    'as' => 'addworking.billing.payment_order.update'
                ]);
                Route::get("{$base}", [
                    'uses' => 'PaymentOrderController@index',
                    'as' => 'addworking.billing.payment_order.index'
                ]);
                Route::get("{$base}/{payment_order}", [
                    'uses' => 'PaymentOrderController@show',
                    'as' => 'addworking.billing.payment_order.show'
                ]);
                Route::get("{$base}/{payment_order}/associate", [
                    'uses' => 'PaymentOrderController@indexAssociate',
                    'as' => 'addworking.billing.payment_order.index_associate'
                ]);
                Route::post("{$base}/{payment_order}/associate/store", [
                    'uses' => 'PaymentOrderController@storeAssociate',
                    'as' => 'addworking.billing.payment_order.store_associate'
                ]);
                Route::get("{$base}/{payment_order}/dissociate", [
                    'uses' => 'PaymentOrderController@indexDissociate',
                    'as' => 'addworking.billing.payment_order.index_dissociate'
                ]);
                Route::post("{$base}/{payment_order}/dissociate/store", [
                    'uses' => 'PaymentOrderController@storeDissociate',
                    'as' => 'addworking.billing.payment_order.store_dissociate'
                ]);
                Route::get("{$base}/{payment_order}/generate", [
                    'uses' => 'PaymentOrderController@generate',
                    'as' => 'addworking.billing.payment_order.generate'
                ]);
                Route::get("{$base}/{payment_order}/execute", [
                    'uses' => 'PaymentOrderController@execute',
                    'as' => 'addworking.billing.payment_order.execute'
                ]);
                Route::delete("{$base}/{payment_order}/destroy", [
                    'uses' => 'PaymentOrderController@destroy',
                    'as' => 'addworking.billing.payment_order.destroy'
                ]);
            });
    }

    public function mapReceivedPayment()
    {
        Route::middleware(['web', 'auth'])
            ->prefix('addworking')
            ->namespace($this->namespace)
            ->group(function () {
                $base = "enterprise/{enterprise}/received-payment";

                Route::get("{$base}/create", [
                    'uses' => 'ReceivedPaymentController@create',
                    'as' => 'addworking.billing.received_payment.create'
                ]);
                Route::post("{$base}/store", [
                    'uses' => 'ReceivedPaymentController@store',
                    'as' => 'addworking.billing.received_payment.store'
                ]);
                Route::get("{$base}", [
                    'uses' => 'ReceivedPaymentController@index',
                    'as' => 'addworking.billing.received_payment.index'
                ]);
                Route::get("{$base}/{received_payment}/edit", [
                    'uses' => 'ReceivedPaymentController@edit',
                    'as' => 'addworking.billing.received_payment.edit'
                ]);
                Route::put("{$base}{received_payment}/update", [
                    'uses' => 'ReceivedPaymentController@update',
                    'as' => 'addworking.billing.received_payment.update'
                ]);
                Route::get("{$base}/search-outbound-invoices", [
                    'uses' => 'ReceivedPaymentController@searchOutboundInvoice',
                    'as' => 'addworking.billing.received_payment.search_outbound_invoices'
                ]);
                Route::get("{$base}/import", [
                    'uses' => 'ReceivedPaymentController@import', 'as' => 'addworking.billing.received_payment.import'
                ]);
                Route::post("{$base}/load", [
                    'uses' => 'ReceivedPaymentController@load', 'as' => 'addworking.billing.received_payment.load'
                ]);

                Route::delete("{$base}/{received_payment}/delete", [
                    'uses' => 'ReceivedPaymentController@delete',
                    'as' => 'addworking.billing.received_payment.delete'
                ]);

                Route::get("{$base}/check-received-payment-amount-ajax", [
                    'uses' => 'ReceivedPaymentController@checkReceivedPaymentAmountAjax',
                    'as' => 'addworking.billing.received_payment.check_received_payment_amount_ajax'
                ]);

                Route::get("{$base}/check-customer-country-ajax", [
                    'uses' => 'ReceivedPaymentController@checkCustomerCountryAjax',
                    'as' => 'addworking.billing.received_payment.check_customer_country_ajax'
                ]);
            });
    }

    private function mapReceivedPaymentSupportRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                $base = "received-payment";

                Route::get("{$base}", [
                    'uses' => 'ReceivedPaymentController@indexSupport', 'as' => 'support.received_payment.index'
                ]);

                Route::get("{$base}/import", [
                    'uses' => 'ReceivedPaymentController@import', 'as' => 'support.received_payment.import'
                ]);

                Route::post("{$base}/load", [
                    'uses' => 'ReceivedPaymentController@load', 'as' => 'support.received_payment.load'
                ]);
            });
    }
}
