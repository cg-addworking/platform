<?php

use App\Models\Addworking\Mission\Proposal;
use App\Models\Addworking\Mission\ProposalResponse;
use App\Models\Addworking\User\User;
use Faker\Generator as Faker;

$factory->define(ProposalResponse::class, function (Faker $faker) {
    return [
        'status'       => $faker->randomElement(ProposalResponse::getAvailableStatuses()),
        'starts_at'    => $faker->dateTime,
        'ends_at'      => $faker->dateTime,
        'quantity'     => $faker->randomFloat,
        'valid_from'   => null,
        'valid_until'  => null,
        'accepted_at'  => null,
        'refused_at'   => null,
        'unit'         => null,
        'unit_price'   => null,
    ];
});

$factory->afterMaking(ProposalResponse::class, function ($response, $faker) {
    $response->proposal()->associate(
        factory(Proposal::class)->create()
    );

    $response->createdBy()->associate(
        factory(User::class)->create()
    );
});

$factory->state(ProposalResponse::class, 'pending', [
    'status' => ProposalResponse::STATUS_PENDING,
]);

$factory->state(ProposalResponse::class, 'ok_to_meet', [
    'status' => ProposalResponse::STATUS_OK_TO_MEET,
]);

$factory->state(ProposalResponse::class, 'interview_requested', [
    'status' => ProposalResponse::STATUS_INTERVIEW_REQUESTED,
]);

$factory->state(ProposalResponse::class, 'interview_positive', [
    'status' => ProposalResponse::STATUS_INTERVIEW_POSITIVE,
]);

$factory->state(ProposalResponse::class, 'final_validation', [
    'status' => ProposalResponse::STATUS_FINAL_VALIDATION,
]);

$factory->state(ProposalResponse::class, 'refused', [
    'status' => ProposalResponse::STATUS_REFUSED,
]);

$factory->state(ProposalResponse::class, 'rejected_for_answer_not_ok', [
    'reason_for_rejection' => ProposalResponse::REJECTED_FOR_ANSWER_NOT_OK,
]);

$factory->state(ProposalResponse::class, 'rejected_for_quantity_not_ok', [
    'reason_for_rejection' => ProposalResponse::REJECTED_FOR_QUANTITY_NOT_OK,
]);

$factory->state(ProposalResponse::class, 'rejected_for_unit_price_not_ok', [
    'reason_for_rejection' => ProposalResponse::REJECTED_FOR_UNIT_PRICE_NOT_OK,
]);

$factory->state(ProposalResponse::class, 'rejected_for_ends_at_not_ok', [
    'reason_for_rejection' => ProposalResponse::REJECTED_FOR_ENDS_AT_NOT_OK,
]);

$factory->state(ProposalResponse::class, 'rejected_for_starts_at_not_ok', [
    'reason_for_rejection' => ProposalResponse::REJECTED_FOR_STARTS_AT_NOT_OK,
]);

$factory->state(ProposalResponse::class, 'rejected_for_other', [
    'reason_for_rejection' => ProposalResponse::REJECTED_FOR_OTHER,
]);
