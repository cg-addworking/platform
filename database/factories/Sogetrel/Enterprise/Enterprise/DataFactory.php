<?php

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Sogetrel\Enterprise\Data;
use Faker\Generator as Faker;

$factory->define(Data::class, function (Faker $faker) {
    $marche_groups     = Data::getAvailableComptaMarcheGroups();
    $marche_tva_groups = Data::getAvailableComptaMarcheTvaGroups();
    $produit_groups    = Data::getAvailableComptaProduitGroups();

    return [
        'navibat_id'              => "ADW-" . $faker->randomNumber,
        'compta_marche_group'     => $faker->randomElement($marche_groups),
        'compta_marche_tva_group' => $faker->randomElement($marche_tva_groups),
        'compta_produit_group'    => $faker->randomElement($produit_groups),
        'navibat_sent'            => $faker->boolean,
    ];
});

$factory->afterMaking(Data::class, function ($data, $faker) {
    $data->enterprise()->associate(
        factory(Enterprise::class)->create(['is_vendor' => true])
    );
});
