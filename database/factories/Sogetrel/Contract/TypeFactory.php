<?php

use App\Models\Sogetrel\Contract\Type;
use Faker\Generator as Faker;

$factory->define(Type::class, function (Faker $faker) {
    $name = $faker->sentence;

    return [
        'name' => str_slug($name),
        'display_name' => $name,
    ];
});
