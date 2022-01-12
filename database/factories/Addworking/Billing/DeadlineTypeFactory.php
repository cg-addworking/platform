<?php

use App\Models\Addworking\Billing\DeadlineType;
use Faker\Generator as Faker;

$factory->define(DeadlineType::class, function (Faker $faker) {
    $name = $faker->sentence;

    return [
        'name'         => $name,
        'display_name' => $name,
        'value'        => $faker->numberBetween(0, 365),
        'description'  => $faker->text,
    ];
});
