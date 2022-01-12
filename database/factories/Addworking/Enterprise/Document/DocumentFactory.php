<?php

use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\Enterprise;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Document::class, function (Faker $faker) {
    return [
        'valid_from' => Carbon::now(),
        'valid_until' => Carbon::now(),
    ];
});

$factory->afterMaking(Document::class, function (Document $doc, $faker) {
    $doc->documentType()->associate(
        factory(DocumentType::class)->create()
    );

    $doc->enterprise()->associate(
        factory(Enterprise::class)->create()
    );
});

$factory->afterCreating(Document::class, function (Document $doc, $faker) {
    $doc->files()->attach(
        factory(File::class)->create()
    );
});

$factory->state(Document::class, 'pending', [
    'status' => "pending"
]);

$factory->state(Document::class, 'validated', [
    'status' => "validated"
]);

$factory->state(Document::class, 'rejected', [
    'status' => "rejected"
]);

$factory->state(Document::class, 'outdated', [
    'status' => "outdated"
]);
