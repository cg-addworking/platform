<?php

use App\Models\Addworking\Common\Job;
use App\Models\Addworking\Enterprise\Enterprise;
use Faker\Generator as Faker;

$factory->define(Job::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'display_name' => $faker->word,
        'description' => $faker->sentence,
    ];
});

$factory->afterMaking(Job::class, function ($job, $faker) {
    $job->enterprise()->associate(
        factory(Enterprise::class)->create(['is_customer' => true])
    );
});
