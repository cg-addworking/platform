<?php

use App\Models\Addworking\Contract\ContractDocument;
use App\Models\Addworking\Contract\ContractParty;
use App\Models\Addworking\Enterprise\Document;
use Faker\Generator as Faker;

$factory->define(ContractDocument::class, function (Faker $faker) {
    return [
        //
    ];
});

$factory->afterMaking(ContractDocument::class, function ($doc, $faker) {
    $doc->contractParty()->associate(
        factory(ContractParty::class)->create()
    );

    $doc->document()->associate(
        factory(Document::class)->create()
    );
});
