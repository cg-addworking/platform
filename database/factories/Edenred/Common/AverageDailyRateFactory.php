<?php

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Edenred\Common\AverageDailyRate;
use App\Models\Edenred\Common\Code;
use Faker\Generator as Faker;

$factory->define(AverageDailyRate::class, function (Faker $faker) {
    return [
        'rate' => $faker->randomFloat,
    ];
});

$factory->afterMaking(AverageDailyRate::class, function ($rate, $faker) {
    $rate->code()->associate(
        factory(Code::class)->create()
    );
});

$factory->afterMaking(AverageDailyRate::class, function ($rate, $faker) {
    $rate->vendor()->associate(
        factory(Enterprise::class)->create()
    );
});
