<?php

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Everial\Mission\Price;
use App\Models\Everial\Mission\Referential;
use Faker\Generator as Faker;

$factory->define(Price::class, function (Faker $faker) {
    return [
        'amount' => $faker->randomFloat($nb_max_decimals = 2, $min = 0, $max = 99999),
    ];
});

$factory->afterMaking(Price::class, function ($price_list, $faker) {
    $price_list->vendor()->associate(
        factory(Enterprise::class)->states('vendor')->create()
    );
});

$factory->afterMaking(Price::class, function ($price_list, $faker) {
    $price_list->referential()->associate(
        factory(Referential::class)->create()
    );
});
