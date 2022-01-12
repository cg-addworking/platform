<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Spie\Enterprise\CoverageZone;
use App\Models\Spie\Enterprise\Enterprise;
use Faker\Generator as Faker;

$factory->define(CoverageZone::class, function (Faker $faker) {
    return [
        'code' => random_numeric_string(9),
        'label' => $faker->slug,
    ];
});

$factory->afterCreating(CoverageZone::class, function ($coverage_zone, $faker) {
    $coverage_zone->enterprises()->attach(
        factory(Enterprise::class)->create(),
        ['active' => $faker->boolean]
    );
});
