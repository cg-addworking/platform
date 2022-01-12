<?php

return [
    'google_application_credentials' =>
        env(
            'GOOGLE_APPLICATION_CREDENTIALS',
            base_path(DIRECTORY_SEPARATOR.'vault'.DIRECTORY_SEPARATOR.'vision-addworking-key.json')
        ),
        'document_type_urssaf_enabled' => env('OCR_DOCUMENT_TYPE_URSSAF_ENABLED', false),
];
