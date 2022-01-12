<?php

use App\Models\Sogetrel\User\Passwork;
use App\Models\Sogetrel\User\Quizz;
use Faker\Generator as Faker;

$jobs = [
    "FTTH",
];

$factory->define(Quizz::class, function (Faker $faker) use ($jobs) {
    return [
        'status'       => $faker->randomElement(Quizz::getAvailableStatuses()),
        'job'          => $faker->randomElement($jobs),
        'score'        => $faker->randomDigit,
        'proposed_at'  => $faker->dateTimeThisYear,
        'completed_at' => $faker->dateTimeThisYear,
    ];
});

$factory->afterMaking(Quizz::class, function ($quizz, $faker) {
    $quizz->passwork()->associate(
        factory(Passwork::class)->create()
    );
});
