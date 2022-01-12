<?php

namespace Tests\Unit\Foundation\Model;

use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tests\Unit\Foundation\Model\ViewableTest\Alpha;
use Tests\Unit\Foundation\Model\ViewableTest\Beta;

class ViewableTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->app['view']->addNamespace('test', __DIR__ . '/ViewableTest');
    }

    public function testViews()
    {
        $alpha = new Alpha;

        $this->assertInstanceof(
            View::class,
            $alpha->views()->actions,
            "Alpha should have an action view"
        );
    }

    public function testGetViewsAttribute()
    {
        $alpha = new Alpha;

        $this->assertInstanceof(
            View::class,
            $alpha->getViewsAttribute()->actions,
            "Alpha should have an action view"
        );
    }

    public function testGetView()
    {
        $alpha = new Alpha;
        $alpha->foo = Str::random();

        $this->assertInstanceof(
            View::class,
            $alpha->getView('actions'),
            "Alpha should have an action view"
        );

        $this->assertStringContainsString(
            $alpha->foo,
            $alpha->getView('actions'),
            "Alpha's actions should display value of \$foo propoerty"
        );

        $beta = new Beta;
        $beta->bar = Str::random();

        $this->assertInstanceof(
            View::class,
            $beta->getView('actions', @compact('alpha')),
            "Beta should have an action view"
        );

        $this->assertStringContainsString(
            $beta->bar,
            $beta->getView('actions', @compact('alpha')),
            "Beta's actions should display value of \$bar propoerty"
        );

        $this->assertStringContainsString(
            $alpha->foo,
            $beta->getView('actions', @compact('alpha')),
            "Beta's actions should display value of \$bar propoerty"
        );
    }
}
