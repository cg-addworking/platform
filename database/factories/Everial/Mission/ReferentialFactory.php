<?php

use App\Models\Everial\Mission\Referential;
use Faker\Generator as Faker;

$factory->define(Referential::class, function (Faker $faker) {
    return [
        'shipping_site'       => $faker->city,
        'shipping_address'    => $faker->streetAddress.', '.$faker->postcode.' '.$faker->city,
        'destination_site'    => $faker->city,
        'destination_address' => $faker->streetAddress.', '.$faker->postcode.' '.$faker->city,
        'distance'            => $faker->randomFloat($nb_max_decimals = 2, $min = 0, $max = 9999),
        'pallet_number'       => $faker->numberBetween($min = 1, $max = 12),
        'pallet_type'         => "115x115",
        'analytic_code'       => $faker->sha1,
    ];
});
