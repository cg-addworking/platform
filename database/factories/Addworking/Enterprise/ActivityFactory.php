<?php

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\EnterpriseActivity;
use Faker\Generator as Faker;

$factory->define(EnterpriseActivity::class, function (Faker $faker) {
    return [
        'activity'        => array_random(['Production de pommes de terres', 'Cultivateur de tomates']),
        'field'           => array_random(EnterpriseActivity::getAvailableFields()),
        'employees_count' => $faker->randomDigitNotNull,
    ];
});

$factory->afterMaking(EnterpriseActivity::class, function ($activity, $faker) {
    $activity->enterprise()->associate(
        factory(Enterprise::class)->create()
    );
});
