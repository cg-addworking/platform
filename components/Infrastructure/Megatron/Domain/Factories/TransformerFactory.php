<?php

namespace Components\Infrastructure\Megatron\Domain\Factories;

use Components\Infrastructure\Megatron\Domain\Classes\TransformerFactoryInterface;
use Components\Infrastructure\Megatron\Domain\Classes\TransformerInterface;
use Components\Infrastructure\Megatron\Domain\Transformers\IdentityTransformer;
use Illuminate\Contracts\Foundation\Application;

class TransformerFactory implements TransformerFactoryInterface
{
    protected $app;
    protected $config;

    public function __construct(Application $app, array $config)
    {
        $this->app = $app;
        $this->config = $config;
    }
    public function getTransformer(string $table): TransformerInterface
    {
        $class = $this->config[$table] ?? IdentityTransformer::class;

        return $this->app->make($class);
    }
}
