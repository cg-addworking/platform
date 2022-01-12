<?php

use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\Enterprise\Enterprise;

use App\Models\Addworking\Mission\Offer;
use Faker\Generator as Faker;

$factory->define(Mission::class, function (Faker $faker) {
    return [
        'status'      => array_random(Mission::getAvailableStatuses()),
        'label'       => $faker->sentence(6, true),
        'description' => $faker->paragraph(3, true),
        'location'    => array_random(array_flatten(Mission::getAvailableLocations())),
        'starts_at'   => date('Y-m-d', strtotime('-1 week')),
        'ends_at'     => date('Y-m-d', strtotime('-1 days')),
        'quantity'    => rand(1, 5),
        'unit_price'  => 10.1,
        'unit'        => array_random(Mission::getAvailableUnits()),
        'external_id' => str_random(),
        'number'      => rand(),
    ];
});

$factory->afterMaking(Mission::class, function ($response, $faker) {
    $response->customer()->associate(
        factory(Enterprise::class)->create([
            'is_customer' => true,
        ])
    );

    $response->vendor()->associate(
        factory(Enterprise::class)->create([
            'is_vendor' => true,
        ])
    );

    $response->offer()->associate(
        factory(Offer::class)->create()
    );
});

$factory->state(Mission::class, 'unit_hours', [
    'unit' => Mission::UNIT_HOURS,
]);

$factory->state(Mission::class, 'unit_days', [
    'unit' => Mission::UNIT_DAYS,
]);

$factory->state(Mission::class, 'unit_fixed_fees', [
    'unit' => Mission::UNIT_FIXED_FEES,
]);

$factory->state(Mission::class, 'status_draft', [
    'status' => Mission::STATUS_DRAFT,
]);

$factory->state(Mission::class, 'status_in_progress', [
    'status' => Mission::STATUS_IN_PROGRESS,
]);

$factory->state(Mission::class, 'status_done', [
    'status' => Mission::STATUS_DONE,
]);
