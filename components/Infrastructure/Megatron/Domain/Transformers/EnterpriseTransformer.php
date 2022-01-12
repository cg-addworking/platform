<?php

namespace Components\Infrastructure\Megatron\Domain\Transformers;

use Components\Infrastructure\Megatron\Domain\Classes\TransformerInterface;
use Faker\Factory;

class EnterpriseTransformer implements TransformerInterface
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function transform(array $enterprise): array
    {
        $result = [];

        if ($enterprise['is_vendor']) {
            $result['name'] = $this->faker->company . uniqid('_fake_');
        }

        $result['identification_number'] = $this->generateRandomNumericString(14);
        $result['registration_town'] = $this->faker->city;
        $result['tax_identification_number'] = $this->faker->iban('fr');

        return $result;
    }

    private function generateRandomNumericString(int $length)
    {
        $string = '';

        for ($i = 0; $i < $length; $i++) {
            $string .= mt_rand(0, 9);
        }

        return $string;
    }
}
