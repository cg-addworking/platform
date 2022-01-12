<?php

use App\Models\Addworking\Common\Skill;
use App\Models\Edenred\Common\Code;
use Faker\Generator as Faker;

$factory->define(Code::class, function (Faker $faker) {
    return [
        'level' => $faker->randomDigitNotNull,
        'code' => $faker->shuffle('foobar124'),
    ];
});

$factory->afterMaking(Code::class, function ($code, $faker) {
    $code->skill()->associate(
        factory(Skill::class)->create()
    );
});
