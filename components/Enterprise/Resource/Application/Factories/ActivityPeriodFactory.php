<?php

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\Resource\Application\Models\ActivityPeriod;
use Components\Enterprise\Resource\Application\Models\Resource;
use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(ActivityPeriod::class, function (Faker $faker) {
    return [
    ];
});

$factory->afterMaking(ActivityPeriod::class, function ($period, $faker) {
    $period->customer()->associate(
        factory(Enterprise::class)->state('customer')->create()
    );

    $period->resource()->associate(
        factory(Resource::class)->create()
    );
});
