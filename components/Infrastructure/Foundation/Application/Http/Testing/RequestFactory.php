<?php

namespace Components\Infrastructure\Foundation\Application\Http\Testing;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\App;

class RequestFactory
{
    protected $request;

    public function __construct(string $class = Request::class)
    {
        $this->request = new $class;
        $this->setRoute();
        $this->setSession();
    }

    public function obtain(): Request
    {
        return $this->request;
    }

    public function setInputs(array $inputs): self
    {
        $this->request->replace($inputs);

        return $this;
    }

    public function setFiles(array $files = []): self
    {
        $this->request->files->replace($files);

        return $this;
    }

    public function setUser(Authenticatable $user): self
    {
        $auth = App::make('auth');
        $auth->setUser($user);

        $auth->resolveUsersUsing(function () use ($user) {
            return $user;
        });

        $this->request->setUserResolver(function () use ($user) {
            return $user;
        });

        return $this;
    }

    public function setRoute($method = 'GET', $uri = '/', $action = null): self
    {
        $action = $action ?? 'Controller@action';

        $this->request->setRouteResolver(function () use ($method, $uri, $action) {
            return (new Route($method, $uri, $action))->bind($this->request);
        });

        return $this;
    }

    public function setSession(array $session = []): self
    {
        $store = App::make('session')->driver('array');
        $store->put($session);

        $this->request->setLaravelSession($store);

        return $this;
    }
}
