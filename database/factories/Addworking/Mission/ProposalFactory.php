<?php

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Offer;
use App\Models\Addworking\Mission\Proposal;
use App\Models\Addworking\User\User;
use Faker\Generator as Faker;

$factory->define(Proposal::class, function (Faker $faker) {
    return [
        'label'             => str_random(),
        'details'           => $faker->text(),
        'external_id'       => str_random(),
        'status'            => Proposal::STATUS_DRAFT,
        'need_quotation'    => $faker->boolean,
        'valid_from'        => $faker->date,
        'valid_until'       => $faker->date,
        'quantity'          => $faker->randomNumber(),
        'unit_price'        => $faker->randomFloat(2),
    ];
});

$factory->afterMaking(Proposal::class, function ($proposal, $faker) {
    $proposal->offer()->associate(
        factory(Offer::class)->create()
    );

    $proposal->createdBy()->associate(
        factory(User::class)->create()
    );

    $proposal->vendor()->associate(
        factory(Enterprise::class)->states('vendor')->create()
    );
});

$factory->state(Proposal::class, 'status_received', [
    'status' => Proposal::STATUS_RECEIVED,
]);

$factory->state(Proposal::class, 'status_interested', [
    'status' => Proposal::STATUS_INTERESTED,
]);
