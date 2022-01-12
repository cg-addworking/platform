<?php

use Faker\Generator as Faker;
use App\Models\Addworking\Mission\Milestone;
use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\Mission\MissionTracking;

$factory->define(MissionTracking::class, function (Faker $faker) {
    return [
        'number'      => $faker->randomDigitNotNull,
        'user_id'     => null,
        'status'      => $faker->randomElement(MissionTracking::getAvailableStatuses()),
        'description' => $faker->paragraph(3, true),
    ];
});

$factory->afterMaking(MissionTracking::class, function ($response, $faker) {
    $response->mission()->associate(
        factory(Mission::class)->create()
    );

    $response->milestone()->associate(
        factory(Milestone::class)->create()
    );
});
