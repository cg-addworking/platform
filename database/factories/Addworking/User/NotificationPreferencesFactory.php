<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Addworking\User\NotificationPreferences;
use App\Models\Addworking\User\User;
use Faker\Generator as Faker;

$factory->define(NotificationPreferences::class, function (Faker $faker) {
    return [
        'email_enabled' => true,
        'confirmation_vendors_are_paid' => true,
        'iban_validation' => true
    ];
});

$factory->afterMaking(NotificationPreferences::class, function ($notification, $faker) {
    $notification->user()->associate(
        factory(User::class)->create()
    );
});
