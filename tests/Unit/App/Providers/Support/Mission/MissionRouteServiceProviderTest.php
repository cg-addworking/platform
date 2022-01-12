<?php

namespace Tests\Unit\App\Providers\Support\Mission;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Tests\TestCase;

class MissionRouteServiceProviderTest extends TestCase
{
    use RefreshDatabase;

    public function testMap()
    {
        $this->assertInstanceOf(
            Route::class,
            $this->app->make(Router::class)->getRoutes()->getByName('support.enterprise.mission.tracking.line'),
            "Support's mission tracking index route should exist"
        );
    }
}
