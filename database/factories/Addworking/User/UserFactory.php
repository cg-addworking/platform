<?php

use App\Models\Addworking\User\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

$factory->define(User::class, function (Faker $faker) {
    return [
        'gender'         => $gender = array_random(['male', 'female']),
        'firstname'      => $faker->{'firstName'.ucfirst($gender)},
        'lastname'       => $faker->lastName,
        'email'          => $faker->unique()->safeEmail,
        'password'       => Hash::make('password'),
        'remember_token' => str_random(10),
    ];
});

$factory->state(User::class, 'male', [
    'gender' => "male"
]);

$factory->state(User::class, 'female', [
    'gender' => "female"
]);

$factory->state(User::class, 'support', [
    'is_system_superadmin'  => true,
    'is_system_admin'       => true,
    'is_system_operator'    => true,
]);

$factory->state(User::class, 'non-support', [
    'is_system_superadmin'  => false,
    'is_system_admin'       => false,
    'is_system_operator'    => false,
]);
