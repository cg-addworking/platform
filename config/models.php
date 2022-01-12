<?php

return [

    'directories' => [
        'app/Models',
        'components/Billing/Outbound/Application/Models',
        'components/Contract/Model/Application/Models',
        'components/Contract/Contract/Application/Models',
        'components/Enterprise/InvoiceParameter/Application/Models',
        'components/Enterprise/AccountingExpense/Application/Models',
        'components/Enterprise/ActivityReport/Application/Models',
        'components/Enterprise/BusinessTurnover/Application/Models',
        'components/Enterprise/Resource/Application/Models',
        'components/Enterprise/WorkField/Application/Models',
        'components/Sogetrel/Mission/Application/Models',
        'components/Sogetrel/Passwork/Application/Models',
    ],

    'aliases' => [
        'db_file' => "App\Models\Addworking\Common\File",
        'mission_offer' => "App\Models\Addworking\Mission\Offer",
        'mission_proposal' => "App\Models\Addworking\Mission\Proposal",
        'sogetrel_passwork' => "App\Models\Sogetrel\User\Passwork",
        'sogetrel_passwork_quizz' => "App\Models\Sogetrel\User\Quizz",
        'sogetrel_contract_type' => "App\Models\Sogetrel\Contract\Type",
        'edenred_code' => "App\Models\Edenred\Common\Code",
        'edenred_average_daily_rate' => "App\Models\Edenred\Common\AverageDailyRate",
        'spie_enterprise' => "App\Models\Spie\Enterprise\Enterprise",
        'spie_coverage_zone' => "App\Models\Spie\Enterprise\CoverageZone",
        'spie_order' => "App\Models\Spie\Enterprise\Order",
        'spie_qualification' => "App\Models\Spie\Enterprise\Qualification",
        'sogetrel_passwork_acceptation' => "Components\Sogetrel\Passwork\Application\Models\Acceptation",
    ],

];
