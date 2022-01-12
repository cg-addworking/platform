<?php

use App\Models\Addworking\User\User;
use App\Models\Sogetrel\User\PassworkSavedSearch;
use Faker\Generator as Faker;

$factory->define(PassworkSavedSearch::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'search' => "#",

    ];
});

$factory->afterMaking(PassworkSavedSearch::class, function ($search, $faker) {
    $search->user()->associate(
        factory(User::class)->create()
    );
});
