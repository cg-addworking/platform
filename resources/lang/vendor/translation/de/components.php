<?php
return [
    "alterable" => ["save" => "Speichern"],
    "contract" => [
        "contract" => [
            "application" => [
                "requests" => ["store_contract_request" => ["messages" => ["before_or_equal" => ""]]],
                "views" => [
                    "contract" => [
                        "_actions" => [
                            "add_part" => "",
                            "back" => "",
                            "cancel" => "",
                            "create_amendment" => "",
                            "deactivate" => "",
                            "delete" => "",
                            "edit" => "",
                            "edit_contract_party" => "",
                            "nba_generate" => "",
                            "nba_parties" => "",
                            "nba_send" => "",
                            "regenerate_contract" => "",
                            "show" => "",
                            "sign" => "",
                            "upload_signed_contract" => "",
                            "variable_list" => ""
                        ],
                        "_breadcrumb" => [
                            "create" => "",
                            "create_amendment" => "",
                            "create_part" => "",
                            "dashboard" => "",
                            "edit" => "",
                            "index" => "",
                            "show" => "",
                            "sign" => "",
                            "upload_signed_contract" => ""
                        ],
                        "_filters" => [
                            "active" => "",
                            "being_signed" => "",
                            "cancelled" => "",
                            "declined" => "",
                            "draft" => "",
                            "enterprise" => "",
                            "error" => "",
                            "expired" => "",
                            "generated" => "",
                            "generating" => "",
                            "inactive" => "",
                            "locked" => "",
                            "party" => "",
                            "published" => "",
                            "ready_to_generate" => "",
                            "ready_to_sign" => "",
                            "signed" => "",
                            "state" => "",
                            "status" => "",
                            "unknown" => "",
                            "uploaded" => "",
                            "uploading" => ""
                        ],
                        "_form" => [
                            "amendment_name_preset" => "",
                            "amendment_without_contract_model" => "",
                            "contract_model" => "",
                            "enterprise" => "",
                            "enterprise_owner" => "",
                            "external_identifier" => "",
                            "general_information" => "",
                            "mission" => "",
                            "mission_create" => "",
                            "mission_none" => "",
                            "mission_select" => "",
                            "name" => "",
                            "valid_from" => "",
                            "valid_until" => ""
                        ],
                        "_form_without_model" => [
                            "contract_body" => "",
                            "contract_informations" => "",
                            "designation" => "",
                            "display_name" => "",
                            "enterprise" => "",
                            "external_identifier" => "",
                            "file" => "",
                            "name" => "",
                            "owner" => "",
                            "part_informations" => "",
                            "parties_informations" => "",
                            "party_1_designation" => "",
                            "party_2_designation" => "",
                            "select_file" => "",
                            "signatory" => "",
                            "signed_at" => "",
                            "valid_from" => "",
                            "valid_until" => ""
                        ],
                        "_html" => [
                            "amendment_contracts" => "",
                            "created_at" => "",
                            "documents" => "",
                            "download" => "",
                            "informations" => "",
                            "mission" => "",
                            "more_informations" => "",
                            "owner" => "",
                            "parent_contract" => "",
                            "parties" => "",
                            "parts" => "",
                            "party_signed_at" => "",
                            "state" => "",
                            "status" => "",
                            "updated_at" => "",
                            "valid_from" => "",
                            "valid_until" => "",
                            "valid_until_date" => ""
                        ],
                        "_state" => [
                            "active" => "",
                            "canceled" => "",
                            "declined" => "",
                            "draft" => "",
                            "due" => "",
                            "in_writing" => "",
                            "inactive" => "",
                            "is_ready_to_generate" => "",
                            "signed" => "",
                            "to_be_distributed_for_further_information" => "",
                            "to_complete" => "",
                            "to_countersign" => "",
                            "to_sign" => "",
                            "unknown" => ""
                        ],
                        "_status" => [
                            "active" => "",
                            "being_signed" => "",
                            "cancelled" => "",
                            "declined" => "",
                            "draft" => "",
                            "error" => "",
                            "expired" => "",
                            "generated" => "",
                            "generating" => "",
                            "inactive" => "",
                            "locked" => "",
                            "published" => "",
                            "ready_to_generate" => "",
                            "ready_to_sign" => "",
                            "signed" => "",
                            "unknown" => "",
                            "uploaded" => "",
                            "uploading" => ""
                        ],
                        "_table_head" => [
                            "actions" => "",
                            "enterprise" => "",
                            "model" => "",
                            "name" => "",
                            "number" => "",
                            "parties" => "",
                            "state" => "",
                            "status" => "",
                            "valid_from" => "",
                            "valid_until" => ""
                        ],
                        "create" => ["create" => "", "return" => "", "title" => ""],
                        "create_amendment" => ["title" => ""],
                        "create_without_model" => ["return" => "", "submit" => "", "title" => ""],
                        "edit" => ["edit" => "", "title" => ""],
                        "index" => [
                            "contract_model" => "",
                            "create" => "",
                            "createContractWithoutModel" => "",
                            "return" => "",
                            "title" => ""
                        ],
                        "mail" => [
                            "addworking_team" => "",
                            "consult_button" => "",
                            "contract_needs_documents" => [
                                "addworking_team" => "",
                                "consult_button" => "",
                                "greetings" => "",
                                "sentence_one" => "",
                                "sentence_two" => "",
                                "thanks_you" => ""
                            ],
                            "greetings" => "",
                            "sentence_one" => "",
                            "sentence_two" => "",
                            "thanks_you" => ""
                        ],
                        "show" => [
                            "edit_variable" => "",
                            "generate_contract" => "",
                            "return" => "",
                            "sign" => "",
                            "upload_documents" => ""
                        ],
                        "upload_signed_contract" => [
                            "display_name" => "",
                            "file" => "",
                            "party_signed_at" => "",
                            "return" => "",
                            "select_file" => "",
                            "submit" => "",
                            "title" => ""
                        ]
                    ],
                    "contract_part" => [
                        "_actions" => ["delete" => ""],
                        "_form" => ["display_name" => "", "file" => "", "select_file" => ""],
                        "create" => ["return" => "", "submit" => "", "title" => ""]
                    ],
                    "contract_party" => [
                        "_breadcrumb" => [
                            "create" => "",
                            "dashboard" => "",
                            "index" => "",
                            "index_contract" => "",
                            "show_contract" => ""
                        ],
                        "_form" => [
                            "confirm_edit" => "",
                            "denomination" => "",
                            "enterprise" => "",
                            "general_information" => "",
                            "order" => "",
                            "party" => "",
                            "signatory" => "",
                            "signed_at" => ""
                        ],
                        "create" => ["create" => "", "return" => "", "title" => ""]
                    ],
                    "contract_party_document" => [
                        "_breadcrumb" => ["dashboard" => "", "index" => "", "index_contract" => "", "show_contract" => ""],
                        "index" => ["return" => "", "title" => ""]
                    ],
                    "contract_variable" => [
                        "_breadcrumb" => [
                            "dashboard" => "",
                            "define_value" => "",
                            "edit" => "",
                            "index" => "",
                            "index_contract" => "",
                            "show_contract" => ""
                        ],
                        "_filters" => [
                            "filter" => "",
                            "model_variable_display_name" => "",
                            "model_variable_input_type" => "",
                            "model_variable_model_part_display_name" => "",
                            "model_variable_required" => "",
                            "reset" => "",
                            "value" => ""
                        ],
                        "_form" => [
                            "denomination_party" => "",
                            "display_name" => "",
                            "edit_variable_value" => "",
                            "value" => ""
                        ],
                        "_table_head" => [
                            "contract_model_display_name" => "",
                            "contract_model_input_type" => "",
                            "contract_model_part_name" => "",
                            "contract_party_enterprise_name" => "",
                            "required" => "",
                            "value" => ""
                        ],
                        "define_value" => ["create" => "", "edit" => "", "return" => "", "title" => ""],
                        "error" => ["no_variable_to_edit" => ""],
                        "index" => ["define_value" => "", "return" => "", "table_row_empty" => "", "title" => ""]
                    ]
                ]
            ]
        ],
        "model" => [
            "application" => [
                "models" => [
                    "contract_model_variable" => [
                        "input_type" => [
                            "contract_enterprise_owner" => "",
                            "contract_external_identifier" => "",
                            "contract_title" => "",
                            "contract_valid_from" => "",
                            "contract_valid_until" => "",
                            "date" => "",
                            "enterprise_address" => "",
                            "enterprise_identification_number" => "",
                            "enterprise_legal_form" => "",
                            "enterprise_name" => "",
                            "enterprise_siren_number" => "",
                            "enterprise_title" => "",
                            "party_title" => "",
                            "registration_town" => "",
                            "signatory_function" => "",
                            "signatory_mail" => "",
                            "signatory_name" => "",
                            "signatory_title" => "",
                            "text" => "",
                            "text_title" => ""
                        ]
                    ]
                ],
                "views" => [
                    "contract_model" => [
                        "_actions" => [
                            "add_part" => "",
                            "consult" => "",
                            "delete" => "",
                            "duplicate" => "",
                            "edit" => "",
                            "index_part" => "",
                            "index_variable" => "",
                            "index_variables" => "",
                            "preview" => ""
                        ],
                        "_breadcrumb" => ["create" => "", "dashboard" => "", "edit" => "", "index" => "", "show" => ""],
                        "_form" => ["display_name" => "", "enterprise" => "", "general_information" => ""],
                        "_html" => [
                            "archived_date" => "",
                            "created_date" => "",
                            "delete" => "",
                            "display_name" => "",
                            "document_types" => "",
                            "enterprise" => "",
                            "id" => "",
                            "last_modified_date" => "",
                            "parties" => "",
                            "published_date" => "",
                            "status" => ""
                        ],
                        "_table_head" => [
                            "actions" => "",
                            "archived_at" => "",
                            "created_at" => "",
                            "display_name" => "",
                            "enterprise" => "",
                            "number" => "",
                            "published_at" => "",
                            "status" => ""
                        ],
                        "create" => ["create" => "", "parties" => "", "party" => "", "return" => "", "title" => ""],
                        "edit" => ["edit" => "", "party" => "", "title" => ""],
                        "index" => [
                            "button_create" => "",
                            "part" => "",
                            "publish_button" => "",
                            "return" => "",
                            "table_row_empty" => "",
                            "title" => ""
                        ],
                        "show" => ["back" => "", "part" => "", "publish_button" => "", "return" => "", "variable" => ""]
                    ],
                    "contract_model_document_type" => [
                        "_actions" => ["delete" => ""],
                        "_breadcrumb" => [
                            "create" => "",
                            "dashboard" => "",
                            "document_type" => "",
                            "index" => "",
                            "party" => "",
                            "show" => ""
                        ],
                        "_form" => [
                            "add" => "",
                            "document_type" => "",
                        ],
                        "_table_head" => [
                            "actions" => "",
                            "created_at" => "",
                            "document_type" => "",
                            "validation_by" => "",
                        ],
                        "create" => ["create" => "", "return" => "", "title" => ""],
                        "index" => ["button_create" => "", "return" => "", "table_row_empty" => "", "title" => ""]
                    ],
                    "contract_model_part" => [
                        "_actions" => ["delete" => "", "preview" => ""],
                        "_breadcrumb" => [
                            "create" => "",
                            "dashboard" => "",
                            "edit" => "",
                            "index" => "",
                            "parts" => "",
                            "show" => ""
                        ],
                        "_form" => [
                            "display_name" => "",
                            "file" => "",
                            "general_information" => "",
                            "information" => [
                                "call_to_action" => "",
                                "modal" => [
                                    "main_title" => "",
                                    "paragraph_1_1" => "",
                                    "paragraph_1_10" => "",
                                    "paragraph_1_11" => "",
                                    "paragraph_1_12" => "",
                                    "paragraph_1_13" => "",
                                    "paragraph_1_14" => "",
                                    "paragraph_1_15" => "",
                                    "paragraph_1_2" => "",
                                    "paragraph_1_3" => "",
                                    "paragraph_1_5" => "",
                                    "paragraph_1_6" => "",
                                    "paragraph_1_7" => "",
                                    "paragraph_1_8" => "",
                                    "paragraph_1_9" => "",
                                    "paragraph_2_1" => "",
                                    "title_1" => "",
                                    "title_2" => ""
                                ],
                                "paragraph_1" => "",
                                "paragraph_2" => "",
                                "paragraph_3" => "",
                                "paragraph_4" => "",
                                "paragraph_5" => "",
                                "paragraph_6" => "",
                                "paragraph_7" => "",
                                "paragraph_8" => ""
                            ],
                            "is_initialled" => "",
                            "is_signed" => "",
                            "no" => "",
                            "order" => "",
                            "part_type" => "",
                            "signature_mention" => "",
                            "signature_page" => "",
                            "signature_position" => "",
                            "textarea" => "",
                            "yes" => ""
                        ],
                        "_table_head" => [
                            "actions" => "",
                            "display_name" => "",
                            "id" => "",
                            "is_initialled" => "",
                            "is_signed" => "",
                            "order" => ""
                        ],
                        "contract_model_variable" => [
                            "_breadcrumb" => ["dashboard" => "", "index" => "", "show" => "", "variables" => ""],
                            "_table_head" => [
                                "actions" => "",
                                "default_value" => "",
                                "description" => "",
                                "display_name" => "",
                                "id" => "",
                                "input_type" => "",
                                "part_name" => "",
                                "party_denomination" => "",
                                "required" => ""
                            ],
                            "index" => ["return" => "", "table_row_empty" => "", "title" => ""]
                        ],
                        "create" => ["create" => "", "parties" => "", "party" => "", "return" => "", "title" => ""],
                        "edit" => [
                            "_actions" => ["delete" => "", "preview" => ""],
                            "_breadcrumb" => ["create" => "", "dashboard" => "", "edit" => "", "index" => "", "show" => ""],
                            "edit" => "",
                            "party" => "",
                            "title" => ""
                        ],
                        "index" => [
                            "button_create" => "",
                            "create" => "",
                            "return" => "",
                            "table_row_empty" => "",
                            "title" => ""
                        ]
                    ],
                    "contract_model_variable" => [
                        "_breadcrumb" => ["dashboard" => "", "edit" => "", "index" => "", "show" => "", "variables" => ""],
                        "_filters" => [
                            "active" => "",
                            "being_signed" => "",
                            "cancelled" => "",
                            "declined" => "",
                            "draft" => "",
                            "enterprise" => "",
                            "error" => "",
                            "expired" => "",
                            "generated" => "",
                            "generating" => "",
                            "inactive" => "",
                            "locked" => "",
                            "party" => "",
                            "published" => "",
                            "ready_to_generate" => "",
                            "ready_to_sign" => "",
                            "signed" => "",
                            "status" => "",
                            "unknown" => "",
                            "uploaded" => "",
                            "uploading" => ""
                        ],
                        "_form" => [
                            "amendment_name_preset" => "",
                            "amendment_without_contract_model" => "",
                            "contract_model" => "",
                            "default_value" => "",
                            "description" => "",
                            "display_name" => "",
                            "enterprise" => "",
                            "enterprise_owner" => "",
                            "external_identifier" => "",
                            "general_information" => "",
                            "input_type" => "",
                            "name" => "",
                            "required" => "",
                            "valid_from" => "",
                            "valid_until" => "",
                            "variable" => ""
                        ],
                        "_form_without_model" => [
                            "actions" => "",
                            "contract_informations" => "",
                            "designation" => "",
                            "display_name" => "",
                            "enterprise" => "",
                            "external_identifier" => "",
                            "file" => "",
                            "name" => "",
                            "number" => "",
                            "owner" => "",
                            "part_informations" => "",
                            "parties_informations" => "",
                            "select_file" => "",
                            "signatory" => "",
                            "valid_from" => "",
                            "valid_until" => ""
                        ],
                        "_status" => [
                            "active" => "",
                            "being_signed" => "",
                            "cancelled" => "",
                            "declined" => "",
                            "draft" => "",
                            "error" => "",
                            "expired" => "",
                            "generated" => "",
                            "generating" => "",
                            "inactive" => "",
                            "locked" => "",
                            "published" => "",
                            "ready_to_generate" => "",
                            "ready_to_sign" => "",
                            "signed" => "",
                            "unknown" => "",
                            "uploaded" => "",
                            "uploading" => ""
                        ],
                        "_table_head" => [
                            "actions" => "",
                            "default_value" => "",
                            "description" => "",
                            "display_name" => "",
                            "enterprise" => "",
                            "input_type" => "",
                            "model" => "",
                            "name" => "",
                            "part_name" => "",
                            "parties" => "",
                            "party_denomination" => "",
                            "required" => "",
                            "status" => "",
                            "valid_from" => "",
                            "valid_until" => ""
                        ],
                        "create_without_model" => ["return" => "", "submit" => "", "title" => ""],
                        "edit" => [
                            "create_amendment" => "",
                            "create_part" => "",
                            "edit" => "",
                            "return" => "",
                            "title" => "",
                            "upload_signed_contract" => ""
                        ],
                        "index" => [
                            "create" => "",
                            "createContractWithoutModel" => "",
                            "edit" => "",
                            "return" => "",
                            "table_row_empty" => "",
                            "title" => ""
                        ],
                        "show" => ["return" => "", "title" => ""],
                        "upload_signed_contract" => [
                            "display_name" => "",
                            "file" => "",
                            "party_signed_at" => "",
                            "return" => "",
                            "select_file" => "",
                            "submit" => "",
                            "title" => ""
                        ]
                    ]
                ]
            ]
        ]
    ],
    "enterprise_finder" => [
        "companies_found" => "Gefundene Unternehmen",
        "enterprise" => "Unternehmen",
        "error_occurred" => "Ein Fehler ist aufgetreten ! Wenn das Problem weiterhin besteht, wenden Sie sich an den"
    ],
    "form" => [
        "checkbox_list" => ["select_all" => "Alles wählen "],
        "group" => ["required_field" => "Pflichtfeld"],
        "modal" => ["register" => "Speichern"],
        "qualification_list" => [
            "being_obtained" => "Im Gange",
            "no" => "Nein",
            "yes" => "Ja",
            "yes_probative" => "Ja, möglich"
        ]
    ],
    "modal" => [
        "confirm" => ["no" => "Nein", "yes" => "Ja"],
        "post_confirm" => ["no" => "Nein", "yes" => "Ja"]
    ],
    "modal2" => ["to_close" => "Schließen"],
    "sogetrel" => [
        "mission" => [
            "application" => [
                "policies" => [
                    "create" => ["denied_must_be_support_user" => ""],
                    "create_support" => ["denied_must_be_support_user" => ""],
                    "index" => ["denied_must_be_support_user" => ""],
                    "index_support" => ["denied_must_be_support_user" => ""],
                    "update" => ["denied_must_be_support_user" => ""],
                    "view" => ["denied_must_be_support_user" => ""]
                ],
                "views" => [
                    "mission_tracking_line_attachment" => [
                        "_breadcrumb" => ["create" => "", "edit" => "", "index" => ""],
                        "_form" => ["period" => "", "title" => ""],
                        "_html" => [
                            "amount" => "",
                            "created_at" => "",
                            "direct_billing" => "",
                            "id" => "",
                            "label" => "",
                            "num_attachment" => "",
                            "num_order" => "",
                            "num_site" => "",
                            "reverse_charges" => "",
                            "signed_at" => "",
                            "submitted_at" => "",
                            "updated_at" => ""
                        ],
                        "_period_selector" => ["customer" => "", "milestone" => "", "mission" => "", "vendor" => ""],
                        "create" => [
                            "amount" => "",
                            "direct_billing" => "",
                            "file" => "",
                            "num_attachment" => "",
                            "num_order" => "",
                            "num_site" => "",
                            "return" => "",
                            "reverse_charges" => "",
                            "save" => "",
                            "signed_at" => "",
                            "submitted_at" => "",
                            "title" => ""
                        ],
                        "create_support" => [
                            "amount" => "",
                            "customer" => "",
                            "direct_billing" => "",
                            "file" => "",
                            "milestone" => "",
                            "mission" => "",
                            "num_attachment" => "",
                            "num_order" => "",
                            "num_site" => "",
                            "reverse_charges" => "",
                            "save" => "",
                            "signed_at" => "",
                            "title" => "",
                            "vendor" => ""
                        ],
                        "edit" => ["return" => "", "save" => "", "title" => ""],
                        "index" => [
                            "add" => "",
                            "amount" => "",
                            "customer" => "",
                            "direct_billing" => "",
                            "doesnt_have_inbound_invoice" => "",
                            "doesnt_have_outbound_invoice" => "",
                            "empty" => "",
                            "filter_inbound_invoice" => "",
                            "filter_outbound_invoice" => "",
                            "has_inbound_invoice" => "",
                            "has_outbound_invoice" => "",
                            "inbound_invoice" => "",
                            "milestone" => "",
                            "mission" => "",
                            "num_attachment" => "",
                            "num_order" => "",
                            "outbound_invoice" => "",
                            "signed_at" => "",
                            "title" => "",
                            "vendor" => ""
                        ],
                        "show" => ["return" => "", "tab_file" => "", "tab_summary" => "", "title" => ""]
                    ],
                    "support_mission_tracking_line_attachment" => [
                        "index" => [
                            "add" => "",
                            "amount" => "",
                            "customer" => "",
                            "direct_billing" => "",
                            "doesnt_have_inbound_invoice" => "",
                            "doesnt_have_outbound_invoice" => "",
                            "filter_inbound_invoice" => "",
                            "filter_outbound_invoice" => "",
                            "has_inbound_invoice" => "",
                            "has_outbound_invoice" => "",
                            "inbound_invoice" => "",
                            "milestone" => "",
                            "mission" => "",
                            "num_attachment" => "",
                            "num_order" => "",
                            "outbound_invoice" => "",
                            "signed_at" => "",
                            "title" => "",
                            "vendor" => ""
                        ]
                    ]
                ]
            ]
        ]
    ]
];
