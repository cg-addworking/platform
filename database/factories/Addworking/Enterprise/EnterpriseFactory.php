<?php

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use Faker\Generator as Faker;

$factory->define(Enterprise::class, function (Faker $faker) {
    return [
        'name'                      => uniqid('fake_', false) . $faker->company,
        'identification_number'     => random_numeric_string(14),
        'registration_town'         => $faker->city,
        'tax_identification_number' => 'FR' . random_numeric_string(11),
        'vat_rate'                  => array_random([0, .1, .2]),
        'main_activity_code'        => random_numeric_string(4) . 'X',
        'external_id'               => random_numeric_string(5),
        'country'                   => array_random(['fr', 'de', 'be']),
    ];
});

$factory->afterCreating(Enterprise::class, function ($enterprise, $faker) {
    $enterprise->users()->attach(
        factory(User::class)->create(),
        [
            'job_title'               => "Administrateur",
            'primary'                 => true,
            'current'                 => true,
            'is_signatory'            => true,
            'is_legal_representative' => true,
            'is_admin'                => true,
        ]
    );

    $enterprise->addresses()->attach(
        factory(Address::class)->create()
    );

    $enterprise->phoneNumbers()->attach(
        factory(PhoneNumber::class)->create()
    );
});

$factory->state(Enterprise::class, 'customer', [
    'is_customer' => true,
]);

$factory->state(Enterprise::class, 'vendor', [
    'is_vendor' => true,
]);

$factory->state(Enterprise::class, 'addworking', [
    'name'        => "ADDWORKING",
    'is_customer' => false,
    'is_vendor'   => false,
]);

$factory->state(Enterprise::class, 'sas', [
    'legal_form' => "sas"
]);

$factory->state(Enterprise::class, 'sasu', [
    'legal_form' => "sasu"
]);

$factory->state(Enterprise::class, 'sa', [
    'legal_form' => "sa"
]);

$factory->state(Enterprise::class, 'sarl', [
    'legal_form' => "sarl"
]);

$factory->state(Enterprise::class, 'eurl', [
    'legal_form' => "eurl"
]);

$factory->state(Enterprise::class, 'eirl', [
    'legal_form' => "eirl"
]);

$factory->state(Enterprise::class, 'ei', [
    'legal_form' => "ei"
]);

$factory->state(Enterprise::class, 'micro', [
    'legal_form' => "micro"
]);

$factory->state(Enterprise::class, 'fr', [
    'country' => "fr"
]);

$factory->state(Enterprise::class, 'de', [
    'country' => "de"
]);

$factory->state(Enterprise::class, 'be', [
    'country' => "be"
]);
