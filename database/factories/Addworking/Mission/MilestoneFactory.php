<?php

use Faker\Generator as Faker;
use App\Models\Addworking\Mission\Milestone;
use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\Enterprise\Enterprise;

$factory->define(Milestone::class, function (Faker $faker) {
    return [
        'starts_at'    => $faker->date,
        'ends_at'      => $faker->date,
    ];
});

$factory->afterMaking(Milestone::class, function ($response, $faker) {
    $response->mission()->associate(
        factory(Mission::class)->create()
    );
});
