<?php

use App\Models\Addworking\Enterprise\LegalForm;
use Faker\Generator as Faker;

$factory->define(LegalForm::class, function (Faker $faker) {

    $legalForms = [
        "sas"   => "SAS",
        "sasu"  => "SASU",
        "sa"    => "SA",
        "sarl"  => "SARL",
        "sarlu" => "SARLU",
        "eurl"  => "EURL",
        "eirl"  => "EIRL",
        "ei"    => "EI",
        "micro" => "Micro",
    ];

    $form = $faker->randomElement($legalForms);

    return [
        'name'         => $form,
        'display_name' => strtoupper($form),
        'country'      => "fr",
    ];
});
