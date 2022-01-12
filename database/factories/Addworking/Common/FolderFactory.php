<?php

use App\Models\Addworking\Common\Folder;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Faker\Generator as Faker;

$factory->define(Folder::class, function (Faker $faker) {
    return [
        'name'                => $faker->sentence,
        'display_name'        => $faker->sentence,
        'shared_with_vendors' => false
    ];
});

$factory->afterMaking(Folder::class, function ($folder, $faker) {
    $folder->createdBy()->associate(
        factory(User::class)->create()
    );

    $folder->enterprise()->associate(
        factory(Enterprise::class)->create()
    );
});
