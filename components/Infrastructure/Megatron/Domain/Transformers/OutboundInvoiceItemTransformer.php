<?php

namespace Components\Infrastructure\Megatron\Domain\Transformers;

use Components\Infrastructure\Megatron\Domain\Classes\TransformerInterface;
use Faker\Factory;

class OutboundInvoiceItemTransformer implements TransformerInterface
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function transform(array $outboundsInvoices): array
    {
        return [
            'label' => $this->faker->text()
        ];
    }
}
