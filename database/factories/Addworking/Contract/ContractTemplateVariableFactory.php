<?php

use App\Models\Addworking\Contract\ContractTemplate;
use App\Models\Addworking\Contract\ContractTemplateVariable;
use Faker\Generator as Faker;

$factory->define(ContractTemplateVariable::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence,
        'default_Value' => "",
        'required' => false,
    ];
});

$factory->afterMaking(ContractTemplateVariable::class, function ($variable, $faker) {
    $variable->contractTemplate()->associate(
        factory(ContractTemplate::class)->create()
    );
});
