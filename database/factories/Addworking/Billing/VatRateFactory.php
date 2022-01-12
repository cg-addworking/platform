<?php

use App\Models\Addworking\Billing\VatRate;
use Faker\Generator as Faker;

$factory->define(VatRate::class, function (Faker $faker) {
    $name = $faker->sentence;

    return [
        'name'         => $name,
        'display_name' => $name,
        'value'        => $faker->randomFloat(2, 0, 100),
        'description'  => $faker->text,
    ];
});
