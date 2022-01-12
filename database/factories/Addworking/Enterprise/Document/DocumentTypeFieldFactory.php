<?php

use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\DocumentTypeField;
use Faker\Generator as Faker;

$factory->define(DocumentTypeField::class, function (Faker $faker) {
    $name = $faker->sentence;

    return [
        'name' => $name,
        'display_name' => $name,
    ];
});

$factory->afterMaking(DocumentTypeField::class, function ($doc, $faker) {
    $doc->documentType()->associate(
        factory(DocumentType::class)->create()
    );
});
