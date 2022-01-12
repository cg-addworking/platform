<?php
return [
    "milestone" => [
        "type" => [
            "annual" => "Annual",
            "biannual" => "Bi-annual",
            "end_of_mission" => "End of work",
            "monthly" => "Monthly",
            "quarterly" => "Quarterly",
            "weekly" => "Weekly"
        ]
    ],
    "mission" => [
        "amount" => "Qty",
        "analytic_code" => "Analytical code",
        "analytic_code_placeholder" => "Example: Az9Tr",
        "contract" => "Contract",
        "create_title" => "Create a work",
        "customer" => "Client",
        "date" => "Dated:: date",
        "date_label" => "Dated",
        "date_placeholder" => "DD / MM / YYYY",
        "days" => "Day",
        "delete_success" => "Work successfully deleted",
        "dispute" => "Challenge",
        "edit_title" => "Edit the work",
        "ends_at" => "Work end date",
        "ends_at_placeholder" => "DD / MM / YYYY",
        "external_id" => "Client ID",
        "external_id_placeholder" => "External ID",
        "fixed_fees" => "Flat rate",
        "hours" => "Hour",
        "id" => "Id",
        "inbound_invoice_item" => "Incoming invoice lines",
        "outbound_invoice_item" => "Outgoing invoice lines",
        "price" => "Price:: price ?",
        "price_th" => "Price",
        "profile" => [
            "diploma" => "Study level",
            "job" => "Job",
            "job_placeholder" => "Example: Consultant",
            "languages" => "Language(s)",
            "mobility" => "Mobility",
            "region" => "Country / Region",
            "should_provide_recommendations" => "Recommendation",
            "skills" => "Skills",
            "years_of_experience" => "Professional experience"
        ],
        "quantity" => "Quantity",
        "quotation" => [
            "destroy" => ["error" => "The quote could not be deleted", "success" => "The quote is deleted"],
            "save_date_estimation" => [
                "error" => "Error while saving the visit date!",
                "success" => "The visit date has been recorded!"
            ],
            "send" => ["error" => "Error creating the quote", "success" => "Quote successfully created"],
            "store" => [
                "error" => "Quote creation failed",
                "success" => "The quote was created successfully"
            ],
            "update" => ["error" => "The quote could not be updated", "success" => "Updated quote"]
        ],
        "save_success" => "The mission has been registered",
        "starts_at" => "Start date",
        "starts_at_desired" => "Desired start date",
        "starts_at_placeholder" => "DD / MM / YYYY",
        "status" => "Status",
        "status_abandoned" => "Abandoned",
        "status_accepted" => "Accepted",
        "status_answered" => "Answered",
        "status_assigned" => "Assigned",
        "status_closed" => "Closed",
        "status_communicated" => "broadcast",
        "status_disputed" => "Under dispute",
        "status_done" => "Completed",
        "status_draft" => "Rough draft",
        "status_in_progress" => "In progress",
        "status_paid" => "Paid",
        "status_pending" => "Waiting",
        "status_ready_to_start" => "Good For Starter",
        "status_refused" => "Declined",
        "status_to_pay" => "To pay",
        "status_to_provide" => "To provide",
        "status_under_negociation" => "Negotiation",
        "status_under_negotiation" => "Negotiation",
        "title" => "Your works",
        "tracking" => [
            "status" => ["pending" => "Pending", "rejected" => "Rejected", "validated" => "Accepted"]
        ],
        "unit" => "Unit",
        "unit_days" => "Days",
        "unit_days_short" => "Days",
        "unit_fixed_fees" => "Flat fee",
        "unit_fixed_fees_short" => "Fixed fees",
        "unit_hours" => "Hours",
        "unit_hours_short" => "Hours",
        "unit_price" => "Unit Price",
        "user" => "User",
        "vendor" => "Subcontractor",
        "visit_date" => "Enter the visit date for <br /> the work, with the final Client.",
        "visit_date_failed" => "Error while saving the visit date!",
        "visit_date_success" => "The visit date has been recorded!"
    ],
    "proposal" => [
        "details" => "Further information",
        "label" => "Purpose of the proposal",
        "need_quotation" => [
            "0" => "No",
            "1" => "Yes",
            "false" => "No",
            "label" => "Quote required",
            "true" => "Yes"
        ],
        "send_invitation" => "Send to invited Subcontractors",
        "status" => [
            "abandoned" => "Abandoned",
            "accepted" => "Accepted",
            "answered" => "Answered",
            "assigned" => "Assigned",
            "bpu_sended" => "BPU (Unit Prices Form) transmitted",
            "draft" => "Draft",
            "interested" => "Interested",
            "received" => "Received",
            "refused" => "Refused",
            "under_negotiation" => "Negotiation"
        ],
        "valid_from" => "Proposal Start Date",
        "valid_from_placeholder" => "DD/MM/YYYY",
        "valid_until" => "Proposal Deadline",
        "valid_until_placeholder" => "DD/MM/YYYY"
    ],
    "response" => [
        "reason_for_rejection" => [
            "answer_not_ok" => "The answer does not meet the need",
            "ends_at_not_ok" => "The end date does not meet the need",
            "other" => "Other",
            "quantity_not_ok" => "Quantity is not aligned with the need",
            "starts_at_not_ok" => "The start date does not meet the need",
            "unit_price_not_ok" => "The price does not meet the need"
        ],
        "status" => [
            "final_validation" => "Final validation",
            "interview_positive" => "Positive exchange",
            "interview_requested" => "Exchange requested",
            "ok_to_meet" => "OK for exchange",
            "pending" => "Pending",
            "refused" => "Refused"
        ],
        "unit" => ["days" => "Day", "fixed_fees" => "Flat fee", "hours" => "Hour"]
    ],
    "tracking" => [
        "line" => [
            "reason_for_rejection" => [
                "error_amount" => "Error on Price",
                "error_quantity" => "Error on Quantity",
                "mission_not_completed" => "Mission partially completed",
                "mission_not_realized" => "Mission not completed",
                "other" => "Other"
            ]
        ],
        "pending" => "Pending",
        "refused" => "Refused",
        "search_for_agreement" => "Need agreement",
        "validated" => "Validated"
    ]
];
