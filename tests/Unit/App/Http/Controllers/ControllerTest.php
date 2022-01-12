<?php

namespace Tests\Unit\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteCollection;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class ControllerTest extends TestCase
{
    /**
     * @dataProvider controllerDataProvider
     */
    public function testRedirectWhenConditionIstrue(Controller $controller)
    {
        $response = $controller->redirectWhen(true, '/foo/bar');
        $response = TestResponse::fromBaseResponse($response);

        $response->assertRedirect('/foo/bar');
        $response->assertSessionHas('status.class', "success");
    }

    /**
     * @dataProvider controllerDataProvider
     */
    public function testRedirectWhenConditionIsFalse(Controller $controller)
    {
        // mocking Redirector or UrlGenerator is very complicated. A very
        // simple solution to "force" UrlGenerator::previous to generate
        // a fixed path is to simply use an anonymous class and then
        // swap it on the container (i.e. replacing the existing 'url'
        // implementation with our). See RoutingServiceProvider for more
        // details about the intricacies of this.
        $this->swap('url', new class(new RouteCollection, new Request) extends UrlGenerator {
            public function previous($fallback = false)
            {
                return "/somewhere/else";
            }
        });

        $response = $controller->redirectWhen(false, '/foo/bar');
        $response = TestResponse::fromBaseResponse($response);

        $response->assertRedirect('/somewhere/else');
        $response->assertSessionHas('status.class', "danger");
    }

    /**
     * @dataProvider controllerDataProvider
     */
    public function testSuccess(Controller $controller)
    {
        $controller->success("that's a success!");

        $this->assertTrue(Session::has('status.class'));
        $this->assertEquals("success", Session::get('status.class'));

        $this->assertTrue(Session::has('status.message'));
        $this->assertEquals("that's a success!", Session::get('status.message'));
    }

    /**
     * @dataProvider controllerDataProvider
     */
    public function testInfo(Controller $controller)
    {
        $controller->info("Breaking news!");

        $this->assertTrue(Session::has('status.class'));
        $this->assertEquals("info", Session::get('status.class'));

        $this->assertTrue(Session::has('status.message'));
        $this->assertEquals("Breaking news!", Session::get('status.message'));
    }

    /**
     * @dataProvider controllerDataProvider
     */
    public function testWarning(Controller $controller)
    {
        $controller->warning("Be careful!");

        $this->assertTrue(Session::has('status.class'));
        $this->assertEquals("warning", Session::get('status.class'));

        $this->assertTrue(Session::has('status.message'));
        $this->assertEquals("Be careful!", Session::get('status.message'));
    }

    /**
     * @dataProvider controllerDataProvider
     */
    public function testError(Controller $controller)
    {
        $controller->error("Woops...");

        $this->assertTrue(Session::has('status.class'));
        $this->assertEquals("danger", Session::get('status.class'));

        $this->assertTrue(Session::has('status.message'));
        $this->assertEquals("Woops...", Session::get('status.message'));
    }

    /**
     * @dataProvider controllerDataProvider
     */
    public function testSuccessStatus(Controller $controller)
    {
        $status = $controller->successStatus("message");

        $this->assertEquals('success', Arr::get($status, 'status.class'));
        $this->assertEquals('message', Arr::get($status, 'status.message'));
    }

    /**
     * @dataProvider controllerDataProvider
     */
    public function testInfoStatus(Controller $controller)
    {
        $status = $controller->infoStatus("message");

        $this->assertEquals('info', Arr::get($status, 'status.class'));
        $this->assertEquals('message', Arr::get($status, 'status.message'));
    }

    /**
     * @dataProvider controllerDataProvider
     */
    public function testWarningStatus(Controller $controller)
    {
        $status = $controller->warningStatus("message");

        $this->assertEquals('warning', Arr::get($status, 'status.class'));
        $this->assertEquals('message', Arr::get($status, 'status.message'));
    }

    /**
     * @dataProvider controllerDataProvider
     */
    public function testErrorStatus(Controller $controller)
    {
        $status = $controller->errorStatus("message");

        $this->assertEquals('danger', Arr::get($status, 'status.class'));
        $this->assertEquals('message', Arr::get($status, 'status.message'));
    }

    public function testRedirectHelperFunctionWhenConditionIstrue()
    {
        $response = redirect_when(true, '/foo/bar');
        $response = TestResponse::fromBaseResponse($response);

        $response->assertRedirect('/foo/bar');
        $response->assertSessionHas('status.class', "success");
    }

    public function testRedirectHelperFunctionWhenConditionIsFalse()
    {
        // mocking Redirector or UrlGenerator is very complicated. A very
        // simple solution to "force" UrlGenerator::previous to generate
        // a fixed path is to simply use an anonymous class and then
        // swap it on the container (i.e. replacing the existing 'url'
        // implementation with our). See RoutingServiceProvider for more
        // details about the intricacies of this.
        $this->swap('url', new class(new RouteCollection, new Request) extends UrlGenerator {
            public function previous($fallback = false)
            {
                return "/somewhere/else";
            }
        });

        $response = redirect_when(false, '/foo/bar');
        $response = TestResponse::fromBaseResponse($response);

        $response->assertRedirect('/somewhere/else');
        $response->assertSessionHas('status.class', "danger");
    }

    public function testSuccessStatusHelperFunction()
    {
        $status = success_status("message");

        $this->assertEquals('success', Arr::get($status, 'status.class'));
        $this->assertEquals('message', Arr::get($status, 'status.message'));
    }

    public function testInfoStatusHelperFunction()
    {
        $status = info_status("message");

        $this->assertEquals('info', Arr::get($status, 'status.class'));
        $this->assertEquals('message', Arr::get($status, 'status.message'));
    }

    public function testWarningStatusHelperFunction()
    {
        $status = warning_status("message");

        $this->assertEquals('warning', Arr::get($status, 'status.class'));
        $this->assertEquals('message', Arr::get($status, 'status.message'));
    }

    public function testErrorStatusHelperFunction()
    {
        $status = error_status("message");

        $this->assertEquals('danger', Arr::get($status, 'status.class'));
        $this->assertEquals('message', Arr::get($status, 'status.message'));
    }

    public function controllerDataProvider()
    {
        return [
            'blank-controller' => [
                'controller' => new class extends Controller {
                    //
                },
            ],
        ];
    }
}
