<?php

use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\PaymentOrder\Application\Models\PaymentOrder;
use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(PaymentOrder::class, function (Faker $faker) {
    return [
        'number'        => $faker->randomNumber(),
        'status'        => "pending",
        'customer_name' => $faker->realText(10),
        'executed_at'   => $faker->dateTimeThisMonth()->format('Y-m-d'),
    ];
});
