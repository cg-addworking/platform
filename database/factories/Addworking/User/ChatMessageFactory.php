<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Addworking\User\ChatMessage;
use App\Models\Addworking\User\ChatRoom;
use App\Models\Addworking\User\User;
use Faker\Generator as Faker;

$factory->define(ChatMessage::class, function (Faker $faker) {
    return [
        'message' => $faker->sentence
    ];
});

$factory->afterMaking(ChatMessage::class, function ($message, $faker) {
    $message->user()->associate(
        factory(User::class)->create()
    );
});

$factory->afterMaking(ChatMessage::class, function ($message, $faker) {
    $message->chatRoom()->associate(
        factory(ChatRoom::class)->create()
    );
});
