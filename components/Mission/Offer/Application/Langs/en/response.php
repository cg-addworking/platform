<?php
return [
    "_actions" => ["show" => "View"],
    "_breadcrumb" => [
        "create" => "Create",
        "dashboard" => "Dashboard",
        "index" => "Responses",
        "index_offer" => "Work order offer",
        "offer" => ":label",
        "show" => "Response"
    ],
    "_close_offer_modal" => [
        "accept" => "Accept",
        "accept_close_offer" => "Accept and close offer",
        "close_offer" => "Close offer",
        "sentence_one" => "You are about to accept this quotation for validation,",
        "sentence_two" => "if you have finished selecting quotations, you can then close this offer and launch the corresponding work order."
    ],
    "_filters" => ["reset" => "Reset", "status" => "Status", "submit" => "Filter"],
    "_form" => [
        "amount_before_taxes" => "Quotation amount ex. tax",
        "argument" => "Rationale",
        "ends_at" => "End date",
        "file" => "Quotation",
        "starts_at" => "Possible start date"
    ],
    "_status" => [
        "accepted" => "Response accepted",
        "not_selected" => "Not accepted",
        "pending" => "Pending",
        "refused" => "Response rejected"
    ],
    "_table_head" => [
        "actions" => "Actions",
        "amount_before_taxes" => "Amount ex. tax",
        "created_at" => "Creation date",
        "enterprise" => "Company",
        "status" => "Status"
    ],
    "construction" => [
        "_html" => [
            "amount_before_taxes" => "Quotation amount ex. tax",
            "argument" => "Rationale",
            "ends_at" => "End date",
            "file" => "Quotation",
            "offer" => "Work order offer",
            "starts_at" => "Possible start date",
            "status" => "Status",
            "vendor" => "Responding company"
        ]
    ],
    "create" => [
        "email" => [
            "access_to_response_to_proposal" => "Access the response",
            "addworking_team" => "AddWorking Team",
            "cordially" => "Regards",
            "hello" => "Hello",
            "text_line1" => "is interested in the work order offer: ",
            "text_line2" => "You can view the response details and validate it in your AddWorking account.",
            "text_line3" => "You can also copy and paste the following URL into the address bar of your browser"
        ],
        "return" => "Back",
        "submit" => "Respond",
        "title" => "Respond to offer :label"
    ],
    "index" => [
        "return" => "Back",
        "search" => ["enterprise_name" => "Company"],
        "title" => "Responses for work order offer :label"
    ],
    "show" => [
        "accept" => "Accept",
        "reject" => [
            "close" => "Close",
            "comment" => "Rejection comments",
            "confirm" => "Confirm rejection?",
            "reject" => "Reject",
            "submit" => "Reject"
        ],
        "return" => "Back",
        "title" => "Response to offer :label"
    ]
];
