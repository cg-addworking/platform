<?php

namespace Components\Infrastructure\Megatron\Domain\Classes;

interface TransformerInterface
{
    public function transform(array $data) : array;
}
