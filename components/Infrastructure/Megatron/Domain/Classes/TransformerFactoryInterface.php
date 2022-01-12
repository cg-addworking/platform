<?php

namespace Components\Infrastructure\Megatron\Domain\Classes;

interface TransformerFactoryInterface
{
    public function getTransformer(string $table) : TransformerInterface;
}
