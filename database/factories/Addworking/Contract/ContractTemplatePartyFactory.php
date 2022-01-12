<?php

use App\Models\Addworking\Contract\ContractTemplate;
use App\Models\Addworking\Contract\ContractTemplateParty;
use Faker\Generator as Faker;

$factory->define(ContractTemplateParty::class, function (Faker $faker) {
    return [
        'denomination' => $faker->sentence,
        'order' => $faker->numberBetween(0, 5),
    ];
});

$factory->afterMaking(ContractTemplateParty::class, function ($party, $faker) {
    $party->contractTemplate()->associate(
        factory(ContractTemplate::class)->create()
    );
});
