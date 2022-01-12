<?php

namespace Tests\Unit\Foundation\Model;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;
use Tests\Unit\Foundation\Model\RoutableTest\Alpha;
use Tests\Unit\Foundation\Model\RoutableTest\Beta;
use Tests\Unit\Foundation\Model\RoutableTest\Gamma;

class RoutableTest extends TestCase
{
    public function testIsset()
    {
        Route::get('/foo', [
            'uses' => "UnknownController@foo",
            'as'   => "alpha.foo_bar"
        ]);

        $model = new Alpha;

        $this->assertTrue(
            isset($model->routes->fooBar),
            "A routable model should be able to determine if a route exists using camel-case syntax"
        );

        $this->assertTrue(
            isset($model->routes->foo_bar),
            "A routable model should be able to determine if a route exists using snake-case syntax"
        );

        $this->assertFalse(
            isset($model->routes->barFoo),
            "A routable model should be able to determine if a route doesn't exists using camel-case syntax"
        );

        $this->assertFalse(
            isset($model->routes->barFoo),
            "A routable model should be able to determine if a route doesn't exists using snake-case syntax"
        );
    }

    public function testRouteFormat()
    {
        Route::get('/foo', [
            'uses' => "UnknownController@foo",
            'as'   => "alpha.foo_bar"
        ]);

        $model = new Alpha;

        $this->assertEquals(
            config('app.url')."/foo",
            $model->routes->fooBar,
            "A routable model should be able to generate a route using camel-case syntax"
        );

        $this->assertEquals(
            config('app.url')."/foo",
            $model->routes->foo_bar,
            "A routable model should be able to generate a route using snake-case syntax"
        );
    }

    public function testRoutes()
    {
        Route::resource('alpha', 'AlphaControlller');
        Route::resource('alpha.beta', 'BetaControlller');
        Route::resource('alpha.beta.gamma', 'GammaControlller');

        $model = new Alpha;

        $this->assertEquals(
            config('app.url')."/alpha",
            $model->routes()->index,
            "A routable model should be able to generate an index route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/create",
            $model->routes()->create,
            "A routable model should be able to generate a create route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/123",
            $model->routes()->show,
            "A routable model should be able to generate a show route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/123/edit",
            $model->routes()->edit,
            "A routable model should be able to generate an edit route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/123",
            $model->routes()->update,
            "A routable model should be able to generate an update route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/123",
            $model->routes()->destroy,
            "A routable model should be able to generate a destroy route"
        );

        $model = new Beta;

        $this->assertEquals(
            config('app.url')."/alpha/123/beta",
            $model->routes()->index,
            "A routable model should be able to generate an index route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/123/beta/create",
            $model->routes()->create,
            "A routable model should be able to generate a create route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/123/beta/456",
            $model->routes()->show,
            "A routable model should be able to generate a show route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/123/beta/456/edit",
            $model->routes()->edit,
            "A routable model should be able to generate an edit route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/123/beta/456",
            $model->routes()->update,
            "A routable model should be able to generate an update route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/123/beta/456",
            $model->routes()->destroy,
            "A routable model should be able to generate a destroy route"
        );

        $model = new Gamma;

        $this->assertEquals(
            config('app.url')."/alpha/123/beta/456/gamma",
            $model->routes()->index,
            "A routable model should be able to generate an index route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/123/beta/456/gamma/create",
            $model->routes()->create,
            "A routable model should be able to generate a create route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/123/beta/456/gamma/789",
            $model->routes()->show,
            "A routable model should be able to generate a show route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/123/beta/456/gamma/789/edit",
            $model->routes()->edit,
            "A routable model should be able to generate an edit route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/123/beta/456/gamma/789",
            $model->routes()->update,
            "A routable model should be able to generate an update route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/123/beta/456/gamma/789",
            $model->routes()->destroy,
            "A routable model should be able to generate a destroy route"
        );
    }

    public function testRoutesWithParams()
    {
        Route::resource('alpha', 'AlphaControlller');
        Route::resource('alpha.beta', 'BetaControlller');
        Route::resource('alpha.beta.gamma', 'GammaControlller');

        $params = [
            'alpha' => new Alpha(['id' => 111]),
            'betum' => new Beta(['id' => 222]),
            'gamma' => new Gamma(['id' => 333]),
        ];

        $model = new Alpha;

        $this->assertEquals(
            config('app.url')."/alpha",
            $model->routes()->index($params),
            "A routable model should be able to generate an index route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/create",
            $model->routes()->create($params),
            "A routable model should be able to generate a create route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/111",
            $model->routes()->show($params),
            "A routable model should be able to generate a show route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/111/edit",
            $model->routes()->edit($params),
            "A routable model should be able to generate an edit route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/111",
            $model->routes()->update($params),
            "A routable model should be able to generate an update route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/111",
            $model->routes()->destroy($params),
            "A routable model should be able to generate a destroy route"
        );

        $model = new Beta;

        $this->assertEquals(
            config('app.url')."/alpha/111/beta",
            $model->routes()->index($params),
            "A routable model should be able to generate an index route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/111/beta/create",
            $model->routes()->create($params),
            "A routable model should be able to generate a create route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/111/beta/222",
            $model->routes()->show($params),
            "A routable model should be able to generate a show route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/111/beta/222/edit",
            $model->routes()->edit($params),
            "A routable model should be able to generate an edit route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/111/beta/222",
            $model->routes()->update($params),
            "A routable model should be able to generate an update route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/111/beta/222",
            $model->routes()->destroy($params),
            "A routable model should be able to generate a destroy route"
        );

        $model = new Gamma;

        $this->assertEquals(
            config('app.url')."/alpha/111/beta/222/gamma",
            $model->routes()->index($params),
            "A routable model should be able to generate an index route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/111/beta/222/gamma/create",
            $model->routes()->create($params),
            "A routable model should be able to generate a create route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/111/beta/222/gamma/333",
            $model->routes()->show($params),
            "A routable model should be able to generate a show route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/111/beta/222/gamma/333/edit",
            $model->routes()->edit($params),
            "A routable model should be able to generate an edit route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/111/beta/222/gamma/333",
            $model->routes()->update($params),
            "A routable model should be able to generate an update route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/111/beta/222/gamma/333",
            $model->routes()->destroy($params),
            "A routable model should be able to generate a destroy route"
        );
    }

