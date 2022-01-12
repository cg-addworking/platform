<?php

use App\Models\Addworking\Common\Department;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Offer;
use App\Models\Addworking\User\User;
use Faker\Generator as Faker;

$factory->define(Offer::class, function (Faker $faker) {
    return [
        'number'      => $faker->randomNumber,
        'status'      => "draft",
        'label'       => $faker->sentence(3),
        'description' => $faker->paragraph,
        'starts_at'   => $faker->dateTime,
        'ends_at'     => $faker->dateTime,
        'external_id' => null,
    ];
});

$factory->afterMaking(Offer::class, function ($offer, $faker) {
    $offer->customer()->associate(
        factory(Enterprise::class)->states('customer')->create()
    );

    $offer->createdBy()->associate(
        $offer->customer->users()->first()
    );

    $offer->referent()->associate(
        factory(User::class)->create()
    );
});

$factory->afterCreating(Offer::class, function ($offer, $faker) {
    $offer->departments()->attach(
        Department::exists() ? Department::inRandomOrder()->take(3)->get() : factory(Department::class, 3)->create()
    );
});

$factory->state(Offer::class, 'draft', [
    'status' => Offer::STATUS_DRAFT
]);

$factory->state(Offer::class, 'to_provide', [
    'status' => Offer::STATUS_TO_PROVIDE
]);

$factory->state(Offer::class, 'communicated', [
    'status' => Offer::STATUS_COMMUNICATED
]);

$factory->state(Offer::class, 'closed', [
    'status' => Offer::STATUS_CLOSED
]);

$factory->state(Offer::class, 'abandoned', [
    'status' => Offer::STATUS_ABANDONED
]);
