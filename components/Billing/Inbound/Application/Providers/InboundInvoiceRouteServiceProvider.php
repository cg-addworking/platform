<?php

namespace Components\Billing\Inbound\Application\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class InboundInvoiceRouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Components\Billing\Inbound\Application\Controllers';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapInboundInvoiceRoutes();
    }

    private function mapInboundInvoiceRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(function () {
                Route::get("inbound-invoice/", [
                    'uses' => 'InboundInvoiceController@indexCustomer', 'as' => 'inbound_invoice.index_customer'
                ]);

                Route::get('inbound_invoice/export', [
                    'uses' => "InboundInvoiceController@export",
                    'as'   => "inbound_invoice.export",
                ]);
            });
    }
}
