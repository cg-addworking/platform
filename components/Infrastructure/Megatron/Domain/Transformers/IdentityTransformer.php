<?php

namespace Components\Infrastructure\Megatron\Domain\Transformers;

use Components\Infrastructure\Megatron\Domain\Classes\TransformerInterface;

class IdentityTransformer implements TransformerInterface
{
    public function transform(array $item): array
    {
        return $item;
    }
}
