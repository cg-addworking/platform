<?php

use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Contract\ContractParty;
use Faker\Generator as Faker;

$factory->define(ContractParty::class, function (Faker $faker) {
    return [
        'denomination' => $faker->sentence,
        'order' => $faker->numberBetween(0, 5),
    ];
});

$factory->afterMaking(ContractParty::class, function ($party, $faker) {
    $party->contract()->associate(
        factory(Contract::class)->create()
    );
});
