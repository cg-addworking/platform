<?php

use App\Models\Addworking\Contract\ContractTemplate;
use App\Models\Addworking\Enterprise\Enterprise;
use Faker\Generator as Faker;

$factory->define(ContractTemplate::class, function (Faker $faker) {
    return [
        'number'       => $faker->randomNumber(),
        'name'         => str_random(),
        'display_name' => str_random(),
    ];
});

$factory->afterMaking(ContractTemplate::class, function ($template, $faker) {
    $template->enterprise()->associate(
        factory(Enterprise::class)->create(['is_customer' => true])
    );
});
