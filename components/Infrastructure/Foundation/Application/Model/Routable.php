<?php

namespace Components\Infrastructure\Foundation\Application\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Router;
use Illuminate\Support\Str;
use ReflectionParameter;
use RuntimeException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use stdClass;

trait Routable
{
    public function routes()
    {
        return new class($this)
        {
            protected $routable;

            public function __construct(Model $routable)
            {
                $this->routable = $routable;
            }

            public function __get(string $key): string
            {
                return $this->routable->getRoute($key);
            }

            public function __call(string $method, array $arguments): string
            {
                return $this->routable->getRoute($method, $arguments[0] ?? []);
            }

            public function __isset(string $name): bool
            {
                try {
                    return $this->routable->getRoute($name);
                } catch (RouteNotFoundException $e) {
                    return false;
                }
            }
        };
    }

    public function getRoutesAttribute()
    {
        return $this->routes();
    }

    protected function getRoutePrefix(): string
    {
        return rtrim($this->routePrefix ?? snake_case(class_basename($this)), '.');
    }

    public function getRoute(string $name, array $arguments = []): string
    {
        $name   = ltrim(sprintf("%s.%s", $this->getRoutePrefix(), Str::snake($name)), ".");
        $route  = app(Router::class)->getRoutes()->getByName($name);

        if (is_null($route)) {
            throw new RouteNotFoundException("no such route {$name}");
        }

        $results = preg_match_all("/\{(\w+)\}/", $route->uri(), $matches);

        if (! $results) {
            return route($name);
        }

        $parameters = array_reverse($matches[1]);
        $vars       = [];
        $current    = $this;

        foreach ($parameters as $parameter) {
            $related  = $this->getRouteParameter($name, $current, $parameter, $arguments);
            $vars[]   = $related;
            $current  = $related;
        }

        return route($name, array_reverse($vars));
    }

    protected function getRouteParameter(string $route, Model $model, string $name, array $arguments): Model
    {
        // relation direclty passed to getRoute are prioritary over
        // current model's relations so they can be overriden when necessary
        // e.g. (new User)->routes->show(['user' => User::find(123)])
        if (isset($arguments[$name])) {
            return $arguments[$name];
        }

        // allows parameter name translation, when the route parameter
        // has a different name than the relation method on the model object
        // for instance /enterprise/{enterprise}/offer and $offer->customer.
        $name = $this->getRouteParameterAliases()[$name] ?? $name;
        $relation = camel_case($name);

        // the last route parameter is often the object itself, like a show route
        // for example. In this case, we take the ID directly on the object and not
        // from a relation
        if (ucfirst($relation) == class_basename($model)) {
            return $this;
        }

        // obtain the related model that the current model rely on
        // for example in /foo/{foo}/bar/{bar}, bar object should have a
        // foo() relation. We can therefore use $bar->foo()->id as a value
        // for {foo} parameter.
        $related  = $relations[$relation] ?? $model->{$relation};

        if (is_null($related) || ! $related instanceof Model || ! $related->exists) {
            throw new RuntimeException(
                static::class . " cannot generate route '{$route}': relation {$relation} missing"
            );
        }

        return $related;
    }

    protected function getRouteParameterAliases(): array
    {
        return $this->routeParameterAliases ?? [];
    }
}
