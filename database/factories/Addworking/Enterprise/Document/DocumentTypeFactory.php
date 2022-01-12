<?php

use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\LegalForm;
use Faker\Generator as Faker;

$factory->define(DocumentType::class, function (Faker $faker) {
    $name = $faker->sentence;

    return [
        'name' => str_slug($name),
        'display_name' => $name,
    ];
});

$factory->afterMaking(DocumentType::class, function ($type, $faker) {
    $type->enterprise()->associate(
        factory(Enterprise::class)->create(['is_customer' => true])
    );
});

$factory->state(DocumentType::class, 'legal', [
    'type' => DocumentType::TYPE_LEGAL,
]);

$factory->state(DocumentType::class, 'business', [
    'type' => DocumentType::TYPE_BUSINESS,
]);

$factory->state(DocumentType::class, 'informative', [
    'type' => DocumentType::TYPE_INFORMATIVE,
]);

$factory->state(DocumentType::class, 'is_mandatory', [
    'is_mandatory' => true,
]);
