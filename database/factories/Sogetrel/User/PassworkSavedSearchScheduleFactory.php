<?php

use App\Models\Sogetrel\User\PassworkSavedSearch;
use App\Models\Sogetrel\User\PassworkSavedSearchSchedule;
use Faker\Generator as Faker;

$factory->define(PassworkSavedSearchSchedule::class, function (Faker $faker) {
    return [
        'email' => $faker->email,
        'frequency' => $faker->numberBetween(1, 7),
        'last_sent_at' => $faker->dateTimeThisMonth,

    ];
});

$factory->afterMaking(PassworkSavedSearchSchedule::class, function ($schedule, $faker) {
    $schedule->passworkSavedSearch()->associate(
        factory(PassworkSavedSearch::class)->create()
    );
});
