<?php

use App\Models\Addworking\Common\CsvLoaderReport;
use Faker\Generator as Faker;

$factory->define(CsvLoaderReport::class, function (Faker $faker) {
    return [
        'label' => $faker->sentence,
        'data' => "",
        'line_count' => 0,
        'error_count' => 0,
    ];
});
