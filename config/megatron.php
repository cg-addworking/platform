<?php

use Components\Infrastructure\Megatron\Domain\Transformers\AddressTransformer;
use Components\Infrastructure\Megatron\Domain\Transformers\ContractTransformer;
use Components\Infrastructure\Megatron\Domain\Transformers\EnterpriseTransformer;
use Components\Infrastructure\Megatron\Domain\Transformers\FileTransformer;
use Components\Infrastructure\Megatron\Domain\Transformers\MissionProposalTransformer;
use Components\Infrastructure\Megatron\Domain\Transformers\OutboundInvoiceCommentTransformer;
use Components\Infrastructure\Megatron\Domain\Transformers\OutboundInvoiceItemTransformer;
use Components\Infrastructure\Megatron\Domain\Transformers\PhoneNumbersTransformer;
use Components\Infrastructure\Megatron\Domain\Transformers\SogetrelUserPassworksTransformer;
use Components\Infrastructure\Megatron\Domain\Transformers\UserTransformer;

return [

    /*
    |--------------------------------------------------------------------------
    | Protected databases
    |--------------------------------------------------------------------------
    |
    | Here you may provide the the name of databases you want to protect. It
    | can be either a connection name in config/database.php like 'postgres'
    | or an environment variable name like 'DATABASE_URL'. The --force option
    | of the megatron:run command overrides this configuration.
    |
    */

    'protected' => [
        'MATTHIEU_URL',
        'HEROKU_POSTGRESQL_CYAN_URL',
        'DATABASE_URL',
        'pgsql',
    ],

    /*
    |--------------------------------------------------------------------------
    | Transformers
    |--------------------------------------------------------------------------
    |
    | Here you may provide the the transformers to be run. The keys are
    | the tablenames and the value the transformer class. Only tables
    | listed here will be processed during the run process, other tables
    | will be gracefully ignored. See Megatron\Run and Megatron\Transform
    | commands for more details.
    |
    */

    'transformers' => [
        'addworking_user_users' => UserTransformer::class,
        'sogetrel_user_passworks' => SogetrelUserPassworksTransformer::class,
        'addworking_common_phone_numbers' => PhoneNumbersTransformer::class,
        'addworking_billing_outbound_invoice_items' => OutboundInvoiceItemTransformer::class,
        'addworking_billing_outbound_invoice_comments' => OutboundInvoiceCommentTransformer::class,
        'addworking_mission_proposals' => MissionProposalTransformer::class,
        'addworking_common_files' => FileTransformer::class,
        'addworking_enterprise_enterprises' => EnterpriseTransformer::class,
        'addworking_contract_contracts' => ContractTransformer::class,
        'addworking_common_addresses' => AddressTransformer::class
    ],

    /*
    |--------------------------------------------------------------------------
    | Tables to truncate
    |--------------------------------------------------------------------------
    |
    | Here you may provide the the name of the tables you want to truncate
    | during the run process. Typically, those are tables whose tuples
    | (entries) are not necessary or useful for storage like logs or
    | history. See Megatron\Run command for more details.
    |
    */

    'truncate' => [
        'revisions',
        'addworking_user_logs'
    ],

    /*
    |--------------------------------------------------------------------------
    | Table attributes to discard the transform process
    |--------------------------------------------------------------------------
    |
    | Here you may provide the fields (attributes) you want to ignore
    | during the transform process. Those fields WILL NOT be part of the
    | select query. The keys are the tables and the values are an array
    | of the attribute to ignore. All other attributes present on the table
    | will be read. See Megatron\Transform command for more details.
    |
    */

    'exclude' => [
        'addworking_common_files' => [
            'content',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Datalake disk and filename
    |--------------------------------------------------------------------------
    |
    | Here you may provide the disk on which the SQL dumps are dropped (See
    | config/filesystems.php for a list of available disks). You may also
    | provide a custom filename for the generated dumps: %date% is replace
    | to the current date YYYY-MM-DD and %env% by the environment you're
    | running the command from. In all cases, Megatron will create a
    | latest.sql file at the root of the disk when run.
    |
    */

    'datalake' => [
        'disk' => env('MEGATRON_DISK', 'datalake'),
        'filename' => env('MEGATRON_FILENAME', '%date%_%env%_dump.sql'),
    ],
];
