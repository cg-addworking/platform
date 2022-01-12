<?php

use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Enterprise\Enterprise;
use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Contract::class, function (Faker $faker) {
    return [
        'status'                 => array_random(Contract::getAvailableStatuses()),
        'name'                   => str_random(),
        'signinghub_package_id'  => null,
        'signinghub_document_id' => null,
    ];
});

$factory->afterMaking(Contract::class, function ($contract, $faker) {
    $contract->enterprise()->associate(
        factory(Enterprise::class)->create()
    );
});

$factory->state(Contract::class, 'cps1', [
    'type' => "cps1",
]);

$factory->state(Contract::class, 'cps2', [
    'type' => "cps2",
]);

$factory->state(Contract::class, 'cps3', [
    'type' => "cps3",
]);

$factory->state(Contract::class, "draft", [
    'status' => Contract::STATUS_DRAFT,
]);

$factory->state(Contract::class, "ready_to_generate", [
    'status' => Contract::STATUS_READY_TO_GENERATE,
]);

$factory->state(Contract::class, "generating", [
    'status' => Contract::STATUS_GENERATING,
]);

$factory->state(Contract::class, "generated", [
    'status' => Contract::STATUS_GENERATED,
]);

$factory->state(Contract::class, "uploading", [
    'status' => Contract::STATUS_UPLOADING,
]);

$factory->state(Contract::class, "uploaded", [
    'status' => Contract::STATUS_UPLOADED,
]);

$factory->state(Contract::class, "ready_to_sign", [
    'status' => Contract::STATUS_READY_TO_SIGN,
]);

$factory->state(Contract::class, "being_signed", [
    'status' => Contract::STATUS_BEING_SIGNED,
]);

$factory->state(Contract::class, "cancelled", [
    'status' => Contract::STATUS_CANCELLED,
]);

$factory->state(Contract::class, "active", [
    'status' => Contract::STATUS_ACTIVE,
]);

$factory->state(Contract::class, "inactive", [
    'status' => Contract::STATUS_INACTIVE,
]);

$factory->state(Contract::class, "expired", [
    'status' => Contract::STATUS_EXPIRED,
]);

$factory->state(Contract::class, "error", [
    'status' => Contract::STATUS_ERROR,
]);
