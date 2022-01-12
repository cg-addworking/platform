<?php

use App\Models\Addworking\Mission\MissionTrackingLine;
use Components\Sogetrel\Mission\Application\Models\MissionTrackingLineAttachment;
use Faker\Generator as Faker;

$factory->define(MissionTrackingLineAttachment::class, function (Faker $faker) {
    return [
        'num_order' => $faker->randomNumber,
        'num_attachment' => $faker->randomNumber,
        'num_site' => $faker->randomNumber,
        'signed_at' => $faker->dateTimeThisMonth,
        'reverse_charges' => $faker->boolean,
        'direct_billing' => $faker->boolean,
    ];
});

$factory->afterMaking(MissionTrackingLineAttachment::class, function ($attachment, $faker) {
    $attachment->missionTrackingLine()->associate(
        factory(MissionTrackingLine::class)->create()
    );
});
