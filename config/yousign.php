<?php

return [
    'environment' => env('YOUSIGN_ENVIRONMENT', 'staging'),
    'api_key' => env('YOUSIGN_API_KEY', '5fa5decf791c1da90ed90d145aaafac6'),
    'test_email' => env('YOUSIGN_TEST_EMAIL_ROOT'),
    'test_phone_number' => env('YOUSIGN_TEST_PHONE_NUMBER'),
    'contract_enabled' => env('YOUSIGN_CONTRACT_ENABLED', false),
    'initials_enabled' => env('YOUSIGN_INITIALS_ENABLED', false),
    'ui_interface' => [
        'app' => env('YOUSIGN_UI_INTERFACE_APP', '/signature_uis/409c6242-c3ce-4481-b950-2a6d04e08928'),
        'app_de' => env('YOUSIGN_UI_INTERFACE_APP_DE', '/signature_uis/a2506e8a-b516-4eeb-8456-c2256ff8888f'),
    ],
    'document_enabled' => env('YOUSIGN_DOCUMENT_ENABLED', false)
];
