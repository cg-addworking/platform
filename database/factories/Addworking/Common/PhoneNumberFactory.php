<?php

use App\Models\Addworking\Common\PhoneNumber;
use Faker\Generator as Faker;

$factory->define(PhoneNumber::class, function (Faker $faker) {
    return [
        'number' => random_french_phone_number(
            $faker->boolean(.5),
            $faker->boolean(.5)
        ),
    ];
});

$factory->state(PhoneNumber::class, 'landline', [
    'number' => random_french_phone_number(false),
]);

$factory->state(PhoneNumber::class, 'mobile', [
    'number' => random_french_phone_number(true),
]);

$factory->state(PhoneNumber::class, 'landline_e164', [
    'number' => random_french_phone_number(false, true),
]);

$factory->state(PhoneNumber::class, 'mobile_e164', [
    'number' => random_french_phone_number(true, true),
]);
