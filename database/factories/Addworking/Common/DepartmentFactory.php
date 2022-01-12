<?php

use App\Models\Addworking\Common\Department;
use App\Models\Addworking\Common\Region;
use Faker\Generator as Faker;

$factory->define(Department::class, function (Faker $faker) {
    return [
        'slug_name'    => str_slug($faker->sentence(3)),
        'display_name' => $faker->sentence(3),
        'insee_code'   => $faker->randomNumber(5, true),
        'prefecture'   => str_slug($faker->sentence(3)),
    ];
});

$factory->afterMaking(Department::class, function ($department, $faker) {
    $department->region()->associate(
        factory(Region::class)->create()
    );
});
