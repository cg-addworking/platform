<?php

return [
    'allowed' => [
        'proposal_response' => 'App\Models\Addworking\Mission\ProposalResponse',
        'user'              => 'App\Models\Addworking\User\User',
        'passwork'          => 'App\Models\Sogetrel\User\Passwork',
        'mission_tracking'  => 'App\Models\Addworking\Mission\MissionTracking',
        'document'          => 'App\Models\Addworking\Enterprise\Document',
        'proposal'          => 'App\Models\Addworking\Mission\Proposal',
        'inbound_invoice'   => 'App\Models\Addworking\Billing\InboundInvoice',
        'contract'          => 'Components\Contract\Contract\Application\Models\Contract',
        'response'          => 'Components\Mission\Offer\Application\Models\Response',
    ],

    'notified' => [
        'contract',
    ]
];
