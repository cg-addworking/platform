<?php

use App\Models\Addworking\Common\File;
use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\Mission\PurchaseOrder;
use Barryvdh\DomPDF\Facade as PDF;
use Faker\Generator as Faker;

$factory->define(PurchaseOrder::class, function (Faker $faker) {
    return [
        'status' => $faker->randomElement(PurchaseOrder::getAvailableStatuses()),
    ];
});

$factory->afterMaking(PurchaseOrder::class, function ($response) {
    $response->mission()->associate(
        factory(Mission::class)->create()
    );

    $pdf = PDF::loadHTML('
        <img src="img/logo_addworking_vertical.png">
        <h1><div style="text-align: center;">BON DE COMMANDE</div></h1>
    ');

    $response->file()->associate(
        factory(File::class)->create([
            'path'      => sprintf('%s.%s', uniqid('/tmp/'), 'pdf'),
            'mime_type' => 'application/pdf',
            'content'   => @$pdf->output()
        ])
    );
});

$factory->state(PurchaseOrder::class, 'draft', [
    'status' => PurchaseOrder::STATUS_DRAFT
]);

$factory->state(PurchaseOrder::class, 'sent', [
    'status' => PurchaseOrder::STATUS_SENT
]);
