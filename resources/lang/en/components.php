<?php
return [
    "alterable" => ["save" => "Save"],
    "contract" => [
        "contract" => [
            "application" => [
                "requests" => [
                    "store_contract_request" => [
                        "messages" => [
                            "before_or_equal" => "The :attribute field must be a date before or equal to today's date"
                        ]
                    ]
                ],
                "tracking" => [
                    "addworking" => "AddWorking",
                    "contract_archived" => "archived this contract",
                    "contract_callback" => "retrieved the contract on :date",
                    "contract_expires" => "Contract has expired",
                    "contract_is_active" => "passed the contract to asset",
                    "contract_pre_expire_notification" => "notified that the contract was set to expire in 30 days",
                    "contract_unarchived" => "retrieved this contract from the archives",
                    "contract_variable_value_was_requested" => "was invited to complete variable values by AddWorking",
                    "create_amendment" => "created the amendment :amendment_name",
                    "create_contract" => "created the contract",
                    "party_refuses_to_sign_contract" => "rejected the contract",
                    "party_signs_contract" => "signed the contract",
                    "party_validates_contract" => "approved the contract",
                    "request_send_contract_to_signature" => "sent the contract for approval to :user for their signature.",
                    "scan_urssaf_certificate_document_rejection" => "Automatic recognition could not approve the document",
                    "scan_urssaf_certificate_document_validation" => "Automatic recognition pre-checked the document",
                    "send_contract_to_signature" => "sent the contract for signature",
                    "send_contract_to_validation" => "sent the contract for approval to :user for their signature.",
                    "tracking" => "Follow-up",
                    "tracking_document" => "Restarts follow-up"
                ],
                "views" => [
                    "amendment" => [
                        "_form_without_model" => [
                            "actions" => "Actions",
                            "contract_body" => "Contract body",
                            "contract_informations" => "Contract details",
                            "designation" => "Name of stakeholder",
                            "display_name" => "Name of the contract document",
                            "enterprise" => "Stakeholder",
                            "external_identifier" => "External ID",
                            "file" => "File to be selected",
                            "name" => "Contract name",
                            "number" => "Number",
                            "owner" => "Owner company",
                            "part_informations" => "Details of the contract document",
                            "parties_informations" => "Details of stakeholders and signatories",
                            "select_file" => "Select a file",
                            "signatory" => "Signatory",
                            "signed_at" => "Date of signature",
                            "valid_from" => "Start date",
                            "valid_until" => "End date"
                        ],
                        "_form_without_model_to_sign" => [
                            "amendment_part_label" => "Name of the contract document",
                            "contract_informations" => "Contract details",
                            "display_name" => "Name of the contract document",
                            "external_identifier" => "External ID",
                            "file" => "File to be selected",
                            "name" => "Amendment name",
                            "part_informations" => "Details of the contract document",
                            "select_file" => "Select a file",
                            "valid_from" => "Start date",
                            "valid_until" => "End date"
                        ],
                        "create_without_model" => ["return" => "Back", "submit" => "Save", "title" => "Submit a signed amendment"],
                        "create_without_model_to_sign" => [
                            "return" => "Back",
                            "submit" => "Save",
                            "title" => "Submit an amendment for signature"
                        ]
                    ],
                    "annex" => [
                        "_actions" => ["delete" => "", "show" => ""],
                        "_breadcrumb" => ["create" => "", "dashboard" => "", "index" => ""],
                        "_filters" => ["enterprise" => ""],
                        "_form" => ["description" => "", "enterprise" => "", "file" => "", "name" => ""],
                        "_html" => [
                            "created_date" => "",
                            "description" => "",
                            "display_name" => "",
                            "file" => "",
                            "informations" => "",
                            "last_modified_date" => "",
                            "more_informations" => "",
                            "owner" => ""
                        ],
                        "_table_head" => [
                            "actions" => "",
                            "created_at" => "",
                            "description" => "",
                            "file" => "",
                            "name" => "",
                            "number" => ""
                        ],
                        "create" => ["return" => "", "submit" => "", "title" => ""],
                        "index" => ["create" => "", "show" => "", "title" => ""],
                        "show" => ["return" => ""]
                    ],
                    "contract" => [
                        "_actions" => [
                            "add_part" => "",
                            "archive" => "Archive",
                            "back" => "Back",
                            "call_back" => "Retrieve contract",
                            "cancel" => "Cancel",
                            "create_amendment" => "",
                            "deactivate" => "Deactivate",
                            "delete" => "Delete",
                            "download" => "Download",
                            "download_documents" => "Download linked documents",
                            "download_proof_of_signature" => "Download certificate of signature",
                            "edit" => "Modify",
                            "edit_contract_party" => "Change stakeholders",
                            "edit_validators" => "Approval circuit",
                            "link_mission" => "Link to an existing work order",
                            "nba_generate" => "Generate contract",
                            "nba_parties" => "Enter stakeholders",
                            "nba_send" => "Notify stakeholders",
                            "regenerate_contract" => "Re-generate contract",
                            "show" => "View",
                            "sign" => "Sign",
                            "unarchive" => "De-archive",
                            "update_contract_from_yousign_data" => "Update contract from yousign",
                            "upload_signed_contract" => "Update signed contract",
                            "variable_list" => "Variables"
                        ],
                        "_breadcrumb" => [
                            "create" => "Create",
                            "create_amendment" => "Create an amendment",
                            "create_part" => "Add a specific annex",
                            "dashboard" => "Dashboard",
                            "edit" => "Modify",
                            "index" => "Contracts",
                            "show" => "No. :number",
                            "sign" => "Sign",
                            "upload_signed_contract" => "Update signed contract"
                        ],
                        "_filters" => [
                            "active" => "Active",
                            "archived_contract" => "Display archived contracts ",
                            "being_signed" => "Awaiting signature",
                            "cancelled" => "Canceled",
                            "created_by" => "Contract creator",
                            "declined" => "Declined",
                            "draft" => "Draft",
                            "enterprise" => "Owner company",
                            "error" => "Error",
                            "expired" => "Expired",
                            "filter" => "",
                            "generated" => "Generated",
                            "generating" => "Generation in progress",
                            "inactive" => "Inactive",
                            "locked" => "Locked",
                            "model" => "Template",
                            "party" => "Stakeholder",
                            "published" => "Published",
                            "ready_to_generate" => "Ready for generation",
                            "ready_to_sign" => "Ready to sign",
                            "reset" => "",
                            "signed" => "Signed",
                            "state" => "State",
                            "status" => "Status",
                            "unknown" => "In an unknown state",
                            "uploaded" => "Uploaded",
                            "uploading" => "Uploading",
                            "work_field" => "Site"
                        ],
                        "_form" => [
                            "amendment_name_preset" => "Amendment :count for contract :contract_parent_name",
                            "amendment_without_contract_model" => "",
                            "contract_model" => "Contract template",
                            "contract_model_required" => "Field \"contract template\" is mandatory.",
                            "enterprise" => "Template owner company",
                            "enterprise_owner" => "Contract owner company",
                            "external_identifier" => "Contract number",
                            "general_information" => "General information",
                            "mission" => "Work",
                            "mission_create" => "Create a new work order",
                            "mission_none" => "No work order linked to this contract",
                            "mission_select" => "Select a work order",
                            "name" => "Contract name",
                            "no_selection" => "Nothing selected",
                            "valid_from" => "Start date",
                            "valid_until" => "Due Date"
                        ],
                        "_form_without_model" => [
                            "contract_body" => "Contract body",
                            "contract_informations" => "Contract details",
                            "designation" => "Name of stakeholder",
                            "display_name" => "Name of the contract document",
                            "enterprise" => "Stakeholder",
                            "external_identifier" => "External ID",
                            "file" => "File to be selected",
                            "name" => "Contract name",
                            "owner" => "Owner company",
                            "part_informations" => "Details of the contract document",
                            "parties_informations" => "Details of stakeholders and signatories",
                            "party_1_designation" => "Customer",
                            "party_2_designation" => "Subcontractor",
                            "select_file" => "Select a file",
                            "signatory" => "Signatory",
                            "signed_at" => "Date of signature",
                            "valid_from" => "Start date",
                            "valid_until" => "End date"
                        ],
                        "_form_without_model_to_sign" => [
                            "contract_informations" => "Contract details",
                            "contract_label" => "Contract name",
                            "designation" => "Name of stakeholder",
                            "display_name" => "Name of the contract document",
                            "enterprise" => "Stakeholder",
                            "external_identifier" => "External ID",
                            "file" => "File to be selected",
                            "name" => "Contract name",
                            "owner" => "Owner company",
                            "part_informations" => "Details of the contract document",
                            "parties_informations" => "Details of stakeholders and signatories",
                            "party_1_designation" => "Customer",
                            "party_2_designation" => "Subcontractor",
                            "select_file" => "Select a file",
                            "signatory" => "Signatory",
                            "valid_from" => "Start date",
                            "valid_until" => "End date"
                        ],
                        "_html" => [
                            "amendment_contracts" => "Amendments",
                            "compliance_documents" => "Compliance documents",
                            "contract_dates" => "Contract dates",
                            "contract_model" => "Contract template",
                            "contract_parts_empty" => "Currently no contract document to display.",
                            "created_at" => "Creation date",
                            "documents" => "Document(s) to be provided",
                            "download" => "Download",
                            "external_identifier" => "External ID",
                            "from" => "Of",
                            "generating_refresh" => "Refresh the page",
                            "informations" => "",
                            "mission" => "Work",
                            "more_informations" => "",
                            "non_body_contract_parts" => "Documents attached",
                            "non_body_contract_parts_empty" => "Currently no attached contract documents to display.",
                            "owner" => "Contract owner",
                            "parent_contract" => "Parent contract",
                            "parties" => "Signatories and stakeholders",
                            "parts" => "Contract document(s)",
                            "party_signed_at" => "Date of signature of :party_name",
                            "request_documents" => "Notify :party_denomination",
                            "signed_at" => "Signed on",
                            "state" => "State",
                            "status" => "Status",
                            "to" => "To",
                            "updated_at" => "Date of modification",
                            "valid_from" => "Contract Start Date",
                            "valid_until" => "Contract end date",
                            "valid_until_date" => "Original date: ",
                            "validated_at" => "Approved on",
                            "validator_parties" => "Approved by",
                            "workfield" => "Site"
                        ],
                        "_state" => [
                            "active" => "Active",
                            "archived" => "Archived",
                            "canceled" => "Canceled",
                            "declined" => "Declined",
                            "draft" => "Draft",
                            "due" => "Expired",
                            "generated" => "Ready for signature",
                            "generating" => "Generation in progress",
                            "in_preparation" => "Being prepared",
                            "in_writing" => "Being written",
                            "inactive" => "Inactive",
                            "internal_validation" => "Being approved internally",
                            "is_ready_to_generate" => "To be generated",
                            "missing_documents" => "Documents to provide",
                            "signed" => "Signed",
                            "to_be_distributed_for_further_information" => "To be distributed for additions",
                            "to_complete" => "To be added to",
                            "to_countersign" => "To be countersigned",
                            "to_sign" => "To be signed",
                            "to_sign_waiting_for_signature" => "To be signed/Awaiting signature",
                            "to_validate" => "To validate",
                            "under_validation" => "Being approved",
                            "unknown" => "Unknown",
                            "waiting_for_signature" => "Awaiting signature"
                        ],
                        "_status" => [
                            "active" => "Active",
                            "being_signed" => "Awaiting signature",
                            "cancelled" => "Canceled",
                            "declined" => "Declined",
                            "draft" => "Draft",
                            "error" => "Error",
                            "expired" => "Expired",
                            "generated" => "Generated",
                            "generating" => "Generation in progress",
                            "inactive" => "Inactive",
                            "locked" => "Locked",
                            "published" => "Published",
                            "ready_to_generate" => "Ready for generation",
                            "ready_to_sign" => "Ready to sign",
                            "signed" => "Signed",
                            "unknown" => "In an unknown state",
                            "uploaded" => "Uploaded",
                            "uploading" => "Uploading"
                        ],
                        "_table_head" => [
                            "actions" => "Actions",
                            "amount" => "Amount",
                            "contract_external_identifier" => "Contract code",
                            "contract_number" => "Contract number",
                            "contract_party_enterprise_name" => "Stakeholder",
                            "created_by" => "Contract creator",
                            "enterprise" => "Owner company",
                            "external_identifier" => "External ID",
                            "model" => "Contract template",
                            "name" => "Contract name",
                            "number" => "Number",
                            "parties" => "Stakeholders",
                            "state" => "State",
                            "status" => "Status",
                            "valid_from" => "Start date",
                            "valid_until" => "End date",
                            "workfield_external_identifier" => "Site code"
                        ],
                        "accounting_monitoring" => [
                            "_breadcrumb" => [
                                "contracts" => "Contracts",
                                "dashboard" => "Dashboard",
                                "index" => "Contract billing follow-up"
                            ],
                            "_table_head" => [
                                "actions" => "Actions",
                                "amount_before_taxes" => "Contract amount ex. tax",
                                "amount_before_taxes_invoiced" => "Invoiced amount ex. tax",
                                "amount_of_remains_to_be_billed" => "To be invoiced ex. tax",
                                "amount_of_taxes_invoiced" => "Amount of VAT",
                                "contract_number" => "Contract number",
                                "dc4" => "DC4",
                                "good_end" => "Good end",
                                "good_end_deposit" => "Good end deposit No.",
                                "good_end_value" => "Good end amount retained",
                                "guaranteed_holdback" => "Guaranteed holdback",
                                "guaranteed_holdback_deposit" => "Guaranteed holdback deposit No.",
                                "guaranteed_holdback_value" => "Guaranteed holdback amount retained",
                                "payment" => "Payment",
                                "signature" => "Date of signature",
                                "vendor" => "Subcontractor",
                                "workfield" => "Site Name"
                            ],
                            "index" => [
                                "create_capture_invoice" => "Enter an invoice",
                                "filters" => [
                                    "enterprise" => "Owner company",
                                    "filter" => "Filter",
                                    "reset" => "Reset",
                                    "work_field" => "Site"
                                ],
                                "return" => "Back",
                                "title" => "Contract billing follow-up"
                            ]
                        ],
                        "capture_invoice" => [
                            "_breadcrumb" => [
                                "contracts" => "Contracts",
                                "create" => "Enter an invoice",
                                "dashboard" => "Dashboard",
                                "index" => "Invoices entered",
                                "index_accounting_monitoring" => "Contract billing follow-up"
                            ],
                            "_form" => [
                                "amount_good_end" => "Good end amount for this contract",
                                "amount_guaranteed_holdback" => "Good end amount for this contract (:number of amount ex. tax of entered invoice)",
                                "contract" => "Contract",
                                "contract_number" => "Contract number",
                                "create" => "Enter the invoice",
                                "dc4_date" => "Date of approval DC4",
                                "dc4_file" => "File DC4",
                                "dc4_percent" => "Agreed at X%",
                                "dc4_text" => "DC4: Agreed at :percent%",
                                "deposit_good_end_number" => "Good end deposit No. for this contract",
                                "deposit_guaranteed_holdback_number" => "Guaranteed holdback deposit No. for this contract",
                                "invoice_amount_before_taxes" => "Amount ex. tax for this contract",
                                "invoice_amount_of_taxes" => "Amount of VAT for this contract",
                                "invoice_number" => "Subcontractor invoice number",
                                "invoiced_at" => "Date of invoice",
                                "vendor" => "Subcontractor"
                            ],
                            "_table_head" => [
                                "actions" => "Actions",
                                "amount_good_end" => "GE amount",
                                "amount_guaranteed_holdback" => "GH amount",
                                "deposit_good_end_number" => "Good end deposit No.",
                                "deposit_guaranteed_holdback_number" => "Guaranteed holdback deposit No.",
                                "invoice_amount_before_taxes" => "Amount ex. tax",
                                "invoice_amount_of_taxes" => "Amount of VAT",
                                "invoiced_at" => "Date of invoice",
                                "number" => "Number"
                            ],
                            "create" => ["return" => "Back", "title" => "Enter an invoice for this contract"],
                            "edit" => ["return" => "Back", "title" => "Modify the entered invoice"],
                            "index" => [
                                "create" => "Enter an invoice",
                                "return" => "Back",
                                "title" => "Invoices entered for contract :contract"
                            ]
                        ],
                        "create" => ["create" => "Save", "return" => "Back", "title" => "Contract creation"],
                        "create_amendment" => ["title" => "Amendment creation"],
                        "create_without_model" => ["return" => "Back", "submit" => "Save", "title" => "Submit a contract"],
                        "create_without_model_to_sign" => [
                            "return" => "Back",
                            "submit" => "Save",
                            "title" => "Submit a contract for signature"
                        ],
                        "edit" => ["edit" => "Modify", "title" => "Modify contract No. :number"],
                        "edit_validators" => [
                            "edit" => "Modify",
                            "title" => "Modify the approval circuit for contract No. :number"
                        ],
                        "export" => [
                            "success" => "Your export is being generated and you will receive a link by email to download it."
                        ],
                        "index" => [
                            "accounting_monitoring" => "Billing follow-up",
                            "annex" => "",
                            "contract_model" => "Contract templates",
                            "create" => "Create a Contract",
                            "createContractWithoutModel" => "",
                            "create_contract_without_model" => "Already signed",
                            "create_contract_without_model_to_sign" => "To be signed",
                            "create_dropdown" => "Submit a contract",
                            "export" => "Export",
                            "return" => "Back",
                            "title" => "Contracts"
                        ],
                        "mail" => [
                            "addworking_team" => "",
                            "consult_button" => "",
                            "contract_needs_documents" => [
                                "addworking_team" => "AddWorking Team",
                                "consult_button" => "",
                                "consult_contract" => "See the contract",
                                "consult_doc" => "Submit documents",
                                "followup" => "Reminder: ",
                                "greetings" => "Hello,",
                                "sentence_one" => "Your contract :contract_name with :enterprise_name requires some input from you before it can be sent for signature.",
                                "sentence_two" => "",
                                "subject" => ":enterprise_name is offering you a new contract",
                                "thanks_you" => "Regards,"
                            ],
                            "contract_needs_variables_values" => [
                                "addworking_team" => "",
                                "consult_contract" => "",
                                "greetings" => "",
                                "sentence_one" => "",
                                "sentence_two" => "",
                                "subject" => "",
                                "thanks_you" => ""
                            ],
                            "contract_request_variable_value" => [
                                "addworking_team" => "AddWorking Team",
                                "consult_contract" => "See the contract",
                                "consult_variables" => "View the variables",
                                "greetings" => "Hello,",
                                "sentence_one" => "The contract :contract_name between :pp_1 and :pp_2 requires input from you.",
                                "sentence_two" => "Please complete the required variables.",
                                "subject" => "Variable values are required from you",
                                "subject_oracle" => "",
                                "thanks_you" => "Regards,"
                            ],
                            "contract_to_complete" => [
                                "addworking_team" => "AddWorking Team",
                                "consult_button" => "Check contract",
                                "greetings" => "Hello,",
                                "sentence_one" => "Your contract :type with your customer :owner is being prepared.",
                                "sentence_two" => "Please enter the information needed for its creation.",
                                "subject" => "New contract",
                                "thanks_you" => "Regards,"
                            ],
                            "contract_to_send_to_signature" => [
                                "addworking_team" => "AddWorking Team",
                                "consult_button" => "Check contract",
                                "greetings" => "Hello,",
                                "sentence_one" => "Contract :contract_name is ready to be sent for signature.",
                                "sentence_three" => "You can access it by clicking on the button below.",
                                "sentence_two" => "Send your contract for approval or send it directly for signature.",
                                "subject" => "Contract :contract_name is ready to be sent for signature",
                                "thanks_you" => "Regards,"
                            ],
                            "contract_to_sign" => [
                                "addworking_team" => "AddWorking Team",
                                "consult_button" => "Check contract",
                                "followup" => "Reminder: ",
                                "greetings" => "Hello,",
                                "sentence_one" => "Company :owner is inviting you to sign contract :contract_name.",
                                "sentence_two" => "You can view and then sign this contract by clicking on the button below.",
                                "subject" => "New contract to be signed",
                                "thanks_you" => "Regards,"
                            ],
                            "contract_to_validate_on_yousign" => [
                                "addworking_team" => "AddWorking Team",
                                "consult_button" => "Check contract",
                                "followup" => "Reminder: ",
                                "greetings" => "Hello,",
                                "sentence_one" => "Company :owner is inviting you to approve contract :contract_name before it is sent for signature.",
                                "sentence_two" => "You can view and then approve this contract by clicking on the button below.",
                                "subject" => "A new contract is waiting for your approval",
                                "thanks_you" => "Regards,"
                            ],
                            "expiring_contract_customer" => [
                                "addworking_team" => "AddWorking Team",
                                "greetings" => "Hello,",
                                "sentence_one" => "One or more contract(s) for :enterprise_name will expire in less than 30 days.",
                                "sentence_three" => "One or more contract(s) for :enterprise_name will expire on ",
                                "sentence_two" => "Please take the necessary steps to renew it/them where necessary.",
                                "subject_one" => "You have contracts about to expire",
                                "subject_two" => "You have contracts about to expire",
                                "thank_you" => "Regards,",
                                "url" => "Check the relevant contracts"
                            ],
                            "expiring_contract_vendor" => [
                                "addworking_team" => "AddWorking Team",
                                "greetings" => "Hello,",
                                "sentence_one" => "Your contract :contract_name with :enterprise_name will expire on ",
                                "subject_one" => "You have a contract about to expire",
                                "thank_you" => "Regards,",
                                "url" => "Check contract"
                            ],
                            "export" => [
                                "addworking_team" => "AddWorking Team",
                                "consult_button" => "Download",
                                "greetings" => "Hello,",
                                "sentence_one" => "Your export is ready!",
                                "sentence_two" => "Click on the link below to download it:",
                                "subject" => "Export contracts for :enterprise_name",
                                "thanks_you" => "Regards,"
                            ],
                            "greetings" => "",
                            "notify_for_new_comment" => [
                                "addworking_team" => "AddWorking Team",
                                "comment_author" => "By :author_name",
                                "consult_button" => "Check contract",
                                "greetings" => "Hello :user_name,",
                                "sentence_one" => "AddWorking would like to inform you of a new comment posted for the contract :contract_name: ",
                                "subject" => ":contract_name - A new comment was posted.",
                                "thanks_you" => "Regards,"
                            ],
                            "refused_contract" => [
                                "addworking_team" => "AddWorking Team",
                                "consult_button" => "Check contract",
                                "greetings" => "Hello: name,",
                                "sentence_one" => "AddWorking would like to inform you that the contract :contract_name was rejected.",
                                "subject" => ":name - Your document was rejected in AddWorking.",
                                "thanks_you" => "Regards,"
                            ],
                            "request_validation" => [
                                "access_contract" => "Access contract",
                                "addworking_team" => "AddWorking Team",
                                "greetings" => "Hello,",
                                "sentence_one" => "You have a new contract which needs your approval before it can be sent for signature:",
                                "sentence_two" => "You can view the entire contract by clicking on the button below.",
                                "thanks_you" => "Regards,"
                            ],
                            "sentence_one" => "",
                            "sentence_two" => "",
                            "signed_contract" => [
                                "addworking_team" => "AddWorking Team",
                                "consult_button" => "Check contract",
                                "greetings" => "Hello: name,",
                                "sentence_one" => "AddWorking would like to inform you that the contract :contract_name has been signed.",
                                "subject" => ":name - The signature of your document has been completed in AddWorking.",
                                "thanks_you" => "Regards,"
                            ],
                            "thanks_you" => ""
                        ],
                        "request_validation" => [
                            "general_information" => "General information",
                            "send" => "Send the request for a signature",
                            "success" => "This contract has been sent for approval before it can be signed. If you would like to send a reminder to the approver, you just need to repeat the operation.",
                            "title" => "Send a request for a signature",
                            "user" => "User"
                        ],
                        "show" => [
                            "add_dropdown" => "Add...",
                            "add_part" => "A specific annex",
                            "add_part_to_signed_contract" => "An attached document",
                            "create_amendment" => "An amendment",
                            "create_amendment_without_model" => "A signed amendment",
                            "create_amendment_without_model_to_sign" => "An amendment for signature",
                            "edit_variable" => "Enter variables",
                            "generate_contract" => "",
                            "request_signature" => "Relaunch :designation_pp for signature",
                            "request_validation" => "Send for approval",
                            "return" => "Back",
                            "send_to_manager" => "Send to a manager",
                            "send_to_sign" => "Send contract for signature",
                            "sign" => "Sign",
                            "upload_documents" => "Documents to provide",
                            "validate" => "Approve the contract"
                        ],
                        "tracking" => [
                            "request_documents" => "Notification to collect the documents necessary for the contract on :date to :pp by :user"
                        ],
                        "upload_signed_contract" => [
                            "display_name" => "Name of contract document",
                            "file" => "File to be selected",
                            "party_signed_at" => "Date of signature of :party_name",
                            "return" => "Back",
                            "select_file" => "Select a file",
                            "signed_on_the_at" => "Signed by {firstname} {lastname} on {date.en}",
                            "submit" => "Add",
                            "title" => "Update signed contract"
                        ]
                    ],
                    "contract_mission" => [
                        "_breadcrumb" => [
                            "contract" => "Contract No. :number",
                            "create_amendment" => "Create an amendment",
                            "dashboard" => "Dashboard",
                            "link_contract" => "Link to a contract",
                            "link_mission" => "Link to a work order",
                            "mission" => "Work order No. :number"
                        ],
                        "create" => [
                            "contract" => "Contract",
                            "contract_title" => "Link contract No. :number to a work order",
                            "mission" => "Work",
                            "mission_title" => "Link work order No. :number to a contract",
                            "return" => "Back",
                            "submit" => "Save"
                        ]
                    ],
                    "contract_part" => [
                        "_actions" => ["delete" => "Delete"],
                        "_form" => [
                            "annex" => "",
                            "display_name" => "Name of document",
                            "file" => "Document to add",
                            "is_from_annexes" => "",
                            "is_from_annexes_options" => "",
                            "is_signed" => "Document needs a signature?",
                            "no" => "No",
                            "select_file" => "Select a file",
                            "sign_on_last_page" => "Last page",
                            "signature_mention" => "Signature text",
                            "signature_page" => "Number of signature page ",
                            "upload_file" => "",
                            "yes" => "Yes"
                        ],
                        "create" => ["return" => "Back", "submit" => "Save", "title" => "Add a specific annex"],
                        "signed_contract" => [
                            "create" => ["return" => "Back", "submit" => "Save", "title" => "Add a specific annex"]
                        ]
                    ],
                    "contract_party" => [
                        "_breadcrumb" => [
                            "create" => "Create",
                            "dashboard" => "Dashboard",
                            "index" => "Stakeholders",
                            "index_contract" => "Contracts",
                            "show_contract" => "Contract No. :number"
                        ],
                        "_form" => [
                            "add_validator" => "Add an approver",
                            "confirm_edit" => "Modifying the details of stakeholders will permanently delete the contract files. Are you sure?",
                            "denomination" => "Denomination",
                            "enterprise" => "Company",
                            "general_information" => "General information",
                            "order" => "Order",
                            "party" => "Stakeholder",
                            "remove_validator" => "Retrieve",
                            "signatory" => "Signatory",
                            "signed_at" => "Date of signature",
                            "validator" => "Approver",
                            "validator_info" => "These members will be asked to approve the contract before sending it for signature",
                            "validators" => "Approved by"
                        ],
                        "create" => [
                            "create" => "Save",
                            "return" => "Back",
                            "title" => "ID of stakeholders for contract No. :number"
                        ],
                        "store" => [
                            "success" => "Your pre-filled variables are being generated. This may take several minutes - you can now enter the rest of your variables."
                        ]
                    ],
                    "contract_party_document" => [
                        "_breadcrumb" => [
                            "dashboard" => "Dashboard",
                            "index" => "Documents required for :enterprise_name",
                            "index_contract" => "Contracts",
                            "show_contract" => "Contract No. :number"
                        ],
                        "index" => ["return" => "Back", "title" => "Document(s) for :enterprise for contract :name"]
                    ],
                    "contract_variable" => [
                        "_breadcrumb" => [
                            "dashboard" => "Dashboard",
                            "define_value" => "Define variable values",
                            "edit" => "Define contract variable values",
                            "index" => "Contract variables",
                            "index_contract" => "Contracts",
                            "show_contract" => "Contract No. :number"
                        ],
                        "_filters" => [
                            "filter" => "Filter",
                            "model_variable_display_name" => "Description of variable",
                            "model_variable_input_type" => "Type",
                            "model_variable_model_part_display_name" => "Contract document",
                            "model_variable_required" => "Required",
                            "reset" => "Reset",
                            "value" => "Value"
                        ],
                        "_form" => [
                            "denomination_party" => "Name of stakeholder",
                            "description" => "Description",
                            "display_name" => "Name of variable",
                            "edit_variable_value" => "Modify contract variable values",
                            "value" => "Value (used in document: :part)"
                        ],
                        "_table_head" => [
                            "contract_model_display_name" => "Description of variable",
                            "contract_model_input_type" => "Type",
                            "contract_model_part_name" => "Contract document",
                            "contract_party_enterprise_name" => "Stakeholder",
                            "description" => "Description",
                            "required" => "Mandatory",
                            "value" => "Value"
                        ],
                        "define_value" => [
                            "create" => "Save",
                            "edit" => "Define contract variable values",
                            "request_contract_variable_value_user_to_request" => "Select a user to notify",
                            "request_value_button" => "Assign variables",
                            "return" => "Back",
                            "send_request_contract_variable_value" => "Send Request",
                            "success_send_request_contract_variable_value" => "A request was sent.",
                            "title" => "Define variable values",
                            "url_is_too_long" => "You cannot select more variables."
                        ],
                        "error" => ["no_variable_to_edit" => "No variables to be defined"],
                        "index" => [
                            "define_value" => "Define values",
                            "refresh" => "Update values",
                            "refresh_warning" => "Any variable values on the form which are not saved will be lost.",
                            "regenerate" => "Regenerate contract documents",
                            "return" => "Back",
                            "table_row_empty" => "No contract variable found",
                            "title" => "List of contract variables"
                        ]
                    ]
                ]
            ]
        ],
        "model" => [
            "application" => [
                "models" => [
                    "contract_model_variable" => [
                        "input_type" => [
                            "contract_enterprise_owner" => "Owner company",
                            "contract_external_identifier" => "External ID",
                            "contract_title" => "Contract",
                            "contract_valid_from" => "Start date",
                            "contract_valid_until" => "Due Date",
                            "date" => "Dated",
                            "enterprise_address" => "Company address",
                            "enterprise_employees_number" => "Number of employees ",
                            "enterprise_identification_number" => "Identification number (SIRET)",
                            "enterprise_legal_form" => "Legal form",
                            "enterprise_name" => "Company name",
                            "enterprise_registration_date" => "Date of registration",
                            "enterprise_siren_number" => "SIREN",
                            "enterprise_title" => "Company",
                            "enterprise_town" => "Company town",
                            "long_text" => "Long text",
                            "mission_amount" => "Amount",
                            "mission_ended_at" => "End date",
                            "mission_started_at" => "Start date",
                            "mission_title" => "Work",
                            "options" => "Options",
                            "party_title" => "Stakeholder",
                            "registration_town" => "Town of registration",
                            "signatory_function" => "Signatory job title",
                            "signatory_mail" => "Signatory email address",
                            "signatory_name" => "Signatory name",
                            "signatory_title" => "Signatory",
                            "text" => "Text",
                            "text_title" => "Input",
                            "work_field_address" => "Address",
                            "work_field_description" => "Description of work granted",
                            "work_field_display_name" => "Name",
                            "work_field_ended_at" => "End date",
                            "work_field_external_id" => "Site code",
                            "work_field_project_manager" => "Lead contractor",
                            "work_field_project_owner" => "Lead contractor",
                            "work_field_sps_coordinator" => "SPS coordinator",
                            "work_field_started_at" => "Start date",
                            "work_field_title" => "Site"
                        ]
                    ]
                ],
                "views" => [
                    "contract_model" => [
                        "_actions" => [
                            "add_part" => "Add a document",
                            "archive" => "Archive",
                            "consult" => "View",
                            "delete" => "Supprimer",
                            "duplicate" => "Duplicate",
                            "edit" => "Modify",
                            "index_part" => "Voir les piäces",
                            "index_variable" => "",
                            "index_variables" => "Variables",
                            "preview" => "Preview",
                            "versionate" => "New version"
                        ],
                        "_breadcrumb" => [
                            "create" => "Create a contract template",
                            "dashboard" => "Dashboard",
                            "edit" => "Modify",
                            "index" => "Contract templates",
                            "show" => "No. :number"
                        ],
                        "_filters" => [
                            "archived_contract_model" => "Display archived templates",
                            "enterprise" => "Owner company",
                            "status" => "State"
                        ],
                        "_form" => [
                            "display_name" => "Template name",
                            "enterprise" => "Owner company",
                            "general_information" => "General information",
                            "should_vendors_fill_their_variables" => "Contractors must enter their own variables."
                        ],
                        "_html" => [
                            "archived_date" => "Archiving date",
                            "created_date" => "Creation date",
                            "delete" => "Delete",
                            "display_name" => "Template name",
                            "document_types" => "Associated documents",
                            "enterprise" => "Owner company",
                            "id" => "Identifiant",
                            "informations" => "General information",
                            "last_modified_date" => "Date of last modification",
                            "more_informations" => "Further information",
                            "no" => "No",
                            "parties" => "Stakeholders",
                            "parts" => "Contract template document(s)",
                            "published_date" => "Date of publication",
                            "should_vendors_fill_their_variables" => "Variables will be entered by subcontractors",
                            "status" => "Status",
                            "version" => "(version: :version_number)",
                            "yes" => "Yes"
                        ],
                        "_state" => ["Archived" => "Archived", "Draft" => "Draft", "Published" => "Published"],
                        "_table_head" => [
                            "actions" => "Actions",
                            "archived_at" => "",
                            "created_at" => "",
                            "display_name" => "Template name",
                            "enterprise" => "Owner company",
                            "number" => "Number",
                            "published_at" => "",
                            "status" => "Status"
                        ],
                        "create" => [
                            "create" => "Save",
                            "parties" => "Stakeholders",
                            "party" => "Name of stakeholder :number",
                            "return" => "Back",
                            "title" => "Contract template creation"
                        ],
                        "edit" => [
                            "edit" => "Modify",
                            "party" => "Name of stakeholder :number",
                            "title" => "Modify contract template No. :number"
                        ],
                        "index" => [
                            "button_create" => "Create a contract template",
                            "part" => "Template documents",
                            "publish_button" => "Publish",
                            "return" => "Back",
                            "table_row_empty" => "No contract template found",
                            "title" => "List of contract models"
                        ],
                        "show" => [
                            "back" => "Back",
                            "part" => "Add contract document",
                            "publish_button" => "Publish",
                            "return" => "Back",
                            "unpublished_button" => "Unpublish",
                            "variable" => "Enter variables"
                        ]
                    ],
                    "contract_model_document_type" => [
                        "_actions" => ["delete" => "Delete"],
                        "_breadcrumb" => [
                            "create" => "Add",
                            "dashboard" => "Dashboard",
                            "document_type" => "Document type",
                            "index" => "Contract templates",
                            "party" => "Stakeholder No. :number",
                            "show" => "No. :number"
                        ],
                        "_form" => [
                            "add" => "Select?",
                            "document_type" => "Document Type",
                            "no" => "No",
                            "validation_required" => "Approval request",
                            "yes" => "Yes"
                        ],
                        "_table_head" => [
                            "actions" => "Actions",
                            "created_at" => "Creation date",
                            "document_type" => "Document Type",
                            "validation_by" => "Approved by",
                            "validation_required" => "Approval request"
                        ],
                        "create" => [
                            "create" => "Save",
                            "return" => "Back",
                            "title" => "Define document types for stakeholder No. :number: :denomination"
                        ],
                        "create_specific_document" => [
                            "create" => "Add",
                            "description" => "Description",
                            "display_name" => "Name of document model",
                            "general_information" => "General information",
                            "return" => "Back",
                            "title" => "Add a specific document for stakeholder No. :number: :denomination",
                            "validation_required" => "Approval request?"
                        ],
                        "index" => [
                            "button_create" => "Associate a document ",
                            "button_create_specific_document" => "Add a specific document",
                            "return" => "Back",
                            "table_row_empty" => "No document type is associated with this stakeholder",
                            "title" => "List of documents associated with stakeholder No. :number: :denomination"
                        ]
                    ],
                    "contract_model_part" => [
                        "_actions" => ["delete" => "Supprimer", "preview" => "Preview"],
                        "_breadcrumb" => [
                            "create" => "Create a contract template document",
                            "dashboard" => "Dashboard",
                            "edit" => "Modify",
                            "index" => "Piäce de modäle de contrat",
                            "parts" => "Documents",
                            "show" => "No. :number"
                        ],
                        "_form" => [
                            "display_name" => "Name of document",
                            "empty_textarea" => "The text field is empty.",
                            "file" => "File",
                            "general_information" => "General information",
                            "information" => [
                                "call_to_action" => "More details here.",
                                "modal" => [
                                    "main_title" => "How to use variables",
                                    "paragraph_1_1" => "In order for the system to use your variables, these must follow a specific format",
                                    "paragraph_1_10" => "{{1.siret}}",
                                    "paragraph_1_11" => "{{2.raison_sociale}}",
                                    "paragraph_1_12" => "{{1.variable_partie_prenante_1}}",
                                    "paragraph_1_13" => "{{2.variable_partie_prenante_2}}",
                                    "paragraph_1_14" => "{{1.nom_de_famille}}",
                                    "paragraph_1_15" => "{{2.nom_de_famille}}",
                                    "paragraph_1_2" => "Initially, you should enclose your variable in two opening and two closing curly brackets.",
                                    "paragraph_1_3" => "Finally, you will need to define two pieces of information, which must be separated by a period.",
                                    "paragraph_1_5" => "The first part of the variable indicates the order which designates one of the stakeholders of the contract template.",
                                    "paragraph_1_6" => "The second part designates the variable name. This can take any value.",
                                    "paragraph_1_7" => "Please note: Always write variables in lower case and avoid using alphanumerical values.",
                                    "paragraph_1_8" => "Examples:",
                                    "paragraph_1_9" => "{{1.nom_de_la_variable}}",
                                    "paragraph_2_1" => "Your variable can be placed anywhere in the text zone. It will be automatically detected by the system.",
                                    "title_1" => "Variable format",
                                    "title_2" => "Use of variables"
                                ],
                                "paragraph_1" => "Use variables which will help you automate your contracts. Examples:",
                                "paragraph_2" => "{{1.nom_de_la_variable}}",
                                "paragraph_3" => "{{1.siret}}",
                                "paragraph_4" => "{{2.raison_sociale}}",
                                "paragraph_5" => "{{1.variable_partie_prenante_1}}",
                                "paragraph_6" => "{{2.variable_partie_prenante_2}}",
                                "paragraph_7" => "{{1.nom_de_famille}}",
                                "paragraph_8" => "{{2.nom_de_famille}}"
                            ],
                            "is_initialled" => "Paraphable",
                            "is_signed" => "Signable",
                            "no" => "No",
                            "order" => "Order",
                            "part_type" => "Type of document",
                            "sign_on_last_page" => "Last page",
                            "signature_mention" => "Signature text",
                            "signature_page" => "Number of signature page",
                            "signature_position" => "Position of signature (a,b,c,d)",
                            "textarea" => "Text zone",
                            "yes" => "Yes"
                        ],
                        "_table_head" => [
                            "actions" => "Actions",
                            "display_name" => "Name of document",
                            "id" => "UUID",
                            "is_initialled" => "Paraphable",
                            "is_signed" => "Signable",
                            "order" => "Order"
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
                        "create" => [
                            "create" => "Save",
                            "parties" => "Stakeholders",
                            "party" => "Name of stakeholder :number",
                            "return" => "Back",
                            "title" => "Document creation"
                        ],
                        "edit" => [
                            "_actions" => ["delete" => "Delete", "preview" => "Preview"],
                            "_breadcrumb" => [
                                "create" => "Create",
                                "dashboard" => "Dashboard",
                                "edit" => "Modify",
                                "index" => "Template documents",
                                "show" => "No. :number"
                            ],
                            "edit" => "Modify",
                            "party" => "Name of stakeholder :number",
                            "title" => "Modifier le modäle de contrat N¯ :number"
                        ],
                        "index" => [
                            "button_create" => "Add a document",
                            "create" => "Save",
                            "return" => "Back",
                            "table_row_empty" => "No contract template documents found",
                            "title" => "Liste de piäce de model de contrat"
                        ]
                    ],
                    "contract_model_variable" => [
                        "_breadcrumb" => [
                            "dashboard" => "Dashboard",
                            "edit" => "Modify",
                            "index" => "Contract templates",
                            "show" => "No. :number",
                            "variables" => "Variables"
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
                            "status" => "",
                            "unknown" => "",
                            "uploaded" => "",
                            "uploading" => ""
                        ],
                        "_form" => [
                            "amendment_name_preset" => "",
                            "amendment_without_contract_model" => "",
                            "contract_model" => "Contract template",
                            "default_value" => "Default value",
                            "description" => "Description",
                            "display_name" => "Name of variable",
                            "enterprise" => "Template owner company",
                            "enterprise_owner" => "Contract owner company",
                            "external_identifier" => "External ID",
                            "general_information" => "General information",
                            "input_type" => "Type",
                            "is_exportable" => "Exportable",
                            "model" => "Name of document",
                            "name" => "Contract name",
                            "options" => "Options",
                            "required" => "Required",
                            "valid_from" => "Start date",
                            "valid_until" => "Due Date",
                            "variable" => "Variable"
                        ],
                        "_form_without_model" => [
                            "actions" => "Actions",
                            "contract_informations" => "Contract details",
                            "designation" => "Name of stakeholder",
                            "display_name" => "Name of the contract document",
                            "enterprise" => "Stakeholder",
                            "external_identifier" => "External ID",
                            "file" => "File to be selected",
                            "name" => "Contract name",
                            "number" => "Number",
                            "owner" => "Owner company",
                            "part_informations" => "Details of the contract document",
                            "parties_informations" => "Details of stakeholders and signatories",
                            "select_file" => "Select a file",
                            "signatory" => "Signatory",
                            "valid_from" => "Start date",
                            "valid_until" => "End date"
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
                            "actions" => "Actions",
                            "default_value" => "Default value",
                            "description" => "Description",
                            "display_name" => "Display name",
                            "enterprise" => "Owner company",
                            "input_type" => "Type",
                            "model" => "Contract template",
                            "name" => "Contract name",
                            "part_name" => "Name of document",
                            "parties" => "Stakeholders",
                            "party_denomination" => "Stakeholder",
                            "required" => "Required",
                            "status" => "Status",
                            "valid_from" => "Start date",
                            "valid_until" => "End date"
                        ],
                        "create_without_model" => ["return" => "Back", "submit" => "Save", "title" => "Submit a contract"],
                        "edit" => [
                            "create_amendment" => "Create an amendment",
                            "create_part" => "Add a specific annex",
                            "edit" => "Modify",
                            "return" => "Back",
                            "title" => "",
                            "upload_signed_contract" => "Update signed contract"
                        ],
                        "index" => [
                            "create" => "Create a Contract",
                            "createContractWithoutModel" => "Submit a contract",
                            "edit" => "Update variables",
                            "return" => "Back",
                            "table_row_empty" => "No contract template variable found",
                            "title" => "List of contract template variables"
                        ],
                        "show" => ["return" => "Back", "title" => "Modify variable for contract No. :number"],
                        "upload_signed_contract" => [
                            "display_name" => "Name of contract document",
                            "file" => "File to be selected",
                            "party_signed_at" => "Date of signature of :party_name",
                            "return" => "Back",
                            "select_file" => "Select a file",
                            "submit" => "Add",
                            "title" => "Update signed contract"
                        ]
                    ]
                ]
            ]
        ]
    ],
    "enterprise" => [
        "activity_report" => [
            "application" => [
                "views" => [
                    "activity_report" => [
                        "_form" => ["note" => "Note"],
                        "months" => [
                            "april" => "April",
                            "august" => "August",
                            "december" => "December",
                            "february" => "February",
                            "january" => "January",
                            "july" => "July",
                            "june" => "June",
                            "march" => "March",
                            "may" => "May",
                            "november" => "November",
                            "october" => "October",
                            "september" => "September"
                        ]
                    ]
                ]
            ]
        ],
        "filters" => [
            "identification_number" => "SIRET or SIREN",
            "name" => "Company name",
            "phone" => "Telephone number",
            "zipcode" => "Zip code"
        ]
    ],
    "enterprise_finder" => [
        "companies_found" => "Companies found",
        "enterprise" => "Company",
        "error_occurred" => "Error! If the problem still occurs, please contact the"
    ],
    "form" => [
        "checkbox_list" => ["select_all" => "Select all"],
        "group" => ["required_field" => "Required field"],
        "modal" => ["register" => "Save"],
        "qualification_list" => [
            "being_obtained" => "In progress",
            "no" => "No",
            "yes" => "Yes",
            "yes_probative" => "Yes, possible "
        ]
    ],
    "modal" => [
        "confirm" => ["no" => "No", "yes" => "Yes"],
        "post_confirm" => ["no" => "No", "yes" => "Yes"]
    ],
    "modal2" => ["to_close" => "Close"],
    "sogetrel" => [
        "mission" => [
            "application" => [
                "policies" => [
                    "create" => [
                        "denied_must_be_support_user" => "You must be a support member to create an attachment"
                    ],
                    "create_support" => [
                        "denied_must_be_support_user" => "You must be a member of our AddWorking Support team to see this page"
                    ],
                    "index" => [
                        "denied_must_be_support_user" => "You must be a support member to list attachments"
                    ],
                    "index_support" => [
                        "denied_must_be_support_user" => "You must be a member of our AddWorking Support team to see this page"
                    ],
                    "update" => [
                        "denied_must_be_support_user" => "You must be a support member to modify an attachment"
                    ],
                    "view" => [
                        "denied_must_be_support_user" => "You must be a support member to view an attachment"
                    ]
                ],
                "views" => [
                    "mission_tracking_line_attachment" => [
                        "_breadcrumb" => ["create" => "Create", "edit" => "Edit", "index" => "Attachments"],
                        "_form" => ["period" => "Period", "title" => "Attachment information"],
                        "_html" => [
                            "amount" => "Amount ex. tax",
                            "created_at" => "Created on",
                            "direct_billing" => "Direct invoicing",
                            "id" => "ID number",
                            "label" => "Label",
                            "num_attachment" => "Attachment number",
                            "num_order" => "Order number",
                            "num_site" => "Work site number",
                            "reverse_charges" => "Self-liquidation",
                            "signed_at" => "Signed on",
                            "submitted_at" => "Date of submission in DocuSign",
                            "updated_at" => "Updated on"
                        ],
                        "_period_selector" => [
                            "customer" => "Customer",
                            "milestone" => "Period",
                            "mission" => "Work",
                            "vendor" => "Subcontractor"
                        ],
                        "_table_head" => [
                            "customer" => "Customer",
                            "num_attachment" => "Attachment number",
                            "num_order" => "Order number",
                            "vendor" => "Subcontractor"
                        ],
                        "create" => [
                            "amount" => "Amount",
                            "direct_billing" => "Direct invoicing",
                            "file" => "File",
                            "num_attachment" => "Attachment number",
                            "num_order" => "Order number",
                            "num_site" => "Site number",
                            "return" => "Back",
                            "reverse_charges" => "Self-liquidation",
                            "save" => "Save",
                            "signed_at" => "Signed on",
                            "submitted_at" => "Date of submission in DocuSign",
                            "title" => "Create an attachment"
                        ],
                        "create_support" => [
                            "amount" => "Total excl. tax.",
                            "customer" => "Client",
                            "direct_billing" => "Direct invoicing",
                            "file" => "PDF File",
                            "milestone" => "Period",
                            "mission" => "Work",
                            "num_attachment" => "Attachment number",
                            "num_order" => "Order number",
                            "num_site" => "Work site number",
                            "reverse_charges" => "Reverse Charging",
                            "save" => "Save",
                            "signed_at" => "Date of signature",
                            "title" => "Create an attachment to the Sogetrel follow-up line",
                            "vendor" => "Subcontractor"
                        ],
                        "edit" => ["return" => "Back", "save" => "Save", "title" => "Edit"],
                        "index" => [
                            "add" => "Add",
                            "amount" => "Amount",
                            "created_from_airtable" => "Create Airtable",
                            "customer" => "Customer",
                            "direct_billing" => "Direct invoicing",
                            "doesnt_have_inbound_invoice" => "does not have any inbound invoices",
                            "doesnt_have_outbound_invoice" => "does not have any outbound invoices",
                            "empty" => "Empty",
                            "filter_inbound_invoice" => "Inbound invoices",
                            "filter_outbound_invoice" => "Outbound invoices",
                            "has_inbound_invoice" => "Has inbound invoices",
                            "has_outbound_invoice" => "Has outbound invoices",
                            "inbound_invoice" => "Inbound invoice",
                            "milestone" => "Period",
                            "mission" => "Work",
                            "num_attachment" => "Attachment number",
                            "num_order" => "Order number",
                            "outbound_invoice" => "Outbound invoice",
                            "signed_at" => "Signed on",
                            "title" => "Attachments",
                            "vendor" => "Subcontractor"
                        ],
                        "show" => [
                            "return" => "Back",
                            "tab_file" => "File",
                            "tab_summary" => "Properties",
                            "title" => "Attachment"
                        ]
                    ],
                    "support_mission_tracking_line_attachment" => [
                        "index" => [
                            "add" => "Add",
                            "amount" => "Total excl. tax.",
                            "customer" => "Client",
                            "direct_billing" => "Direct invoicing",
                            "doesnt_have_inbound_invoice" => "Without any invoice",
                            "doesnt_have_outbound_invoice" => "Without any invoice",
                            "filter_inbound_invoice" => "Inbound invoices",
                            "filter_outbound_invoice" => "Outbound invoices",
                            "has_inbound_invoice" => "With Invoices",
                            "has_outbound_invoice" => "With Invoices",
                            "inbound_invoice" => "Inbound invoice",
                            "milestone" => "Period",
                            "mission" => "Work",
                            "num_attachment" => "Attachment",
                            "num_order" => "Order",
                            "outbound_invoice" => "Outbound invoice",
                            "signed_at" => "Signed on",
                            "title" => "Sogetrel Attachments",
                            "vendor" => "Subcontractor"
                        ]
                    ]
                ]
            ]
        ]
    ]
];
