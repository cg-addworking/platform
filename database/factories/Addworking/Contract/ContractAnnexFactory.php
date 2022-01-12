<?php

use App\Models\Addworking\Common\File;
use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Contract\ContractAnnex;
use Faker\Generator as Faker;

$factory->define(ContractAnnex::class, function (Faker $faker) {
    return [
        //
    ];
});

$factory->afterMaking(ContractAnnex::class, function ($annex, $faker) {
    $annex->contract()->associate(
        factory(Contract::class)->create()
    );

    $annex->file()->associate(
        factory(File::class)->create()
    );
});
