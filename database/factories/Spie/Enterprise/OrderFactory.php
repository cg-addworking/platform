<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Spie\Enterprise\Enterprise;
use App\Models\Spie\Enterprise\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'short_label' => $faker->word,
        'year' => $faker->year,
        'subsidiary_company_label' => $faker->company,
        'direction_label' => $faker->jobTitle,
        'amount' => $faker->randomFloat,
    ];
});

$factory->afterMaking(Order::class, function ($order, $faker) {
    $order->enterprise()->associate(
        factory(Enterprise::class)->create()
    );
});
