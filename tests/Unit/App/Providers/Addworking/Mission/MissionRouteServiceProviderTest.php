<?php

namespace Tests\Unit\App\Providers\Addworking\Mission;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Tests\TestCase;

class MissionRouteServiceProviderTest extends TestCase
{
    use RefreshDatabase;

    public function testMapMissionPurchaseOrderRoutes()
    {
        $this->assertInstanceOf(
            Route::class,
            $this->app->make(Router::class)->getRoutes()->getByName('enterprise.mission.purchase_order.send'),
            "PurchaseOrder send route should exist"
        );
    }
}
