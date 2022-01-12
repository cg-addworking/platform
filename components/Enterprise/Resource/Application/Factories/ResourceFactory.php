<?php

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Enterprise\Resource\Application\Models\Resource;
use Components\Enterprise\Resource\Application\Repositories\ResourceRepository;
use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Resource::class, function (Faker $faker) {
    return [
        'number'     => $faker->randomNumber(),
        'first_name'          => $faker->firstName,
        'last_name'           => $faker->lastName,
        'email'               => $faker->unique()->safeEmail,
        'registration_number' => $faker->word,
        'status'              => $faker->randomElement((new ResourceRepository)->getAvailableStatuses()),
        'note'                => $faker->text,
    ];
});

$factory->afterMaking(Resource::class, function ($resource, $faker) {
    $resource->createdBy()->associate(
        factory(User::class)->create()
    );

    $resource->vendor()->associate(
        factory(Enterprise::class)->states('vendor')->create()
    );
});

$factory->state(Resource::class, 'active', [
    'status' => Resource::STATUS_ACTIVE,
]);

$factory->state(Resource::class, 'inactive', [
    'status' => Resource::STATUS_INACTIVE,
]);
