<?php

namespace Tests\Unit\App\Providers\Support\Enterprise;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Tests\TestCase;

class EnterpriseRouteServiceProviderTest extends TestCase
{
    use RefreshDatabase;

    public function testMap()
    {
        $this->assertInstanceOf(
            Route::class,
            $this->app->make(Router::class)->getRoutes()->getByName('support.enterprise.omnisearch.index'),
            "Omnisearch index route should exist"
        );

        $this->assertInstanceOf(
            Route::class,
            $this->app->make(Router::class)->getRoutes()->getByName('support.enterprise.omnisearch.search'),
            "Omnisearch index route should exist"
        );
    }
}
