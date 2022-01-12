<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Spie\Enterprise\Enterprise;
use App\Models\Spie\Enterprise\Qualification;
use Faker\Generator as Faker;

$factory->define(Qualification::class, function (Faker $faker) {
    return [
        'code' => random_numeric_string(9),
        'name' => $faker->word,
        'display_name' => $faker->sentence,
        'follow_up' => $faker->boolean,
        'active' => $faker->boolean,
        'valid_until' => $faker->date,
        'revived_at' => $faker->date,
        'site' => $faker->city,
    ];
});

$factory->afterMaking(Qualification::class, function ($qualification, $faker) {
    $qualification->enterprise()->associate(
        factory(Enterprise::class)->create()
    );
});
