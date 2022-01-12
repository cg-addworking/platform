<?php
return [
    "outbound" => [
        "application" => [
            "views" => [
                "_actions" => [
                    "addworking_commissions" => "AddWorking fees",
                    "consult" => "Consult",
                    "create_credit_note_invoice" => "Create a credit note  ",
                    "credit_lines" => "Credit lines",
                    "edit" => "Edit",
                    "generate_pdf" => "Generate PDF",
                    "invoice_lines" => "Invoice lines",
                    "payment_orders" => "Payment orders",
                    "supplier_invoice_included" => "Included Subcontractors Invoices"
                ],
                "_breadcrumb" => [
                    "addworking_commission" => "AddWorking fee",
                    "addworking_commissions" => "AddWorking fees",
                    "addworking_invoices" => "AddWorking invoices",
                    "calculate_commissions" => "Calculate fees",
                    "create" => "Create",
                    "create_credit_lines" => "Create credit lines",
                    "dashboard" => "Dashboard",
                    "edit" => "Edit",
                    "generate_file" => "Generate file",
                    "invoice_number" => "Invoice No.",
                    "number" => "No.",
                    "provider_invoice" => "Subcontractors Invoices"
                ],
                "_filter" => [
                    "bill_number" => "Invoice number",
                    "billing_period" => "Invoicing Period",
                    "due_date" => "Due Date",
                    "filter" => "Filters",
                    "invoice_date" => "Date of issue",
                    "payment_deadline" => "Payment deadline",
                    "reset" => "Reset",
                    "status" => "Status"
                ],
                "_form" => [
                    "billing_period" => "Invoicing Period",
                    "due_date" => "Due Date",
                    "include_fees" => "Include commission on the invoice?",
                    "innvoice_date" => "Dated",
                    "invoice_date" => "Invoice issue date",
                    "no" => "No",
                    "payment_deadline" => "Payment deadline",
                    "yes" => "Yes"
                ],
                "_html" => [
                    "amount_excluding_taxes" => "Total excluding taxes (excl tax)",
                    "amount_including_taxes" => "Total including taxes (incl tax)",
                    "client" => "Client",
                    "copy_to_clipboard" => "Copy to clipboard",
                    "created_date" => "Creation date",
                    "due_date" => "Due Date",
                    "issue_date" => "Date of issue",
                    "last_modified_date" => "Date of last modification",
                    "legal_notice" => "Legal Notice",
                    "number" => "Number",
                    "parent_invoice_number" => "Parent Invoice number",
                    "payment_order_date" => "Date of payment of payment orders",
                    "period" => "Period",
                    "received_by_assignment_daily" => "DAILLY Debt Write-off",
                    "reverse_vat" => "Reverse Charging VAT",
                    "status" => "Status",
                    "updated_by" => "Modified by ",
                    "uuid" => "UUID",
                    "validated_at" => "",
                    "validated_by" => "",
                    "vat_amount" => "Total of taxes (VAT)"
                ],
                "_status" => [
                    "fees_calculated" => "Calculated fees",
                    "file_generated" => "File generated",
                    "fully_paid" => "Fully Paid",
                    "partially_paid" => "Partially Paid",
                    "pending" => "Pending",
                    "validated" => "Validated"
                ],
                "_table_head" => [
                    "action" => "Action",
                    "amount_ht" => "Total excl. tax.",
                    "bill_number" => "Invoice number",
                    "create_invoice" => "Create an invoice",
                    "customer_visibility" => "Client visibility",
                    "deadline" => "Payment deadline",
                    "does_not_have_invoices" => "Has no invoices",
                    "due_at" => "Due Date",
                    "invoiced_at" => "Date of issue",
                    "month" => "Invoicing Period",
                    "status" => "Status",
                    "tax" => "Total of taxes",
                    "the_enterprise" => "The Company",
                    "total" => "Total incl. tax."
                ],
                "_table_row_empty" => [
                    "create_invoice" => "Create an Invoice",
                    "does_not_have_invoices" => "does not have any AddWorking invoices.",
                    "the_enterprise" => "The Company"
                ],
                "associate" => [
                    "action" => "Action",
                    "amount_ht" => "Total excl. tax.",
                    "associate" => "Associate",
                    "associate_selected_invoice" => "Associate the selected invoices",
                    "billing_period" => "Invoicing Period",
                    "invoice_number" => "Invoice number",
                    "note" => "Note: the remainder to be invoiced corresponds to the list of Subcontractors invoices that are not included in an AddWorking invoice.",
                    "payment_deadline" => "Payment deadline",
                    "remains_to_be_invoiced" => "Remainder to be invoiced ",
                    "return" => "Back",
                    "service_provider" => "Subcontractor",
                    "status" => "Status",
                    "text_1" => "has no Subcontractors invoices to associate",
                    "text_2" => "for the period",
                    "text_3" => "deadline",
                    "the_enterprise" => "The Company",
                    "total" => "Total incl. tax."
                ],
                "create" => [
                    "create_invoice" => "Create the invoice",
                    "create_invoice_for" => "Create an invoice for",
                    "return" => "Back"
                ],
                "dissociate" => [
                    "action" => "Action",
                    "amount_ht" => "Total excl. tax.",
                    "associate_invoice" => "Associate Invoices",
                    "billing_period" => "Invoicing Period",
                    "dissociate" => "Dissociate",
                    "export" => "Export",
                    "invoice_number" => "Invoice number",
                    "payment_deadline" => "Payment deadline",
                    "reset_invoice" => "Remainder to be invoiced ",
                    "return" => "Back",
                    "service_provider" => "Subcontractor",
                    "status" => "Status",
                    "text_1" => "has no Subcontractors invoices to dissociate",
                    "text_2" => "for the period",
                    "text_3" => "deadline",
                    "the_enterprise" => "The Company",
                    "title" => "Subcontractors invoices of invoice No.",
                    "total" => "Total incl. tax.",
                    "ungroup_selected_invoice" => "Dissociate the selected invoices"
                ],
                "edit" => [
                    "edit_invoice" => "Edit invoice",
                    "return" => "Back",
                    "status" => "Status",
                    "title" => "Edit Invoice No."
                ],
                "fee" => [
                    "_actions" => ["confirm_delete" => "Sure to delete?", "delete" => "Remove"],
                    "_table_head" => [
                        "actions" => "Actions",
                        "amount" => "Total",
                        "label" => "Label",
                        "number" => "Number",
                        "service_provider" => "Subcontractor",
                        "tax_amount_invoice_line" => "Total excl. tax. invoice line",
                        "type" => "Type",
                        "vat_rate" => "VAT rate"
                    ],
                    "_table_head_associate" => [
                        "actions" => "Actions",
                        "amount" => "Total",
                        "label" => "Label",
                        "number" => "Number",
                        "service_provider" => "Subcontractor",
                        "tax_amount_invoice_line" => "Total exl. tax. invoice line",
                        "type" => "Type",
                        "vat_rate" => "VAT rate"
                    ],
                    "_table_head_credit_fees" => [
                        "actions" => "Actions",
                        "amount" => "Amount",
                        "label" => "Label",
                        "number" => "Number",
                        "service_provider" => "Subcontractor",
                        "tax_amount_invoice_line" => "Total excl. tax. invoice line",
                        "type" => "Type",
                        "vat_rate" => "VAT rate"
                    ],
                    "_table_row_associate" => ["cancel" => "Cancel"],
                    "_type" => [
                        "custom_management_fees" => "Personalized management rate",
                        "default_management_fees" => "Default management rate",
                        "discount" => "Discount",
                        "fixed_fees" => "Fixed fees",
                        "other" => "Other",
                        "subscription" => "Subscription"
                    ],
                    "associate_credit_fees" => [
                        "cancel_selected" => "Cancel selected fees lines",
                        "return" => "Back",
                        "text_1" => "The AddWorking Invoice No.",
                        "text_2" => "has no fees lines.",
                        "title" => "Cancel AddWorking fees lines"
                    ],
                    "calculate" => [
                        "calculate_commissions" => "Calculate fees",
                        "return" => "Back",
                        "text_1" => "By default, AddWorking fees will be calculated on the AddWorking invoice No.",
                        "text_2" => "AddWorking Invoice to process",
                        "title" => "Calculate the fees of the AddWorking Invoice No."
                    ],
                    "create" => [
                        "calculate_commissions" => "",
                        "create" => "Create the fee",
                        "return" => "Back",
                        "text_1" => "",
                        "text_2" => "",
                        "title" => "Add a fee to the AddWorking Invoice No."
                    ],
                    "index" => [
                        "calculate_commissions" => "Calculate fees",
                        "create" => "Add",
                        "export" => "Export",
                        "return" => "Back",
                        "text_1" => "The AddWorking Invoice No.",
                        "text_2" => "of the Company",
                        "text_3" => "has no AddWorking fees.",
                        "title" => "Fees related to Invoice No. "
                    ],
                    "index_credit_fees" => [
                        "cancel_commissions" => "Cancel fees",
                        "return" => "Back",
                        "title" => "Fees related to Invoice No. "
                    ]
                ],
                "file" => [
                    "_annex" => [
                        "annex_details" => "Annex: details of subcontractors",
                        "code_analytic" => "Analytical code",
                        "management_fees_ht" => "Management fees excl. tax.",
                        "mission_code" => "Work #",
                        "name" => "Name of Subcontractor",
                        "price_ht" => "Price excl. tax.",
                        "ref_mission" => "Work Ref ",
                        "subcontracter_code" => "Subcontractor code",
                        "total_ht" => "Total excl. tax. ",
                        "wording" => "Label"
                    ],
                    "_enterprises" => [
                        "addworking" => "ADDWORKING",
                        "contract_number" => "CPS1 Contract No.",
                        "date" => "Dated:",
                        "france" => "France",
                        "invoice_number" => "Invoice No.",
                        "line_1" => "17 RUE LAC SAINT ANDRE",
                        "line_2" => "73370 LE BOURGET DU LAC",
                        "line_3" => "Intra-community VAT number: FR71810840900 00015",
                        "line_4" => "Represented by Julien PERONA",
                        "line_5" => "DAILLY Debt Write-off",
                        "line_6" => "BPI FRANCE FINANCING",
                        "of" => "Of:",
                        "parent_invoice_number" => "Parent invoice number:"
                    ],
                    "_footer" => [
                        "addworking" => "ADDWORKING",
                        "line_1" => "Simplified Joint Stock Company with capital of ? 143,645.00 - RCS CHAMBERY 810 840 900 - Intra-community VAT number: FR71810840900 00015",
                        "line_2" => "17 rue du Lac Saint AndrÇ - Savoie Technolac - BP 350 - 73370 Le Bourget du Lac - FRANCE",
                        "line_3" => "contact@addworking.com"
                    ],
                    "_header" => ["credit_note_invoice" => "Invoice No.", "invoice_number" => "Invoice No."],
                    "_legal_notice" => [
                        "line_1" => "REVERSE CHARGING VAT - in application of article 242 nonies A, I-13 ¯ Annex II to the French General Tax Code",
                        "line_2" => "To be discharged, the payment of this invoice must be made on our account opened at BPI France Financement:",
                        "line_3" => "IBAN: CPMEFRPPXXX / FR76 1835 9000 4300 0202 5754 547",
                        "line_4" => "Institution code: 18359, Branch code: 00043, Account number 00020257545, Key 47",
                        "line_5" => "BPI France Financing, Accounting Movements of funds - Banks",
                        "line_6" => "27-31 avenue du GÇnÇral Leclerc, 94710 Maisons-Alfort Cedex"
                    ],
                    "_lines" => [
                        "amount_ht" => "Total excl. tax.",
                        "line_1" => "ADDWORKING - Subcontractor management fees",
                        "line_2" => "ADDWORKING - Subscription fees",
                        "line_3" => "ADDWORKING -",
                        "line_4" => "Referenced Subcontractors",
                        "line_5" => "ADDWORKING - Discount",
                        "name" => "Name of Subcontractor",
                        "period" => "Period",
                        "subcontracted_code" => "Subcontractor code",
                        "subcontracter_code" => "Subcontractor code"
                    ],
                    "_summary" => [
                        "amount" => "Amount",
                        "benifits" => "SERVICES EXCL. TAX.",
                        "iban_for_transfer" => "IBAN for transfer",
                        "line_1" => "FR76 1835 9000 4300 0202 5754 547",
                        "management_fees_ht" => "Management fees excl. tax.",
                        "payment_deadline" => "Payment deadline",
                        "referrence" => "Reference to remind on the transfer",
                        "total_ht" => "Total excl. tax. ",
                        "total_ttc" => "Total incl. tax.",
                        "total_vat" => "Total of taxes",
                        "vat" => "Name",
                        "vat_summary" => "of which"
                    ]
                ],
                "generate_file" => [
                    "address" => "Client invoicing address",
                    "generate_file" => "Generate file",
                    "legal_notice" => "Legal Notice",
                    "received_by_assignment_daily" => "DAILLY Debt Write-off",
                    "return" => "Back",
                    "reverse_vat" => "Reverse charge of VAT",
                    "title" => "Generate file of invoice No."
                ],
                "index" => [
                    "create_invoice" => "Create an invoice",
                    "text" => "does not have any AddWorking invoices.",
                    "the_enterprise" => "The Company",
                    "title" => "AddWorking invoices for the Company"
                ],
                "item" => [
                    "_actions" => ["confirm_delete" => "Sure to delete?", "delete" => "Remove"],
                    "_breadcrumb" => [
                        "addworking_invoices" => "AddWorking invoices",
                        "create" => "Create",
                        "dashboard" => "Dashboard",
                        "invoice_lines" => "Invoice Lines",
                        "invoice_number" => "Invoice No."
                    ],
                    "_form" => [
                        "label" => "Label",
                        "quantity" => "Quantity",
                        "unit_price" => "Unit price",
                        "vat_rate" => "VAT rate"
                    ],
                    "_table_head" => [
                        "action" => "Action",
                        "amount_ht" => "Total excl. tax.",
                        "invoice_number" => "Invoice No.",
                        "label" => "Label",
                        "number" => "Number",
                        "quantity" => "Quantity",
                        "service_provider" => "Subcontractor",
                        "unit_price" => "Unit price",
                        "vat_rate" => "VAT rate"
                    ],
                    "associate_credit_line" => [
                        "action" => "Action",
                        "amount_ht" => "Total excl. tax.",
                        "create" => "Create",
                        "invoice_number" => "Invoice No.",
                        "label" => "Label",
                        "label_1" => "Create credit note lines for selected lines",
                        "number" => "Number",
                        "quantity" => "Quantity",
                        "return" => "Back",
                        "service_provider" => "Subcontractor",
                        "text_1" => "The AddWorking invoice No.",
                        "text_2" => "has no invoice lines.",
                        "title" => "Select credit lines",
                        "unit_price" => "Unit price",
                        "vat_rate" => "VAT rate"
                    ],
                    "create" => [
                        "create" => "Create the line",
                        "return" => "Back",
                        "title" => "Create a line for the AddWorking invoice No."
                    ],
                    "index" => [
                        "create" => "Create a line",
                        "create_new" => "Create an invoice line",
                        "return" => "Back",
                        "text_1" => "The Company",
                        "text_2" => "has no invoice lines.",
                        "text_3" => "for the period",
                        "text_4" => "deadline",
                        "title" => "Lines of invoice No."
                    ],
                    "index_credit_line" => [
                        "create" => "Create a credit note line",
                        "lines_number" => "Lines of invoice No.",
                        "return" => "Back"
                    ]
                ],
                "show" => [
                    "return" => "Back",
                    "text" => "The PDF invoice is not yet generated",
                    "title" => "Invoice No.",
                    "validate" => "",
                    "vendor_invoices" => "Subcontractors Invoices"
                ],
                "support" => [
                    "_breadcrumb" => ["addworking_invoices" => "AddWorking invoices", "support" => "Support"],
                    "_filter" => [
                        "billing_period" => "Invoicing Period",
                        "enterprise" => "Company",
                        "filter" => "Filter",
                        "filters" => "Filters",
                        "invoice_date" => "Date of issue",
                        "invoice_number" => "Invoice number",
                        "payment_deadline" => "payment deadline",
                        "reset" => "Reset",
                        "status" => "Status"
                    ],
                    "_table_head" => [
                        "action" => "Action",
                        "amount_ht" => "Total excl. tax.",
                        "billing_period" => "Invoicing Period",
                        "customer_visibility" => "Client visibility",
                        "due_date" => "Date of issue",
                        "enterprise" => "Company",
                        "invoice_date" => "Due Date",
                        "invoice_number" => "Invoice number",
                        "payment_deadline" => "Payment deadline",
                        "status" => "Status",
                        "tax_amount" => "Total of taxes",
                        "total_ttc" => "Total (incl tax)"
                    ],
                    "index" => ["text" => "No AddWorking Invoice."]
                ]
            ]
        ]
    ]
];
