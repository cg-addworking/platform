<?php

use App\Models\Addworking\Common\Comment;
use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\User\User;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'content' => $faker->realText($maxNbChars = 200, $indexSize = 2),
    ];
});

$factory->afterMaking(Comment::class, function ($comment, $faker) {
    $comment->author()->associate(
        factory(User::class)->create()
    );

    $comment->commentable()->associate(
        factory(Mission::class)->create()
    );
});
