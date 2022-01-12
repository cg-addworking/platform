<?php

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Iban;
use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Iban::class, function (Faker $faker) {
    return [
        'iban'  => $faker->iban('fr'),
        'bic'   => $faker->swiftBicNumber,
        'label' => $faker->realText(10)
    ];
});

$factory->afterMaking(Iban::class, function ($iban, $faker) {
    $iban->enterprise()->associate(
        factory(Enterprise::class)->create()
    );
});

$factory->state(Iban::class, 'approved', [
    'status' => "approved",
]);

$factory->state(Iban::class, 'pending', [
    'status' => "pending",
]);

$factory->state(Iban::class, 'expired', [
    'status' => "expired",
]);
