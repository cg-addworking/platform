<?php
return [
    "outbound" => [
        "application" => [
            "views" => [
                "_actions" => [
                    "addworking_commissions" => "",
                    "consult" => "",
                    "create_credit_note_invoice" => "",
                    "credit_lines" => "",
                    "edit" => "",
                    "generate_pdf" => "",
                    "invoice_lines" => "",
                    "payment_orders" => "",
                    "supplier_invoice_included" => ""
                ],
                "_breadcrumb" => [
                    "addworking_commission" => "",
                    "addworking_commissions" => "",
                    "addworking_invoices" => "",
                    "calculate_commissions" => "",
                    "create" => "",
                    "create_credit_lines" => "",
                    "dashboard" => "",
                    "edit" => "",
                    "generate_file" => "",
                    "invoice_number" => "",
                    "number" => "",
                    "provider_invoice" => ""
                ],
                "_filter" => [
                    "bill_number" => "",
                    "billing_period" => "",
                    "due_date" => "",
                    "filter" => "",
                    "invoice_date" => "",
                    "payment_deadline" => "",
                    "reset" => "",
                    "status" => ""
                ],
                "_form" => [
                    "billing_period" => "",
                    "due_date" => "",
                    "innvoice_date" => "",
                    "invoice_date" => "",
                    "payment_deadline" => ""
                ],
                "_html" => [
                    "amount_excluding_taxes" => "",
                    "amount_including_taxes" => "",
                    "client" => "",
                    "copy_to_clipboard" => "",
                    "created_date" => "",
                    "due_date" => "",
                    "issue_date" => "",
                    "last_modified_date" => "",
                    "legal_notice" => "",
                    "number" => "",
                    "parent_invoice_number" => "",
                    "period" => "",
                    "received_by_assignment_daily" => "",
                    "reverse_vat" => "",
                    "status" => "",
                    "updated_by" => "",
                    "uuid" => "",
                    "vat_amount" => ""
                ],
                "_status" => [
                    "fees_calculated" => "",
                    "file_generated" => "",
                    "fully_paid" => "",
                    "partially_paid" => "",
                    "pending" => "",
                    "validated" => ""
                ],
                "_table_head" => [
                    "action" => "",
                    "amount_ht" => "",
                    "bill_number" => "",
                    "create_invoice" => "",
                    "customer_visibility" => "",
                    "deadline" => "",
                    "does_not_have_invoices" => "",
                    "due_at" => "",
                    "invoiced_at" => "",
                    "month" => "",
                    "status" => "",
                    "tax" => "",
                    "the_enterprise" => "",
                    "total" => ""
                ],
                "_table_row_empty" => ["create_invoice" => "", "does_not_have_invoices" => "", "the_enterprise" => ""],
                "associate" => [
                    "action" => "",
                    "amount_ht" => "",
                    "associate" => "",
                    "associate_selected_invoice" => "",
                    "billing_period" => "",
                    "invoice_number" => "",
                    "note" => "",
                    "payment_deadline" => "",
                    "remains_to_be_invoiced" => "",
                    "return" => "",
                    "service_provider" => "",
                    "status" => "",
                    "text_1" => "",
                    "text_2" => "",
                    "text_3" => "",
                    "the_enterprise" => "",
                    "total" => ""
                ],
                "create" => ["create_invoice" => "", "create_invoice_for" => "", "return" => ""],
                "dissociate" => [
                    "action" => "",
                    "amount_ht" => "",
                    "associate_invoice" => "",
                    "billing_period" => "",
                    "dissociate" => "",
                    "export" => "",
                    "invoice_number" => "",
                    "payment_deadline" => "",
                    "reset_invoice" => "",
                    "return" => "",
                    "service_provider" => "",
                    "status" => "",
                    "text_1" => "",
                    "text_2" => "",
                    "text_3" => "",
                    "the_enterprise" => "",
                    "title" => "",
                    "total" => "",
                    "ungroup_selected_invoice" => ""
                ],
                "edit" => ["edit_invoice" => "", "return" => "", "status" => "", "title" => ""],
                "fee" => [
                    "_actions" => ["confirm_delete" => "", "delete" => ""],
                    "_table_head" => [
                        "actions" => "",
                        "amount" => "",
                        "label" => "",
                        "number" => "",
                        "service_provider" => "",
                        "tax_amount_invoice_line" => "",
                        "type" => "",
                        "vat_rate" => ""
                    ],
                    "_table_head_associate" => [
                        "actions" => "",
                        "amount" => "",
                        "label" => "",
                        "number" => "",
                        "service_provider" => "",
                        "tax_amount_invoice_line" => "",
                        "type" => "",
                        "vat_rate" => ""
                    ],
                    "_table_head_credit_fees" => [
                        "actions" => "",
                        "amount" => "",
                        "label" => "",
                        "number" => "",
                        "service_provider" => "",
                        "tax_amount_invoice_line" => "",
                        "type" => "",
                        "vat_rate" => ""
                    ],
                    "_table_row_associate" => ["cancel" => ""],
                    "_type" => [
                        "custom_management_fees" => "",
                        "default_management_fees" => "",
                        "discount" => "",
                        "fixed_fees" => "",
                        "other" => "",
                        "subscription" => ""
                    ],
                    "associate_credit_fees" => [
                        "cancel_selected" => "",
                        "return" => "",
                        "text_1" => "",
                        "text_2" => "",
                        "title" => ""
                    ],
                    "calculate" => [
                        "calculate_commissions" => "",
                        "return" => "",
                        "text_1" => "",
                        "text_2" => "",
                        "title" => ""
                    ],
                    "create" => [
                        "calculate_commissions" => "",
                        "create" => "",
                        "return" => "",
                        "text_1" => "",
                        "text_2" => "",
                        "title" => ""
                    ],
                    "index" => [
                        "calculate_commissions" => "",
                        "create" => "",
                        "export" => "",
                        "return" => "",
                        "text_1" => "",
                        "text_2" => "",
                        "text_3" => "",
                        "title" => ""
                    ],
                    "index_credit_fees" => ["cancel_commissions" => "", "return" => "", "title" => ""]
                ],
                "file" => [
                    "_annex" => [
                        "annex_details" => "",
                        "code_analytic" => "",
                        "management_fees_ht" => "",
                        "mission_code" => "",
                        "name" => "",
                        "price_ht" => "",
                        "ref_mission" => "",
                        "subcontracter_code" => "",
                        "total_ht" => "",
                        "wording" => ""
                    ],
                    "_enterprises" => [
                        "addworking" => "",
                        "contract_number" => "",
                        "date" => "",
                        "france" => "",
                        "invoice_number" => "",
                        "line_1" => "",
                        "line_2" => "",
                        "line_3" => "",
                        "line_4" => "",
                        "line_5" => "",
                        "line_6" => "",
                        "of" => ""
                    ],
                    "_footer" => ["addworking" => "", "line_1" => "", "line_2" => "", "line_3" => ""],
                    "_header" => ["invoice_number" => ""],
                    "_legal_notice" => [
                        "line_1" => "",
                        "line_2" => "",
                        "line_3" => "",
                        "line_4" => "",
                        "line_5" => "",
                        "line_6" => ""
                    ],
                    "_lines" => [
                        "amount_ht" => "",
                        "line_1" => "",
                        "line_2" => "",
                        "line_3" => "",
                        "line_4" => "",
                        "line_5" => "",
                        "name" => "",
                        "period" => "",
                        "subcontracted_code" => "",
                        "subcontracter_code" => ""
                    ],
                    "_summary" => [
                        "benifits" => "",
                        "iban_for_transfer" => "",
                        "line_1" => "",
                        "management_fees_ht" => "",
                        "payment_deadline" => "",
                        "referrence" => "",
                        "total_ht" => "",
                        "total_ttc" => "",
                        "total_vat" => ""
                    ]
                ],
                "generate_file" => [
                    "address" => "",
                    "generate_file" => "",
                    "legal_notice" => "",
                    "received_by_assignment_daily" => "",
                    "return" => "",
                    "reverse_vat" => "",
                    "title" => ""
                ],
                "index" => ["create_invoice" => "", "text" => "", "the_enterprise" => "", "title" => ""],
                "item" => [
                    "_actions" => ["confirm_delete" => "", "delete" => ""],
                    "_breadcrumb" => [
                        "addworking_invoices" => "",
                        "create" => "",
                        "dashboard" => "",
                        "invoice_lines" => "",
                        "invoice_number" => ""
                    ],
                    "_form" => ["label" => "", "quantity" => "", "unit_price" => "", "vat_rate" => ""],
                    "_table_head" => [
                        "action" => "",
                        "amount_ht" => "",
                        "invoice_number" => "",
                        "label" => "",
                        "number" => "",
                        "quantity" => "",
                        "service_provider" => "",
                        "unit_price" => "",
                        "vat_rate" => ""
                    ],
                    "associate_credit_line" => [
                        "action" => "",
                        "amount_ht" => "",
                        "create" => "",
                        "invoice_number" => "",
                        "label" => "",
                        "label_1" => "",
                        "number" => "",
                        "quantity" => "",
                        "return" => "",
                        "service_provider" => "",
                        "text_1" => "",
                        "text_2" => "",
                        "title" => "",
                        "unit_price" => "",
                        "vat_rate" => ""
                    ],
                    "create" => ["create" => "", "return" => "", "title" => ""],
                    "index" => [
                        "create" => "",
                        "create_new" => "",
                        "return" => "",
                        "text_1" => "",
                        "text_2" => "",
                        "text_3" => "",
                        "text_4" => "",
                        "title" => ""
                    ],
                    "index_credit_line" => ["create" => "", "lines_number" => "", "return" => ""]
                ],
                "show" => ["return" => "", "text" => "", "title" => "", "vendor_invoices" => ""],
                "support" => [
                    "_breadcrumb" => ["addworking_invoices" => "", "support" => ""],
                    "_filter" => [
                        "billing_period" => "",
                        "enterprise" => "",
                        "filter" => "",
                        "filters" => "",
                        "invoice_date" => "",
                        "invoice_number" => "",
                        "payment_deadline" => "",
                        "reset" => "",
                        "status" => ""
                    ],
                    "_table_head" => [
                        "action" => "",
                        "amount_ht" => "",
                        "billing_period" => "",
                        "customer_visibility" => "",
                        "due_date" => "",
                        "enterprise" => "",
                        "invoice_date" => "",
                        "invoice_number" => "",
                        "payment_deadline" => "",
                        "status" => "",
                        "tax_amount" => "",
                        "total_ttc" => ""
                    ],
                    "index" => ["text" => ""]
                ]
            ]
        ]
    ]
];
