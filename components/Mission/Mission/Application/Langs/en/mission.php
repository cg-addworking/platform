<?php
return [
    "_actions" => [
        "create_contract" => "Create a new contract",
        "delete" => "Supprimer",
        "edit" => "Modify",
        "link_contract" => "Link an existing contract"
    ],
    "_breadcrumb" => [
        "create" => "Create",
        "dashboard" => "Dashboard",
        "edit" => "Modify",
        "index" => "Work orders",
        "workfields" => "Sites"
    ],
    "_status" => [
        "abandoned" => "Canceled",
        "closed" => "Closed",
        "done" => "Completed",
        "draft" => "Draft",
        "in_progress" => "Pending",
        "ready_to_start" => "OK To Start"
    ],
    "construction" => [
        "_form" => [
            "amount" => "Amount",
            "analytic_code" => "Analytical code",
            "cost_estimation" => ["amount_before_taxes" => "Price ex. tax", "file" => "File", "title" => "Quotation"],
            "departments" => "Location(s)",
            "description" => "Description of work granted",
            "ends_at" => "End date",
            "enterprises" => "Customer in question",
            "external_id" => "Work order code",
            "files" => "File(s)",
            "general_information" => "Details",
            "label" => "Subject of work order",
            "referents" => "Contact",
            "starts_at" => "Start date",
            "vendors" => "Subcontractor in question",
            "workfield" => "Site"
        ],
        "_html" => [
            "amount" => "Work order amount",
            "analytical_code" => "Analytical code",
            "cost_estimation" => ["amount_before_taxes" => "Quotation amount"],
            "customer" => "Relevant company",
            "departments" => "Départements",
            "description" => "Description",
            "end_date" => "End date",
            "external_id" => "Identifier",
            "location" => "Département(s) where work located",
            "referent" => "Contact",
            "start_date" => "Start date",
            "status" => "Status",
            "tabs" => [
                "additional_documents" => "Additional documents",
                "cost_estimation_document" => "Quotation documents"
            ],
            "vendor" => "Assigned subcontractor",
            "workfield" => "Site"
        ]
    ],
    "create" => [
        "mission_vendor_id_required" => "The field \"subcontractor in question\" is mandatory",
        "no_selection" => "Nothing selected",
        "return" => "Back",
        "save_as_draft" => "Save as draft",
        "submit" => "Create",
        "title" => "New work order"
    ],
    "edit" => ["return" => "Back", "submit" => "Modify", "title" => "Modify work order"],
    "show" => [
        "contractualize" => "Contractualize work order",
        "create_contract" => "Create a Contract",
        "link_contract" => "Link to an existing contract",
        "return" => "Back",
        "submit_signed_contract" => "Submit a contract already signed"
    ]
];
