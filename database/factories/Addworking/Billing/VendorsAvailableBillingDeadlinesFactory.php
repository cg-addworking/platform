<?php

use App\Models\Addworking\Billing\VendorsAvailableBillingDeadlines;
use App\Models\Addworking\Enterprise\Enterprise;
use Faker\Generator as Faker;

$factory->define(VendorsAvailableBillingDeadlines::class, function (Faker $faker) {
    return [
        'upon_receipt' => $faker->boolean(),
        '30_days'      => $faker->boolean(),
    ];
});

$factory->afterMaking(VendorsAvailableBillingDeadlines::class, function ($deadlines, $faker) {
    $deadlines->customer()->associate(
        factory(Enterprise::class)->create(['is_customer' => true])
    );

    $deadlines->vendor()->associate(
        factory(Enterprise::class)->create(['is_vendor' => true])
    );
});
