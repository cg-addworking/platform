<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Spie\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Enterprise as AddworkingEnterprise;
use Faker\Generator as Faker;

$factory->define(Enterprise::class, function (Faker $faker) {
    return [
        'code' => random_numeric_string(9),
        'index' => $faker->randomElement([null, '1', 'Z']),
        'active' => $faker->boolean,
        'rank' => $faker->randomDigit,
        'year' => $faker->year,
        'gross_income' => $faker->randomFloat,
        'topology' => $faker->randomLetter . $faker->randomDigit,
        'al' => $faker->boolean,
        'last_coface_enquiry' => $faker->date,
        'last_coface_grade' => $faker->randomFloat,
        'previous_coface_enquiry' => $faker->date,
        'previous_coface_grade' => $faker->randomFloat,
        'nuclear_qualification' => $faker->boolean,
        'addressable_volume_large_order' => $faker->boolean,
        'addressable_volume_average_order' => $faker->boolean,
        'adressable_volume_small_order' => $faker->boolean,
    ];
});

$factory->afterMaking(Enterprise::class, function ($enterprise, $faker) {
    $enterprise->enterprise()->associate(
        factory(AddworkingEnterprise::class)->state('vendor')->create()
    );
});
