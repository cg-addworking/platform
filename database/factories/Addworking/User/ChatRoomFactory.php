<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Addworking\User\ChatRoom;
use Faker\Generator as Faker;

$factory->define(ChatRoom::class, function (Faker $faker) {
    return [
        'name' => $faker->name
    ];
});
