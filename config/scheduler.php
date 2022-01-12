<?php

return [
    'notifying-for-non-compliance' => env('SCHEDULER_1_ENABLED', true),
    'requesting_activity_reports_for_sogetrel' => env('SCHEDULER_2_ENABLED', true),
    'sending_activity_reports_to_support' => env('SCHEDULER_3_ENABLED', true),
    'sending_vendor_document_to_sogetrel_ftp' => env('SCHEDULER_4_ENABLED', true),
    'sending_vendor_informations_to_sogetrel_navibat' => env('SCHEDULER_5_ENABLED', true),
    'set_contract_state' => env('SCHEDULER_6_ENABLED', true),
    'create_sogetrel_attachments_from_airtable' => env('SCHEDULER_7_ENABLED', true),
    'send_contract_email_followup' => env('SCHEDULER_8_ENABLED', true),
    'check_contract_expiry' => env('SCHEDULER_9_ENABLED', true),
    'unfinished_onboarding_reminder' => env('SCHEDULER_10_ENABLED', true),
    'create_milestone_mission' => env('SCHEDULER_11_ENABLED', true),
    'extract_data_from_attachment_file' => env('SCHEDULER_12_ENABLED', true),
    'notify-document-expiration' => env('SCHEDULER_13_ENABLED', true),
    'sync-aws-with-scaleway' => env('SCHEDULER_14_ENABLED', true),
];
