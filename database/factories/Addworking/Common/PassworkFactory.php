<?php

use App\Models\Addworking\Common\Passwork;
use App\Models\Addworking\Enterprise\Enterprise;
use Faker\Generator as Faker;

$factory->define(Passwork::class, function (Faker $faker) {
    return [
        //
    ];
});

$factory->afterMaking(Passwork::class, function ($passwork, $faker) {
    $passwork->passworkable()->associate(
        factory(Enterprise::class)->create(['is_vendor' => true])
    );
});
