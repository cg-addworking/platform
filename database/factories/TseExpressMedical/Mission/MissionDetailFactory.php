<?php

use App\Models\Addworking\Mission\Mission;
use App\Models\TseExpressMedical\Mission\MissionDetail;
use Faker\Generator as Faker;

$factory->define(MissionDetail::class, function (Faker $faker) {
    return [
        'gasoil_tax' => 0,
        'equipment_rental' => 0,
    ];
});

$factory->afterMaking(MissionDetail::class, function ($detail, $faker) {
    $detail->mission()->associate(
        factory(Mission::class)->create()
    );
});
