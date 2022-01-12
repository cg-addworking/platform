<?php
return [
    "billing" => [
        "inbound_invoice" => [
            "_action" => ["download" => "Download", "items" => "Items", "reconciliation" => "Reconciliation"],
            "_dropdown" => [
                "consulter" => "See",
                "download" => "Download",
                "invoice_lines" => "Invoice lines",
                "modifier" => "Edit",
                "remove" => "Remove"
            ],
            "_form" => [
                "amount_all_taxes_included" => "Total including taxes (incl tax)",
                "amount_excluding_taxes" => "Total excluding taxes (excl tax)",
                "amount_of_taxes" => "Total of taxes (VAT)",
                "current_file" => "Current file",
                "date_of_invoice" => "Date of issue of invoice",
                "file" => "File",
                "invoice_properties" => "Invoice Settings",
                "is_factoring_alert_line_1" => "Here is the IBAN in your AddWorking account: :iban",
                "is_factoring_alert_line_2" => "If this IBAN is not that of your factor, please replace it ",
                "is_factoring_check" => "I declare that this invoice has been transferred to a factor and that I have updated the bank details in my AddWorking account",
                "is_factoring_message" => "If you have transferred your invoice to a factor, please declare it below:",
                "note" => "Note",
                "number" => "Number",
                "payment_deadline" => "Payment deadline",
                "replace" => "Replace",
                "replace_rib" => "here",
                "tracking_lines" => "Work follow-up lines",
                "tracking_lines_amount_before_taxes" => "Total excluding taxes (ex. tax)",
                "tracking_lines_description" => "Description",
                "tracking_lines_not_found" => "I could not find a billable item to associate.",
                "tracking_lines_quantity" => "Quantity",
                "tracking_lines_unit_price" => "Unit Price",
                "tracking_lines_vat_rate" => "VAT"
            ],
            "_form_support" => [
                "admin" => "Admin",
                "admin_amount" => "(admin) Total excluding taxes (excl. tax.)",
                "admin_amount_all_taxes_included" => "(admin) Total including taxes (incl. tax.)",
                "admin_amount_of_taxes" => "(admin) Total of taxes (VAT)",
                "outbound_invoice" => "Associated outbound Invoice",
                "paid" => "Paid",
                "pending" => "Pending",
                "status" => "Status",
                "to_validate" => "To validate",
                "validated" => "Validated"
            ],
            "_html" => [
                "admin_amount" => "(admin) Invoice totals",
                "admin_amount_all_taxes_included" => "Total including taxes (incl tax)",
                "admin_amount_of_taxes" => "Total of taxes (VAT)",
                "administrative_compliance" => "Administrative compliance",
                "amount_all_taxes_included" => "Total including taxes (incl tax)",
                "amount_excluding_taxes" => "Total excluding taxes (excl tax)",
                "amount_of_taxes" => "Total of taxes (VAT)",
                "associated_customer_invoice" => "Associated Client Invoice",
                "client" => "Client",
                "creation_date" => "Creation date",
                "date_of_invoice" => "Date of issue of invoice",
                "file" => "File",
                "is_factoring" => "Billing",
                "last_modified_date" => "Date of last modification",
                "no" => "No",
                "note" => "Note",
                "number" => "Number",
                "payment_deadline" => "Payment deadline",
                "period" => "Period",
                "service_provider" => "Subcontractor",
                "status" => "Status",
                "tracking" => "Follow-up",
                "updated_by" => "Modified by ",
                "username" => "Username",
                "yes" => "Yes"
            ],
            "_status" => [
                "paid" => "Paid",
                "pending" => "Pending",
                "unknown" => "Unknown",
                "validate" => "To validate",
                "validated" => "Validated"
            ],
            "_table_row_empty" => [
                "add_from_tracking_lines" => "Add from follow-ups lines",
                "statement_postfix" => "does not have any item in this Subcontractor invoice.",
                "statement_prefix" => "The Company"
            ],
            "_warning" => [
                "address" => "ADDWORKING",
                "address_deutschland" => "ADDWORKING GmbH",
                "attention" => "Warning",
                "invoice_payable_to" => "Remember to make your invoices payable to:",
                "line_1" => "17 rue du Lac Saint AndrÇ",
                "line_2" => "Savoie Technolac - BP 350",
                "line_3" => "73370 Le Bourget du Lac - France",
                "line_4" => "AddWorking Intra-Community VAT number: FR 71 810 840 900 00015",
                "line_5" => "Lebacher Strasse 4",
                "line_6" => "66113 SaarbrÅcken"
            ],
            "before_create" => [
                "companies" => "Companies",
                "continue" => "Continue",
                "create" => "Create",
                "customer" => "Client",
                "dashboard" => "Dashboard",
                "help_text" => "The period corresponds to the month in which you done the work. For example: if it's November and your work was done in October, then the invoicing period is October.",
                "my_bills" => "My Invoices",
                "new_invoice" => "New invoice",
                "period" => "Period"
            ],
            "create" => [
                "companies" => "Companies",
                "create" => "Create",
                "dashboard" => "Dashboard",
                "my_bills" => "My Invoices",
                "new_invoice" => "New invoice",
                "return" => "Back"
            ],
            "edit" => [
                "companies" => "Companies",
                "customer" => "Client",
                "dashboard" => "Dashboard",
                "edit" => "Edit",
                "edit_invoice" => "Edit invoice",
                "help_text" => "The period corresponds to the month in which you done the work. For example: if it's November and your work was done in October, then the invoicing period is October.",
                "month" => "Month",
                "my_bills" => "My Invoices",
                "register" => "Save",
                "return" => "Back",
                "service_provider" => "Subcontractor"
            ],
            "export" => [
                "addworking_team" => "AddWorking Team",
                "download_button" => "Download",
                "greetings" => "Hello,",
                "sentence_one" => "Your export is ready!",
                "sentence_two" => "Click on the link below to download it:",
                "success" => "Your export is being generated and you will receive a link by email to download it.",
                "thanks_you" => "Regards,"
            ],
            "export_ready" => [
                "email_sentence" => "Please find attached to this email the inbound Invoices extract as requested.",
                "greeting" => "Hello,",
                "have_a_good_day" => "Have a nice day!"
            ],
            "inbound_invoice_reconciliation" => [
                "consult_invoice" => "See the invoice",
                "sentence" => "did not find any billable items for this invoice."
            ],
            "index" => [
                "action" => "Action",
                "amount_excluding" => "Total excl. tax.",
                "amount_including_tax" => "Total incl. tax.",
                "cannot_create_invoice_sentence" => "To add an invoice, you must have at least one customer and have entered your IBAN.",
                "companies" => "Companies",
                "create_invoice" => "Create an Invoice",
                "created_date" => "Creation date",
                "customer" => "Client",
                "dashboard" => "Dashboard",
                "empty" => "Empty",
                "fill_iban_button" => "I want to enter my IBAN",
                "my_bills" => "My Invoices",
                "number" => "Number",
                "service_provider" => "Subcontractor",
                "status" => "Status",
                "tax_amount" => "Total of taxes"
            ],
            "new_inbound_uploaded" => [
                "consult_invoice" => "I check the invoice",
                "deposited_new_invoice" => "has left a new invoice in his workspace",
                "your_turn_to_play" => "It's your turn Antoine ?? You rock!"
            ],
            "show" => [
                "alert_business_plus" => "Your customer's subscription allows invoices to be submitted and viewed. In this context, the status of your invoice is handled outside the AddWorking platform.",
                "alert_inbound_invoice_item_not_found" => "The subcontractor did not find any billable items for this invoice.",
                "amount_all_taxes_included" => "Total including taxes (incl tax):",
                "amount_of_taxes" => "Total of taxes (VAT):",
                "attention" => "Warning",
                "bills" => "Invoice",
                "comments" => "Comments",
                "companies" => "Companies",
                "compliant_invoice" => "This invoice is compliant",
                "create_outbound_invoice" => "Create the AddWorking invoice",
                "dashboard" => "Dashboard",
                "file" => "File",
                "general_information" => "General information",
                "in_processing_by_addworking" => "In processing by AddWorking",
                "information_calculated_from_mission_monitoring_lines" => "Information calculated from the works follow-ups lines:",
                "information_provided_by_service_provider" => "Information provided by the subcontractor:",
                "my_bills" => "My Invoices",
                "not_compliant_invoice" => "This invoice is not compliant",
                "processed_by_addworking" => "Processed by AddWorking",
                "reconciliation" => "Reconciliation",
                "reconciliation_here" => "Reconciliate here",
                "reconciliation_success_text" => "Well done: this subcontractor invoice is reconciled!",
                "return" => "Back",
                "total_amount_excluding_taxes" => "Total excluding taxes (excl tax):",
                "validate_invoice" => "Validate the invoice",
                "waiting_administrative_verification" => "This invoice is awaiting administrative verification"
            ],
            "tracking" => [
                "paid" => "Invoice paid by AddWorking on :date at :datetime",
                "replace_file" => "Invoice replaced by :user on :date at :datetime",
                "validate" => "Invoice approved by AddWorking on :date at :datetime"
            ]
        ],
        "inbound_invoice_item" => [
            "_actions" => [
                "consult" => "See",
                "dissociate" => "Dissociate",
                "edit" => "Edit",
                "remove" => "Delete"
            ],
            "_form" => [
                "amount" => "Quantity",
                "general_information" => "General information",
                "label" => "Description",
                "unit_price" => "Unit price",
                "vat_rate" => "VAT rate"
            ],
            "_html" => [
                "amount" => "Quantity",
                "amount_all_taxes_included" => "Total including taxes (incl tax)",
                "amount_before_taxes" => "Total excluding taxes (excl tax)",
                "consult_invoice" => "",
                "created_date" => "Created on",
                "last_modified_date" => "Last modified on",
                "tax_amount" => "Total of taxes (VAT)",
                "unit_price" => "Unit price",
                "username" => "ID number",
                "wording" => "Line description"
            ],
            "_table_items" => [
                "amount" => "Quantity",
                "label" => "Line description",
                "unit_price" => "Unit price",
                "vat_rate" => "VAT rate"
            ],
            "_table_tracking_lines" => [
                "amount" => "Quantity",
                "customer_validation" => "Client approval",
                "mission_number" => "Work #",
                "period" => "Period",
                "provider_validation" => "Subcontractor approval",
                "purpose_of_mission_monitoring_line" => "Work follow-up line object",
                "total_ht" => "Total excl. tax. ",
                "unit_price" => "Unit price",
                "vat_rate" => "VAT rate"
            ],
            "create" => [
                "companies" => "Companies",
                "create" => "Create",
                "create_invoice_line" => "Create an invoice line",
                "dashboard" => "Dashboard",
                "invoice_lines" => "Invoice lines",
                "my_bills" => "My Invoices",
                "return" => "Back"
            ],
            "create_from_tracking_lines" => [
                "associate" => "Match",
                "companies" => "Companies",
                "create" => "Create",
                "dashboard" => "Dashboard",
                "invoice_lines" => "Invoice lines",
                "mission_followups_affected_by_this_invoice" => "Works follow-ups related to this invoice",
                "my_bills" => "My Invoices",
                "number_of_lines_selected" => "Number of selected lines:",
                "return" => "Back",
                "total_amount_excluding_taxes_of_selected_lines" => "Total (exl tax) of selected lines:"
            ],
            "edit" => [
                "companies" => "Companies",
                "dashboard" => "Dashboard",
                "edit_invoice_line" => "Edit Invoice line",
                "invoice_lines" => "Invoice lines",
                "modifier" => "Edit",
                "my_bills" => "My Invoices",
                "register" => "Save",
                "return" => "Back"
            ],
            "index" => [
                "action" => "Actions",
                "add_from_tracking_lines" => "Match with follow-ups lines",
                "amount" => "Quantity",
                "amount_all_taxes_included" => "Total including taxes (incl tax):",
                "amount_excluding" => "Total excl. tax.",
                "amount_of_taxes" => "Total of taxes (VAT):",
                "companies" => "Companies",
                "customer_validation" => "Client approval",
                "dashboard" => "Dashboard",
                "invoice_lines" => "Invoice lines",
                "label" => "Line description",
                "lines_of" => "Lines of",
                "mission" => "Work",
                "my_bills" => "My Invoices",
                "provider_validation" => "Subcontractor approval",
                "return" => "Back",
                "summary" => "Summary",
                "total_amount_excluding_taxes" => "Total excluding taxes (excl tax):",
                "unit_price" => "Unit price",
                "vat_rate" => "VAT rate"
            ],
            "show" => [
                "companies" => "Companies",
                "dashboard" => "Dashboard",
                "invoice_lines" => "Invoice lines",
                "my_bills" => "My Invoices",
                "return" => "Back"
            ]
        ],
        "outbound_invoice" => [
            "_actions" => [
                "actions" => "Actions",
                "add_row" => "Add a line",
                "assign_number" => "Assign a number",
                "consult" => "Consult",
                "create_balance_invoice" => "Create of a Rest Invoice",
                "create_payment_order" => "Create a payment order",
                "create_remainder" => "Create a remainder",
                "details_tse_express_medical" => "Details TSE Express Medical",
                "export_charles_lineart" => "Export Charles LIENART",
                "export_for_payment" => "Export for Payment",
                "export_tse_express_medical" => "Export TSE Express Medical",
                "generate" => "Generate",
                "numbering" => "Numbering",
                "payment_orders" => "Payment orders",
                "regenrate" => "Regenerate",
                "service_provider_invoices" => "Subcontractors Invoices"
            ],
            "_form" => [
                "amount_excluding" => "Total excl. tax.",
                "amount_including_tax" => "Total incl tax.",
                "file" => "File",
                "include_fix_cost" => "Include fixed fees",
                "issue_date" => "Date of issue",
                "number_of_providers" => "Number of subcontractors",
                "payable_on" => "Payable on",
                "period" => "Period",
                "vat_rate" => "Total of taxes (VAT)"
            ],
            "_html" => [
                "amount_excluding" => "Total excl. tax.",
                "amount_including_tax" => "Total incl. tax.",
                "created_on" => "Created on",
                "date_of_invoice" => "Date of invoice",
                "download_invoice" => "Download the invoice",
                "enterprise" => "Company",
                "number" => "Number",
                "payable_on" => "Payable on",
                "payable_to" => "Payable to",
                "status" => "Status",
                "updated_on" => "Updated on",
                "username" => "Username",
                "vat_rate" => "Total of taxes (VAT)"
            ],
            "_missions_inbound_invoices" => [
                "amount" => "Total",
                "empty" => "Empty",
                "number" => "Number",
                "period" => "Period",
                "status" => "Status"
            ],
            "_missions_missions" => [
                "amount_per_day" => "Total per day",
                "number_of_days" => "Number of days",
                "total" => "Total",
                "tour_id" => "Round ID"
            ],
            "_number" => ["attribute" => "Assign"],
            "_search" => [
                "enterprise" => "Company",
                "number" => "Number",
                "reinitialize_search" => "(re)initialize the search",
                "search" => "Search",
                "username" => "Username"
            ],
            "_table" => [
                "amount_excluding" => "Total excl. tax.",
                "amount_including_tax" => "Total incl. tax.",
                "attribute" => "Assign",
                "company" => "Company",
                "deadline" => "Deadline",
                "enterprise" => "Company",
                "issued_on" => "Issued on",
                "number" => "Number",
                "payable_on" => "Payable on",
                "period" => "Period",
                "status" => "Status",
                "uuid" => "UUID"
            ],
            "_vendors" => ["enterprise" => "Company", "status" => "Status", "uuid" => "UUID"],
            "create" => [
                "create" => "Create",
                "create_invoice" => "Create an invoice",
                "create_new_invoice" => "Create the invoice",
                "dashboard" => "Dashboard",
                "invoices" => "Invoices",
                "return_to_list_of_invoices" => "Back to the list of invoices"
            ],
            "details" => [
                "invoice_details" => "Invoice details:",
                "label" => "Label",
                "properties" => "Settings",
                "quantity" => "Qty",
                "service_provider_invoices" => "Subcontractors invoice(s)",
                "unit_price" => "Unit price",
                "vat_rate" => "VAT"
            ],
            "document" => [
                "_annex" => [
                    "agency_code" => "Agency Code",
                    "amount" => "Total",
                    "analytical_code" => "Analytical code",
                    "annex" => "Annex:",
                    "detail_subcontractors" => "Subcontractors detail",
                    "management_fees_ht" => "Management fees excl. tax.",
                    "subcontractor_code" => "Subcontractor code",
                    "subcontractor_name" => "Name of Subcontractor",
                    "total_ht" => "Total excl. tax. ",
                    "tour_code" => "Round ID",
                    "unit_price_ht" => "Unit Price excl. tax."
                ],
                "_details" => [
                    "amount_excluding" => "Total excl. tax.",
                    "period_per_number_of_contract" => "Period / Contract No.",
                    "subcontractor_code" => "Subcontractor code",
                    "subcontractor_name" => "Name of Subcontractor"
                ],
                "_enterprises" => [
                    "addworking_sas" => "ADDWORKING SAS",
                    "at" => "At:",
                    "cps_contract_number" => "CPS1 Contract No.",
                    "date" => "Dated:",
                    "invoice_number" => "Invoice No.",
                    "line_1" => "17 RUE LAC SAINT ANDRE",
                    "line_2" => "73370 LE BOURGET DU LAC",
                    "line_3" => "FRANCE",
                    "line_4" => "France",
                    "of" => "Of:",
                    "represented_by" => "Represented by",
                    "represented_by_julien" => "Represented by Julien PERONA",
                    "vat_number" => " FR 718 1084 0900 00015",
                    "vat_number_label" => "Intracommunity VAT No.:"
                ],
                "_summary" => [
                    "benifits_ht" => "Services excl. tax.",
                    "iban_for_transfer" => "IBAN for transfer:",
                    "iban_number" => "FR76 3000 3005 7100 0201 2497 429",
                    "management_fees_ht" => "Management fees excl. tax.",
                    "payment_deadline" => "Payment deadline:",
                    "reference_tobe_reminded_on_transfer" => "Reference to remind on the transfer:",
                    "total_ht" => "Total excl. tax. ",
                    "total_ttc" => "Total incl. tax.",
                    "total_vat" => "Total of taxes (VAT)"
                ],
                "invoice_number" => "Invoice No."
            ],
            "edit" => [
                "dashboard" => "Dashboard",
                "edit" => "Edit",
                "invoices_issued" => "Issued Invoices",
                "register" => "Save",
                "return" => "Back"
            ],
            "inbound_invoice_list" => [
                "action" => "Action",
                "amount_excluding" => "Total excl. tax.",
                "amount_including_tax" => "Total incl. tax.",
                "dashboard" => "Dashboard",
                "export" => "Export",
                "invoices" => "Invoices",
                "no_result" => "No result",
                "number" => "Number",
                "processing" => "Processing",
                "provider_invoices_included" => "Included Subcontractors Invoices",
                "reconcile" => "To Reconciliate",
                "reconciliation_ok" => "Reconciliation OK",
                "return" => "Back",
                "service_provider" => "Subcontractor",
                "service_provider_invoices" => "Subcontractors Invoices",
                "state" => "State",
                "status" => "Status"
            ],
            "index" => [
                "action" => "Action",
                "add_invoice" => "Add an invoice",
                "amount_ht_by_ttc" => "Total excl. / incl. tax.",
                "created_at" => "Created on",
                "dashboard" => "Dashboard",
                "deadline" => "Deadline",
                "enterprise" => "Company",
                "export" => "Export",
                "invoices_issued" => "Issued Invoices",
                "issued_on" => "Issued on",
                "my_bills" => "My Invoices",
                "number" => "Number",
                "payable_on" => "Payable on",
                "period" => "Period",
                "status" => "Status"
            ],
            "missions" => [
                "add_comment" => "Add a comment",
                "add_row" => "Add a line",
                "amount_per_day" => "Total per day",
                "are_you_sure_delete" => "Sure to delete this line?",
                "are_you_sure_delete_comment" => "Sure to delete the comment?",
                "attention_text" => "Please note: the amounts of your invoice and that of your subcontractor do not correspond. \nDo you want to validate this invoice anyway?",
                "comments_for_info" => "Comments (for information and not visible on the invoice)",
                "entitled" => "Entitled",
                "final_invoice_tobe_validated" => "Final invoice to validate",
                "final_invoice_validated" => "Final invoice validated",
                "import_data_from_your_system" => "Import data from your system",
                "import_invoice_from_your_service_provider" => "Import your subcontractor's invoices",
                "invoice_for_period" => "Invoice for the period:",
                "no_longer_validate_for_invoicing" => "No longer validate for invoicing",
                "number_of_days" => "Number of days",
                "payable" => "Payable:",
                "providers_list" => "List of subcontractors",
                "removal" => "Removal",
                "save_put_on_hold" => "Save and put on hold",
                "service_provider" => "Subcontractor:",
                "total" => "Total",
                "validate_for_invoicing" => "Validate for invoicing"
            ],
            "show" => [
                "comments" => "Comments",
                "dashboard" => "Dashboard",
                "details" => "Details",
                "file" => "File",
                "general_information" => "General information",
                "invoices" => "Invoices",
                "remainder_of" => "Remainder of",
                "return" => "Back",
                "service_provider_invoices" => "Subcontractors Invoices"
            ],
            "validate" => [
                "assign_number" => "Assign a number",
                "invoice_for_period" => "Invoice for the period:",
                "invoice_has_no_number" => "This invoice has no number",
                "payable" => "Payable:",
                "reconciliation" => "Reconciliation",
                "return_to_invoices" => "Back to invoice",
                "total_tobe_invoiced" => "Total to invoice"
            ]
        ],
        "outbound_invoice_comment" => [
            "_form" => ["comment" => "Comment:", "not_stated_on_invoice" => "(not stated on the invoice)"]
        ],
        "outbound_invoice_item" => [
            "_actions" => ["remove" => "Remove"],
            "_form" => [
                "label" => "Label",
                "label_placeholder" => "Description",
                "quantity" => "Quantity",
                "service_provider" => "Subcontractor",
                "unit_price" => "Unit price"
            ],
            "edit" => ["add_title" => "Add", "edit_title" => "Edit", "save" => "Save"]
        ],
        "outbound_invoice_number" => [
            "_html" => [
                "created_at" => "Created on",
                "priority" => "Priority",
                "updated_at" => "Update on"
            ],
            "index" => [
                "associate" => "Associate",
                "bill" => "Invoice",
                "enterprise" => "Company",
                "numbering_of_invoices" => "Numbering of invoices",
                "reserve_new_number" => "Reserve a new number"
            ]
        ],
        "outbound_invoice_payment_order" => [
            "_form" => [
                "no_result" => "No result",
                "service_provider_does_not_have_iban" => "Can't include this subcontractor in the payment order: this subcontractor doesn't have any registered IBAN.",
                "service_provider_not_included_in_payment_order" => "Can't include this subcontractor in the payment order: one of his invoices doesn't have any \"administrator\" total (filled in by the AddWorking Support team)."
            ],
            "_html" => [
                "bill" => "Invoice",
                "change_status" => "Change Status",
                "created_at" => "Created on",
                "status" => "Status",
                "updated_at" => "Updated on"
            ],
            "index" => ["button_add" => "Add", "title_index" => "Payment orders"],
            "show" => ["properties" => "Properties"]
        ]
    ],
    "common" => [
        "address" => [
            "_form" => ["appartment_floor" => "Apartment, Floor ...", "city_place" => "City or Place"],
            "edit" => ["edit_title" => "Addresses", "save" => "Save"],
            "index" => ["title" => "Addresses"],
            "view" => ["address" => "Address", "general_information" => "General information"]
        ],
        "comment" => [
            "_create" => [
                "add_comment" => "Add a comment",
                "comment" => "Comment",
                "help_text" => "Public: visible to everyone. Protected: visible to members of my company. Private: visible only to me.",
                "users_to_notify" => "Notify",
                "visibility" => "Visibility"
            ],
            "_html" => ["added_by" => "Added by", "remove" => "Remove"]
        ],
        "csv_loader_report" => [
            "_actions" => ["download_csv_of_errors" => "Download the CSV of errors"],
            "_html" => [
                "created_date" => "Creation date",
                "errors" => "Errors",
                "label" => "Label",
                "last_modified_date" => "Date of last modification",
                "number_of_lines" => "Number of lines",
                "username" => "Username"
            ],
            "index" => [
                "actions" => "Actions",
                "add" => "Add",
                "csv_load_reports" => "CSV Load Reports",
                "dashboard" => "Dashboard",
                "date" => "Dated",
                "errors" => "Errors",
                "label" => "Label",
                "number_of_lines" => "Number of lines"
            ],
            "show" => [
                "csv_load_reports" => "CSV Load Reports",
                "dashboard" => "Dashboard",
                "general_information" => "General information",
                "preview" => "Preview",
                "return" => "Back"
            ]
        ],
        "file" => [
            "_actions" => ["download" => "Download"],
            "_form" => [
                "file" => "File",
                "general_information" => "General information",
                "mime_type" => "Mime Type",
                "path" => "Path"
            ],
            "_html" => [
                "created_at" => "Created on",
                "cut" => "Size",
                "extension" => "Extension",
                "mime_type" => "MIME Type (Multipurpose Internet Mail Extensions)",
                "name" => "File name",
                "owner" => "Owner",
                "path" => "Path",
                "url" => "URL",
                "username" => "Username"
            ],
            "_summary" => ["file" => "File:"],
            "create" => [
                "create" => "Create",
                "create_file" => "Create a file",
                "dashboard" => "Dashboard",
                "files" => "Files",
                "register" => "Save",
                "return" => "Back"
            ],
            "edit" => [
                "dashboard" => "Dashboard",
                "edit" => "Edit",
                "edit_file" => "Edit file",
                "files" => "Files",
                "register" => "Save",
                "return" => "Back"
            ],
            "index" => [
                "actions" => "Actions",
                "add_file" => "Add a file",
                "associated_to" => "Associated to",
                "creation" => "Creation",
                "cut" => "Size",
                "dashboard" => "Dashboard",
                "files" => "Files",
                "owner" => "Owner",
                "path" => "Path",
                "type" => "Type"
            ],
            "show" => [
                "content" => "Content",
                "dashboard" => "Dashboard",
                "error" => "An error occurred when retrieving the file; please refresh the page",
                "files" => "Files",
                "general_information" => "General information"
            ]
        ],
        "folder" => [
            "1" => "Add to folder",
            "" => "Add to folder",
            "_form" => [
                "folder_name" => "Folder Name",
                "general_information" => "General information",
                "owner" => "Owner",
                "visible_to_providers" => "File visible to Subcontractors?"
            ],
            "_html" => [
                "actions" => "Actions",
                "created_at" => "Created on",
                "created_date" => "Creation date",
                "description" => "Description",
                "folder_shared_with_service_providers" => "File shared with Subcontractors",
                "label" => "Label",
                "last_modified_date" => "Date of last modification",
                "owner" => "Owner",
                "username" => "Username"
            ],
            "_items" => [
                "actions" => "Actions",
                "created_at" => "Created on",
                "description" => "Description",
                "title" => "Title"
            ],
            "attach" => [
                "add_to_folder" => "Add to folder",
                "attach" => "Attach",
                "dashboard" => "Dashboard",
                "enterprises" => "Companies",
                "file" => "Folder",
                "files" => "Files",
                "link_to_file" => "Link to file",
                "object_to_add_to_file" => "Object to add to the file",
                "register" => "Save",
                "return" => "Back"
            ],
            "create" => [
                "create" => "Create",
                "create_folder" => "Create a folder",
                "dashboard" => "Dashboard",
                "enterprises" => "Companies",
                "files" => "Files",
                "register" => "Save",
                "return" => "Back"
            ],
            "edit" => [
                "dashboard" => "Dashboard",
                "edit" => "Edit",
                "enterprises" => "Companies",
                "files" => "Files",
                "register" => "Save",
                "return" => "Back"
            ],
            "index" => [
                "actions" => "Actions",
                "add" => "Add",
                "created_at" => "Created on",
                "createed_at" => "Created on",
                "dashboard" => "Dashboard",
                "enterprises" => "Company",
                "file" => "File",
                "files" => "Files",
                "my_clients_files" => "My Clients' files",
                "my_folders" => "My folders",
                "owner" => "Owner"
            ],
            "show" => [
                "content" => "Content",
                "dashboard" => "Dashboard",
                "enterprises" => "Companies",
                "files" => "Files",
                "general_information" => "General information",
                "return" => "Back"
            ]
        ],
        "job" => [
            "_actions" => ["skills" => "Skills"],
            "_form" => [
                "description" => "Description",
                "general_information" => "General information",
                "job" => "Job",
                "parent" => "Relative"
            ],
            "_html" => [
                "description" => "Description",
                "last_name" => "Name",
                "owner" => "Owner",
                "parent" => "Relative",
                "skills" => "Skills"
            ],
            "create" => [
                "create_new_skill" => "Create a new skill",
                "create_skill" => "Create a skill",
                "dashboard" => "Dashboard",
                "enterprises" => "Companies",
                "job" => "Jobs",
                "register" => "Save",
                "return" => "Back",
                "save_create_again" => "Save and create again"
            ],
            "edit" => [
                "dashboard" => "Dashboard",
                "edit" => "Edit",
                "edit_job" => "Edit job",
                "enterprises" => "Companies",
                "job" => "Jobs",
                "register" => "Save",
                "return" => "Back"
            ],
            "index" => [
                "actions" => "Actions",
                "add" => "Add",
                "created_at" => "Created on",
                "dashboard" => "Dashboard",
                "enterprises" => "Companies",
                "job" => "Jobs",
                "job_catalog" => "Jobs catalog",
                "last_name" => "Name",
                "skills" => "Skills"
            ],
            "show" => [
                "dashboard" => "Dashboard",
                "enterprises" => "Companies",
                "job" => "Jobs",
                "return" => "Back"
            ]
        ],
        "passwork" => [
            "_html" => ["client" => "Client", "owner" => "Owner", "skills" => "Skills"],
            "create" => [
                "client" => "Client",
                "continue" => "Continue",
                "create_new_passwork" => "Create a new Passwork",
                "create_passwork" => "Create a Passwork",
                "dashboard" => "Dashboard",
                "enterprises" => "Companies",
                "general_information" => "General information",
                "passwork" => "Passworks",
                "return" => "Back"
            ],
            "edit" => [
                "advance" => "Advanced",
                "beginner" => "Beginner",
                "dashboard" => "Dashboard",
                "edit" => "Edit",
                "edit_passwork" => "Edit the Passwork",
                "enterprises" => "Companies",
                "intermediate" => "intermediate",
                "job" => "Job",
                "level" => "Level",
                "passwork" => "Passworks",
                "register" => "Save",
                "return" => "Back",
                "skill" => "Skill"
            ],
            "index" => [
                "actions" => "Actions",
                "add" => "Add",
                "client" => "Client",
                "created_at" => "Created on",
                "dashboard" => "Dashboard",
                "enterprises" => "Companies",
                "owner" => "Owner",
                "passworks" => "Passworks",
                "passworks_catalogs" => "Passworks catalog",
                "skills" => "Skills",
                "username" => "Username"
            ],
            "show" => [
                "dashboard" => "Dashboard",
                "enterprises" => "Companies",
                "passwork" => "Passwork",
                "passworks" => "Passworks",
                "return" => "Back"
            ]
        ],
        "phone_number" => [
            "_form" => [
                "note" => "Note",
                "note_placeholder" => "Note",
                "number" => "Phone Number",
                "number_placeholder" => "Phone No"
            ]
        ],
        "skill" => [
            "_form" => [
                "description" => "Description",
                "general_information" => "General information",
                "skill" => "Skill"
            ],
            "_html" => [
                "description" => "Description",
                "enterprise" => "Company",
                "job" => "Job",
                "skill" => "Skill"
            ],
            "create" => [
                "create" => "Create",
                "create_new_skill" => "Create a new skill",
                "create_skill" => "Create a skill",
                "dashboard" => "Dashboard",
                "enterprises" => "Companies",
                "job" => "Jobs",
                "return" => "Back",
                "skills" => "Skills"
            ],
            "edit" => [
                "dashboard" => "Dashboard",
                "edit" => "Edit",
                "edit_skill" => "Change the skill",
                "enterprises" => "Companies",
                "job" => "Jobs",
                "register" => "Save",
                "return" => "Back",
                "skills" => "Skills"
            ],
            "index" => [
                "actions" => "Actions",
                "add" => "Add",
                "created_at" => "Created on",
                "dashboard" => "Dashboard",
                "enterprises" => "Companies",
                "job" => "Jobs",
                "job_skills" => "Job skills",
                "skills" => "Skills"
            ],
            "show" => [
                "dashboard" => "Dashboard",
                "enterprises" => "Companies",
                "job" => "Jobs",
                "return" => "Back",
                "skills" => "Skills"
            ]
        ]
    ],
    "components" => [
        "billing" => [
            "inbound" => [
                "index" => [
                    "breadcrumb" => ["dashboard" => "Dashboard", "inbound" => "Invoice"],
                    "button" => ["return" => "Return"],
                    "card" => [
                        "amount_all_taxes_included" => "Amout All Taxes Included",
                        "amount_before_taxes" => "Amount before Taxes",
                        "amount_of_taxes" => "Amount of Taxes",
                        "number_total_of_invoices" => "Total Number of Invoices"
                    ],
                    "filters" => [
                        "associated" => "Associed",
                        "customer" => "Customer",
                        "filter" => "Filter",
                        "month" => "Month",
                        "paid" => "Paid",
                        "pending" => "Pending",
                        "pending_association" => "Pending association",
                        "reset" => "Reset",
                        "status" => "Status",
                        "to_validate" => "To validate",
                        "validated" => "Validated",
                        "vendor" => "Subcontractors"
                    ],
                    "table_head" => [
                        "actions" => "Actions",
                        "amount_all_taxes_included" => "Amount All Taxes Included",
                        "amount_before_taxes" => "Amount before Taxes",
                        "amount_of_taxes" => "Amount of Taxes",
                        "customer" => "",
                        "due_at" => "Due at",
                        "enterprises" => "Subcontractor/Customer",
                        "month" => "Month",
                        "outbound_invoice" => "AddWorking invoice",
                        "status" => "Status",
                        "vendor" => ""
                    ],
                    "title" => "Subcontractors invoices"
                ]
            ],
            "outbound" => [
                "payment_order" => [
                    "_actions" => [
                        "associated_invoices" => "Included invoices",
                        "confirm_delete" => "Confirm delete the payment order?",
                        "delete" => "Delete"
                    ],
                    "associate" => [
                        "actions" => "Actions",
                        "amount_all_taxes_included" => "Total incl. tax.",
                        "amount_without_taxes" => "Total excl. tax.",
                        "associate" => "Associate",
                        "billing_period" => "Invoicing Period",
                        "customer" => "The Company",
                        "deadline" => "Due Date",
                        "invoice_number" => "Invoice No.",
                        "is_factoring" => "Billing",
                        "outbound_invoice_number" => "Client Invoice No.",
                        "return" => "Back",
                        "select" => "Associate these Subcontractors invoices with the payment order",
                        "status" => "Status",
                        "table_row_empty" => "has no Subcontractors invoices to associate with the payment order.",
                        "title" => "Subcontractors Invoices to associate",
                        "vendor" => "Subcontractor"
                    ],
                    "dissociate" => [
                        "actions" => "Actions",
                        "amount_all_taxes_included" => "Total incl. tax.",
                        "amount_without_taxes" => "Total excl. tax.",
                        "billing_period" => "Billing Period",
                        "customer" => "The Company",
                        "deadline" => "Due Date",
                        "dissociate" => "Dissociate",
                        "invoice_number" => "Invoice number",
                        "left_to_pay" => "Rest to pay",
                        "return" => "Back",
                        "select" => "Dissociate these Subcontractors invoices from the payment order",
                        "status" => "Status",
                        "table_row_empty" => "has no Subcontractors invoices included in the payment order.",
                        "title" => "Included Subcontractors Invoices",
                        "vendor" => "Subcontractor"
                    ],
                    "html" => [
                        "bank_reference" => "Bank Reference",
                        "count_items" => "Number of transfers included",
                        "created_at" => "Issue date",
                        "customer" => "Client name",
                        "debtor_info" => "Debtor Information",
                        "deleted_at" => "Delete on",
                        "download" => "Download",
                        "executed_at" => "Execution date",
                        "file" => "XML File",
                        "number" => "Payment Order Number",
                        "outbound_invoice" => "AddWorking Invoice Number",
                        "reference" => "Reference",
                        "status" => "Status",
                        "total_amount" => "Total",
                        "updated_at" => "Date of last modification"
                    ],
                    "index" => [
                        "button_create" => "Create a payment order",
                        "button_return" => "Back",
                        "table_row_empty" => "This Addworking invoice has no payment order.",
                        "title" => "Payment Orders"
                    ],
                    "show" => [
                        "button_return" => "Back",
                        "execute" => "Execute",
                        "generate" => "Generate",
                        "title" => "Payment Order No."
                    ],
                    "table_head" => [
                        "actions" => "Actions",
                        "created_at" => "Issued on",
                        "executed_at" => "Executed on",
                        "number" => "Number",
                        "status" => "Status"
                    ]
                ],
                "received_payment" => [
                    "_actions" => ["delete" => "Delete", "edit" => "Edit"],
                    "buttons" => ["actions" => "Actions", "create" => "Create", "edit" => "Edit", "return" => "Back"],
                    "create" => ["title" => "Confirm payment receipt for the Company"],
                    "edit" => ["title" => "Edit received payment no."],
                    "import" => [
                        "_breadcrumb" => [
                            "dashboard" => "Dashboard",
                            "import" => "Import received payments",
                            "received_payments" => "Received Payments"
                        ],
                        "_form" => ["csv_file" => "CSV File", "general_information" => "General information"],
                        "import" => "Import",
                        "title" => "Import received payments"
                    ],
                    "index" => [
                        "table_row_empty" => "This invoice doesn't have any received payments.",
                        "title" => "Received Payments for the Company",
                        "title_support" => "Received Payments"
                    ],
                    "received_payments" => "Received Payments ",
                    "table_head" => [
                        "amount" => "Total",
                        "amount_consumed" => "Total to invoice",
                        "bank_reference" => "Bank Reference",
                        "bic" => "BIC",
                        "iban" => "IBAN",
                        "invoices" => "Invoices",
                        "number" => "Number",
                        "received_at" => "Date of Receipt"
                    ]
                ]
            ]
        ],
        "enterprise" => [
            "activity_report" => [
                "application" => [
                    "views" => [
                        "activity_report" => [
                            "_breadcrumb" => ["activity_report" => "Activity monitoring"],
                            "_form" => ["missions" => "List of work orders per customer"],
                            "create" => [
                                "create" => "Save",
                                "return" => "Back ",
                                "title" => "Activity - from :start_date to :end_date"
                            ]
                        ],
                        "emails" => [
                            "request" => [
                                "addworking_team" => "AddWorking Team",
                                "cordially" => "Regards",
                                "hello" => "Hello",
                                "submit_activity_report" => "Click here",
                                "text_line1" => "You have one or more contract(s) in progress with your customer SOGETREL.",
                                "text_line2" => "In order to make monitoring your activity easier, please take 1 minute to tell us which site(s) you worked at in the month of ",
                                "text_line3" => "You can also copy and paste the following URL into the address bar of your browser"
                            ]
                        ]
                    ]
                ]
            ],
            "enterprise" => [
                "_breadcrumb" => ["enterprise" => ""],
                "email" => [
                    "export" => [
                        "have_a_good_day" => "Have a nice day!",
                        "hello" => "Hello,",
                        "join_sentence" => ""
                    ]
                ]
            ],
            "export" => [
                "email" => [
                    "export" => [
                        "have_a_good_day" => "Have a nice day!",
                        "hello" => "Hello,",
                        "join_sentence" => "Here attached the requested exports: Companies and their activities, Users by Company, Links between Companies and Invoicing"
                    ]
                ]
            ]
        ]
    ],
    "contract" => [
        "contract" => [
            "_actions" => [
                "annexes" => "Attachments",
                "create_addendum" => "Create an amendment",
                "download" => "Download",
                "model" => "Template",
                "stakeholders" => "Stakeholders",
                "variables" => "Variables"
            ],
            "_breadcrumb" => [
                "addendums" => "Amendments",
                "contracts" => "Contracts",
                "create" => "Create",
                "edit" => "Edit"
            ],
            "_form" => [
                "contract_due_date" => "Due Date",
                "contract_properties" => "Contract Settings",
                "contract_start_date" => "Contract Start Date",
                "external_identifier" => "External ID",
                "last_name" => "Name"
            ],
            "_html" => [
                "consult" => "Consult",
                "created_at" => "Created on",
                "effective_date" => "Effective date",
                "external_identifier" => "External ID",
                "file" => "File",
                "model" => "Template",
                "number" => "Number",
                "owner" => "Owner",
                "sign_in_hub" => "SigningHub",
                "status" => "Status",
                "term" => "Term",
                "username" => "Username"
            ],
            "_summary" => [
                "contract_created" => "The contract is created",
                "contract_is" => "The contract is",
                "contract_with_atleast_2_stakeholders" => "The contract has at least 2 stakeholders",
                "required_documents_valid" => "The required documents are valid",
                "signatories_assigned" => "Signatories are assigned",
                "signatories_signed" => "The signatories signed"
            ],
            "_table_head" => [
                "actions" => "Actions",
                "clients" => "",
                "deadline" => "Deadline",
                "last_name" => "Name",
                "model" => "Template",
                "parties" => "Stakeholders",
                "providers" => "",
                "status" => "Status"
            ],
            "_table_row_empty" => [
                "create_addendum" => "Create an Amendment",
                "create_contract" => "Create a Contract",
                "for_those_filters" => "for selected filters",
                "has_no_addendum" => " has no Amendment",
                "has_no_contract" => " has no Contract",
                "the_company" => "The Company",
                "the_contract" => "The Contract"
            ],
            "create" => [
                "create_blank_contract" => "Create a blank Contract",
                "create_contract" => "Create a Contract",
                "create_from_existing_file" => "Create from an existing file",
                "create_from_mockup" => "Create from a template",
                "return" => "Back"
            ],
            "create_blank" => ["create" => "Create", "create_contract" => "Create a Contract", "return" => "Back"],
            "create_from_file" => [
                "contract" => "Contract",
                "create" => "Create",
                "create_contract" => "Create a Contract",
                "return" => "Back"
            ],
            "create_from_template" => ["create" => "Create", "create_contract" => "Create a Contract", "return" => "Back"],
            "edit" => [
                "contract" => "Contract",
                "edit" => "Edit",
                "register" => "Save",
                "return" => "Back",
                "status" => "Status"
            ],
            "index" => [
                "add" => "Add",
                "contract" => "Contract Library",
                "filter" => "Filter",
                "reset_filter" => "Reset"
            ],
            "show" => ["return" => "Back"]
        ],
        "contract_annex" => [
            "_breadcrumb" => ["annexes" => "Attachments", "create" => "Create", "edit" => "Edit"],
            "_form" => ["general_information" => "General information"],
            "_html" => [
                "created_date" => "Creation date",
                "label" => "Label",
                "last_modified_date" => "Date of last modification",
                "username" => "Login"
            ],
            "_table_head" => ["action" => "Action", "file" => "File"],
            "_table_row_empty" => [
                "add_document" => "Add a document",
                "does_not_have_annex" => "does not have any annex",
                "the_contract" => "The contract"
            ],
            "create" => ["add_annex" => "Add an annex", "create" => "Create", "return" => "Back"],
            "edit" => ["edit" => "Edit", "register" => "Save", "return" => "Back"],
            "index" => ["add" => "Add", "annexes" => "Attachments"],
            "show" => ["return" => "Back"]
        ],
        "contract_document" => [
            "_breadcrumb" => ["create" => "Create", "documents" => "Documents", "edit" => "Edit"],
            "_form" => ["general_information" => "General information"],
            "_html" => [
                "created_date" => "Creation date",
                "label" => "Label",
                "last_modified_date" => "Date of last modification",
                "username" => "Username"
            ],
            "_table_head" => [
                "action" => "Action",
                "document" => "Document",
                "provider" => "Subcontractor",
                "status" => "Status"
            ],
            "_table_row_empty" => [
                "add_document" => "Add a document",
                "has_no_document" => "has no document",
                "the_contract" => "The contract"
            ],
            "create" => ["add_document" => "Add a document", "create" => "Create", "return" => "Back"],
            "edit" => ["edit" => "Edit", "register" => "Save", "return" => "Back"],
            "index" => ["add" => "Add", "documents" => "Documents"],
            "show" => ["return" => "Back"]
        ],
        "contract_party" => [
            "_actions" => [
                "dissociate_signer" => "Dissociate the signatory",
                "required_document" => "Required document",
                "signatory" => "Signatory"
            ],
            "_assign_signatory" => ["signatory" => "Signatory"],
            "_breadcrumb" => ["create" => "Create", "edit" => "Edit", "stakeholders" => "Stakeholders"],
            "_form" => [
                "declined" => "Declined",
                "declined_on" => "Declined on",
                "denomination" => "Denomination",
                "general_information" => "General information",
                "has_signed" => "Signed",
                "signatory" => "Signatory",
                "signed_on" => "Signed on"
            ],
            "_html" => [
                "created_date" => "Creation date",
                "label" => "Label",
                "last_modified_date" => "Date of last modification",
                "username" => "Username"
            ],
            "_signatory" => ["for" => "for"],
            "_status" => [
                "assign_signer" => "Assign a signatory",
                "at" => "the",
                "decline" => "Declined",
                "must_assign_signer" => "Must assign a signatory",
                "must_sign" => "Must sign",
                "sign" => "Signed",
                "status_unknown" => "Unknown status",
                "waiting" => "Pending"
            ],
            "_table_head" => [
                "actions" => "Actions",
                "denomination" => "Denomination",
                "documents_provided" => "Provided document ",
                "signatory" => "Signatory",
                "status" => "Status"
            ],
            "_table_row_empty" => [
                "add_stakeholder" => "Add a stakeholder",
                "has_no_stakeholder" => "has no stakeholder.",
                "the_contract" => "The contract"
            ],
            "assign_signatory" => ["assign" => "Assign", "edit" => "Edit", "return" => "Back"],
            "create" => [
                "add_stakeholder" => "Add a stakeholder",
                "create" => "Create",
                "denomination" => "Denomination",
                "enterprise" => "Company",
                "help_text" => "Example: 'The Service Provider' or 'The Subcontractor'",
                "my_enterprise" => "My Company",
                "return" => "Back"
            ],
            "edit" => ["edit" => "Edit", "register" => "Save", "return" => "Back"],
            "index" => ["add" => "Add", "stakeholders" => "Stakeholders"],
            "show" => ["return" => "Back"]
        ],
        "contract_party_document_type" => [
            "_actions" => [
                "associate_existing_document" => "Associate an existing document",
                "associate_new_document" => "Associate a new document",
                "detach_document" => "Detach the document"
            ],
            "_breadcrumb" => [
                "attach_document" => "Attach a document",
                "create" => "Create",
                "edit" => "Edit",
                "required_document" => "Required document "
            ],
            "_form" => [
                "mandatory" => "Mandatory",
                "properties" => "Settings",
                "validation_required" => "Required validation "
            ],
            "_html" => [
                "created_date" => "Creation date",
                "label" => "Label",
                "last_modified_date" => "Date of last modification",
                "username" => "Username"
            ],
            "_table_head" => [
                "actions" => "Actions",
                "dcoument" => "",
                "document" => "Document",
                "mandatory" => "Mandatory",
                "type" => "Type",
                "validation_required" => "Required validation "
            ],
            "_table_row_empty" => [
                "add_required_document" => "Add a required document",
                "has_no_document" => "has no document to provide.",
                "the_stakeholder" => "The stakeholder"
            ],
            "attach_existing_document" => [
                "associate" => "Associate",
                "associate_document" => "Associate a document",
                "document" => "Document",
                "return" => "Back"
            ],
            "attach_new_document" => [
                "associate_document" => "Associate a document",
                "create_and_associate" => "Create and associate",
                "document" => "Document",
                "return" => "Back"
            ],
            "create" => [
                "add_required_document" => "Add a required document",
                "create" => "Create",
                "return" => "Back",
                "type_of_document" => "Type of document",
                "types_of_document" => "Types of documents"
            ],
            "edit" => ["edit" => "Edit", "register" => "Save", "return" => "Back"],
            "index" => ["add" => "Add", "document_required_for" => "Required document for"],
            "show" => ["return" => "Back"]
        ],
        "contract_template" => [
            "_actions" => [
                "annexes" => "Attachments",
                "contracts" => "Contracts",
                "stakeholders" => "Stakeholders",
                "variables" => "Variables"
            ],
            "_breadcrumb" => [
                "contract_templates" => "Contract templates",
                "create" => "Create",
                "edit" => "Edit"
            ],
            "_form" => [
                "general_information" => "General information",
                "model" => "Template",
                "model_name" => "Template name"
            ],
            "_html" => [
                "created_date" => "Creation date",
                "deleted_date" => "Date of deletion",
                "label" => "Label",
                "last_modified_date" => "Date of last modification",
                "username" => "Username"
            ],
            "_table_head" => [
                "action" => "Action",
                "name_of_contract_template" => "Name of the contract template"
            ],
            "_table_row_empty" => [
                "create_contract_template" => "Create a contract template",
                "has_no_contract_template" => "has no contract template",
                "the_enterprise" => "The Company"
            ],
            "create" => [
                "create" => "Create",
                "create_contract_template" => "Create a contract template",
                "return" => "Back"
            ],
            "edit" => ["edit" => "Edit", "register" => "Save", "return" => "Back"],
            "index" => ["add" => "Add", "contract_templates" => "Contract templates"],
            "show" => ["return" => "Back"]
        ],
        "contract_template_annex" => [
            "_breadcrumb" => ["annexes" => "Attachments", "create" => "Create", "edit" => "Edit"],
            "_form" => ["general_information" => "General information"],
            "_html" => [
                "created_date" => "Creation date",
                "label" => "Label",
                "last_modified_date" => "Date of last modification",
                "username" => "Username"
            ],
            "_table_row_empty" => [
                "add_document" => "Add a document",
                "does_not_have_annex" => "does not have any annex",
                "the_template" => "The template"
            ],
            "create" => ["add_annex" => "Add an annex", "create" => "Create", "return" => "Back"],
            "edit" => ["edit" => "Edit", "return" => "Back"],
            "index" => ["add" => "Add", "annexes" => "Attachments"],
            "show" => ["return" => "Back"]
        ],
        "contract_template_party" => [
            "_actions" => ["documents_to_provide" => "Documents to provide"],
            "_breadcrumb" => ["create" => "Create", "edit" => "Edit", "stakeholders" => "Stakeholders"],
            "_form" => ["denomination" => "Denomination", "general_information" => "General information"],
            "_html" => [
                "created_date" => "Creation date",
                "label" => "Label",
                "last_modified_date" => "Date of last modification",
                "username" => "Username"
            ],
            "_table_head" => [
                "actions" => "Actions",
                "denomination" => "Denomination",
                "documents_to_provide" => "Documents to provide",
                "order" => "Order"
            ],
            "_table_row_empty" => [
                "add_stakeholder" => "Add a stakeholder",
                "has_no_stakeholder" => "has no stakeholder",
                "the_template" => "The template"
            ],
            "create" => ["add_stakeholder" => "Add a stakeholder", "create" => "Create", "return" => "Back"],
            "edit" => ["edit" => "Edit", "register" => "Save", "return" => "Back"],
            "index" => ["add" => "Add", "stakeholders" => "Stakeholders"],
            "show" => ["return" => "Back"]
        ],
        "contract_template_party_document_type" => [
            "_breadcrumb" => [
                "create" => "Create",
                "documents_to_provide" => "Documents to provide",
                "edit" => "Edit"
            ],
            "_form" => [
                "general_information" => "General information",
                "mandatory_document" => "Mandatory document",
                "type_of_document" => "Type of document",
                "validation_required" => "Required validation "
            ],
            "_html" => [
                "created_date" => "Creation date",
                "label" => "Label",
                "last_modified_date" => "Date of last modification",
                "username" => "Username"
            ],
            "_table_head" => [
                "actions" => "Actions",
                "document" => "Document",
                "mandatory" => "Mandatory",
                "validated_by" => "Validated by",
                "validation_required" => "Required validation "
            ],
            "_table_row_empty" => [
                "add_required_document" => "Add a required document",
                "does_not_require_document" => "does not require any document",
                "the_stakeholder" => "The stakeholder"
            ],
            "create" => [
                "add_document_to_provide" => "Add a document to provide",
                "create" => "Create",
                "return" => "Back"
            ],
            "edit" => ["edit" => "Edit", "register" => "Save", "return" => "Back"],
            "index" => ["add" => "Add", "documents_to_provide" => "Documents to provide"],
            "show" => ["return" => "Back"]
        ],
        "contract_template_variable" => [
            "_breadcrumb" => ["create" => "Create", "edit" => "Edit", "variables" => "Variables"],
            "_form" => ["general_information" => "General information"],
            "_html" => [
                "created_date" => "Creation date",
                "label" => "Label",
                "last_modified_date" => "Date of last modification",
                "username" => "Username"
            ],
            "_table_row_empty" => [
                "add_variable" => "Add a variable",
                "has_no_variables" => "has no variable",
                "the_template" => "The template"
            ],
            "create" => ["add_variable" => "Add a variable", "create" => "Create", "return" => "Back"],
            "edit" => ["edit" => "Edit", "register" => "Save", "return" => "Back"],
            "index" => ["add" => "Add", "variables" => "Variables"],
            "show" => ["return" => "Back"]
        ],
        "contract_variable" => [
            "_breadcrumb" => ["create" => "Create", "edit" => "Edit", "variables" => "Variables"],
            "_form" => ["general_information" => "General information"],
            "_html" => [
                "created_date" => "Creation date",
                "label" => "Label",
                "last_modified_date" => "Date of last modification",
                "username" => "Username"
            ],
            "_table_row_empty" => [
                "add_variable" => "Add a variable",
                "has_no_variables" => "has no variable",
                "the_contract" => "The Contract"
            ],
            "create" => ["add_variable" => "Add a variable", "create" => "Create", "return" => "Back"],
            "edit" => ["edit" => "Edit", "register" => "Save", "return" => "Back"],
            "index" => ["add" => "Add", "variables" => "Variables"],
            "show" => ["return" => "Back"]
        ]
    ],
    "emails" => [
        "enterprise" => [
            "document" => [
                "expires_soon" => [
                    "addworking_supports_guarantee" => "AddWorking supports you in order to guarantee your compliance with your Clients.",
                    "cordially" => "Regards,",
                    "hello" => "Hello!",
                    "inform_legal_text_plurial" => "In this context, we inform you that the following legal documents are expiring",
                    "inform_legal_text_singular" => "In this context, we inform you that the following legal document is fall due",
                    "team_signature" => "The AddWorking team",
                    "update_on_account" => "In order to secure relations with your Clients, please update it on your account.",
                    "update_on_account_button" => "I update my documents",
                    "valid_until" => "Valid until"
                ],
                "outdated" => [
                    "addworking_supports_guarantee" => "AddWorking supports you in order to guarantee your compliance with your Clients.",
                    "cordially" => "Regards,",
                    "hello" => "Hello!",
                    "inform_legal_text_plurial" => "In this context, we inform you that the following legal documents are expiring",
                    "inform_legal_text_singular" => "In this context, we inform you that the following legal document is fall due",
                    "team_signature" => "The AddWorking team",
                    "update_on_account" => "In order to secure relationships with your Clients, please update it on your account.",
                    "update_on_account_button" => "I update my documents",
                    "valid_until" => "Valid until"
                ]
            ],
            "vendor" => [
                "noncompliance" => [
                    "addworking_supports_guarantee" => "AddWorking supports you in ensuring the compliance of your subcontractors and service providers.",
                    "after_last_week" => "Since last week :",
                    "before_last_week" => "Before last week :",
                    "compliance_service" => "AddWorking Compliance Department",
                    "cordially" => "Regards,",
                    "hello" => "Hello,",
                    "inform_legal_text_plural" => "In this context, we inform you that the following accounts present a non-compliance likely to impact your contractual relationship",
                    "inform_legal_text_plurial" => "In this context, we inform you that the following accounts show a noncompliance likely to impact your contractual relationship",
                    "inform_legal_text_singular" => "In this context, we inform you that the following account show a noncompliance likely to impact your contractual relationship",
                    "log_in" => "Log in",
                    "reminder_compliance_email" => "As a reminder, the subcontractors have been notified and are reminded to update their profiles."
                ]
            ]
        ]
    ],
    "enterprise" => [
        "document" => [
            "_actions" => [
                "add_proof_authenticity" => "Add proof of authenticity",
                "download" => "Download",
                "download_proof_authenticity" => "Download proof of authenticity",
                "download_proof_authenticity_from_yousign" => "Download proof of signature",
                "edit_proof_authenticity" => "Modify proof of authenticity",
                "history" => "Follow-up",
                "remove_precheck" => "Remove the pre-check tag",
                "replace" => "Replace",
                "replacement_of_document" => "Sure to replace document?",
                "tag_in_precheck" => "Pre-check tag"
            ],
            "_form" => [
                "accept_by" => "Accepted by",
                "accept_it" => "Accepted on",
                "reject_by" => "Rejected by",
                "reject_on" => "Rejected on",
                "reject_reason" => "Rejection reason",
                "validity_end" => "End of validity",
                "validity_start" => "Start of validity"
            ],
            "_form_accept" => ["expiration_date" => "Expiration date"],
            "_form_create" => [
                "expiration_date" => "Expiration date",
                "files" => "File(s)",
                "publish_date" => "Release date"
            ],
            "_form_fields" => ["additional_fields" => "Additional fields"],
            "_form_reject" => ["refusal_reason" => "Refusal reason"],
            "_html" => [
                "address" => "Address",
                "by" => "by",
                "code" => "Code",
                "created_the" => "Created on",
                "customer_attached" => "Clients related to Subcontractor",
                "days" => "days",
                "delete_it" => "Deleted on",
                "document_owner" => "Document owner",
                "expiration_date" => "Expiration date",
                "further_information" => "Additional information",
                "legal_representative" => "Legal representatives",
                "modified" => "Modified on",
                "pattern" => "Reason",
                "publish_date" => "Release date",
                "registration_town" => "Town of registration",
                "reject_on" => "Rejected on",
                "signed_at" => "Signed on",
                "status" => "Status",
                "the" => "On",
                "tracking_document" => "Restarts follow-up",
                "type" => "Type",
                "username" => "Username",
                "valid" => "Validated",
                "validity_period" => "Validity period"
            ],
            "_status" => [
                "expired" => "Expired",
                "missing" => "Missing",
                "pending_signature" => "Awaiting signature",
                "precheck" => "Pre-checked",
                "refusal_comment" => "Refusal comment:",
                "rejected" => "Rejected",
                "valid" => "Validated",
                "waiting" => "Pending"
            ],
            "accept" => [
                "accept" => "Accept",
                "accept_document" => "Accept the document",
                "company" => "Company",
                "dashboard" => "Dashboard",
                "document" => "Document",
                "return" => "Back"
            ],
            "actions_history" => [
                "action" => "Action",
                "active" => "Active",
                "company" => "Company",
                "created_by" => "Made by",
                "dashboard" => "Dashboard",
                "date" => "Dated",
                "document" => "Document",
                "history" => "History",
                "no_result" => "No result",
                "return" => "Back"
            ],
            "create" => [
                "choose" => "Generate statement",
                "choose_model" => "Select sworn statement",
                "choose_model_for" => "Select a statement for ",
                "choose_model_sentence" => "You must select a statement to complete as a function of your situation.",
                "company" => "Companies",
                "create_document" => "Create the document",
                "create_document_2" => " of ",
                "dashboard" => "Dashboard",
                "date_of_file_is_not_valid" => "The document you have submitted has expired. Please send a current valid statement.",
                "document" => "Document",
                "message" => "I declare this document to be authentic and confirm that I have read article 441-7 of the Penal Code (below):",
                "record" => "Save",
                "return" => "Back",
                "scan_compliance_document_couldnt_read_security_code" => "Automatic recognition could not read the verification code at :time",
                "scan_compliance_document_couldnt_save_proof_of_authenticity" => "Security code not valid for retrieval of proof of authenticity at :time",
                "scan_compliance_document_couldnt_validate_security_code" => "Verification code not valid for approval of document at :time",
                "scan_compliance_document_error_occurred" => "",
                "scan_extract_kbis_document_couldnt_validate_address" => "",
                "scan_extract_kbis_document_couldnt_validate_company_name" => "",
                "scan_extract_kbis_document_couldnt_validate_end_of_extract" => "",
                "scan_extract_kbis_document_couldnt_validate_legal_form" => "",
                "scan_extract_kbis_document_couldnt_validate_town" => "",
                "scan_extract_kbis_document_has_validated_address" => "",
                "scan_extract_kbis_document_has_validated_company_name" => "",
                "scan_extract_kbis_document_has_validated_end_of_extract" => "",
                "scan_extract_kbis_document_has_validated_legal_form" => "",
                "scan_extract_kbis_document_has_validated_town" => "",
                "scan_urssaf_certificate_document_rejection" => "Automatic recognition could not approve the document at :time",
                "scan_urssaf_certificate_document_validation" => "Automatic recognition pre-checked the document at :time",
                "scan_urssaf_certificate_extracted_date_is_not_valid" => "Automatic recognition could not extract a valid date at :time",
                "scan_urssaf_certificate_extracted_date_is_valid" => "",
                "scan_urssaf_certificate_extractors_could_not_read_date" => "Automatic recognition could not read the document date at :time",
                "scan_urssaf_certificate_save_proof_of_authenticity" => "Proof of authenticity was taken at :time",
                "scan_urssaf_certificate_siren_is_not_valid" => "Automatic recognition detected that the document's SIREN/SIRET Nos. were different from the company's numbers at :time",
                "scan_urssaf_certificate_siren_is_valid" => "",
                "sentence_five" => "Penalties are up to 3 years? imprisonment and a ?45,000 fine for infringements against",
                "sentence_four" => "",
                "sentence_one" => "\"Article 441-7 of the Penal Code: Irrespective of the cases outlined in this chapter, the following act is punishable by one year's imprisonment and a ?15,000 fine:",
                "sentence_six" => "the TrÇsor Public (Treasury/Tax Office) or the assets of another, either for the purpose of obtaining a residence permit or benefiting from an anti-deportation order. \"",
                "sentence_three" => "",
                "sentence_two" => ""
            ],
            "edit" => [
                "active" => "Active",
                "company" => "Company",
                "dashboard" => "Dashboard",
                "document" => "Document",
                "modify" => "Edit",
                "record" => "Save",
                "return" => "Back"
            ],
            "expires_soon" => [
                "addworking_supports_guarantee" => "AddWorking supports you in order to guarantee your compliance with your customers.",
                "inform_legal_text" => "In this context, we inform you that the following legal document expires:",
                "inform_legal_text_general" => "In this context, we inform you that the following legal documents are expiring",
                "update_documents" => "I update my documents",
                "update_on_account" => "In order to secure relationships with your customers, please update it on your account.",
                "update_on_account_general" => "In order to secure relationships with your Clients, please update them on your account.",
                "validity_end" => "end of validity: on:"
            ],
            "history" => [
                "active" => "Active",
                "company" => "Company",
                "dashboard" => "Dashboard",
                "deleted" => "Deleted",
                "deletion_date" => "Deleted on",
                "deposit_date" => "Uploaded on",
                "document" => "Document",
                "expiration_date" => "Expiry date ",
                "history" => "History",
                "no_result" => "No result",
                "return" => "Back",
                "service_provider" => "Subcontractor",
                "state" => "State",
                "status" => "Status"
            ],
            "index" => [
                "action" => "Actions",
                "company" => "Company",
                "consult" => "View",
                "contract" => "Contract:",
                "dashboard" => "Dashboard",
                "deposit_date" => "Uploaded on",
                "document" => "Document(s) of",
                "document_name" => "Document Name",
                "documents" => "Documents",
                "documents_contractuels" => "Contract documents",
                "documents_contractuels_specifiques" => "Specific contract documents",
                "documents_legaux" => "Submit the legal documents requested by your Client,",
                "documents_metier" => "Business documents",
                "download_validated_documents" => "Download the validated documents",
                "enterprise_name" => "Relevant company",
                "expiration_date" => "Expiry date ",
                "expire_in" => "Expired since :days days",
                "no_document" => "No document",
                "status" => "Status"
            ],
            "proof_authenticity" => [
                "create" => [
                    "add_proof_authenticity" => "Add proof of authenticity",
                    "company" => "Company",
                    "dashboard" => "Dashboard",
                    "document" => "Document",
                    "record" => "Save",
                    "return" => "Back"
                ],
                "edit" => [
                    "company" => "Company",
                    "dashboard" => "Dashboard",
                    "document" => "Document",
                    "edit" => "Modify proof of authenticity",
                    "record" => "Save",
                    "return" => "Back"
                ],
                "proof_authenticity" => "Proof of authenticity"
            ],
            "reject" => [
                "comment" => "Comment",
                "company" => "Company",
                "dashboard" => "Dashboard",
                "decline_document" => "Refuse the document",
                "document" => "Document",
                "refuse" => "Refuse",
                "return" => "Back"
            ],
            "rejected" => [
                "addworking_supports_guarantee" => "AddWorking supports you in order to guarantee your compliance towards your Clients.",
                "cordially" => "Regards,",
                "greeting" => "Hello,",
                "inform_legal_text" => "In this context, we inform you that the document",
                "pattern" => "Reason",
                "please_update_account" => "Please update it on your account.",
                "show_non_compliance" => "shows non-compliance.",
                "update_documents" => "I update my documents"
            ],
            "show" => [
                "accept" => "Accept",
                "code" => "Code",
                "company" => "Company",
                "dashboard" => "Dashboard",
                "document" => "Document",
                "no_file" => "No file available",
                "pre_validate" => "Pre-validate",
                "proof_authenticity" => "Proof of authenticity",
                "refuse" => "Refuse",
                "return" => "Back",
                "type" => "Type"
            ],
            "show_model" => [
                "add_documents" => "This statement requires documents to be submitted before it can be signed",
                "company" => "Company",
                "dashboard" => "Dashboard",
                "document" => "Documents",
                "no_file" => "No corresponding file",
                "return" => "Back",
                "sign" => "Sign",
                "sign_sentence" => "Please check the accuracy of the information in this statement before signing."
            ],
            "tracking" => [
                "create_document_type" => "Document :document_type_name submitted",
                "expire" => "Document :doc_type_name from :enterprise_name has expired",
                "expired" => ":user_name has been notified that their document :doc_type_name will expire in :expire_in days",
                "expired_many_users" => "Compliance managers have been notified that the document :doc_type_name will expire in :expire_in days",
                "outdated" => ":user_name has been notified that the submitted document :doc_type_name has expired",
                "outdated_many_users" => "Compliance managers have been notified that the submitted document :doc_type_name has expired",
                "reject" => "Document :document_type_name rejected",
                "reject_notification" => "Rejection notice sent",
                "validate" => "Document :document_type_name approved"
            ]
        ],
        "document_collection" => [
            "_status" => [
                "all_document_valid" => "All documents are valid",
                "atleast_one_document_non_compliant" => "At least one document is non-compliant",
                "atleast_one_document_out_dated" => "At least one document is expired",
                "atleast_one_document_pending" => "At least one document is pending",
                "no_document_received" => "No document received"
            ]
        ],
        "document_type" => [
            "_actions" => [
                "add_to_folder" => "Add to folder",
                "consult" => "See",
                "document_type_model" => "Sworn statements",
                "edit" => "Edit",
                "reject_reason_index" => "Reason for rejection",
                "remove" => "Remove"
            ],
            "_add_model" => ["add_modify_template" => "Add/Edit template", "file" => "File"],
            "_form" => [
                "country_document" => "Country",
                "customer" => "Customer",
                "deadline_date" => "Validity expiration date (inclusive)",
                "document_code" => "Document Code",
                "document_description" => "Document description",
                "document_name" => "Document Name",
                "document_template" => "Template",
                "document_type" => "Document Type",
                "enter_document_description" => "Please describe the document....",
                "example_driver_name" => "Example: Driving license",
                "exmaple_dmpc_v0" => "Example: DMPC_V0",
                "is_automatically_generated" => "Check this box if the document needs an auto-generated sworn statement",
                "is_mandatory" => "Mandatory document",
                "need_proof_authenticity" => "Check this box if the document needs proof of authenticity",
                "needs_validation" => "Checker of document compliance",
                "request_document" => "Request ",
                "support" => "Support",
                "validity_period" => "Validity period",
                "validity_period_days" => "Validity period in days"
            ],
            "_html" => [
                "created_at" => "Created on",
                "customer" => "Customer",
                "days" => "day(s)",
                "deadline_date" => "Validity expiration date (inclusive)",
                "delete_it" => "Deleted on",
                "document_template" => "Template",
                "legal_forms" => "Authorized Legal Forms",
                "mandatory" => "Mandatory",
                "modified" => "Modified on",
                "no" => "No",
                "possible_validation_by" => "Approval possible by:",
                "support" => "Support",
                "yes" => "Yes"
            ],
            "_summary" => [
                "ask_by" => "requested by",
                "business" => "Business document",
                "contractual" => "Contract document",
                "download_model" => "Download the template",
                "informative" => "Information document",
                "job" => "",
                "legal" => "legal",
                "mandatory" => "Mandatory",
                "optional" => "optional"
            ],
            "_table_row" => [
                "add" => "Add",
                "replace" => "Replace",
                "replacement_of_document" => "Confirm replacement ?"
            ],
            "create" => [
                "company" => "Company",
                "create" => "Create",
                "create_document" => "Create the document",
                "create_new_document" => "Create a new document",
                "dashboard" => "Dashboard",
                "document_type_management" => "Documents types management",
                "return" => "Back"
            ],
            "edit" => [
                "company" => "Company",
                "dashboard" => "Dashboard",
                "document_type_management" => "Documents types management",
                "edit" => "Edit",
                "edit_document" => "Edit document",
                "return" => "Back"
            ],
            "index" => [
                "add" => "Add",
                "dashboard" => "Dashboard",
                "document_list" => "Documents list to provide for",
                "document_type_management" => "Documents types management",
                "mandatory" => "Mandatory",
                "missing_documents_before_sign_contract" => "Documents needed to be able to sign your contract are missing.",
                "return" => "Back"
            ],
            "show" => [
                "add_field" => "Add a field",
                "add_modify_template" => "Add/Edit template",
                "company" => "Company",
                "dashboard" => "Dashboard",
                "document_type_management" => "Documents types management",
                "general_information" => "General information"
            ]
        ],
        "document_type_field" => [
            "_create" => [
                "add_modify_field" => "Add/Edit field",
                "bubble_info" => "Bubble info",
                "filed_name" => "Field name",
                "filed_type" => "Field type",
                "required_filed" => "Required field"
            ],
            "_edit" => [
                "bubble_info" => "Bubble info",
                "edit_field" => "Edit field",
                "filed_name" => "Field name",
                "filed_type" => "Field type",
                "required_filed" => "Required field"
            ]
        ],
        "enterprise" => [
            "_actions" => [
                "accounting_expense" => "Accounting options",
                "addworking_invoice" => "AddWorking invoices",
                "billing_settings" => "Invoicing settings",
                "consult_contract" => "Contracts",
                "consult_document" => "Documents",
                "consult_invoice" => "Invoices",
                "consult_passwork" => "Passwork",
                "contract_mockups" => "Contract Templates",
                "contracts" => "Contracts",
                "customer_invoice" => "",
                "customer_invoice_beta" => "",
                "document_management" => "Documents management",
                "documents" => "Documents",
                "edenred_codes" => "Edenred codes",
                "files" => "Files",
                "invoicing" => "Billing",
                "membership_management" => "Members management",
                "passworks" => "Passworks",
                "payment" => "Payment",
                "payment_order" => "Issued Payments ",
                "providers" => "Subcontractors",
                "purchase_order" => "Purchase Orders",
                "received_payments" => "Received Payments",
                "refer_service_provider" => "Index a Subcontractor",
                "refer_user" => "Index a User",
                "resource_management" => "Workforce management",
                "service_provider_invoices" => "Subcontractor Invoices",
                "sites" => "Sites",
                "subsidiaries" => "Subsidiaries",
                "trades" => "Services"
            ],
            "_activities" => ["employee" => "employee(s)"],
            "_badges" => ["client" => "Client", "service_provider" => "Subcontractor"],
            "_breadcrumb" => ["companies" => "", "dashboard" => "Dashboard", "enterprise" => "Companies"],
            "_departments" => ["intervention_department" => "Local areas of activity"],
            "_form" => [
                "business_plus" => "Business +",
                "business_plus_message" => "Business +: customers can allow their subcontractors to submit their invoices for viewing",
                "collect_business_turnover" => "Collect turnover",
                "company_name" => "Company name",
                "company_registered_at" => "Company incorporated in",
                "contractualization_language" => "Please select the desired contract language?",
                "country" => "Country",
                "external_identifier" => "External ID",
                "general_information" => "General information",
                "legal_form" => "Legal form",
                "main_activity_code" => "Main Activity Code (French \"APE\" code)",
                "registration_date" => "Company incorporated on",
                "siren_14_digit_help" => "This is a 14-digit identifier composed by the French SIREN number (9 digits) and NIC number (5 digits).",
                "siret_number" => "French SIRET number (14 digits) / Company register number",
                "social_reason" => "Business Name",
                "structure_created" => "Being created?",
                "vat_number" => "VAT No."
            ],
            "_form_disabled_inputs" => [
                "company_name" => "Company name",
                "company_registered_at" => "Company incorporated in",
                "contact_support" => "Please contact our Support team to update the general information of your company",
                "external_identifier" => "External ID",
                "general_information" => "General information",
                "legal_form" => "Legal form",
                "main_activity_code" => "Main Activity Code (French \"APE\" code)",
                "siren_14_digit_help" => "This is a 14-digit identifier composed by the French SIREN number (9 digits) and NIC number (5 digits).",
                "siret_number" => "French SIRET number (14 digits) / Company register number",
                "social_reason" => "Business Name",
                "structure_created" => "Being created?",
                "vat_number" => "VAT No."
            ],
            "_html" => [
                "activity" => "Activity",
                "activity_department" => "Local areas of activity",
                "add_one" => "add one",
                "address" => "Address",
                "affiliate" => "Subsidiary of",
                "applicable_vat" => "Applicable VAT",
                "client_id" => "Client ID",
                "created_the" => "Created on",
                "customer" => "Customer",
                "iban" => "IBAN",
                "id" => "Identifier",
                "legal_representative" => "Legal representatives",
                "main_activity_code" => "Main Activity Code (French \"APE\" code)",
                "modified" => "Modified on",
                "no_logo" => "No logo yet",
                "number" => "Number",
                "phone_number" => "Phone numbers",
                "registration_town" => "Registered at",
                "sectors" => "Sectors",
                "siret" => "SIRET",
                "social_reason" => "Business Name",
                "type" => "Type",
                "vat_number" => "VAT Number"
            ],
            "_iban" => ["cannot_see_company_iban" => "You can't see this company's IBAN"],
            "_index_form" => [
                "all_companies" => "All companies",
                "hybrid" => "Hybrid",
                "providers" => "Subcontractors",
                "subsidiaries" => "Subsidiaries"
            ],
            "_type" => ["customer" => "Customer", "service_provider" => "Subcontractor"],
            "create" => [
                "activity" => "Activity",
                "address_line_1" => "Address line 1",
                "address_line_2" => "Address line 2",
                "ape_code_help" => "The French APE code (company main activity) is made up of 4 digits + 1 letter",
                "city" => "City",
                "company_activity" => "Company's activity",
                "contact" => "Contact",
                "country" => "Country",
                "create" => "Create",
                "create_company" => "Create Company",
                "dashboard" => "Dashboard",
                "department" => "Local area",
                "department_help" => "You can choose several local areas by holding down the [Ctrl] key on your keyboard.",
                "enterprise" => "Companies",
                "job_title_in_company" => "What is your role at your company?",
                "main_address" => "Main address",
                "note" => "Note",
                "number_of_employees" => "Number of employees",
                "postal_code" => "Zip code",
                "return" => "Back",
                "sector" => "Sector of activity",
                "start_new_business" => "Create a new company",
                "telephone_1" => "Phone line 1",
                "telephone_2" => "Phone line 2",
                "telephone_3" => "Phone line 3",
                "user_job_title" => "Role within company"
            ],
            "edit" => [
                "activity" => "Activity",
                "address_line_1" => "Address line 1",
                "address_line_2" => "Address line 2",
                "business_type" => "Company type(s)",
                "choice_legal_representative" => "Choose legal representative and signatory",
                "city" => "City",
                "dashboard" => "Dashboard",
                "legal_representative" => "Legal representative",
                "main_address" => "Main address",
                "modifier" => "Edit",
                "postal_code" => "Zip code",
                "record" => "Save",
                "return" => "Back",
                "sectors" => "Sectors",
                "service_provider" => "Subcontractor",
                "sign" => "Signatory"
            ],
            "index" => [
                "actions" => "Actions",
                "activity" => "Activity",
                "add" => "Add",
                "company" => "Companies",
                "create" => "Create",
                "created" => "Created on",
                "customer" => "Customer",
                "dashboard" => "Dashboard",
                "enterprise" => "Company",
                "filter" => [
                    "activity" => "Activity",
                    "activity_field" => "Sector of activity",
                    "identification_number" => "SIRET or SIREN",
                    "legal_form" => "Legal form",
                    "legal_representative" => "Legal representative",
                    "main_activity_code" => "Main Activity Code (French \"APE\" code)",
                    "name" => "Company name",
                    "phone" => "Telephone number",
                    "reinitialize" => "Reset",
                    "type" => "Type",
                    "zip_code" => "Zip code"
                ],
                "hybrid" => "Hybrid",
                "identification_number" => "SIRET",
                "leader" => "Head",
                "legal_form" => "Legal form",
                "legal_representative" => "Legal representative",
                "main_activity_code" => "Local Activity Code",
                "name" => "Name",
                "phone" => "Phone",
                "return" => "Back",
                "service_provider" => "Subcontractor",
                "society" => "Company",
                "type" => "Type",
                "update" => "Updated on",
                "vendor" => "Subcontractor"
            ],
            "language" => ["english" => "English", "french" => "French", "german" => "German"],
            "requests" => [
                "store_enterprise_request" => [
                    "messages" => [
                        "unique" => "The entered SIRET number already exists. Please check that your company has not already been created in AddWorking by a member of your team."
                    ]
                ]
            ],
            "show" => [
                "business_turnover" => "Annual turnover",
                "dashboard" => "Dashboard",
                "enterprise" => "Company",
                "general_information" => "General information",
                "phone_number" => "Phone numbers",
                "providers" => "Subcontractors",
                "return" => "Back",
                "sogetrel_data" => "Sogetrel data"
            ],
            "tabs" => [
                "_business_turnover" => [
                    "amount" => "Turnover",
                    "business_turnover" => "",
                    "created_by_name" => "Declared by",
                    "no_activity" => "No turnover",
                    "no_activity_message" => "(has declared that there has been no turnover this year)",
                    "year" => "Year"
                ],
                "_phone_number" => [
                    "action" => "Actions",
                    "add" => "Add",
                    "date_added" => "Added on",
                    "note" => "Notes",
                    "phone_number" => "Phone number"
                ],
                "_sogetrel_data" => [
                    "edit_oracle_id" => "Modify Oracle ID",
                    "group_counted_march" => "Group Accounts Department - \"Market\"",
                    "no" => "No",
                    "product_accounting_group" => "Group Accounts Department - \"Product\"",
                    "record" => "Save",
                    "sent_navibat" => "Sent to Navibat",
                    "vat_group_accounting" => "Group Accounts Department - \"Market\" - VAT",
                    "yes" => "Yes"
                ],
                "_vendor" => [
                    "company" => "Company",
                    "legal_representative" => "Legal representative",
                    "provide_since" => "Subcontractor since"
                ]
            ]
        ],
        "enterprise_activity" => [
            "_form" => [
                "enterprise_activity_help" => "Example: Commerce, Catering, Personal Care Services, etc.",
                "select_multiple_departments_help" => "Hold the CTRL key on your keyboard down  in order to choose several local areas at once"
            ],
            "create" => [
                "create" => "Create",
                "create_company" => "Create Company",
                "dashboard" => "Dashboard",
                "general_information" => "General information",
                "return" => "Back"
            ],
            "edit" => [
                "company_activity" => "Company's activity",
                "modify_activity" => "Edit Company's activity"
            ]
        ],
        "enterprise_signatory" => [
            "_form" => [
                "director" => "Director",
                "function_legal_representative" => "Legal representative's function",
                "legal_representative" => "Legal representative",
                "quality_legal_representative" => "Legal representative's position",
                "signatory_contracts" => "Contracts Signatory"
            ]
        ],
        "enterprise_subsidiaries" => [
            "create" => [
                "create" => "Create",
                "create_subsidiary" => "Create a subsidiary of",
                "dashboard" => "Dashboard",
                "return" => "Back",
                "subsidiaries" => "Subsidiaries"
            ],
            "index" => [
                "create_subsidiary" => "Create a subsidiary of",
                "dashboard" => "Dashboard",
                "return" => "Back",
                "subsidiaries" => "Subsidiaries",
                "subsidiaries_of" => "Subsidiaries of"
            ]
        ],
        "enterprise_vendors" => [
            "_actions" => [
                "dereference" => "Deregister",
                "see_documents" => "See his documents",
                "see_passwork" => "See his passwork",
                "see_passworks" => "See his passworks"
            ]
        ],
        "iban" => [
            "_actions" => ["actions" => "Actions", "download" => "Download", "replace" => "Replace"],
            "_form" => [
                "bank_code" => "Bank code (BIC or SWIFT)",
                "label" => "Label",
                "rib_account_statement" => "Bank Account details"
            ],
            "_html" => ["download" => "Download", "status" => "Status"],
            "create" => [
                "company_iban" => "Company's IBAN",
                "dashboard" => "Dashboard",
                "enterprise" => "Company",
                "general_information" => "General information",
                "record" => "Save",
                "return" => "Back"
            ],
            "show" => [
                "check_mailbox" => "Please check your email inbox",
                "company_iban" => "Company's IBAN",
                "dashboard" => "Dashboard",
                "enterprise" => "Company",
                "iban_awaiting_confirmation" => "your IBAN's confirmation is pending",
                "label" => "Description",
                "resend_confirmation_email" => "Resend the confirmation email",
                "title" => "Company's IBAN "
            ]
        ],
        "invitation" => [
            "_actions" => ["consult" => "See", "revive" => "Contact again"],
            "_index_form" => [
                "accepted" => "Accepted",
                "all_invitations" => "All invitations",
                "in_progress" => "Awaiting confirmation ",
                "pending" => "Pending delivery",
                "rejected" => "Expired / Rejected"
            ],
            "_invitation_status" => [
                "accepted" => "Accepted",
                "in_progress" => "Awaiting confirmation ",
                "pending" => "Pending delivery",
                "rejected" => "Expired / Rejected"
            ],
            "_invitation_types" => ["member" => "User", "mission" => "Work", "vendor" => "Subcontractor"],
            "_table_head" => [
                "actions" => "Actions",
                "email" => "Email",
                "guest" => "Guest",
                "status" => "Status",
                "type" => "Type"
            ],
            "index" => [
                "dashboard" => "Dashboard",
                "enterprise" => "Company",
                "expire" => "Expires on :date",
                "expired" => "Expired",
                "index_relaunch" => "Contact again in batches",
                "invite_member" => "Invite a member",
                "invite_provider" => "Invite a Subcontractor",
                "my_invitations" => "My Invitations",
                "of" => "of",
                "return" => "Back"
            ],
            "show" => [
                "dashboard" => "Dashboard",
                "enterprise" => "Company",
                "expired_on" => "Expired on",
                "expires_on" => "Expires on",
                "guest" => "Guest",
                "invitation_for" => "Invitations for",
                "my_invitations" => "My Invitations",
                "return" => "Back",
                "revive" => "Contact again",
                "status" => "Status",
                "type" => "Type"
            ]
        ],
        "legal_form" => [
            "_form" => [
                "acronym" => "Acronym",
                "general_information" => "General information",
                "wording" => "Label"
            ],
            "_html" => [
                "acronym" => "Acronym",
                "creation_date" => "Creation date",
                "last_modification_date" => "Date of last modification",
                "username" => "Login",
                "wording" => "Label"
            ],
            "create" => [
                "create" => "Create",
                "create_legal_form" => "Create a legal form",
                "dashboard" => "Dashboard",
                "legal_form" => "Legal form",
                "return" => "Back"
            ],
            "edit" => [
                "dashboard" => "Dashboard",
                "edit" => "Edit",
                "legal_form" => "Legal form",
                "record" => "Save",
                "return" => "Back"
            ],
            "index" => [
                "acronym" => "Acronym",
                "add" => "Add",
                "dashboard" => "Dashboard",
                "legal_form" => "Legal form",
                "wording" => "Label"
            ],
            "show" => ["dashboard" => "Dashboard", "legal_form" => "Legal form", "return" => "Back"]
        ],
        "member" => [
            "_actions" => [
                "assign_provider" => "Assign Subcontractors",
                "confirm_delisting_of_member" => "Confirm deregister this member?",
                "consult" => "See",
                "dereference" => "Deregister",
                "edit" => "Edit"
            ],
            "_form" => [
                "access_application" => "Access the App",
                "fonction" => "Function",
                "general_information" => "General information",
                "general_project_manager" => "(CEO, Project Manager, Intern, etc.)",
                "is_accounting_monitoring" => "Contract accounting follow-up",
                "is_admin" => "Administrator",
                "is_allowed_to_invite_vendors" => "Can invite subcontractors",
                "is_allowed_to_send_contract_to_signature" => "Can send contracts for signature",
                "is_allowed_to_view_business_turnover" => "Can view subcontractors' turnover declarations",
                "is_customer_compliance_manager" => "Subcontractor compliance manager",
                "is_financial" => "Financial",
                "is_legal_representative" => "Legal representative",
                "is_mission_offer_broadcaster" => "Can publish work offers",
                "is_mission_offer_closer" => "Can conclude work offers",
                "is_operator" => "Operator",
                "is_readonly" => "Observer",
                "is_signatory" => "Signatory",
                "is_vendor_compliance_manager" => "Customer compliance manager",
                "is_work_field_creator" => "Can create a site",
                "role" => "Roles",
                "role_contract_creator" => "Can create a contract"
            ],
            "_member_accesses" => ["access" => "Access "],
            "_table_head" => ["access" => "Access ", "last_name" => "Name"],
            "create" => [
                "dashboard" => "Dashboard",
                "platform_user" => "Platform Users",
                "record" => "Save",
                "refer_user" => "Index a User",
                "return" => "Back",
                "users" => "Users"
            ],
            "edit" => [
                "company_members" => "Company members",
                "dashboard" => "Dashboard",
                "edit" => "Edit",
                "record" => "Save",
                "return" => "Back"
            ],
            "index" => [
                "company_members" => "Company members",
                "dashboard" => "Dashboard",
                "invite_member" => "Invite a member",
                "refer_user" => "Index a User",
                "return" => "Back"
            ],
            "invitation" => [
                "accept" => "Accept",
                "accept_invitation" => "To accept the invitation, simply click on the button below.",
                "copy_paste_url" => "You can also copy and paste one of the following URL into your browser's address bar to:",
                "create" => [
                    "dashboard" => "Dashboard",
                    "invite" => "Invite",
                    "invite_member" => "Invite a member",
                    "my_invitations" => "My Invitations",
                    "return" => "Back",
                    "user_invite" => "User to invite"
                ],
                "exchanges_with_subcontractors" => "AddWorking supports you in the digitalization of your exchanges with your subcontractors and service providers.",
                "greeting" => "Hello,",
                "i_accept_invitation" => "I accept the invitation",
                "invitation_to_join" => "You have been invited to join the company",
                "need_support" => "Need support in getting started with the tool? Do not hesitate to contact us!",
                "notification" => [
                    "accept" => "Accept",
                    "accept_invitation" => "To accept the invitation, simply click on the button below.",
                    "copy_paste_url" => "You can also copy and paste one of the following URLs into your browser's address bar to:",
                    "exchanges_with_subcontractors" => "AddWorking supports you in the digitalization of your exchanges with your Subcontractors and Service providers.",
                    "greeting" => "Hello,",
                    "i_accept_invitation" => "I accept the invitation",
                    "invitation_to_join" => "You have been invited to join the company",
                    "need_support" => "Need support in getting started with the tool? Do not hesitate to contact us!",
                    "refuse" => "Refuse",
                    "see_you_soon" => "Looking forward to hearing from you soon!",
                    "team_addworking" => "The AddWorking team"
                ],
                "refuse" => "Refuse",
                "review" => ["join_company" => "Join the Company", "rejoin" => "Join"],
                "see_you_soon" => "Looking forward to hearing from you soon!",
                "team_addworking" => "The AddWorking team"
            ],
            "show" => [
                "access" => "Access ",
                "access_company_information" => "See company's information",
                "access_company_user" => "See company's users",
                "access_contracts" => "See Contracts",
                "access_invoicing" => "See Invoicing",
                "access_mission" => "See Works",
                "access_purchase_order" => "See Purchase Orders",
                "become_member" => "Became member",
                "company_members" => "Company's members",
                "contact" => "Contact",
                "dashboard" => "Dashboard",
                "edit" => "Edit",
                "identity" => "Identity",
                "return" => "Back",
                "title" => "Title",
                "to_log_in" => "Log in"
            ]
        ],
        "membership_request" => [
            "create" => [
                "associate_user_with_company" => "Link a User to the Company",
                "create_association" => "Create the link"
            ]
        ],
        "phone_number" => [
            "create" => [
                "add_phone_number" => "Add a phone number to",
                "dashboard" => "Dashboard",
                "phone" => "Phone",
                "phone_number" => "Phone number",
                "record" => "Save",
                "return" => "Back"
            ]
        ],
        "referent" => [
            "_form_assigned_vendors" => [
                "general_information" => "General information",
                "provider_of" => "Subcontractors of"
            ],
            "edit_assigned_vendors" => [
                "assigned_by" => "Assigned by",
                "assigned_providers_list" => "List of assigned Subcontractors",
                "company_members" => "Company's members",
                "dashboard" => "Dashboard",
                "modify_assigned_providers" => "Edit the list of assigned Subcontractors",
                "record" => "Save",
                "return" => "Back"
            ]
        ],
        "site" => [
            "_actions" => ["to_consult" => "See"],
            "create" => [
                "address_line_1" => "Address line 1",
                "address_line_2" => "Address line 2",
                "analytical_code" => "Analytical code",
                "city" => "City",
                "create_new_site" => "Create a new site",
                "create_site" => "Create a site",
                "create_sites" => "Create sites",
                "dashboard" => "Dashboard",
                "general_information" => "General information",
                "last_name" => "Name",
                "main_address" => "Main address",
                "postal_code" => "Zip code",
                "return" => "Back",
                "telephone_1" => "Phone line 1",
                "telephone_2" => "Phone line 2",
                "telephone_3" => "Phone line 3"
            ],
            "edit" => [
                "address_line_1" => "Address line 1",
                "address_line_2" => "Address line 2",
                "analytical_code" => "Analytical code",
                "city" => "City",
                "dashboard" => "Dashboard",
                "edit" => "Edit",
                "edit_site" => "Edit site",
                "general_information" => "General information",
                "last_name" => "Last Name",
                "main_address" => "Main address",
                "postal_code" => "Zip code",
                "record" => "Save",
                "return" => "Back"
            ],
            "index" => [
                "add" => "Add",
                "address" => "Address",
                "company_sites" => "Company sites",
                "created_the" => "Created on",
                "dashboard" => "Dashboard",
                "last_name" => "Last Name",
                "phone" => "Phone",
                "return" => "Back"
            ],
            "phone_number" => [
                "create" => [
                    "add_phone_number" => "Add a phone number to",
                    "dashboard" => "Dashboard",
                    "phone" => "Phone",
                    "phone_number" => "Phone number",
                    "record" => "Save",
                    "return" => "Back"
                ]
            ],
            "show" => [
                "" => "",
                "add" => "Add",
                "address" => "Address",
                "analytical_code" => "Analytical code",
                "dashboard" => "Dashboard",
                "date_added" => "Added on",
                "general_information" => "General information",
                "phone_number" => "Phone number",
                "phone_numbers" => "Phone numbers",
                "remove" => "Remove",
                "return" => "Back"
            ]
        ],
        "vendor" => [
            "_actions" => [
                "action" => "Actions",
                "billing_options" => "Invoicing options",
                "confirm_delisting_of_service_provider" => "Sure to deregister this Subcontractor?",
                "consult_contract" => "Check Contracts",
                "consult_document" => "Check Documents",
                "consult_invoice" => "Check Invoices",
                "consult_passwork" => "Check Passwork",
                "dereference" => "Deregister"
            ],
            "attach" => [
                "dashboard" => "Dashboard",
                "general_information" => "General information",
                "list_prestataries" => "List of subcontractors",
                "record" => "Save",
                "referencing_providers" => "Index Subcontractors for",
                "return" => "Back"
            ],
            "billing_deadline" => [
                "edit" => [
                    "dashboard" => "Dashboard",
                    "my_providers" => "My Subcontractors",
                    "payment_deadline" => "Payment deadline",
                    "payment_terms" => "Setting up Payment deadlines for",
                    "record" => "Save",
                    "return" => "Back",
                    "setting" => "Setting"
                ],
                "index" => [
                    "active" => "Active",
                    "creation_date" => "Created on",
                    "dashboard" => "Dashboard",
                    "edit" => "Edit",
                    "inactive" => "Inactive",
                    "my_providers" => "My Subcontractors",
                    "number_of_days" => "Number of days",
                    "payment_deadline" => "Payment deadline",
                    "payment_due_for" => "Payment deadline for",
                    "return" => "Back",
                    "wording" => "Label"
                ]
            ],
            "detached" => ["by" => "By", "dereferenced" => "has been deregistered from the Company"],
            "import" => [
                "csv_file" => "CSV File",
                "dashboard" => "Dashboard",
                "import" => "Import",
                "import_providers" => "Subcontractors import",
                "my_providers" => "My Subcontractors"
            ],
            "index" => [
                "action" => "Actions",
                "active" => "Active",
                "activity_status" => "Status",
                "business_documents_compliance" => "Professional Documents Compliance",
                "complaint_service_provider" => "Compliant Subcontractor",
                "dashboard" => "Dashboard",
                "dedicated_resources" => "Dedicated workforce",
                "division_by_skills" => "Division by skills",
                "enterprise" => "Enterprise",
                "export" => "Export",
                "import" => "Import",
                "inactive" => "Inactive",
                "leader" => "Head",
                "legal_documents_compliance" => "Legal documents Compliance",
                "my_providers" => "My Subcontractors",
                "non_complaint_service_provider" => "Non-compliant Subcontractor",
                "onboarding_completed" => "Onboarding completed",
                "onboarding_inprogress" => "Onboarding in progress",
                "onboarding_non_existent" => "Nonexistent onboarding",
                "onboarding_status" => "Onboarding status",
                "return" => "Back",
                "see_only_assigned_providers" => "See only my assigned Subcontractors",
                "society" => "Society"
            ],
            "index_division_by_skills" => [
                "breadcrumb" => [
                    "dashboard" => "Dashboard",
                    "division_by_skills" => "Division by skills",
                    "enterprise" => "Companies",
                    "my_vendors" => "My Subcontractors"
                ],
                "jobs_catalog_button" => "Jobs catalog",
                "return_button" => "Back",
                "table_head" => ["job" => "Job", "skill" => "Skill", "vendors" => "Number of subcontractors"],
                "table_row_empty" => "This Company does not benchmark skills.",
                "title" => "Division by skills"
            ],
            "invitation" => [
                "accept" => "Accept",
                "accept_invitation" => "Accept the invitation by clicking on the button below,",
                "access_from_account" => "accessible from your AddWorking account",
                "and_its_done" => "And it's already over!",
                "company_information" => "Please enter your company's information",
                "copy_paste_url" => "",
                "create" => [
                    "dashboard" => "Dashboard",
                    "invite" => "Invite",
                    "invite_several_providers_once" => "In order to invite several Subcontractors at once, you must put an email per line as below",
                    "my_invitations" => "My Invitations",
                    "provider1" => "Subcontractor 1",
                    "provider2" => "Subcontractor 2",
                    "provider3" => "Subcontractor 3",
                    "provider4" => "Subcontractor 4",
                    "provider5" => "Subcontractor 5",
                    "provider_invitation" => "Subcontractor invitation",
                    "return" => "Back",
                    "service_provider_information" => "Information related to the Subcontractor's invitation",
                    "user_invite" => "User(s) to invite"
                ],
                "greeting" => "Hello,",
                "i_accept_invitation" => "I accept the invitation",
                "instant_messaging" => "Instant messaging",
                "legal_documents" => "Submit the legal documents requested by your Client,",
                "notification" => [
                    "accept" => "Accept",
                    "accept_invitation" => "Accept the invitation by clicking on the button below,",
                    "access_from_account" => "accessible from your AddWorking account",
                    "and_its_done" => "And it's already over!",
                    "company_information" => "Please enter your company's information,",
                    "copy_paste_url" => "You can also copy and paste one of the following URLs into your browser's address bar to:",
                    "email" => "Email",
                    "greeting" => "Hello,",
                    "have_questions" => "Any questions? Our Support team is here to help you",
                    "i_accept_invitation" => "I accept the invitation",
                    "instant_messaging" => "Instant messaging",
                    "legal_documents" => "Submit the legal documents requested by your Client,",
                    "our_app" => "Our App, easy-to-use and accessible on all media, simplifies the relationship with your Client, while ensuring your compliance.",
                    "phone" => "Phone",
                    "refuse" => "Refuse",
                    "register_free" => "To register, it's very easy (and free)!",
                    "team_addworking" => "The AddWorking team",
                    "title" => "Your customer :client_name wants to list you in the AddWorking app",
                    "welcome" => "Welcome to AddWorking!",
                    "wish_to_reference" => "would like to add you on AddWorking. Congratulations!"
                ],
                "our_app" => "",
                "questions" => "Any questions? Our Support team is here to help you",
                "refuse" => "",
                "register_free" => "",
                "review" => [
                    "become_provider" => "Become a Subcontractor of",
                    "choose_company" => "Choose a Company",
                    "create_account" => "Create my account"
                ],
                "team_addworking" => "AddWorking team",
                "telephone" => "",
                "welcome" => "",
                "wish_to_reference" => ""
            ],
            "invitation_create" => [
                "dashboard" => "Dashboard",
                "invite_provider" => "Invite a Subcontractor",
                "invite_provider_join_client" => "Invite a Subcontractor to join the Client",
                "my_invitations" => "My Invitations"
            ],
            "noncompliance" => [
                "addworking_supports_guarantee" => "AddWorking supports you in order to guarantee your compliance with your Clients.",
                "compliance_service" => "",
                "consult_documents" => "I check the documents",
                "cordially" => "Regards,",
                "greeting" => "Hello,",
                "nonconformity" => "shows non-compliance.",
                "not_confirm" => "",
                "we_inform" => "We inform you that the following legal document "
            ],
            "partnership" => [
                "edit" => [
                    "activity_ends_at" => "Expiration date",
                    "activity_starts_at" => "Start date of activity",
                    "custom_management_fees_tag" => "Personalized management Fees option",
                    "dashboard" => "Dashboard",
                    "my_providers" => "My Subcontractors",
                    "partnership" => "Everyday activity",
                    "record" => "Save",
                    "return" => "Back",
                    "updated_at" => "Date of last modification",
                    "updated_by" => "Last modification made by",
                    "vendor_external_id" => "Subcontractor identifier"
                ]
            ]
        ]
    ],
    "mission" => [
        "mission" => [
            "_actions" => [
                "complete_mission" => "Close this work",
                "confirm_deletion" => "Sure to delete?",
                "confirm_generate_purchase_order" => "Are you sure your details are correct before generating the purchase order? Once it has been generated, you will no longer be able to change it.",
                "consult" => "See",
                "define_tracking_mode" => "Define the follow-up mode",
                "delete_purchase_order" => "Delete order form",
                "edit" => "Edit",
                "generate_order_form" => "Generate order form",
                "mission_followup" => "Create a work follow-up",
                "mission_monitoring" => "Work follow-up",
                "order_form" => "See Order Form",
                "remove" => "Remove"
            ],
            "_breadcrumb" => ["create" => "Create", "edit" => "Edit", "index" => "Works"],
            "_departments" => ["departments" => "Local areas"],
            "_form" => [
                "assignment_purpose" => "Work purpose",
                "describe_mission_help" => "Describe here the work in detail ",
                "identifier_help" => "If necessary, put an additional ID",
                "location" => "Place",
                "project_development_help" => "Example: project development",
                "tracking_mode" => "Follow-up mode"
            ],
            "_html" => [
                "add_note" => "Add a note",
                "amount" => "Total",
                "end" => "End",
                "location" => "Place",
                "number" => "Number",
                "permalink" => "Permalink",
                "rate_mission" => "Evaluate the work",
                "service_provider" => "Subcontractor",
                "start" => "Start",
                "status" => "Status",
                "unit" => "Unit",
                "user_id" => "User ID"
            ],
            "create" => [
                "affected_companies" => "Relevant Companies",
                "create" => "Create",
                "create_mission" => "Create a work",
                "create_the_mission" => "Create the work",
                "dashboard" => "Dashboard",
                "general_information" => "General information",
                "mission" => "Work",
                "return" => "Back"
            ],
            "create_milestone_type" => [
                "create" => "Create",
                "dashboard" => "Dashboard",
                "define_tracking_mode" => "Define the follow-up mode",
                "mission" => "Work",
                "mission_information" => "Work information",
                "return" => "Back",
                "tracking_mode" => "Follow-up mode"
            ],
            "edit" => [
                "assignment_purpose" => "Work purpose",
                "dashboard" => "Dashboard",
                "describe_mission_help" => "Describe here the work in detail ",
                "edit" => "Edit",
                "edit_mission" => "Modify the work",
                "identifier_help" => "If necessary, put an additional ID",
                "location" => "Place",
                "mission" => "Works",
                "mission_information" => "Work information",
                "project_development_help" => "Example: project development",
                "return" => "Back"
            ],
            "index" => [
                "actions" => "Actions",
                "add" => "Add",
                "amount" => "Amount",
                "customer" => "Customer",
                "dashboard" => "Dashboard",
                "finish" => "Done ",
                "label" => "Label",
                "mission" => "Work orders",
                "mission_closed_by" => "Work closed by",
                "new" => "New",
                "no" => "No",
                "number" => "Number",
                "return" => "Back",
                "service_provider" => "Subcontractor",
                "start_date" => "Start date",
                "status" => "Status"
            ],
            "show" => [
                "abondend_by" => "Given up by",
                "abondend_date" => "Date of give up",
                "amount" => "Quantity",
                "assigned_provider" => "Chosen subcontractor",
                "billing" => "Invoice",
                "change_status" => "Change status",
                "closed_by" => "Closed by",
                "closing_date" => "Closing date",
                "consult_proposal" => "See the proposal",
                "contractualize" => "Contractualize work order",
                "create_contract" => "Create a new contract",
                "created_by" => "Created by",
                "creation_date" => "Creation date",
                "customer" => "Customer",
                "dashboard" => "Dashboard",
                "description" => "Description",
                "determine" => "Choose",
                "end_date" => "End date",
                "further_information" => "Further information",
                "general_information" => "General information",
                "id" => "Identifier",
                "incoming_invoice" => "Associated incoming invoice",
                "last_update" => "Last update",
                "link_contract" => "Link an existing contract",
                "location" => "Place",
                "mission_proposal" => "Work proposal",
                "number" => "Number",
                "price" => "Price",
                "start_date" => "Start date",
                "status" => "Status",
                "tracking_mode" => "Follow-up mode"
            ]
        ],
        "mission_tracking" => [
            "_actions" => ["actions" => "Actions", "consult" => "See", "edit" => "Edit", "remove" => "Remove"],
            "_breadcrumb" => ["create" => "Create", "edit" => "Edit", "index" => " Works follow-ups"],
            "_status" => [
                "refuse" => "Refused",
                "search_for_agreement" => "Need agreement",
                "valid" => "Confirmed",
                "waiting" => "Pending"
            ],
            "create" => [
                "addtional_files" => "Additional files",
                "amount" => "Quantity",
                "create" => "Create",
                "dashboard" => "Dashboard",
                "general_information" => "General information",
                "mission_followup" => "New work follow-up",
                "mission_followup_ref" => "Work follow-up reference",
                "mission_monitoring" => "Work follow-up",
                "notify_customer" => "Notify Client",
                "notify_provider" => "Notify Subcontractor",
                "order_attached_help" => "Eg: Order #, Attachment #, etc.",
                "period_concerned" => "Relevant period",
                "record" => "Save",
                "return" => "Back",
                "unit" => "Unit",
                "unit_price" => "Unit price"
            ],
            "created" => [
                "access_mission_tracking" => "Work follow-up",
                "copy_paste_url" => "You can also copy and paste the following URL into the address bar of your browser",
                "cordially" => "Regards,",
                "greeting" => "Hello,",
                "new_vision_tracking" => "",
                "team_addworking" => "AddWorking Team",
                "validate" => "Validate"
            ],
            "edit" => [
                "addtional_files" => "Additional files",
                "dashboard" => "Dashboard",
                "edit" => "Edit",
                "edit_mission_tracking" => "Edit work follow-up",
                "external_identifier" => "External ID",
                "general_information" => "General information",
                "mission_followup" => "Works follow-ups",
                "mission_monitoring" => "Work follow-up",
                "order_attached_help" => "Eg: Order #, Attachment #, etc.",
                "period_concerned" => "Relevant period",
                "record" => "Save",
                "return" => "Back"
            ],
            "index" => [
                "actions" => "Actions",
                "client" => "Client",
                "dashboard" => "Dashboard",
                "edit_mission_tracking" => "Edit work follow-up",
                "end_date" => "End date",
                "mission" => "Work",
                "mission_monitoring" => "Work follow-up",
                "mission_number" => "Mission #",
                "return" => "Back",
                "service_provider" => "Subcontractor",
                "start_date" => "Start date",
                "status" => "Status"
            ],
            "show" => [
                "accounting_expense" => "Cost center",
                "actions" => "Actions",
                "add_row" => "Add a line",
                "amount" => "Quantity",
                "amount_before_taxes" => "Amount before taxes",
                "attachement" => "Attachments",
                "commenting_text" => "You can chat through the \"Comment\" for mutual agreement.",
                "comments" => "Comments",
                "customer_status" => "Client status",
                "dashboard" => "Dashboard",
                "description" => "Description",
                "express_agreement" => "You have already accepted (or not)",
                "external_identifier" => "External ID",
                "general_information" => "General information",
                "information_note" => "Information note",
                "label" => "Label",
                "mission_followup" => "Mission follow-ups",
                "mission_followup_text" => "You can create as many follow-up lines as necessary (example: work steps, additional costs/expenses related to unexpected events, etc.).",
                "mission_monitoring" => "Work follow-up",
                "mission_monitoring_statement" => "A follow-up line allows Client and Subcontractor to validate the work right execution as well as the final price - depending on field events - in order to a fair invoice",
                "no_more_edit" => "You can no longer change this line",
                "period_concerned" => "Relevant period",
                "provider_status" => "Subcontractor status",
                "reason_for_rejection" => "Rejection reason",
                "refusal_reason" => "Refusal reason",
                "return" => "Back",
                "tracking_lines" => "Follow-up lines",
                "unit_price" => "Unit price"
            ]
        ],
        "mission_tracking_line" => [
            "_actions" => [
                "accept_mission" => "Accept the work follow-up line?",
                "customer_refusal" => "Client refusal",
                "customer_validation" => "Client approval",
                "edit" => "Edit",
                "mission_tracking_deletion_confirm" => "Confirm delete the work follow-up line?",
                "provider_validation" => "Subcontractor approval",
                "remove" => "Remove",
                "service_provider_refusal" => "Subcontractor refusal"
            ],
            "_breadcrumb" => ["create" => "Create", "edit" => "Edit", "index" => "Lines"],
            "_html" => [
                "accounting_expense" => "Cost center",
                "amout" => "Amount",
                "label" => "Description",
                "reason_for_rejection" => "Rejection reason",
                "validation" => "Approval",
                "validation_customer" => "Customer approval",
                "validation_vendro" => "Subcontractor approval"
            ],
            "_reject" => [
                "client" => "Client",
                "decline_tracking" => "Refuse the work follow-up line",
                "refusal_reason" => "Refusal reason",
                "service_provider" => "Subcontractor"
            ],
            "_table_row_empty" => [
                "add_line" => "Add a line",
                "doesnt_have_lines" => "has no line",
                "the_tracking" => "Work follow-up"
            ],
            "create" => [
                "accounting_expense" => "Cost center",
                "amount" => "Quantity",
                "create_row" => "Create a line",
                "dashboard" => "Dashboard",
                "general_information" => "General information",
                "line_label" => "Description",
                "mission" => "Works",
                "mission_monitoring" => "Work follow-up",
                "mission_monitoring_new" => "New work follow-up line",
                "record" => "Save",
                "return" => "Back",
                "unit" => "Unit",
                "unit_price" => "Unit price"
            ],
            "edit" => [
                "amount" => "Quantity",
                "dashboard" => "Dashboard",
                "edit" => "Edit",
                "general_information" => "General information",
                "line_label" => "Description",
                "lines" => "Lines",
                "mission" => "Works",
                "mission_monitoring" => "Work follow-ups",
                "modify_mission_tracking" => "Edit work follow-up line",
                "modify_row" => "Edit line",
                "return" => "Back",
                "unit" => "Unit",
                "unit_price" => "Unit price"
            ],
            "index" => [
                "amount" => "Amount",
                "label" => "Follow-up lines",
                "title" => "Follow-up lines",
                "validation" => "Approval"
            ]
        ],
        "offer" => [
            "_actions" => [
                "change_status" => "Change Status",
                "change_status_offer" => "Change the offer status ",
                "choose_recp_offer" => "Choose the recipients of the offer",
                "close_offer" => "Close the offer",
                "closing_request" => "Closing request",
                "consult" => "Consult",
                "edit" => "Edit",
                "relaunch_mission_proposal" => "Relaunch work proposals",
                "remove" => "Remove",
                "responses" => "Answers",
                "see_missions" => "View associated work orders",
                "status" => "Status",
                "summary" => "Summary"
            ],
            "_form" => [
                "desc_mission_details" => "Describe here all the details of the work",
                "referent" => "Referent"
            ],
            "_proposal_actions" => [
                "consult_passwork" => "See the passwork",
                "consult_proposal" => "See the proposal",
                "view_responses" => "Check answers"
            ],
            "_status" => [
                "abondend" => "Given up",
                "broadcast" => "Released",
                "closed" => "Closed",
                "diffuse" => "To diffuse",
                "rough_draft" => "Draft"
            ],
            "accept_offer" => [
                "congratulations" => "Congratulations!",
                "cordially" => "Regards,",
                "greeting" => "Hello,",
                "i_consult" => "See",
                "legal_statement" => "",
                "response_to_mission_proposal" => "Your response to the work proposal",
                "team_addworking" => "AddWorking team",
                "validate" => "Validate"
            ],
            "assign" => [
                "assign" => "Assign",
                "assign_offer_service_provider" => "Assign the offer to a Subcontractor",
                "dashboard" => "Dashboard",
                "mission_offer" => "Work offer",
                "return" => "Back",
                "service_provider" => "Subcontractor"
            ],
            "assign_modal" => [
                "close" => "Close",
                "close_offer" => "Close the offer?",
                "register" => "Save",
                "title" => "Assign"
            ],
            "create" => [
                "additional_file" => "Additional file",
                "assignment_desired_skills" => "Required skill(s) for this work",
                "assignment_offer_info" => "Information on the work offer",
                "assignment_purpose" => "Work purpose",
                "create" => "Create",
                "dashboard" => "Dashboard",
                "mission_offer" => "Work offer",
                "new_mission_offer" => "New Work Offer",
                "project_development_help" => "Example: project development",
                "return" => "Back",
                "select_multiple_departments_help" => "You can choose several local areas by holding down the [Ctrl] key on your keyboard.",
                "success_creation" => ""
            ],
            "edit" => [
                "additional_file" => "Additional file",
                "assignment_offer_info" => "Information on the assignment offer",
                "assignment_purpose" => "Purpose of the assignment",
                "dashboard" => "Dashboard",
                "department_help" => "You can choose several departments by holding down the [Ctrl] key on your keyboard.",
                "edit" => "EDIT",
                "location" => "place",
                "mission_offer" => "Work offer",
                "modify_assignment_offer" => "Modify an assignment offer",
                "project_development_help" => "Example: project development",
                "return" => "Return"
            ],
            "index" => [
                "actions" => "Actions",
                "create_assignment_offer" => "Create a work offer",
                "create_offer_for_construction" => "Create a public works offer",
                "created_on" => "Created on",
                "customer" => "Customer",
                "dashboard" => "Dashboard",
                "mission_offer" => "Works offers",
                "referent" => "Referent",
                "status" => "Status"
            ],
            "pending_offer" => [
                "greeting" => "Hello,",
                "no_longer_respond" => "You can no longer respond to this offer.",
                "offer_closed" => "",
                "see_you_soon" => "Looking forward to hearing from you soon!"
            ],
            "refuse_offer" => [
                "greeting" => "Hello,",
                "has_refused_by" => "has been refused by",
                "i_consult" => "I check",
                "see_you_soon" => "Looking forward to hearing from you soon!",
                "your_response" => ""
            ],
            "request_close_offer" => [
                "confirm_choice" => "Close the work offer?",
                "cordially" => "Regards,",
                "greeting" => "Hello,",
                "legal_statement" => "",
                "mission_offer_close" => "Close the offer",
                "retained_respondent" => "Chosen subcontractor",
                "team_addworking" => "The AddWorking team"
            ],
            "send_request_close" => [
                "dashboard" => "Dashboard",
                "mission_offer" => "Work offer",
                "offer_close_req" => "Request to close the assignment offer",
                "return" => "Return",
                "send_request" => "Send Request",
                "solicit_responsible" => "Responsible to solicit",
                "you_selected" => "You have selected",
                "you_selected_text" => "response (s) in final validation for this offer. It is now necessary to close the offer. Please choose an authorized person from the list below."
            ],
            "show" => [
                "action" => "stock",
                "additional_document" => "Additional Documents",
                "analytical_code" => "Analytical code",
                "assignment_desired_skills" => "Desired skill (s) for this assignment",
                "assignment_purpose" => "Purpose of the assignment",
                "assing_mission_directly" => "Assign the mission directly",
                "choose_recp_offer" => "Choose the recipients of the offer",
                "client_id" => "Client ID",
                "close_offer" => "Close the offer",
                "closing_request" => "Closing request",
                "confirm_close_assignment" => "answer(s) in final validation, are you sure you want to close this work offer?",
                "dashboard" => "Dashboard",
                "end_date" => "End date",
                "general_information" => "General information",
                "location" => "Place",
                "mission_offer" => "Works offers",
                "mission_proposal" => "Works proposals",
                "no_document" => "No document",
                "no_proposal" => "No proposal",
                "provider_company" => "Subcontractor company",
                "referent" => "Referent",
                "response_number" => "Number of answers",
                "start_date" => "Start date",
                "status" => "Status",
                "you_have" => "You have"
            ],
            "summary" => [
                "create" => "Create",
                "dashboard" => "Dashboard",
                "enterprise" => "Company",
                "mission" => "Work",
                "mission_offer" => "Work offer",
                "reply_date" => "Answer date",
                "response_not_in_final_validation" => "This answer does not have the \"final validation status\"",
                "responses_summary" => "Summary of answers to the work offer",
                "see_mission" => "See this work",
                "status" => "status",
                "summary" => "Summary"
            ]
        ],
        "profile" => [
            "create" => [
                "dashboard" => "Dashboard",
                "disseminate_offer" => "Release the work offer to",
                "enterprise" => "Companies",
                "mission_offer" => "Work Offer",
                "provider_selection" => "Choose subcontractors",
                "return" => "Back",
                "selected_company" => "Chosen company(ies)",
                "service_provider_selection" => "Choose subcontractors for the work offer",
                "trades_skill" => "Services & Skills"
            ]
        ],
        "proposal" => [
            "_actions" => [
                "assign_proposal_confirm" => "Are you sure you want to assign the work?",
                "assing_mission" => "Assign the work",
                "confirmation" => "Confirmation",
                "consult" => "See",
                "delete_proposal_confirm" => "Are you sure you want to delete the work proposal?",
                "edit" => "Edit",
                "remove" => "Remove",
                "responses" => "Answers"
            ],
            "create" => ["broadcast" => "Release", "close" => "Close"],
            "edit" => [
                "dashboard" => "Dashboard",
                "edit" => "Edit",
                "mission_offer" => "Work offer",
                "mission_proposal" => "Work proposal",
                "mission_proposal_info" => "Information on the work proposal",
                "modify_proposal" => "Edit the work proposal",
                "return" => "Back",
                "service_provider" => "Subcontractor"
            ],
            "index" => [
                "dashboard" => "Dashboard",
                "desired_start_date" => "Desired Start date",
                "mission_offer" => "Work Offer",
                "mission_proposal" => "Works proposals",
                "referent" => "Referent",
                "service_provider" => "Subcontractor",
                "status" => "Status"
            ],
            "show" => [
                "additional_document" => "Additional documents",
                "amount" => "Quantity",
                "client_id" => "Client ID",
                "comments" => "Comments",
                "customer" => "Client",
                "dashboard" => "Dashboard",
                "desired_start_date" => "Desired Start date",
                "details_assignment_offer" => "Work offer details",
                "download" => "Download",
                "files_title" => "Additional documents",
                "further_information" => "Further information",
                "information_req" => "Information request",
                "mission_end" => "End of work",
                "mission_location" => "Work location",
                "mission_proposal" => "Work proposal",
                "mission_proposal_response" => "Answers to the work proposal",
                "no_file_sentence" => "No file attached",
                "no_response_sentence" => "No answer",
                "offer_closed" => "The offer is now closed, you can no longer answer",
                "offer_description" => "Work proposal description",
                "offer_label" => "Purpose of the work proposal",
                "offer_status" => "Offer status",
                "proposal_start_date" => "Proposal Start Date",
                "proposal_status" => "Proposal status",
                "quote_required" => "Quote required",
                "read_more" => "See more",
                "replace" => "Replace",
                "req_sent" => "Your request for information has been sent, a Sogetrel manager will answer you",
                "respond_deadline" => "Answer deadline",
                "respond_tenders" => "Respond to the call for bids",
                "response" => "See the answer of",
                "response_title" => "Answers",
                "send_bpu" => "Send the Unit Price Form",
                "service_provider" => "Subcontractor",
                "show_bpu" => "See the Unit Price Form",
                "to_respond_update" => "To respond to this call for bids, you must update your documents",
                "total_amount" => "Total excl. tax.",
                "unit" => "Unit",
                "unit_price" => "Unit price"
            ],
            "status" => [
                "_interested" => [
                    "audience_text" => "Public: visible to everyone. Protected: visible to members of my company. Private: visible only to me.",
                    "information_req" => "Information request",
                    "information_requested" => "Information requested",
                    "visibility" => "Visibility"
                ]
            ]
        ],
        "proposal_response" => [
            "_actions" => ["edit" => "Edit"],
            "_status" => [
                "exchange_positive" => "Positive exchange",
                "exchange_req" => "Exchange requested",
                "final_validation" => "Final validation",
                "refuse" => "Refuse",
                "validate_price" => "Validate price",
                "waiting" => "Pending"
            ],
            "create" => [
                "additional_file" => "Additional files",
                "amount" => "Quantity",
                "availability_end_date" => "End date of availability",
                "create_response" => "Create an answer",
                "create_response1" => "Create the answer",
                "dashboard" => "Dashboard",
                "general_information" => "General information",
                "mission_proposal" => "Work proposal",
                "possible_start_date" => "Possible Start date",
                "price" => "Price",
                "respond_offer" => "Answer to the offer",
                "return" => "Back",
                "unit" => "Unit"
            ],
            "edit" => [
                "additional_file" => "Additional files",
                "amount" => "Quantity",
                "availability_end_date" => "End date of availability",
                "dashboard" => "Dashboard",
                "edit_response" => "Edit the answer",
                "edit_response1" => "Edit answer",
                "general_information" => "General information",
                "mission_proposal" => "Work proposal",
                "possible_start_date" => "Possible Start date",
                "price" => "Price",
                "return" => "Back",
                "unit" => "Unit"
            ],
            "index" => [
                "action" => "Actions",
                "client_company" => "Client Company",
                "close_assignment_confirm" => "answer(s) in final validation, are you sure you want to close this work offer?",
                "close_offer" => "Close the offer",
                "closing_request" => "Closing request",
                "created" => "Created on",
                "dashboard" => "Dashboard",
                "mission_offer" => "Works Offers",
                "mission_proposal" => "Works proposals",
                "new_response" => "New answers",
                "offer_answer" => "Answers to the offer",
                "provider_company" => "Subcontractor company",
                "response" => "Answers",
                "status" => "Status"
            ],
            "show" => [
                "accept_it" => "Accepted on",
                "accepted_by" => "Accepted by",
                "additional_document" => "Additional documents",
                "amount" => "Quantity",
                "change_status" => "Change status",
                "client" => "Client",
                "close_assignment_confirm" => "answer(s) in final validation, are you sure you want to close this work offer?",
                "close_offer" => "Close the offer",
                "closing_request" => "Closing request",
                "comment" => "Comments",
                "dashboard" => "Dashboard",
                "description" => "Description",
                "general_information" => "General information",
                "mission_offer" => "Work Offer",
                "mission_proposal" => "Work proposal",
                "no_document" => "No document",
                "offer_answer" => "Answer to the offer",
                "possible_end_date" => "Possible End date",
                "possible_start_date" => "Proposal Start date",
                "price" => "Price",
                "refusal_reason" => "Reason for refusal",
                "refused_by" => "Refused by",
                "refused_on" => "Refused on",
                "response" => "Answers",
                "service_provider" => "Subcontractor",
                "status" => "Status"
            ],
            "status" => [
                "_final_validation" => [
                    "audience_text" => "Public: visible to everyone. Protected: visible to members of my company. Private: visible only to me.",
                    "change_resp_status" => "Change from answer to status",
                    "close_assignment" => "Close the work offer?",
                    "comment" => "Comment",
                    "visibility" => "Visibility"
                ],
                "_interview_positive" => [
                    "audience_text" => "Public: visible to everyone. Protected: visible to members of my company. Private: visible only to me.",
                    "change_resp_status" => "Change from answer to status",
                    "comment" => "Comment",
                    "visibility" => "Visibility"
                ],
                "_interview_requested" => [
                    "audience_text" => "Public: visible to everyone. Protected: visible to members of my company. Private: visible only to me.",
                    "change_resp_status" => "Change from answer to status",
                    "comment" => "Comment",
                    "visibility" => "Visibility"
                ],
                "_ok_to_meet" => [
                    "audience_text" => "Audience: visible to everyone. Protected: visible to members of my company. Private: visible only to me.",
                    "change_resp_status" => "Change from response to status",
                    "comment" => "Comment",
                    "visibility" => "Visibility"
                ],
                "_pending" => [
                    "audience_text" => "Public: visible to everyone. Protected: visible to members of my company. Private: visible only to me.",
                    "change_resp_status" => "Change from answer to status",
                    "comment" => "Comment",
                    "visibility" => "Visibility"
                ],
                "_reject" => [
                    "audience_text" => "Public: visible to everyone. Protected: visible to members of my company. Private: visible only to me.",
                    "comment" => "Comment",
                    "refuse_assign_offer" => "Decline the answer to the work offer",
                    "visibility" => "Visibility"
                ]
            ]
        ],
        "purchase_order" => [
            "document" => [
                "_details" => [
                    "amount" => "Quantity",
                    "assignment_purpose" => "Work purpose",
                    "uht_amount" => "Total excl. tax.",
                    "uht_price" => "Unit Price (excl. tax.)",
                    "unit" => "Unit"
                ],
                "_enterprises" => [
                    "address" => "17 rue du Lac Saint AndrÇ<br/>Savoie Technolac - BP 350<br/>73370 Le Bourget du Lac - France",
                    "address1" => "Address",
                    "addworking" => "ADDWORKING",
                    "billing_address" => "Invoice Address",
                    "buyer" => "Buyer",
                    "last_name" => "Name",
                    "legal_entity" => "LEGAL ENTITY",
                    "mail" => "Email",
                    "net_transfer" => "30-day net transfer",
                    "payment_condition" => "Payment condition",
                    "phone" => "Phone",
                    "provider" => "Provider"
                ],
                "_header" => [
                    "created" => "Created on",
                    "purchase_order" => "PURCHASE ORDER",
                    "reference_mission" => "WORK REFERENCE",
                    "remind_correspondence" => "(to be reminded <u>obligatorily</u> on all your correspondence, <strong>delivery notes</strong> and <strong>invoices</strong> )"
                ],
                "_shipping_informations" => [
                    "by_receiving_supplier_undertakes" => "By receiving this order form, the supplier is committing to",
                    "delivery_information" => "Delivery information",
                    "description" => "Description",
                    "destination_site" => "Destination Site",
                    "expected_start_date" => "Expected Start date",
                    "referent" => "Referent",
                    "shipping_site" => "Shipping Site",
                    "supplier_undertake_1" => "1. Process this order in accordance with the prices, conditions, delivery instructions and specifications listed above.",
                    "supplier_undertake_2" => "2. Submit your invoice on the AddWorking platform.",
                    "supplier_undertake_3" => "3. Immediately notify the purchaser if he is unable to ship the order as specified."
                ],
                "_terms" => ["spf_purchase_condition" => "SPF General Purchasing Conditions"],
                "_total" => [
                    "total_net_excl_tax" => "Net Total excl.tax in ?",
                    "total_price" => "Total incl. tax.",
                    "vat" => "VAT"
                ],
                "page" => "Page"
            ],
            "index" => [
                "action" => "Actions",
                "assignment_purpose" => "Work purpose",
                "creation_date" => "Creation date",
                "dashboard" => "Dashboard",
                "enterprise" => "Companies",
                "ht_price" => "Price (excl. tax.)",
                "mission_reference" => "Work reference",
                "order_form" => "Order forms for",
                "purchase_order" => "Purchase Orders",
                "status" => "Status"
            ],
            "show" => [
                "dashboard" => "Dashboard",
                "details" => "Details",
                "enterprise" => "Company",
                "mission" => "Work",
                "order_form" => "Order form for",
                "order_form_help_text" => "This order form was generated from the corresponding work. You can modify the work (and regenerate the order form) as long as the order form has not been sent to the subcontractor",
                "purchase_order" => "Purchase Order",
                "return" => "Back",
                "send_order_form" => "Are you sure to send the order form?",
                "send_to_service_provider_and_referrer" => "Send to Subcontractor and Referent"
            ]
        ]
    ],
    "mssion" => [
        "mission_tracking_line" => [
            "_html" => [
                "amout" => "",
                "label" => "",
                "reason_for_rejection" => "",
                "validation" => "",
                "validation_customer" => "",
                "validation_vendro" => ""
            ]
        ]
    ],
    "navbar" => ["need_help" => "Need help?"],
    "user" => [
        "auth" => [
            "login" => [
                "email_address" => "Email address",
                "forgot_password" => "Forgot your password?",
                "log_in" => "Log in",
                "login" => "Log in",
                "password" => "Password"
            ],
            "passwords" => [
                "email" => [
                    "email_address" => "Email address",
                    "reset_password" => "Reset password",
                    "send" => "Send"
                ],
                "reset" => [
                    "confirm_password" => "Confirm password",
                    "email_address" => "Email address",
                    "password" => "Password",
                    "record" => "Save",
                    "reset_password" => "Resetting your password"
                ]
            ],
            "register" => [
                "reCaptcha_failed" => "ReCaptcha verification failed",
                "registration" => "Registration"
            ]
        ],
        "chat" => [
            "index" => [
                "converse" => "You are chatting with",
                "refresh" => "Refresh",
                "sent" => "Sent",
                "to_send" => "Send",
                "view_document" => "See document"
            ],
            "rooms" => [
                "access_your_conversation" => "Go to the chat",
                "chatroom_list" => "Chat room lists",
                "chatroom_list_participate" => "Lists of chat rooms in which you participate",
                "conversation_with" => "Chat with",
                "see_conversation" => "See the chat"
            ]
        ],
        "dashboard" => [
            "_customer" => [
                "active_contract" => "Ongoing contracts",
                "contract" => "Contracts",
                "invoices" => "Invoices",
                "mission" => "Works",
                "missions_this_month" => "Works this month",
                "new_response" => "New answers",
                "pending_contract" => "",
                "performance" => "Performance",
                "providers" => "Subcontractors",
                "validate_offer" => "Offers to validate"
            ],
            "_onboarding" => [
                "boarding" => "Onboarding",
                "step" => [
                    "confirm_email" => [
                        "call_to_action" => "Resend the confirmation email",
                        "description" => "Confirm your email",
                        "message" => "A valid email address is required so that we can send you notifications. An email was sent to you automatically when you created your account. It contains a validation link which you can use to confirm your account."
                    ],
                    "create_enterprise" => [
                        "call_to_action" => "Update my company",
                        "description" => "Enter your company",
                        "message" => "You have still not entered your company"
                    ],
                    "create_enterprise_activity" => [
                        "call_to_action" => "Enter activity",
                        "description" => "Please enter your company's activity",
                        "message" => "You have still not entered your company's activity"
                    ],
                    "create_passwork" => [
                        "call_to_action" => "Create my Passwork",
                        "description" => "Enter your Passwork",
                        "message" => "You have still not created your Passwork"
                    ],
                    "on" => "on",
                    "step" => "Step",
                    "steps" => "Steps",
                    "upload_legal_document" => [
                        "call_to_action" => "Download your legal documents",
                        "description" => "Download your legal documents",
                        "message" => "Please download your legal documents."
                    ],
                    "validation_passwork" => [
                        "call_to_action" => "View my Passwork",
                        "description" => "Your Passwork is awaiting validation",
                        "message" => "Your Passwork is being validated"
                    ]
                ]
            ],
            "_vendor" => [
                "active_contract" => "Ongoing contracts",
                "alert_expired_document" => "You have expired documents to update",
                "alert_expired_document_button" => "I update my documents",
                "client" => "Clients",
                "contract" => "Contracts",
                "mission_proposal" => "Works proposals",
                "missions_this_month" => "Works this month",
                "pending_contract" => ""
            ]
        ],
        "log" => [
            "index" => [
                "dashboard" => "Dashboard",
                "date" => "Dated",
                "email" => "Email",
                "export_sogetrel_user_activities" => "Export of Sogetrel users activities",
                "http_method" => "HTTP Method",
                "impersonating" => "It's not you?",
                "ip" => "IP",
                "rout" => "Road",
                "url" => "URL",
                "user_logs" => "Users logs"
            ]
        ],
        "notification_process" => [
            "edit" => [
                "iban_change_confirmation" => "Receive IBAN change confirmations",
                "notification_setting" => "Notification Settings",
                "notify_service_provider_paid" => "Be notified when one of my Subcontractors has been paid",
                "receive_emails" => "Receive emails",
                "receive_mission_followup_email" => "Receive emails when works follow-ups are created "
            ]
        ],
        "onboarding_process" => [
            "_actions" => [
                "add_context_tag" => "Add the So?connext tag",
                "confirm_activation" => "Confirm activating?",
                "confirm_deactivation" => "Confirm deactivating?",
                "remove_context_tag" => "Remove the So?connext tag",
                "to_log_in" => "Log in"
            ],
            "_form" => [
                "concern_domain" => "Relevant field",
                "onboarding_completed" => "Onboarding completed",
                "user" => "User"
            ],
            "_html" => [
                "completion_date" => "Completion date",
                "creation_date" => "Creation date",
                "enterprise" => "Company",
                "field" => "Field",
                "onboarding_completed" => "Onboarding completed",
                "step_in_process" => "Ongoing step",
                "user" => "User"
            ],
            "create" => [
                "concerned_domain" => "Relevant field",
                "create" => "Create",
                "create_new_onboaring_process" => "Create a new onboarding process",
                "dashboard" => "Dashboard",
                "general_information" => "General information",
                "onboarding_completed" => "Onboarding completed",
                "onboarding_process" => "Onboarding process",
                "record" => "Save",
                "return" => "Back",
                "user" => "User"
            ],
            "edit" => [
                "dashboard" => "Dashboard",
                "edit" => "Edit",
                "edit_onboarding_process" => "Editing the onboarding process",
                "general_information" => "General information",
                "onboarding_completed" => "Onboarding completed",
                "onboarding_process" => "Onboarding process",
                "record" => "Save",
                "return" => "Back",
                "step_in_process" => "Ongoing step"
            ],
            "index" => [
                "action" => "Action",
                "add" => "Add",
                "client" => "Client",
                "concerned_domain" => "Relevant field",
                "created" => "Created on",
                "dashboard" => "Dashboard",
                "entreprise" => "Company",
                "export" => "Export",
                "finish" => "Done ",
                "in_progress" => "In progress",
                "onboarding_process" => "Onboarding process",
                "return" => "Back",
                "status" => "Status",
                "step_in_process" => "Ongoing step",
                "user" => "User"
            ],
            "show" => [
                "dashboard" => "Dashboard",
                "general_information" => "General information",
                "onboarding" => "Onboarding",
                "onboarding_process" => "Onboarding process",
                "return" => "Back"
            ]
        ],
        "profile" => [
            "customers" => [
                "dashboard" => "Dashboard",
                "entreprise" => "Company",
                "my_clients" => "My Clients",
                "return" => "Back"
            ],
            "edit" => [
                "change_password" => "Change password",
                "dashboard" => "Dashboard",
                "edit" => "Edit",
                "edit_email" => "Edit email",
                "edit_profile" => "Edit profile",
                "profile" => "Profile",
                "profile_information" => "Profile information",
                "record" => "Save",
                "return" => "Back"
            ],
            "edit_password" => [
                "change_password" => "Change your password",
                "current_password" => "Current password",
                "dashboard" => "Dashboard",
                "new_password" => "New password",
                "profile" => "Profile",
                "record" => "Save",
                "repeat_new_password" => "Repeat new password"
            ],
            "index" => [
                "additional_address" => "Additional address",
                "address" => "Address(es)",
                "change_password" => "Change password",
                "dashboard" => "Dashboard",
                "edit_email" => "Edit email",
                "edit_profile" => "Edit My Profile",
                "enterprise" => "Company",
                "first_name" => "First Name",
                "function" => "Function",
                "last_name" => "Last Name",
                "notification" => "Notifications",
                "phone_number" => "Phone number",
                "phone_numbers" => "Phone numbers",
                "postal_code" => "Zip code",
                "profile_of" => "Profile of",
                "profile_picture" => "Profile picture",
                "user_identity" => "User identity"
            ]
        ],
        "terms_of_use" => [
            "show" => [
                "accept_general_condition" => "Accept the General Conditions of Use",
                "general_information" => "General information",
                "validate" => "Confirm"
            ]
        ],
        "user" => [
            "_badges" => [
                "client" => "Client",
                "service_provider" => "Subcontractor",
                "support" => "Support"
            ],
            "_form" => ["first_name" => "First Name", "last_name" => "Name"],
            "_html" => [
                "activation" => "Activation",
                "active" => "Active",
                "email" => "Email",
                "enterprises" => "Company(ies)",
                "identity" => "Identity",
                "inactive" => "Inactive",
                "last_activity" => "Last activity",
                "last_authentication" => "Last connection",
                "number" => "Number",
                "phone_number" => "Phone number",
                "registration_date" => "Registration Date",
                "tags" => "Tags",
                "username" => "Login"
            ],
            "_index_form" => [
                "all" => "All",
                "clients" => "Clients",
                "providers" => "Subcontractors",
                "support" => "Support"
            ],
            "_tags" => ["na" => "n.a"],
            "create" => [
                "create" => "Create",
                "create_new_user" => "Create a new user",
                "create_user" => "Create user",
                "dashboard" => "Dashboard",
                "general_information" => "General information",
                "return" => "Back",
                "users" => "Users"
            ],
            "edit" => [
                "dashboard" => "Dashboard",
                "edit" => "Edit",
                "edit_user" => "Edit user",
                "general_information" => "General information",
                "modify_user" => "Edit user",
                "return" => "Back",
                "users" => "Users"
            ],
            "index" => [
                "action" => "Action",
                "add" => "Add",
                "created_at" => "Created on",
                "dashboard" => "Dashboard",
                "email" => "Email",
                "enterprise" => "Company",
                "name" => "Name",
                "title" => "Users",
                "type" => "Type",
                "users" => "Users"
            ],
            "show" => [
                "comments" => "Comments",
                "connect" => "Log in",
                "contact" => "Contact",
                "dashboard" => "Dashboard",
                "files" => "Files",
                "general_information" => "General information",
                "users" => "Users"
            ]
        ]
    ]
];
