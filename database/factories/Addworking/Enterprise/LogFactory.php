<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Log;
use Faker\Generator as Faker;

$factory->define(Log::class, function (Faker $faker) {
    return [
        'message' => $faker->sentence,
    ];
});

$factory->afterMaking(Log::class, function ($log, $faker) {
    $log->enterprise()->associate(
        factory(Enterprise::class)->create()
    );
});
