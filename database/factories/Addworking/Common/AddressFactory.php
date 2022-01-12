<?php

use Faker\Generator as Faker;
use App\Models\Addworking\Common\Address;

$factory->define(Address::class, function (Faker $faker) {
    return [
        'address' => $faker->streetAddress,
        'zipcode' => random_numeric_string(5),
        'town'    => $faker->city,
        'country' => array_random(['fr', 'de', 'be']),
    ];
});
