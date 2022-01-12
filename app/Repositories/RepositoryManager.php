<?php

namespace App\Repositories;

use App\Contracts\Models\Repository as ModelRepositoryInterface;
use App\Contracts\RepositoryInterface;
use App\Repositories\BaseRepository;
use Components\Common\Common\Domain\Interfaces\RepositoryInterface as DomainRepositoryInterface;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class RepositoryManager
{
    protected $container;

    protected $aliases = [];

    protected $repositories = [];

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->aliases   = $container['config']->get('repositories');
    }

    public function __call($name, $arguments)
    {
        return $this->get($name);
    }

    public function get($name)
    {
        if ($name instanceof Model) {
            $name = get_class($name);
        }

        if (isset($this->aliases[$name])) {
            $name = $this->aliases[$name];
        }

        if (isset($this->repositories[$name])) {
            return $this->repositories[$name];
        }

        if (is_string($name) && $this->container->has($name) || $this->isRepositoryClass($name)) {
            return $this->resolve($name);
        }

        if (is_string($name) && $this->isModelClass($name)) {
            return $this->lookup($name);
        }

        throw new \RuntimeException("unable to find a valid repository");
    }

    public static function isRepositoryClass(string $class): bool
    {
        return class_exists($class)
            && Arr::hasAny(class_implements($class), [
                RepositoryInterface::class,
                ModelRepositoryInterface::class,
                DomainRepositoryInterface::class,
            ]);
    }

    public static function isModelClass(string $class): bool
    {
        return class_exists($class, true)
            && in_array(Model::class, class_parents($class));
    }

    protected function resolve(string $abstract)
    {
        $resolved = $this->container->make($abstract);

        if (! static::isRepositoryClass(get_class($resolved))) {
            throw new \RuntimeException("invalid repository '{$abstract}': resolved instance is not a repository");
        }

        $this->repositories[$abstract] = $resolved;

        if ($resolved instanceof BaseRepository) {
            $this->repositories[$resolved->getModelClass()] = $resolved;
        }

        return $resolved;
    }

    protected function lookup(string $class)
    {
        $repository_class = "App\\Repositories\\" . Str::after($class, "App\\Models\\") . "Repository";

        if ($this->isRepositoryClass($repository_class)) {
            return $this->resolve($repository_class);
        }

        throw new \RuntimeException("unable to locate repository '{$repository_class}'");
    }
}
