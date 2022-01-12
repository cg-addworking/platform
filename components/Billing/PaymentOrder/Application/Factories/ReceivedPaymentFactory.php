<?php

use Components\Billing\PaymentOrder\Application\Models\ReceivedPayment;
use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(ReceivedPayment::class, function (Faker $faker) {
    return [
        'number'                 => $faker->randomNumber(),
        'bank_reference_payment' => $faker->realText(30),
        'iban'                   => $faker->realText(10),
        'bic'                    => $faker->realText(10),
        'amount'                 => $faker->randomNumber(),
        'received_at'            => $faker->dateTime()->format('Y-m-d'),
    ];
});
