<?php

use Faker\Generator as Faker;
use App\Models\Addworking\Mission\MissionTracking;
use App\Models\Addworking\Mission\MissionTrackingLine;
use App\Models\Addworking\Mission\Mission;

$factory->define(MissionTrackingLine::class, function (Faker $faker) {
    return [
        'label'                => $faker->sentence(6, true),
        'quantity'             => rand(1, 5),
        'unit_price'           => random_float(100, 200),
        'unit'                 => $faker->randomElement(Mission::getAvailableUnits()),
        'validation_vendor'    => $faker->randomElement(MissionTrackingLine::getAvailableStatuses()),
        'validation_customer'  => $faker->randomElement(MissionTrackingLine::getAvailableStatuses()),
        'reason_for_rejection' => null,

    ];
});

$factory->afterMaking(MissionTrackingLine::class, function ($response, $faker) {
    $response->missionTracking()->associate(
        factory(MissionTracking::class)->create()
    );
});
