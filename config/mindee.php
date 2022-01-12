<?php

return [
    'endpoints' => [
        'node_extrait_kbis_api' =>
            env('MINDEE_ENPOINT_NODE_EXTRAIT_KBIS_API', 'https://api.addworking.com/v1/documents/ocr/kbis'),
    ],
    'api_keys' => [
        'urssaf_societe' => env('MINDEE_URSSAF_SOCIETE_API_KEY', 'b39daf3a4293b82bbde47b84c1e95f48'),
        'urssaf_micro' => env('MINDEE_URSSAF_MICRO_API_KEY', '3920b04402ac915f146c2abdf1270601'),
        'kbis_societe' => env('MINDEE_KBIS_SOCIETE_API_KEY', '7ac1eabd6e6a9f7b18ea04c3a5e1baef'),
        'extrait_kbis' => env('MINDEE_EXTRAIT_KBIS_API_KEY', '522a660118f3fae04dd3b8938cc07209'),
        'regularisation_fiscale_micro' =>
            env('MINDEE_REGULARISATION_FISCAl_MICRO_API_KEY', 'dc97e3fa38570bea7f93b45f03430a66'),
        'classification_extrait_kbis_or_extrait_d1' =>
            env('MINDEE_CLASSIFICATION_EXTRAIT_KBIS_OR_EXTRAIT_D1', '046ee8ca218f69c3633a9fdc9d47571a'),
    ]
];
