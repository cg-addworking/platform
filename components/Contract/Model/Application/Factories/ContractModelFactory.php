<?php

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Contract\Model\Application\Models\ContractModel;
use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(ContractModel::class, function (Faker $faker) {
    return [
        'name'         => str_random(),
        'display_name' => str_random(),
    ];
});
