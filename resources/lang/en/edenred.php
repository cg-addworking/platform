<?php
return [
    "common" => [
        "average_daily_rate" => [
            "_actions" => [
                "actions" => "Actions",
                "code" => "Code",
                "consult" => "Consult",
                "edit" => "Edit",
                "remove" => "Remove"
            ],
            "_form" => [
                "general_information" => "General information",
                "rate" => "Rate",
                "service_provider" => "Subcontractor"
            ],
            "_html" => ["code" => "Code", "rate" => "Rate", "service_provider" => "Subcontractor"],
            "create" => [
                "average_daily_rate" => "Average Daily Rate (ADR)",
                "codes" => "Codes",
                "create" => "Create",
                "create_average_daily_rate" => "Create an average daily rate",
                "create_average_daily_rate_for" => "Create an average daily rate for ",
                "dashboard" => "Dashboard",
                "return" => "Back"
            ],
            "edit" => [
                "average_daily_rate" => "Average Daily Rate",
                "change_code_rate" => "Change the code rate",
                "codes" => "Codes",
                "dashboard" => "Dashboard",
                "edit" => "Edit",
                "for" => "for",
                "register" => "Save",
                "return" => "Back"
            ],
            "index" => [
                "actions" => "Actions",
                "add" => "Add",
                "average_daily_rate" => "Average Daily Rate (ADR)",
                "average_daily_rates_for" => "Average daily rates for",
                "codes" => "Codes",
                "created_at" => "Created on",
                "dashboard" => "Dashboard",
                "rate" => "Rate",
                "service_provider" => "Subcontractor"
            ],
            "show" => [
                "average_daily_code_rate" => "Code average daily rate",
                "average_daily_rate" => "Average Daily Rate",
                "codes" => "Codes",
                "dashboard" => "Dashboard",
                "for" => "for",
                "return" => "Back"
            ]
        ],
        "code" => [
            "_actions" => [
                "actions" => "Actions",
                "average_daily_rates" => "Average Daily Rates",
                "confirm_delete" => "Sure to delete?",
                "consult" => "See",
                "edit" => "Edit",
                "remove" => "Remove",
                "skill" => "Skill"
            ],
            "_form" => [
                "bussiness_competence" => "Services & Skills",
                "code" => "Code",
                "general_information" => "General information",
                "level" => "Level"
            ],
            "_html" => [
                "competence" => "Skill",
                "last_name" => "Name",
                "level" => "Level",
                "skill" => "Service"
            ],
            "create" => [
                "codes" => "Codes",
                "create" => "Create",
                "create_code" => "Create a code",
                "create_new_code" => "Create a new code",
                "dashboard" => "Dashboard",
                "return" => "Back"
            ],
            "edit" => [
                "codes" => "Codes",
                "dashboard" => "Dashboard",
                "edit" => "Edit",
                "edit_code" => "Edit code",
                "register" => "Save",
                "return" => "Back"
            ],
            "index" => [
                "actions" => "Actions",
                "add" => "Add",
                "code" => "Code",
                "code_catalog" => "Business codes catalog & No of Subcontractors by skills",
                "codes" => "Codes",
                "created_at" => "Created on",
                "dashboard" => "Dashboard",
                "job" => "Service",
                "providers" => " No of Subcontractors",
                "skill" => "Skill"
            ]
        ]
    ],
    "mission" => [
        "offer" => ["create" => ["assignment_purpose" => "Work purpose", "client" => "Client"]],
        "profile" => [
            "create" => [
                "already_sent" => "Already sent",
                "enterprise" => "Company",
                "esn_on_mission_code" => "Digital and Engineering Services Company positioned on this work code"
            ]
        ],
        "proposal_response" => [
            "index" => [
                "actions" => "Actions",
                "created_at" => "Created on",
                "reference_tjm" => "Reference ADR",
                "service_provider" => "Subcontractor",
                "status" => "Status",
                "tjm_proposed" => "Proposed ADR"
            ]
        ]
    ],
    "user" => ["passwork" => ["create" => ["edenred_passwork" => "I am the EDENRED passwork"]]]
];
