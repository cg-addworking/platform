<?php

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\OnboardingProcess;
use App\Models\Addworking\User\User;
use Faker\Generator as Faker;

$factory->define(OnboardingProcess::class, function (Faker $faker) {
    return [
        'current_step'     => 0,
        'complete'         => false,
        'started_at'       => $faker->dateTime,
        'completed_at'     => $faker->dateTime,
        'last_notified_at' => $faker->dateTime,
    ];
});

$factory->afterMaking(OnboardingProcess::class, function ($onboarding, $faker) {
    $onboarding->user()->associate(
        factory(User::class)->create()
    );
});

$factory->afterMaking(OnboardingProcess::class, function ($onboarding, $faker) {
    $onboarding->enterprise()->associate(
        factory(Enterprise::class)->create()
    );
});

$factory->state(OnboardingProcess::class, 'incomplete', [
    'complete' => false
]);

$factory->state(OnboardingProcess::class, 'complete', [
    'complete' => true
]);
