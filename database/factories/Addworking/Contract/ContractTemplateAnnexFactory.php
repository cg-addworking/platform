<?php

use App\Models\Addworking\Common\File;
use App\Models\Addworking\Contract\ContractTemplate;
use App\Models\Addworking\Contract\ContractTemplateAnnex;
use Faker\Generator as Faker;

$factory->define(ContractTemplateAnnex::class, function (Faker $faker) {
    return [
        //
    ];
});

$factory->afterMaking(ContractTemplateAnnex::class, function ($annex, $faker) {
    $annex->contractTemplate()->associate(
        factory(ContractTemplate::class)->create()
    );

    $annex->file()->associate(
        factory(File::class)->create()
    );
});
