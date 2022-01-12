<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Site;
use Faker\Generator as Faker;

$factory->define(Site::class, function (Faker $faker) {
    return [
        'display_name'  => $faker->company,
        'name'          => $faker->company,
        'analytic_code' => random_numeric_string(5),
    ];
});

$factory->afterMaking(Site::class, function ($site, $faker) {
    $site->enterprise()->associate(
        factory(Enterprise::class)->create()
    );
});
