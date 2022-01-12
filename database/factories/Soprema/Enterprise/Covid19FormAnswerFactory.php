<?php

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Soprema\Enterprise\Covid19FormAnswer;
use Faker\Generator as Faker;

$factory->define(Covid19FormAnswer::class, function (Faker $faker) {
    return [
        'vendor_name'  => $faker->company,
        'vendor_siret' => random_numeric_string(14),
        'pursuit'      => $faker->boolean,
        'message'      => $faker->text,
    ];
});

$factory->afterMaking(Covid19FormAnswer::class, function ($ans, $faker) {
    $ans->vendor()->associate(factory(Enterprise::class)->state('vendor')->create())
        ->customer()->associate(factory(Enterprise::class)->state('customer')->create());
});
