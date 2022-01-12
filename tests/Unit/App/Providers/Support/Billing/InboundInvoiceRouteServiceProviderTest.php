<?php

namespace Tests\Unit\App\Providers\Support\Billing;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Tests\TestCase;

class InboundInvoiceRouteServiceProviderTest extends TestCase
{
    use RefreshDatabase;

    public function testMap()
    {
        $this->assertInstanceOf(
            Route::class,
            $this->app->make(Router::class)->getRoutes()->getByName('support.billing.inbound_invoice.index'),
            "Inbound invoice index route should exist"
        );
    }
}
