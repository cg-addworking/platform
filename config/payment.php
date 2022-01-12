<?php

return [

    'method'        => env('PAYMENT_METHOD', 'TRF'),
    'type_code'     => env('PAYMENT_TYPE_CODE', 'SEPA'),
    'grouping'      => env('PAYMENT_GROUPING', 'MIXD'),
    'debtor_name'   => env('PAYMENT_DEBTOR_NAME'),
    'debtor_iban'   => env('PAYMENT_DEBTOR_IBAN'),
    'debtor_bic'    => env('PAYMENT_DEBTOR_BIC'),
];
