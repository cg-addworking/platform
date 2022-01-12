<?php
return [
    "_actions" => ["delete" => "Delete", "edit" => "Modify", "show" => "View"],
    "_breadcrumb" => [
        "create" => "Create",
        "dashboard" => "Dashboard",
        "edit" => "Modify",
        "index" => "Work order offers",
        "offer" => ":label",
        "send_to_enterprise" => "Publish offer",
        "workfields" => "Sites"
    ],
    "_filters" => [
        "customer" => "Customer",
        "referent" => "Contact",
        "reset" => "Reset",
        "status" => "Status",
        "submit" => "Filter"
    ],
    "_status" => [
        "abandoned" => "Canceled",
        "closed" => "Closed",
        "communicated" => "Published",
        "draft" => "Draft",
        "to_provide" => "To be supplied"
    ],
    "_table_head" => [
        "actions" => "Actions",
        "created_at" => "Creation date",
        "customer" => "Customer",
        "label" => "Subject of offer",
        "referent" => "Contact",
        "status" => "Status"
    ],
    "construction" => [
        "_form" => [
            "analytic_code" => "Analytical code",
            "asked_skills" => "Required skills",
            "departments" => "Location",
            "description" => "Description of work granted",
            "ends_at" => "End date",
            "enterprises" => "Relevant company",
            "external_id" => "Offer code",
            "file" => "File:",
            "files" => "File(s)",
            "general_information" => "Details",
            "label" => "Subject of offer",
            "referents" => "Contact (who will receive responses)",
            "response_deadline" => "Deadline for responses",
            "starts_at_desired" => "Required start date",
            "workfield" => "Site"
        ],
        "_html" => [
            "analytical_code" => "Analytical code",
            "customer" => "Relevant company",
            "departments" => "Departments",
            "description" => "Description of work granted",
            "end_date" => "End date",
            "external_id" => "Identifier",
            "have_response" => "Responded",
            "location" => "Department(s) where work located",
            "no_recipients" => "No recipient",
            "referent" => "Contact",
            "response_deadline" => "Deadline for responses",
            "sended_at" => "Published on: ",
            "skills" => "Required skills",
            "start_date" => "Required start date",
            "status" => "Status",
            "tabs" => [
                "additional_documents" => "Additional documents",
                "info" => "General information",
                "recipients" => "Recipients"
            ],
            "waiting_response" => "Awaiting response",
            "workfield" => "Site"
        ]
    ],
    "create" => [
        "return" => "Back",
        "save_as_draft" => "Save as draft",
        "submit" => "Create",
        "title" => "New work order offer"
    ],
    "edit" => ["return" => "Back", "submit" => "Modify", "title" => "Modify"],
    "index" => [
        "return" => "Back",
        "search" => [
            "customer_name" => "Company",
            "label" => "Subject of offer",
            "referent_lastname" => "Contact (name)"
        ],
        "title" => "Work order offers"
    ],
    "send_to_enterprise" => [
        "edit_response_deadline" => "The deadline for responses has expired - please create a new one.",
        "email" => [
            "access_proposal" => "Access proposal",
            "client" => "Customer",
            "description" => "Description",
            "details" => "Details of work order offer",
            "end_of_mission" => "End of work order",
            "hello" => "Hello",
            "location" => "Location",
            "purpose" => "Subject of work order offer",
            "start_of_mission" => "Start of work order",
            "text_line2" => "We would like to inform you that you have received a new work order proposal from the company",
            "text_line3" => "You can view the details in your AddWorking account."
        ],
        "record" => "Save",
        "reset" => "Reset",
        "response_deadline" => "Deadline for responses",
        "return" => "Back",
        "search" => "Search",
        "sended" => "Already sent",
        "skill" => "Skill",
        "skills" => "Skill(s)",
        "submit" => "Publish",
        "title" => "Publish offer: ",
        "vendor" => "Subcontractor",
        "vendor_skills_no_ok_msg" => "This subcontractor has none of the skills required in the work order offer",
        "vendor_skills_ok_msg" => "This subcontractor has at least one of the skills required in the work order offer"
    ],
    "show" => [
        "close_offer" => "Close offer",
        "confirm_closing_offer" => "Close this work order offer?",
        "no_possible_response" => "You may no longer respond to this offer. Either the response offer is closed or the deadline for responses has expired.",
        "respond" => "Respond to offer",
        "responses" => "See the responses",
        "return" => "Back",
        "send_to_enterprise" => "Publish offer"
    ]
];
