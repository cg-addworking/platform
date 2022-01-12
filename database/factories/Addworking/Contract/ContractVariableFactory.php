<?php

use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Contract\ContractTemplateVariable;
use App\Models\Addworking\Contract\ContractVariable;
use Faker\Generator as Faker;

$factory->define(ContractVariable::class, function (Faker $faker) {
    return [
        'value' =>"",
    ];
});

$factory->afterMaking(ContractVariable::class, function ($variable, $faker) {
    $variable->contract()->associate(
        factory(Contract::class)->create()
    );

    $variable->contractTemplateVariable()->associate(
        factory(ContractTemplateVariable::class)->create()
    );
});
