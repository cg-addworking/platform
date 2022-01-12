<?php

use App\Models\Addworking\Common\Region;
use Faker\Generator as Faker;

$factory->define(Region::class, function (Faker $faker) {
    return [
        'slug_name'    => str_slug($faker->sentence(3)),
        'display_name' => $faker->sentence(3),
    ];
});
