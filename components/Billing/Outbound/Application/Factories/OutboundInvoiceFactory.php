<?php

use App\Models\Addworking\Enterprise\Enterprise;
use Carbon\Carbon;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\Outbound\Application\Repositories\OutboundInvoiceRepository;
use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(OutboundInvoice::class, function (Faker $faker) {
    return [
        'number'      => $faker->randomNumber(),
        'month'       => $faker->dateTimeThisMonth()->format('Y-m'),
        'invoiced_at' => $faker->dateTimeThisMonth()->format('Y-m-d'),
        'due_at'      => $faker->dateTimeThisMonth()->format('Y-m-d'),
        'status'      => OutboundInvoice::STATUS_PENDING,
    ];
});
