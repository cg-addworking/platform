<?php

use Components\Billing\Outbound\Application\Models\OutboundInvoiceItem;
use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(OutboundInvoiceItem::class, function (Faker $faker) {
    return [
        'label'      => $faker->realText(10),
        'quantity'   => $faker->randomDigit,
        'unit_price' => $faker->randomFloat(2, 0, 99999),
        'number'     => $faker->randomNumber(),
    ];
});
