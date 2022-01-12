<?php

namespace Tests\Unit\App\Providers\Addworking\Billing;

use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Tests\TestCase;

class BillingRouteServiceProviderTest extends TestCase
{
    protected $inboundInvoiceRoutes = [
        'index',
        'create',
        'store',
        'show',
        'edit',
        'update',
        'destroy',
    ];

    protected $inboundInvoiceItemRoutes = [
        'index',
        'create',
        'create_from_tracking_line',
        'store_from_tracking_line',
        'store',
        'show',
        'edit',
        'update',
        'destroy',
    ];

    public function testMapInboundInvoice()
    {
        foreach ($this->inboundInvoiceRoutes as $route) {
            $this->assertInstanceOf(
                Route::class,
                $this->app->make(Router::class)->getRoutes()
                    ->getByName("addworking.billing.inbound_invoice.{$route}"),
                "{$route} route should exist"
            );
        }
    }

    public function testMapInboundInvoiceItem()
    {
        foreach ($this->inboundInvoiceItemRoutes as $route) {
            $this->assertInstanceOf(
                Route::class,
                $this->app->make(Router::class)->getRoutes()
                    ->getByName("addworking.billing.inbound_invoice_item.{$route}"),
                "{$route} route should exist"
            );
        }
    }
}
