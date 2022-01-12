<?php

use App\Models\Addworking\Contract\ContractTemplateParty;
use App\Models\Addworking\Contract\ContractTemplatePartyDocumentType;
use App\Models\Addworking\Enterprise\DocumentType;
use Faker\Generator as Faker;

$factory->define(ContractTemplatePartyDocumentType::class, function (Faker $faker) {
    return [
        //
    ];
});

$factory->afterMaking(ContractTemplatePartyDocumentType::class, function ($type, $faker) {
    $type->contractTemplateParty()->associate(
        factory(ContractTemplateParty::class)->create()
    );

    $type->documentType()->associate(
        factory(DocumentType::class)->create()
    );
});
