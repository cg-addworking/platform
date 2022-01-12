<?php

namespace Components\Infrastructure\Megatron\Domain\Transformers;

use Components\Infrastructure\Megatron\Domain\Classes\TransformerInterface;
use Faker\Factory;

class SogetrelUserPassworksTransformer implements TransformerInterface
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function transform(array $passWork): array
    {
        $data = json_decode($passWork['data'], true);
        $data['phone'] = $this->faker->phoneNumber;
        $data['enterprise_name'] = $this->faker->company;

        return [
            'data' => json_encode($data)
        ];
    }
}
