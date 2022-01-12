<?php

namespace Components\Infrastructure\Megatron\Domain\Transformers;

use Components\Infrastructure\Megatron\Domain\Classes\TransformerInterface;
use Faker\Factory;

class OutboundInvoiceCommentTransformer implements TransformerInterface
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function transform(array $outboundInvoiceComments): array
    {
        return [
            'content' => $this->faker->text()
        ];
    }
}
