<?php

namespace Components\Infrastructure\Megatron\Domain\Transformers;

use Components\Infrastructure\Megatron\Domain\Classes\TransformerInterface;
use Faker\Factory;

class AddressTransformer implements TransformerInterface
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function transform(array $address): array
    {
        return [
            'address' => $this->faker->address,
            'additionnal_address' => null,
            'zipcode' => $this->faker->postcode,
            'town' => $this->faker->city,
        ];
    }
}
