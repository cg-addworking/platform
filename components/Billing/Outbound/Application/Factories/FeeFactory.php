<?php

use Carbon\Carbon;
use Components\Billing\Outbound\Application\Models\Fee;
use Components\Billing\Outbound\Application\Repositories\FeeRepository;
use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Fee::class, function (Faker $faker) {
    return [
        'number'              => $faker->randomNumber(),
        'label'               => $faker->realText(10),
        'type'                => $faker->randomElement((new FeeRepository)->getTypes()),
        'amount_before_taxes' => $faker->randomFloat(2, 0, 99999)
    ];
});
