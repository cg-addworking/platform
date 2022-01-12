<?php

use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Billing\InboundInvoiceItem;
use App\Models\Addworking\Billing\VatRate;
use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(InboundInvoiceItem::class, function (Faker $faker) {
    return [
        'label'      => $faker->realText(10),
        'quantity'   => $faker->randomDigit,
        'unit_price' => $faker->randomFloat(2, 0, 99999),
    ];
});

$factory->afterMaking(InboundInvoiceItem::class, function ($item, $faker) {
    $item->vatRate()->associate(
        factory(VatRate::class)->create()
    );
    $item->inboundInvoice()->associate(
        factory(InboundInvoice::class)->create()
    );
});
