<?php

use App\Models\Addworking\Common\Job;
use App\Models\Addworking\Common\Skill;
use Faker\Generator as Faker;

$factory->define(Skill::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'display_name' => $faker->word,
        'description' => $faker->sentence,
    ];
});

$factory->afterMaking(Skill::class, function ($skill, $faker) {
    $skill->job()->associate(
        factory(Job::class)->create()
    );
});
