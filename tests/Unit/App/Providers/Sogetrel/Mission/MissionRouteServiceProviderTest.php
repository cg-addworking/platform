<?php

namespace Tests\Unit\App\Providers\Sogetrel\Mission;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Tests\TestCase;

class MissionRouteServiceProviderTest extends TestCase
{
    use RefreshDatabase;

    public function testBpuStoreRoute()
    {
        $this->assertInstanceOf(
            Route::class,
            $this->app->make(Router::class)->getRoutes()->getByName('sogetrel.mission.proposal.bpu.store'),
            "Proposal bpu store route should exist"
        );
    }

    public function testBpuCreateRoute()
    {
        $this->assertInstanceOf(
            Route::class,
            $this->app->make(Router::class)->getRoutes()->getByName('sogetrel.mission.proposal.bpu.create'),
            "Proposal bpu create route should exist"
        );
    }
}