    public function testGetRoutesAttribute()
    {
        Route::resource('alpha', 'AlphaControlller');
        Route::resource('alpha.beta', 'BetaControlller');
        Route::resource('alpha.beta.gamma', 'GammaControlller');

        $model = new Alpha;

        $this->assertEquals(
            config('app.url')."/alpha",
            $model->routes->index,
            "A routable model should be able to generate an index route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/create",
            $model->routes->create,
            "A routable model should be able to generate a create route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/123",
            $model->routes->show,
            "A routable model should be able to generate a show route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/123/edit",
            $model->routes->edit,
            "A routable model should be able to generate an edit route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/123",
            $model->routes->update,
            "A routable model should be able to generate an update route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/123",
            $model->routes->destroy,
            "A routable model should be able to generate a destroy route"
        );

        $model = new Beta;

        $this->assertEquals(
            config('app.url')."/alpha/123/beta",
            $model->routes->index,
            "A routable model should be able to generate an index route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/123/beta/create",
            $model->routes->create,
            "A routable model should be able to generate a create route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/123/beta/456",
            $model->routes->show,
            "A routable model should be able to generate a show route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/123/beta/456/edit",
            $model->routes->edit,
            "A routable model should be able to generate an edit route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/123/beta/456",
            $model->routes->update,
            "A routable model should be able to generate an update route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/123/beta/456",
            $model->routes->destroy,
            "A routable model should be able to generate a destroy route"
        );

        $model = new Gamma;

        $this->assertEquals(
            config('app.url')."/alpha/123/beta/456/gamma",
            $model->routes->index,
            "A routable model should be able to generate an index route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/123/beta/456/gamma/create",
            $model->routes->create,
            "A routable model should be able to generate a create route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/123/beta/456/gamma/789",
            $model->routes->show,
            "A routable model should be able to generate a show route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/123/beta/456/gamma/789/edit",
            $model->routes->edit,
            "A routable model should be able to generate an edit route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/123/beta/456/gamma/789",
            $model->routes->update,
            "A routable model should be able to generate an update route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/123/beta/456/gamma/789",
            $model->routes->destroy,
            "A routable model should be able to generate a destroy route"
        );
    }

    public function testGetRoute()
    {
        Route::resource('alpha', 'AlphaControlller');
        Route::resource('alpha.beta', 'BetaControlller');
        Route::resource('alpha.beta.gamma', 'GammaControlller');

        $params = [
            'alpha' => new Alpha(['id' => 111]),
            'betum' => new Beta(['id' => 222]),
            'gamma' => new Gamma(['id' => 333]),
        ];

        $model = new Alpha;

        $this->assertEquals(
            config('app.url')."/alpha",
            $model->getRoute('index', $params),
            "A routable model should be able to generate an index route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/create",
            $model->getRoute('create', $params),
            "A routable model should be able to generate a create route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/111",
            $model->getRoute('show', $params),
            "A routable model should be able to generate a show route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/111/edit",
            $model->getRoute('edit', $params),
            "A routable model should be able to generate an edit route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/111",
            $model->getRoute('update', $params),
            "A routable model should be able to generate an update route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/111",
            $model->getRoute('destroy', $params),
            "A routable model should be able to generate a destroy route"
        );

        $model = new Beta;

        $this->assertEquals(
            config('app.url')."/alpha/111/beta",
            $model->getRoute('index', $params),
            "A routable model should be able to generate an index route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/111/beta/create",
            $model->getRoute('create', $params),
            "A routable model should be able to generate a create route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/111/beta/222",
            $model->getRoute('show', $params),
            "A routable model should be able to generate a show route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/111/beta/222/edit",
            $model->getRoute('edit', $params),
            "A routable model should be able to generate an edit route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/111/beta/222",
            $model->getRoute('update', $params),
            "A routable model should be able to generate an update route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/111/beta/222",
            $model->getRoute('destroy', $params),
            "A routable model should be able to generate a destroy route"
        );

        $model = new Gamma;

        $this->assertEquals(
            config('app.url')."/alpha/111/beta/222/gamma",
            $model->getRoute('index', $params),
            "A routable model should be able to generate an index route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/111/beta/222/gamma/create",
            $model->getRoute('create', $params),
            "A routable model should be able to generate a create route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/111/beta/222/gamma/333",
            $model->getRoute('show', $params),
            "A routable model should be able to generate a show route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/111/beta/222/gamma/333/edit",
            $model->getRoute('edit', $params),
            "A routable model should be able to generate an edit route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/111/beta/222/gamma/333",
            $model->getRoute('update', $params),
            "A routable model should be able to generate an update route"
        );

        $this->assertEquals(
            config('app.url')."/alpha/111/beta/222/gamma/333",
            $model->getRoute('destroy', $params),
            "A routable model should be able to generate a destroy route"
        );
    }
}
