<?php

use Carbon\Carbon;
use Components\Enterprise\InvoiceParameter\Application\Models\InvoiceParameter;
use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(InvoiceParameter::class, function (Faker $faker) {
    return [
        'analytic_code'                     => $faker->word,
        'discount_starts_at'                => $faker->date(),
        'discount_ends_at'                  => $faker->date(),
        'discount_amount'                   => $faker->randomFloat(),
        'billing_floor_amount'              => $faker->randomFloat(),
        'billing_cap_amount'                => $faker->randomFloat(),
        'default_management_fees_by_vendor' => $faker->randomFloat($max = 1),
        'custom_management_fees_by_vendor'  => $faker->randomFloat($max = 1),
        'fixed_fees_by_vendor_amount'       => $faker->randomFloat(),
        'subscription_amount'               => $faker->randomFloat(),
        'starts_at'                         => $faker->date(),
    ];
});
