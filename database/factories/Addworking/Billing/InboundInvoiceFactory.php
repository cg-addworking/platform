<?php

use App\Models\Addworking\Billing\DeadlineType;
use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use Carbon\Carbon;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(InboundInvoice::class, function (Faker $faker) {
    return [
        'status'   => array_random(InboundInvoice::getAvailableStatuses()),
        'number'   => $faker->randomDigit,
        'month'    => date('m/Y'),
        'amount_before_taxes' => $faker->randomFloat(2),
        'amount_of_taxes' => $faker->randomFloat(2),
        'amount_all_taxes_included' => $faker->randomFloat(2),
        'invoiced_at' => Carbon::now(),
    ];
});

$factory->afterMaking(InboundInvoice::class, function ($inbound_invoice, $faker) {
    $inbound_invoice->enterprise()->associate(
        factory(Enterprise::class)->create(['is_vendor' => true])
    );

    $inbound_invoice->customer()->associate(
        factory(Enterprise::class)->create(['is_customer' => true])
    );

    $inbound_invoice->deadline()->associate(
        factory(DeadlineType::class)->create()
    );

    $inbound_invoice->file()->associate(
        factory(File::class)->create()
    );
});

$factory->state(InboundInvoice::class, 'to_validate', [
    'status' => InboundInvoice::STATUS_TO_VALIDATE,
]);

$factory->state(InboundInvoice::class, 'pending', [
    'status' => InboundInvoice::STATUS_PENDING,
]);

$factory->state(InboundInvoice::class, 'validated', [
    'status' => InboundInvoice::STATUS_VALIDATED,
]);

$factory->state(InboundInvoice::class, 'paid', [
    'status' => InboundInvoice::STATUS_PAID,
]);
