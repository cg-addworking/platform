<?php

use Components\Billing\PaymentOrder\Application\Models\PaymentOrderItem;
use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(PaymentOrderItem::class, function (Faker $faker) {
    return [
        'amount'          => $faker->randomNumber(),
        'enterprise_name' => $faker->realText(10),
    ];
});
