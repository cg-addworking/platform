<?php

use App\Models\Addworking\Contract\ContractParty;
use App\Models\Addworking\Contract\ContractPartyDocumentType;
use App\Models\Addworking\Enterprise\DocumentType;
use Faker\Generator as Faker;

$factory->define(ContractPartyDocumentType::class, function (Faker $faker) {
    return [
        //
    ];
});

$factory->afterMaking(ContractPartyDocumentType::class, function ($type, $faker) {
    $type->contractParty()->associate(
        factory(ContractParty::class)->create()
    );

    $type->documentType()->associate(
        factory(DocumentType::class)->create()
    );
});
