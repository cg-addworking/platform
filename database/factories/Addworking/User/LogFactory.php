<?php

use App\Models\Addworking\User\User;
use App\Models\Addworking\User\UserLog;
use Faker\Generator as Faker;

$factory->define(UserLog::class, function (Faker $faker) {
    return [
        'user_id'       => function () {
            return factory(User::class)->create()->id;
        },
        'route'         => $faker->slug,
        'url'           => $faker->url,
        'http_method'   => $faker->word,
        'impersonating' => $faker->boolean,
    ];
});
