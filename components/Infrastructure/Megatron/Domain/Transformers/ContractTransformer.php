<?php

namespace Components\Infrastructure\Megatron\Domain\Transformers;

use Components\Infrastructure\Megatron\Domain\Classes\TransformerInterface;
use Faker\Factory;

class ContractTransformer implements TransformerInterface
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function transform(array $contract): array
    {
        return [
            'name' => $this->faker->uuid,
            'signinghub_package_id' => null,
            'signinghub_document_id' => null,
        ];
    }
}
