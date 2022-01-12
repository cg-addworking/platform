<?php

namespace Tests\Unit\App\Providers\Addworking\Enterprise;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Tests\TestCase;

class EnterpriseRouteServiceProviderTest extends TestCase
{
    use RefreshDatabase;

    protected $vendorsBillingDeadlinesRoutes = [
        'index',
        'edit',
        'update',
    ];

    public function testMapVendorsBillingDeadlinesRoutes()
    {
        foreach ($this->vendorsBillingDeadlinesRoutes as $route) {
            $this->assertInstanceOf(
                Route::class,
                $this->app->make(Router::class)->getRoutes()
                    ->getByName("addworking.enterprise.vendor.billing_deadline.{$route}"),
                "{$route} route should exist"
            );
        }
    }

    public function testMapMemberRoutes()
    {
        $this->assertInstanceOf(
            Route::class,
            $this->app->make(Router::class)->getRoutes()->getByName('addworking.enterprise.member.index'),
            'Index route should exist'
        );

        $this->assertInstanceOf(
            Route::class,
            $this->app->make(Router::class)->getRoutes()->getByName('addworking.enterprise.member.create'),
            'Create route should exist'
        );

        $this->assertInstanceOf(
            Route::class,
            $this->app->make(Router::class)->getRoutes()->getByName('addworking.enterprise.member.store'),
            'Store route should exist'
        );

        $this->assertInstanceOf(
            Route::class,
            $this->app->make(Router::class)->getRoutes()->getByName('addworking.enterprise.member.show'),
            'Show route should exist'
        );

        $this->assertInstanceOf(
            Route::class,
            $this->app->make(Router::class)->getRoutes()->getByName('addworking.enterprise.member.edit'),
            'Edit route should exist'
        );

        $this->assertInstanceOf(
            Route::class,
            $this->app->make(Router::class)->getRoutes()->getByName('addworking.enterprise.member.update'),
            'Update route should exist'
        );

        $this->assertInstanceOf(
            Route::class,
            $this->app->make(Router::class)->getRoutes()->getByName('addworking.enterprise.member.remove'),
            'Remove route should exist'
        );
    }
}
