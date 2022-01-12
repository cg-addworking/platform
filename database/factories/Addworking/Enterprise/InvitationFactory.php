<?php

use App\Models\Addworking\Enterprise\Invitation;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */

$factory->define(Invitation::class, function (Faker $faker) {
    return [
        'contact'   => $faker->unique()->safeEmail,
        'status'      => $faker->randomElement(Invitation::getAvailableStatuses()),
        'valid_until' => Carbon::now()->addWeek(),
        'type' => Invitation::TYPE_MEMBER,
    ];
});
