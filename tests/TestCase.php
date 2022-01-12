<?php

namespace Tests;

use App\Models\Addworking\User\User;
use Components\Infrastructure\Foundation\Application\Http\Testing\RequestFactory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Http\Request;
use Illuminate\Http\Testing\File as TestingFile;
use Illuminate\Http\Testing\FileFactory;
use Illuminate\Routing\Router;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function tearDown(): void
    {
        parent::tearDown();

        // workaround the faker text issue
        // @see https://github.com/fzaninotto/Faker/issues/1125
        gc_collect_cycles();
    }

    public function assertRouteExists(string $name, string $message = ''): void
    {
        $routes = $this->app->make(Router::class)->getRoutes();

        $this->assertTrue($routes->hasNamedRoute($name), $message ?: "No route defined for '$name'");
    }

    public function assertResourceRoutesExists(string $name, string $message = ''): void
    {
        foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $sub) {
            $this->assertRouteExists("{$name}.{$sub}", $message);
        }
    }

    public function fakeRequest(string $class = Request::class): RequestFactory
    {
        return new RequestFactory($class);
    }

    public function fakeFile(string $name, int $size_kb = 1024, ?string $mime_type = null): TestingFile
    {
        return $this->app->make(FileFactory::class)->create($name, $size_kb, $mime_type ?? "application/octet-stream");
    }

    public function fakeAuth(User $user)
    {
        $this->app->make('auth')->setUser($user);

        $this->app->make('auth')->resolveUsersUsing(function () use ($user) {
            return $user;
        });
    }
}
