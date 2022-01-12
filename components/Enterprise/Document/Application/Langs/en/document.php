<?php
return [
    "document_type_reject_reason" => [
        "_actions" => ["delete" => "Delete", "edit" => "Modify"],
        "_breadcrumb" => [
            "create" => "Create",
            "dashboard" => "Dashboard",
            "document_type_management" => "Manage document types",
            "edit" => "Modify",
            "index" => "Reason for rejection",
            "number" => "Reason No. :number"
        ],
        "_form" => [
            "display_name" => "Name",
            "general_information" => "General information",
            "is_universal" => "Check this box if this reason for rejection is common to all document types",
            "message" => "Message"
        ],
        "_table_head" => [
            "actions" => "Actions",
            "display_name" => "Name",
            "is_universal" => "Shared?",
            "message" => "Message",
            "number" => "Number"
        ],
        "create" => [
            "create" => "Create",
            "return" => "Back",
            "title" => " Create a reason for rejection"
        ],
        "edit" => ["edit" => "Modify", "return" => "Back", "title" => "Modify a reason for rejection"],
        "index" => [
            "create" => "Create",
            "return" => "Back",
            "title" => "List of reasons for rejection"
        ]
    ]
];
