<?php

use App\Models\Addworking\Common\File;
use App\Models\Addworking\User\User;
use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(File::class, function (Faker $faker) {
    return [
        'path'      => sprintf('%s.%s', uniqid('/tmp/'), $faker->fileExtension ?: 'pdf'),
        'mime_type' => $faker->mimeType,
        'content'   => $faker->text,
    ];
});

$factory->afterMaking(File::class, function ($file, $faker) {
    $file->user()->associate(
        factory(User::class)->create()
    );
});
