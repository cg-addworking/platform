<?php
return [
    "alterable" => ["save" => "Abspeichern"],
    "contract" => [
        "contract" => [
            "application" => [
                "requests" => [
                    "store_contract_request" => [
                        "messages" => [
                            "before_or_equal" => "Das Feld contract.mission.starts at muss ein Datum enthalten, das nach dem heutigen Datum liegt bzw. diesem entspricht"
                        ]
                    ]
                ],
                "tracking" => [
                    "addworking" => "AddWorking",
                    "contract_archived" => "hat diesen Vertrag archiviert",
                    "contract_callback" => "hat an den Vertrag erinnert am :date",
                    "contract_expires" => "Der Vertrag ist fällig",
                    "contract_is_active" => "hat den Vertrag aktiviert",
                    "contract_pre_expire_notification" => "hat mitgeteilt, dass der Vertrag in 30 Tagen fällig ist",
                    "contract_unarchived" => "hat diesen Vertrag aus dem Archiv geholt",
                    "contract_variable_value_was_requested" => "wurde von AddWorking aufgefordert, die Variablenwerte auszufüllen",
                    "create_amendment" => "hat den Nachtrag :amendment_name erstellt",
                    "create_contract" => "hat den Vertrag erstellt",
                    "party_refuses_to_sign_contract" => "hat den Vertrag abgelehnt",
                    "party_signs_contract" => "hat den Vertrag unterzeichnet",
                    "party_validates_contract" => "hat den Vertrag validiert",
                    "request_send_contract_to_signature" => "hat den Vertrag zur Unterzeichnung an :user gesendet.",
                    "scan_urssaf_certificate_document_rejection" => "Das Dokument wurde beim automatischen Einlesen nicht validiert.",
                    "scan_urssaf_certificate_document_validation" => "Pre-Check des Dokuments durch automatisches Einlesen erfolgt",
                    "send_contract_to_signature" => "hat den Vertrag zur Unterzeichnung übergeben",
                    "send_contract_to_validation" => "hat den Vertrag zur Unterzeichnung an :user gesendet.",
                    "tracking" => "Auftragsverfolgung",
                    "tracking_document" => "Mahnungsverwaltung"
                ],
                "views" => [
                    "amendment" => [
                        "_form_without_model" => [
                            "actions" => "Aktionen",
                            "contract_body" => "Hauptteil des Vertrags",
                            "contract_informations" => "Informationen zum Vertrag",
                            "designation" => "Bezeichnung der Vertragspartei",
                            "display_name" => "Name des Vertragselements",
                            "enterprise" => "Vertragspartei",
                            "external_identifier" => "Externe Kennung",
                            "file" => "Auszuwählende Datei",
                            "name" => "Name des Vertrags",
                            "number" => "Nummer",
                            "owner" => "Inhabergeführtes Unternehmen",
                            "part_informations" => "Informationen zum Vertragselement",
                            "parties_informations" => "Informationen zu den Vertragsparteien und Unterzeichnern",
                            "select_file" => "Eine Datei auswählen",
                            "signatory" => "Unterzeichner",
                            "signed_at" => "Datum der Unterzeichnung",
                            "valid_from" => "Anfangsdatum",
                            "valid_until" => "Enddatum"
                        ],
                        "_form_without_model_to_sign" => [
                            "amendment_part_label" => "Name des Vertragselements",
                            "contract_informations" => "Informationen zum Vertrag",
                            "display_name" => "Name des Vertragselements",
                            "external_identifier" => "Externe Kennung",
                            "file" => "Auszuwählende Datei",
                            "name" => "Name des Nachtrags",
                            "part_informations" => "Informationen zum Vertragselement",
                            "select_file" => "Eine Datei auswählen",
                            "valid_from" => "Anfangsdatum",
                            "valid_until" => "Enddatum"
                        ],
                        "create_without_model" => [
                            "return" => "Zurück",
                            "submit" => "Speichern",
                            "title" => "Unterzeichneten Nachtrag unterbreiten"
                        ],
                        "create_without_model_to_sign" => [
                            "return" => "Zurück",
                            "submit" => "Speichern",
                            "title" => "Nachtrag zur Unterzeichnung unterbreiten"
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
                            "archive" => "Archivieren",
                            "back" => "Zurück",
                            "call_back" => "An Vertrag erinnern",
                            "cancel" => "Stornieren",
                            "create_amendment" => "",
                            "deactivate" => "Deaktivieren",
                            "delete" => "Löschen",
                            "download" => "Den Vertrag herunterladen",
                            "download_documents" => "Verbundene Dokumente herunterladen",
                            "download_proof_of_signature" => "Unterschriftenzertifikat herunterladen",
                            "edit" => "Ändern",
                            "edit_contract_party" => "Vertragsparteien ändern",
                            "edit_validators" => "Validierungsweg",
                            "link_mission" => "Einen bestehenden Auftrag verbinden",
                            "nba_generate" => "Vertrag erstellen",
                            "nba_parties" => "Vertragsparteien angeben",
                            "nba_send" => "Vertragsparteien benachrichtigen",
                            "regenerate_contract" => "Vertrag erneut erstellen",
                            "show" => "Einsehen",
                            "sign" => "Unterzeichnen",
                            "unarchive" => "Aus Archiv entfernen",
                            "update_contract_from_yousign_data" => "Vertrag über yousign aktualisieren",
                            "upload_signed_contract" => "Unterzeichneten Vertrag aktualisieren",
                            "variable_list" => "Variablen"
                        ],
                        "_breadcrumb" => [
                            "create" => "Erstellen",
                            "create_amendment" => "Einen Nachtrag erstellen",
                            "create_part" => "Einen bestimmten Anhang hinzufügen",
                            "dashboard" => "Dashboard",
                            "edit" => "Ändern",
                            "index" => "Verträge",
                            "show" => "Einsehen",
                            "sign" => "Unterzeichnen",
                            "upload_signed_contract" => "Unterzeichneten Vertrag aktualisieren"
                        ],
                        "_filters" => [
                            "active" => "Aktiv",
                            "archived_contract" => "Archivierte Verträge anzeigen ",
                            "being_signed" => "zur Unterzeichnung",
                            "cancelled" => "Storniert",
                            "created_by" => "Vertragserzeuger",
                            "declined" => "Abgelehnt",
                            "draft" => "Entwurf",
                            "enterprise" => "Inhabergeführte Unternehmen",
                            "error" => "Fehler",
                            "expired" => "Abgelaufen",
                            "filter" => "Filtern",
                            "generated" => "Erzeugt",
                            "generating" => "In Generierung",
                            "inactive" => "Inaktiv",
                            "locked" => "Gesperrt",
                            "model" => "Modell",
                            "party" => "Beteiligte",
                            "published" => "Veröffentlicht",
                            "ready_to_generate" => "Bereit für Erzeugung",
                            "ready_to_sign" => "Bereit für unterzeichnen",
                            "reset" => "Zurücksetzen",
                            "signed" => "Unterzeichnet",
                            "state" => "Status",
                            "status" => "Status",
                            "unknown" => "In unbekanntem Zustand",
                            "uploaded" => "Hochgeladen",
                            "uploading" => "zum Hochladen",
                            "work_field" => "Baustelle"
                        ],
                        "_form" => [
                            "amendment_name_preset" => "Nachtrag :count des Vertrags :contract_parent_name",
                            "amendment_without_contract_model" => "",
                            "contract_model" => "Modell",
                            "contract_model_required" => "Das Feld „Vertragsmodell“ muss ausgefüllt werden.",
                            "enterprise" => "Inhaber des Modells",
                            "enterprise_owner" => "Inhaber des Vertrags",
                            "external_identifier" => "Vertragsnummer",
                            "general_information" => "Allgemeine Informationen",
                            "mission" => "Mission",
                            "mission_create" => "Neue Mission erstellen",
                            "mission_none" => "Keine Mission mit diesem Vertrag verbunden",
                            "mission_select" => "Eine Mission wählen",
                            "name" => "Name des Vertrags",
                            "no_selection" => "Keine Auswahl",
                            "valid_from" => "Anfangsdatum",
                            "valid_until" => "Fälligkeitsdatum"
                        ],
                        "_form_without_model" => [
                            "contract_body" => "Hauptteil des Vertrags",
                            "contract_informations" => "Informationen zum Vertrag",
                            "designation" => "Bezeichnung der Vertragspartei",
                            "display_name" => "Name des Vertragselements",
                            "enterprise" => "Vertragspartei",
                            "external_identifier" => "Identifiant externe",
                            "file" => "Auszuwählende Datei",
                            "name" => "Name des Vertrags",
                            "owner" => "Inhabergeführtes Unternehmen",
                            "part_informations" => "Informationen zum Vertragselement",
                            "parties_informations" => "Informationen zu den Vertragsparteien und Unterzeichnern",
                            "party_1_designation" => "Der Kunde",
                            "party_2_designation" => "Der Dienstanbieter",
                            "select_file" => "Eine Datei auswählen",
                            "signatory" => "Unterzeichner",
                            "signed_at" => "Datum der Unterzeichnung",
                            "valid_from" => "Anfangsdatum",
                            "valid_until" => "Enddatum"
                        ],
                        "_form_without_model_to_sign" => [
                            "contract_informations" => "Informationen zum Vertrag",
                            "contract_label" => "Name des Vertrags",
                            "designation" => "Bezeichnung der Vertragspartei",
                            "display_name" => "Name des Vertragselements",
                            "enterprise" => "Vertragspartei",
                            "external_identifier" => "Externe Kennung",
                            "file" => "Auszuwählende Datei",
                            "name" => "Name des Vertrags",
                            "owner" => "Inhabergeführtes Unternehmen",
                            "part_informations" => "Informationen zum Vertragselement",
                            "parties_informations" => "Informationen zu den Vertragsparteien und Unterzeichnern",
                            "party_1_designation" => "Der Kunde",
                            "party_2_designation" => "Der Dienstanbieter",
                            "select_file" => "Eine Datei auswählen",
                            "signatory" => "Unterzeichner",
                            "valid_from" => "Anfangsdatum",
                            "valid_until" => "Enddatum"
                        ],
                        "_html" => [
                            "amendment_contracts" => "Vermerke",
                            "compliance_documents" => "Konformitätsdokumente",
                            "contract_dates" => "Daten des Vertrags",
                            "contract_model" => "Modell",
                            "contract_parts_empty" => "Es kann derzeit kein Vertragselement angezeigt werden.",
                            "created_at" => "Erstellungsdatum",
                            "documents" => "Beizufügende(s) Dokument(e)",
                            "download" => "Herunterladen",
                            "external_identifier" => "Externe Kennung",
                            "from" => "Ab dem",
                            "generating_refresh" => "Seite aktualisieren",
                            "informations" => "",
                            "mission" => "Mission",
                            "more_informations" => "",
                            "non_body_contract_parts" => "Angehängte Dokumente",
                            "non_body_contract_parts_empty" => "Es kann derzeit kein angehängtes Dokument zum Vertrag angezeigt werden.",
                            "owner" => "Vertragsinhaber",
                            "parent_contract" => "Übergeordneter Vertrag",
                            "parties" => "Unterzeichner und Vertragsparteien",
                            "parts" => "Vertragselement(e)",
                            "party_signed_at" => "Datum der Unterzeichnung durch :party_name",
                            "request_documents" => "Benachrichtigen am :party_denomination",
                            "signed_at" => "Unterzeichnet am",
                            "state" => "Status",
                            "status" => "Status",
                            "to" => "Bis",
                            "updated_at" => "Änderungsdatum",
                            "valid_from" => "Vertragsbeginn",
                            "valid_until" => "Enddatum des Vertrags",
                            "valid_until_date" => "Ursprungsdatum: ",
                            "validated_at" => "validiert am",
                            "validator_parties" => "Validierer",
                            "workfield" => "Baustelle"
                        ],
                        "_state" => [
                            "active" => "Activ",
                            "archived" => "Archiviert",
                            "canceled" => "Storniert",
                            "declined" => "Abgelehnt",
                            "draft" => "Entwurf",
                            "due" => "Abgeläufft",
                            "generated" => "Bereit unterzeichnet zu werden",
                            "generating" => "Im Generierung",
                            "in_preparation" => "In Vorbereitung",
                            "in_writing" => "Im Verarbeitung",
                            "inactive" => "Inaktiv",
                            "internal_validation" => "Im innerbetriebliche Gültigkeitserklärung",
                            "is_ready_to_generate" => "Zu generieren",
                            "missing_documents" => "Fehlende Dokumente",
                            "signed" => "Unterzeichnet",
                            "to_be_distributed_for_further_information" => "Zu Verteilen für zusätzlische Informationen",
                            "to_complete" => "Vervollständigen",
                            "to_countersign" => "Gegenzeichnen",
                            "to_sign" => "Zu unterzeichnen",
                            "to_sign_waiting_for_signature" => "Zu unterzeichnen/ Warten auf Unterzeichnung",
                            "to_validate" => "Zu validieren",
                            "under_validation" => "Im Gültigskeitserklärung",
                            "unknown" => "Unbekannt",
                            "waiting_for_signature" => "Warten auf Unterzeichnung"
                        ],
                        "_status" => [
                            "active" => "Aktiv",
                            "being_signed" => "zur Unterzeichnung",
                            "cancelled" => "Storniert",
                            "declined" => "Abgelehnt",
                            "draft" => "Entwurf",
                            "error" => "Fehler",
                            "expired" => "Abgelaufen",
                            "generated" => "Erzeugt",
                            "generating" => "In Generierung",
                            "inactive" => "Inaktiv",
                            "locked" => "Gesperrt",
                            "published" => "Veröffentlicht",
                            "ready_to_generate" => "Bereit für Erzeugung",
                            "ready_to_sign" => "Bereit für unterzeichnen",
                            "signed" => "Unterzeichnet",
                            "unknown" => "In unbekanntem Zustand",
                            "uploaded" => "Hochgeladen",
                            "uploading" => "zum Hochladen"
                        ],
                        "_table_head" => [
                            "actions" => "Aktionen",
                            "amount" => "Betrag",
                            "contract_external_identifier" => "Vertragsschlüssel",
                            "contract_number" => "Vertragsnummer",
                            "contract_party_enterprise_name" => "Vertragspartei",
                            "created_by" => "Vertragserzeuger",
                            "enterprise" => "Inhabergeführte Unternehmen",
                            "external_identifier" => "Äußerer Identifikator",
                            "model" => "Modell",
                            "name" => "Namen",
                            "number" => "Vertragsnummer",
                            "parties" => "Beteiligte",
                            "state" => "Status",
                            "status" => "Status",
                            "valid_from" => "Anfangsdatum",
                            "valid_until" => "Enddatum",
                            "workfield_external_identifier" => "Baustellenschlüssel"
                        ],
                        "accounting_monitoring" => [
                            "_breadcrumb" => [
                                "contracts" => "Verträge",
                                "dashboard" => "Dashboard",
                                "index" => "Rechnungsverfolgung für Verträge"
                            ],
                            "_table_head" => [
                                "actions" => "Aktionen",
                                "amount_before_taxes" => "Nettobetrag des Vertrags",
                                "amount_before_taxes_invoiced" => "In Rechnung gestellter Nettobetrag",
                                "amount_of_remains_to_be_billed" => "Abzurechnender Restbetrag (netto)",
                                "amount_of_taxes_invoiced" => "Mehrwertsteuerbetrag",
                                "contract_number" => "Vertragsnummer",
                                "dc4" => "DC4",
                                "good_end" => "BF",
                                "good_end_deposit" => "Nr. der BF-Kaution (Bona Fide)",
                                "good_end_value" => "Einbehaltener BF-Betrag",
                                "guaranteed_holdback" => "RG",
                                "guaranteed_holdback_deposit" => "Nr. der RG-Kaution (mit Sicherheitseinbehalt)",
                                "guaranteed_holdback_value" => "Einbehaltener RG-Betrag",
                                "payment" => "Zahlung",
                                "signature" => "Datum der Unterzeichnung",
                                "vendor" => "Dienstanbieter",
                                "workfield" => "Name der Baustelle"
                            ],
                            "index" => [
                                "create_capture_invoice" => "Eine Rechnung zuschreiben",
                                "filters" => [
                                    "enterprise" => "Inhabergeführtes Unternehmen",
                                    "filter" => "Filtern",
                                    "reset" => "Zurücksetzen",
                                    "work_field" => "Baustelle"
                                ],
                                "return" => "Zurück",
                                "title" => "Rechnungsverfolgung für Verträge"
                            ]
                        ],
                        "capture_invoice" => [
                            "_breadcrumb" => [
                                "contracts" => "Verträge",
                                "create" => "Eine Rechnung zuschreiben",
                                "dashboard" => "Dashboard",
                                "index" => "Zugeschriebene Rechnungen",
                                "index_accounting_monitoring" => "Rechnungsverfolgung für Verträge"
                            ],
                            "_form" => [
                                "amount_good_end" => "BF-Betrag für diesen Vertrag",
                                "amount_guaranteed_holdback" => "RG-Betrag für diesen Vertrag ( :number des Nettobetrags der zugeschriebenen Rechnung)",
                                "contract" => "Vertrag",
                                "contract_number" => "Vertragsnummer",
                                "create" => "Rechnung zuschreiben",
                                "dc4_date" => "Datum der DC4 Validierung",
                                "dc4_file" => "DC4-Datei",
                                "dc4_percent" => "Vereinbart: X %",
                                "dc4_text" => "DC4: Vereinbart: :percent %",
                                "deposit_good_end_number" => "BF-Kautionsnr. für diesen Vertrag",
                                "deposit_guaranteed_holdback_number" => "RG-Kautionsnr. für diesen Vertrag",
                                "invoice_amount_before_taxes" => "Nettobetrag für diesen Vertrag",
                                "invoice_amount_of_taxes" => "Mehrwertsteuerbetrag fr diesen Vertrag",
                                "invoice_number" => "Dienstanbieter-Rechnungsnummer",
                                "invoiced_at" => "Rechnungsdatum",
                                "vendor" => "Dienstanbieter"
                            ],
                            "_table_head" => [
                                "actions" => "Aktionen",
                                "amount_good_end" => "Betrag BF",
                                "amount_guaranteed_holdback" => "Betrag RG",
                                "deposit_good_end_number" => "Nr. der BF-Kaution (Bona Fide)",
                                "deposit_guaranteed_holdback_number" => "Nr. der RG-Kaution (mit Sicherheitseinbehalt)",
                                "invoice_amount_before_taxes" => "Nettobetrag",
                                "invoice_amount_of_taxes" => "Mehrwertsteuerbetrag",
                                "invoiced_at" => "Datum der Inrechnungstellung",
                                "number" => "Nummer"
                            ],
                            "create" => [
                                "return" => "Zurück",
                                "title" => "Eine Rechnung für diesen Vertrag zuschreiben"
                            ],
                            "edit" => ["return" => "Zurück", "title" => "Zugeschriebene Rechnung bearbeiten"],
                            "index" => [
                                "create" => "Eine Rechnung zuschreiben",
                                "return" => "Zurück",
                                "title" => "Dem Vertrag :contract zugeschriebene Rechnungen"
                            ]
                        ],
                        "create" => [
                            "create" => "Abspeichern",
                            "return" => "Zurück",
                            "title" => "Erstellung des Vertrags"
                        ],
                        "create_amendment" => ["title" => "Erstellung des Nachtrags"],
                        "create_without_model" => [
                            "return" => "Zurück",
                            "submit" => "Speichern",
                            "title" => "Einen Vertrag einreichen"
                        ],
                        "create_without_model_to_sign" => [
                            "return" => "Zurück",
                            "submit" => "Speichern",
                            "title" => "Einen Vertrag zur Unterzeichnung einreichen"
                        ],
                        "edit" => ["edit" => "Ändern", "title" => "Vertrag Nr. :number bearbeiten"],
                        "edit_validators" => [
                            "edit" => "Ändern",
                            "title" => "Den Validierungsweg des Vertrags Nr. :number ändern"
                        ],
                        "export" => [
                            "success" => "Ihr Export wird erstellt; Sie erhalten einen Link, über den Sie ihn herunterladen können."
                        ],
                        "index" => [
                            "accounting_monitoring" => "Rechnungslegungsverfolgung",
                            "annex" => "",
                            "contract_model" => "Modell",
                            "create" => "Neuer Vertrag erstellen",
                            "createContractWithoutModel" => "",
                            "create_contract_without_model" => "Bereits unterzeichnet",
                            "create_contract_without_model_to_sign" => "Zu unterzeichnen",
                            "create_dropdown" => "Einen Vertrag einreichen",
                            "export" => "Exportieren",
                            "return" => "Zurück",
                            "title" => "Meine Verträge"
                        ],
                        "mail" => [
                            "addworking_team" => "",
                            "consult_button" => "",
                            "contract_needs_documents" => [
                                "addworking_team" => "Das AddWorking Team",
                                "consult_button" => "",
                                "consult_contract" => "Vertrag einsehen",
                                "consult_doc" => "Dokumente hinterlegen",
                                "followup" => "Erinnerung: ",
                                "greetings" => "Guten Tag, ",
                                "sentence_one" => "Für Ihren Vertrag :contract_name mit :enterprise_name sind bestimmte Elemente erforderlich, bevor er zur Unterzeichnung unterbreitet werden kann.",
                                "sentence_two" => "",
                                "subject" => ":enterprise_name schlägt Ihnen einen neuen Vertrag vor",
                                "thanks_you" => "Mit freundlichen Grüßen"
                            ],
                            "contract_needs_variables_values" => [
                                "addworking_team" => "Das AddWorking Team",
                                "consult_contract" => "Verträge einsehen",
                                "greetings" => "Guten Tag,",
                                "sentence_one" => "Der Vertrag :contract_name erfordert Informationen von Ihnen.",
                                "sentence_two" => "Bitte füllen Sie die Variablen aus.",
                                "subject" => "Variablenwerten sind Ihnen gefragt",
                                "thanks_you" => "Mit freundlichen Grüssen,"
                            ],
                            "contract_request_variable_value" => [
                                "addworking_team" => "Das AddWorking Team",
                                "consult_contract" => "Vertrag einsehen",
                                "consult_variables" => "Variablen einsehen",
                                "greetings" => "Guten Tag, ",
                                "sentence_one" => "Für den Vertrag :contract_name zwischen :pp_1 und :pp_2 werden von Ihnen Elemente benötigt.",
                                "sentence_two" => "Bitte machen Sie die verlangten Angaben.",
                                "subject" => "Sie werden aufgefordert, Variablenwerte einzugeben.",
                                "subject_oracle" => "",
                                "thanks_you" => "Mit freundlichen Grüßen"
                            ],
                            "contract_to_complete" => [
                                "addworking_team" => "Das AddWorking Team",
                                "consult_button" => "Ich sehe den Vertrag ein",
                                "greetings" => "Guten Tag, ",
                                "sentence_one" => "Ihr Vertrag :type mit dem Kunden :owner ist in Vorbereitung",
                                "sentence_two" => "Bitte geben Sie die Informationen ein, die zu seiner Erstellung benötigt werden.",
                                "subject" => "Neuer Vertrag",
                                "thanks_you" => "Mit freundlichen Grüßen"
                            ],
                            "contract_to_send_to_signature" => [
                                "addworking_team" => "Das AddWorking Team",
                                "consult_button" => "Ich sehe den Vertrag ein",
                                "greetings" => "Guten Tag, ",
                                "sentence_one" => "Der Vertrag :contract_name ist zur Vorlage zwecks Unterzeichnung bereit.",
                                "sentence_three" => "Sie können darauf zugreifen, indem Sie auf die nachstehende Schaltfläche klicken.",
                                "sentence_two" => "Senden Sie Ihren Vertrag zur Validierung oder unterbreiten Sie ihn direkt zur Unterzeichnung.",
                                "subject" => "Der Vertrag :contract_name ist zur Vorlage zwecks Unterzeichnung bereit",
                                "thanks_you" => "Mit freundlichen Grüßen"
                            ],
                            "contract_to_sign" => [
                                "addworking_team" => "Das AddWorking Team",
                                "consult_button" => "Ich sehe den Vertrag ein",
                                "followup" => "Erinnerung: ",
                                "greetings" => "Guten Tag, ",
                                "sentence_one" => "Die Firma :owner fordert Sie auf zur Unterzeichnung des Vertrags :contract_name.",
                                "sentence_two" => "Sie können den Vertrag einsehen und dann unterzeichnen, indem Sie auf die nachstehende Schaltfläche klicken.",
                                "subject" => "Neuer Vertrag zur Unterzeichnung",
                                "thanks_you" => "Mit freundlichen Grüßen"
                            ],
                            "contract_to_validate_on_yousign" => [
                                "addworking_team" => "Das AddWorking Team",
                                "consult_button" => "Ich sehe den Vertrag ein",
                                "followup" => "Erinnerung: ",
                                "greetings" => "Guten Tag, ",
                                "sentence_one" => "Die Firma :owner fordert Sie auf zur Validierung des Vertrags :contract_name, bevor dieser zur Unterzeichnung unterbreitet wird.",
                                "sentence_two" => "Sie können den Vertrag einsehen und dann validieren, indem Sie auf die nachstehende Schaltfläche klicken.",
                                "subject" => "Ein neuer Vertrag wartet auf Ihre Validierung",
                                "thanks_you" => "Mit freundlichen Grüßen"
                            ],
                            "expiring_contract_customer" => [
                                "addworking_team" => "Das AddWorking Team",
                                "greetings" => "Guten Tag, ",
                                "sentence_one" => "Ein oder mehrere Verträge von :enterprise_name laufen in weniger als 30 Tagen ab.",
                                "sentence_three" => "Ein oder mehrere Verträge von :enterprise_name laufen ab am ",
                                "sentence_two" => "Wir möchten Sie freundlichst dazu auffordern, die notwendigen Vorkehrungen zu treffen, um den Vertrag/die Verträge ggf. zu erneuern.",
                                "subject_one" => "Sie haben Verträge, die fällig werden",
                                "subject_two" => "Sie haben Verträge, die bald ablaufen",
                                "thank_you" => "Mit freundlichen Grüßen",
                                "url" => "Ich sehe die betroffenen Verträge ein"
                            ],
                            "expiring_contract_vendor" => [
                                "addworking_team" => "Das AddWorking Team",
                                "greetings" => "Guten Tag, ",
                                "sentence_one" => "Ihr Vertrag :contract_name mit :enterprise_name wird fällig am ",
                                "subject_one" => "Sie haben einen Vertrag, der fällig wird",
                                "thank_you" => "Mit freundlichen Grüßen",
                                "url" => "Ich sehe den Vertrag ein"
                            ],
                            "export" => [
                                "addworking_team" => "Das AddWorking Team",
                                "consult_button" => "Herunterladen",
                                "greetings" => "Guten Tag, ",
                                "sentence_one" => "Ihr Export ist fertig!",
                                "sentence_two" => "Klicken Sie auf den nachstehenden Link, um ihn herunterzuladen:",
                                "subject" => "Export der Verträge für :enterprise_name",
                                "thanks_you" => "Mit freundlichen Grüßen"
                            ],
                            "greetings" => "",
                            "notify_for_new_comment" => [
                                "addworking_team" => "Das AddWorking Team",
                                "comment_author" => "Von :author_name",
                                "consult_button" => "Ich sehe den Vertrag ein",
                                "greetings" => "Guten Tag :user_name,",
                                "sentence_one" => "AddWorking informiert Sie hiermit, dass ein neuer Kommentar gesendet wurde für den Vertrag :contract_name : ",
                                "subject" => ":contract_name - Ein neuer Kommentar wurde gesendet.",
                                "thanks_you" => "Mit freundlichen Grüßen"
                            ],
                            "refused_contract" => [
                                "addworking_team" => "Das AddWorking Team",
                                "consult_button" => "Ich sehe den Vertrag ein",
                                "greetings" => "Guten Tag :name,",
                                "sentence_one" => "AddWorking informiert Sie hiermit, dass der Vertrag :contract_name abgelehnt wurde",
                                "subject" => ":name - Ihr Dokument wurde auf AddWorking abgelehnt.",
                                "thanks_you" => "Mit freundlichen Grüßen"
                            ],
                            "request_validation" => [
                                "access_contract" => "Auf den Vertrag zugreifen",
                                "addworking_team" => "Das AddWorking Team",
                                "greetings" => "Guten Tag, ",
                                "sentence_one" => "Sie haben einen neuen Vertrag, der von Ihnen validiert werden muss, bevor er zur Unterzeichnung unterbreitet wird:",
                                "sentence_two" => "Sie können den gesamten Vertrag einsehen, indem Sie auf die nachstehende Schaltfläche klicken.",
                                "thanks_you" => "Mit freundlichen Grüßen"
                            ],
                            "sentence_one" => "",
                            "sentence_two" => "",
                            "signed_contract" => [
                                "addworking_team" => "Das AddWorking Team",
                                "consult_button" => "Ich sehe den Vertrag ein",
                                "greetings" => "Guten Tag :name,",
                                "sentence_one" => "AddWorking informiert Sie hiermit, dass der Vertrag :contract_name mit Erfolg unterzeichnet wurde.",
                                "subject" => ":name - Die Unterzeichnung Ihres Dokuments in AddWorking wurde abgeschlossen.",
                                "thanks_you" => "Mit freundlichen Grüßen"
                            ],
                            "thanks_you" => ""
                        ],
                        "request_validation" => [
                            "general_information" => "Allgemeine Informationen",
                            "send" => "Anforderung für Unterbreitung zur Unterzeichnung absenden",
                            "success" => "Dieser Vertrag wurde zur Validierung gesendet, bevor er zur Unterzeichnung unterbreitet wird. Um den Validierer daran zu erinnern, können Sie den Vorgang einfach wiederholen.",
                            "title" => "Anforderung für Unterbreitung zur Unterzeichnung senden",
                            "user" => "Benutzer"
                        ],
                        "show" => [
                            "add_dropdown" => "Hinzufügen...",
                            "add_part" => "einen bestimmten Anhang",
                            "add_part_to_signed_contract" => "ein anhängendes Dokument",
                            "create_amendment" => "einen Nachtrag",
                            "create_amendment_without_model" => "einen unterzeichneten Nachtrag",
                            "create_amendment_without_model_to_sign" => "einen zu unterzeichnenden Nachtrag",
                            "edit_variable" => "Variablen ausfüllen",
                            "generate_contract" => "",
                            "request_signature" => ":designation_pp erneut an Unterzeichnung erinnern",
                            "request_validation" => "Zur Validierung einsenden",
                            "return" => "Zurück",
                            "send_to_manager" => "An einen Verantwortlichen senden",
                            "send_to_sign" => "Vertrag zur Unterzeichnung vorlegen",
                            "sign" => "Unterzeichnen",
                            "upload_documents" => "Beizufügende Dokumente",
                            "validate" => "Den Vertrag akzeptieren"
                        ],
                        "tracking" => [
                            "request_documents" => "Benachrichtigung zur Anforderung der notwendigen Dokumente für den Vertrag am :date an :pp durch :user"
                        ],
                        "upload_signed_contract" => [
                            "display_name" => "Name des Vertragselements",
                            "file" => "Auszuwählende Datei",
                            "party_signed_at" => "Datum der Unterzeichnung durch :party_name",
                            "return" => "Zurück",
                            "select_file" => "Eine Datei auswählen",
                            "signed_on_the_at" => "Unterzeichnet von {firstname} {lastname} am {date.fr}",
                            "submit" => "Hinzufügen",
                            "title" => "Unterzeichneten Vertrag aktualisieren"
                        ]
                    ],
                    "contract_mission" => [
                        "_breadcrumb" => [
                            "contract" => "Vertrag Nr. :number",
                            "create_amendment" => "Einen Nachtrag erstellen",
                            "dashboard" => "Dashboard",
                            "link_contract" => "Einen Vertrag verbinden",
                            "link_mission" => "Eine Mission verbinden",
                            "mission" => "Mission Nr. :number"
                        ],
                        "create" => [
                            "contract" => "Vertrag",
                            "contract_title" => "Den Vertrag Nr. :number mit einer Mission verbinden",
                            "mission" => "Mission",
                            "mission_title" => "Die Mission Nr. :number mit einem Vertrag verbinden",
                            "return" => "Zurück",
                            "submit" => "Abspeichern"
                        ]
                    ],
                    "contract_part" => [
                        "_actions" => ["delete" => "Löschen"],
                        "_form" => [
                            "annex" => "",
                            "display_name" => "Name des Elements",
                            "file" => "Anzufügendes Element",
                            "is_from_annexes" => "",
                            "is_from_annexes_options" => "",
                            "is_signed" => "Zu unterzeichnendes Element?",
                            "no" => "Nein",
                            "select_file" => "Eine Datei auswählen",
                            "sign_on_last_page" => "Letzte Seite",
                            "signature_mention" => "Anmerkung zur Unterzeichnung",
                            "signature_page" => "Seitenzahl der Unterzeichnung ",
                            "upload_file" => "",
                            "yes" => "Ja"
                        ],
                        "create" => [
                            "return" => "Zurück",
                            "submit" => "Abspeichern",
                            "title" => "Einen bestimmten Anhang hinzufügen"
                        ],
                        "signed_contract" => [
                            "create" => [
                                "return" => "Zurück",
                                "submit" => "Abspeichern",
                                "title" => "Einen bestimmten Anhang hinzufügen"
                            ]
                        ]
                    ],
                    "contract_party" => [
                        "_breadcrumb" => [
                            "create" => "Erstellen",
                            "dashboard" => "Dashboard",
                            "index" => "Vertragsparteien",
                            "index_contract" => "Verträge",
                            "show_contract" => "Vertrag Nr. :number"
                        ],
                        "_form" => [
                            "add_validator" => "Einen Validierer hinzufügen",
                            "confirm_edit" => "Wenn Sie die Informationen der Vertragsparteien bearbeiten, werden die Dateien des Vertrags definitiv gelöscht. Sind Sie sicher?",
                            "denomination" => "Bezeichnung",
                            "enterprise" => "Unternehmen",
                            "general_information" => "Allgemeine Informationen",
                            "order" => "Bestellen",
                            "party" => "Vertragspartei",
                            "remove_validator" => "Zurückziehen",
                            "signatory" => "Unterzeichner",
                            "signed_at" => "Datum der Unterzeichnung",
                            "validator" => "Validierer",
                            "validator_info" => "Diese Mitglieder werden zur Validierung des Vertrags aufgefordert, bevor dieser zur Unterzeichnung vorgelegt wird",
                            "validators" => "Validierer"
                        ],
                        "create" => [
                            "create" => "Abspeichern",
                            "return" => "Zurück",
                            "title" => "Identifikation der Vertragsparteien des Vertrags Nr. :number"
                        ],
                        "store" => [
                            "success" => "Variablen zum automatischen Ausfüllen werden generiert. Dies kann mehrere Minuten dauern. In der Zwischenzeit können Sie die restlichen Variablen ausfüllen."
                        ]
                    ],
                    "contract_party_document" => [
                        "_breadcrumb" => [
                            "dashboard" => "Dashboard",
                            "index" => "Angeforderte Dokumente für :enterprise_name",
                            "index_contract" => "Verträge",
                            "show_contract" => "Vertrag Nr. :number"
                        ],
                        "index" => [
                            "return" => "Zurück",
                            "title" => "Dokument(e) von :enterprise für den Vertrag :name"
                        ]
                    ],
                    "contract_variable" => [
                        "_breadcrumb" => [
                            "dashboard" => "Dashboard",
                            "define_value" => "Variablenwerte definieren",
                            "edit" => "Variablenwerte für den Vertrag definieren",
                            "index" => "Vertragsvariablen",
                            "index_contract" => "Verträge",
                            "show_contract" => "Vertrag Nr. :number"
                        ],
                        "_filters" => [
                            "filter" => "Filtern",
                            "model_variable_display_name" => "Bezeichnung der Variable",
                            "model_variable_input_type" => "Typ",
                            "model_variable_model_part_display_name" => "Vertragselement",
                            "model_variable_required" => "Erforderlich",
                            "reset" => "Zurücksetzen",
                            "value" => "Wert"
                        ],
                        "_form" => [
                            "denomination_party" => "Bezeichnung der Vertragspartei",
                            "description" => "Beschreibung",
                            "display_name" => "Name der Variable",
                            "edit_variable_value" => "Änderung der Variablenwerte des Vertrags",
                            "value" => "Wert (verwendet im Element: :part)"
                        ],
                        "_table_head" => [
                            "contract_model_display_name" => "Bezeichnung der Variable",
                            "contract_model_input_type" => "Typ",
                            "contract_model_part_name" => "Vertragselement",
                            "contract_party_enterprise_name" => "Vertragspartei",
                            "description" => "Beschreibung",
                            "required" => "Obligatorisch",
                            "value" => "Wert"
                        ],
                        "define_value" => [
                            "create" => "Abspeichern",
                            "edit" => "Variablenwerte für den Vertrag definieren",
                            "request_contract_variable_value_user_to_request" => "Einen zu benachrichtigen Benutzer auswählen",
                            "request_value_button" => "Variablen zuweisen",
                            "return" => "Zurück",
                            "send_request_contract_variable_value" => "Anfrage senden",
                            "success_send_request_contract_variable_value" => "Eine Anfrage wurde gesendet.",
                            "title" => "Variablenwerte definieren",
                            "url_is_too_long" => "Sie können keine weiteren Variablen auswählen."
                        ],
                        "error" => ["no_variable_to_edit" => "Keine zu definierende Variable"],
                        "index" => [
                            "define_value" => "Werte definieren",
                            "refresh" => "Variablen aktualisieren",
                            "refresh_warning" => "Nicht gespeicherte Variablenwerte des Formulars gehen verloren.",
                            "regenerate" => "Vertragselemente erneut generieren",
                            "return" => "Zurück",
                            "table_row_empty" => "Keine Vertragsvariable gefunden",
                            "title" => "Liste der Vertragsvariablen"
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
                            "contract_enterprise_owner" => "Inhabergeführtes Unternehmen",
                            "contract_external_identifier" => "Externe Kennung",
                            "contract_title" => "Vertrag",
                            "contract_valid_from" => "Anfangsdatum",
                            "contract_valid_until" => "Fälligkeitsdatum",
                            "date" => "Datum",
                            "enterprise_address" => "Anschrift des Unternehmens",
                            "enterprise_employees_number" => "Anzahl der Mitarbeiter ",
                            "enterprise_identification_number" => "Handelsregisternummer (Kennnummer)",
                            "enterprise_legal_form" => "Rechtsform",
                            "enterprise_name" => "Firmenname",
                            "enterprise_registration_date" => "Registrierungsnummer",
                            "enterprise_siren_number" => "SIREN",
                            "enterprise_title" => "Unternehmen",
                            "enterprise_town" => "Sitz des Unternehmens",
                            "long_text" => "Langer Text",
                            "mission_amount" => "Betrag",
                            "mission_ended_at" => "Enddatum",
                            "mission_started_at" => "Anfangsdatum",
                            "mission_title" => "Mission",
                            "options" => "Optionen",
                            "party_title" => "Vertragspartei",
                            "registration_town" => "Ort der Registrierung",
                            "signatory_function" => "Funktion des Unterzeichners",
                            "signatory_mail" => "E-Mail-Adresse des Unterzeichners",
                            "signatory_name" => "Name des Unterzeichners",
                            "signatory_title" => "Unterzeichner",
                            "text" => "Text",
                            "text_title" => "Eingabe",
                            "work_field_address" => "Anschrift",
                            "work_field_description" => "Beschreibung der in Auftrag gegebenen Aufgaben",
                            "work_field_display_name" => "Name",
                            "work_field_ended_at" => "Enddatum",
                            "work_field_external_id" => "Baustellenschlüssel",
                            "work_field_project_manager" => "Bauherr",
                            "work_field_project_owner" => "Bauunternehmen",
                            "work_field_sps_coordinator" => "EHS-Koordinator",
                            "work_field_started_at" => "Anfangsdatum",
                            "work_field_title" => "Baustelle"
                        ]
                    ]
                ],
                "views" => [
                    "contract_model" => [
                        "_actions" => [
                            "add_part" => "Ein Element hinzufügen",
                            "archive" => "Archivieren",
                            "consult" => "Einsehen",
                            "delete" => "Löschen",
                            "duplicate" => "Duplizieren",
                            "edit" => "Ändern",
                            "index_part" => "Elemente (:count)",
                            "index_variable" => "",
                            "index_variables" => "Variablen",
                            "preview" => "Vorschau",
                            "versionate" => "Neue Version"
                        ],
                        "_breadcrumb" => [
                            "create" => "Erstellen Sie eine Vertragsvorlage",
                            "dashboard" => "Dashboard",
                            "edit" => "Ändern",
                            "index" => "Vertragsmodelle",
                            "show" => "Nr. :number"
                        ],
                        "_filters" => [
                            "archived_contract_model" => "Archivierte Modelle anzeigen",
                            "enterprise" => "Inhabergeführtes Unternehmen",
                            "status" => "Status"
                        ],
                        "_form" => [
                            "display_name" => "Modellname",
                            "enterprise" => "Inhabergeführtes Unternehmen",
                            "general_information" => "Allgemeine Informationen",
                            "should_vendors_fill_their_variables" => "Subunternehmer müssen die sie betreffenden Variablen ausfüllen."
                        ],
                        "_html" => [
                            "archived_date" => "Archivierungsdatum",
                            "created_date" => "Erstellungsdatum",
                            "delete" => "Löschen",
                            "display_name" => "Modellname",
                            "document_types" => "Zugehörige Dokumente",
                            "enterprise" => "Inhabergeführtes Unternehmen",
                            "id" => "Kennung",
                            "informations" => "Allgemeine Informationen",
                            "last_modified_date" => "Datum der letzten Änderung",
                            "more_informations" => "Zusätzliche Informationen",
                            "no" => "Nein",
                            "parties" => "Vertragsparteien",
                            "parts" => "Element(e) des Vertragsmodells",
                            "published_date" => "Veröffentlichungsdatum",
                            "should_vendors_fill_their_variables" => "Die Variablen werden von Subunternehmen ausgefüllt",
                            "status" => "Status",
                            "version" => "(Version: :version_number)",
                            "yes" => "Ja"
                        ],
                        "_state" => ["Archived" => "Archiviert", "Draft" => "Entwurf", "Published" => "Veröffentlicht"],
                        "_table_head" => [
                            "actions" => "Aktionen",
                            "archived_at" => "",
                            "created_at" => "Erstellungsdatum",
                            "display_name" => "Modellname",
                            "enterprise" => "Inhabergeführtes Unternehmen",
                            "number" => "Nummer",
                            "published_at" => "",
                            "status" => "Status"
                        ],
                        "create" => [
                            "create" => "Abspeichern",
                            "parties" => "Vertragsparteien",
                            "party" => "Bezeichnung der Vertragspartei :number",
                            "return" => "Zurück",
                            "title" => "Erstellung des Vertragsmodells"
                        ],
                        "edit" => [
                            "edit" => "Ändern",
                            "party" => "Bezeichnung der Vertragspartei :number",
                            "title" => "Modell für Vertrag Nr. :number ändern"
                        ],
                        "index" => [
                            "button_create" => "Erstellen Sie eine Vertragsvorlage",
                            "part" => "Elemente des Modells",
                            "publish_button" => "Veröffentlichen",
                            "return" => "Zurück",
                            "table_row_empty" => "Kein Vertragsmodell gefunden",
                            "title" => "Liste der Vertragsmodelle"
                        ],
                        "show" => [
                            "back" => "Zurück",
                            "part" => "Ein Vertragselement hinzufügen",
                            "publish_button" => "Veröffentlichen",
                            "return" => "Zurück",
                            "unpublished_button" => "Nicht mehr veröffentlichen",
                            "variable" => "Variablen ausfüllen"
                        ]
                    ],
                    "contract_model_document_type" => [
                        "_actions" => ["delete" => "Löschen"],
                        "_breadcrumb" => [
                            "create" => "Hinzufügen",
                            "dashboard" => "Dashboard",
                            "document_type" => "Art Dokument",
                            "index" => "Vertragsmodelle",
                            "party" => "Vertragspartei Nr. :number",
                            "show" => "Nr. :number"
                        ],
                        "_form" => [
                            "add" => "Auswählen?",
                            "document_type" => "Art des Dokuments",
                            "no" => "Nein",
                            "validation_required" => "Validierungsanforderung",
                            "yes" => "Ja"
                        ],
                        "_table_head" => [
                            "actions" => "Aktionen",
                            "created_at" => "Erstellungsdatum",
                            "document_type" => "Art des Dokuments",
                            "validation_by" => "Validierung durch",
                            "validation_required" => "Validierungsanforderung"
                        ],
                        "create" => [
                            "create" => "Abspeichern",
                            "return" => "Zurück",
                            "title" => "Definieren der Dokumentenart für die Vertragspartei Nr. :number: :denomination"
                        ],
                        "create_specific_document" => [
                            "create" => "Hinzufügen",
                            "description" => "Beschreibung",
                            "display_name" => "Name des Dokumentenmodells",
                            "general_information" => "Allgemeine Informationen",
                            "return" => "Zurück",
                            "title" => "Hinzufügen eines spezifischen Dokuments für die Vertragspartei Nr. :number: :denomination",
                            "validation_required" => "Validierung anfordern?"
                        ],
                        "index" => [
                            "button_create" => "Verknüpfen Sie ein Dokument ",
                            "button_create_specific_document" => "Ein spezifisches Dokument hinzufügen",
                            "return" => "Zurück",
                            "table_row_empty" => "Dieser Vertragspartei wurde keine Dokumentenart zugewiesen",
                            "title" => "Liste der zugewiesenen Dokumente der Vertragspartei Nr. :number: :denomination"
                        ]
                    ],
                    "contract_model_part" => [
                        "_actions" => ["delete" => "Löschen", "preview" => "Vorschau"],
                        "_breadcrumb" => [
                            "create" => "Ein Element als Vertragsmodell erstellen",
                            "dashboard" => "Dashboard",
                            "edit" => "Ändern",
                            "index" => "Elemente als Vertragsmodell",
                            "parts" => "Elemente",
                            "show" => "Nr. :number"
                        ],
                        "_form" => [
                            "display_name" => "Name des Elements",
                            "empty_textarea" => "Das Textfeld ist leer.",
                            "file" => "Datei",
                            "general_information" => "Allgemeine Informationen",
                            "information" => [
                                "call_to_action" => "Mehr Informationen hier",
                                "modal" => [
                                    "main_title" => "Verwendung der Variablen",
                                    "paragraph_1_1" => "Damit Ihre Variablen vom System gelesen werden können, müssen diese ein bestimmtes Format aufweisen",
                                    "paragraph_1_10" => "{{1.siret}}",
                                    "paragraph_1_11" => "{{2.firmenbezeichnung}}",
                                    "paragraph_1_12" => "{{1.variable_vertragspartei_1}}",
                                    "paragraph_1_13" => "{{2.variable_vertragspartei_2}}",
                                    "paragraph_1_14" => "{{1.familienname}}",
                                    "paragraph_1_15" => "{{2.familienname}}",
                                    "paragraph_1_2" => "Schreiben Sie Ihre Variablen zunächst zwischen zwei geschweifte Klammern (zwei öffnende und zwei schließende).",
                                    "paragraph_1_3" => "Definieren Sie anschließend zwei Informationselemente, die Sie durch einen Punkt trennen.",
                                    "paragraph_1_5" => "Der erste Teil der Variable bestimmt die Rangfolge, hier einer der Vertragsparteien des Vertragsmodells.",
                                    "paragraph_1_6" => "Der zweite Teil enthält den Namen der Variable. Sie kann einen beliebigen Wert enthalten.",
                                    "paragraph_1_7" => "Anmerkung: Variablen sollten immer in Kleinbuchstaben geschrieben werden und keine alphanumerischen Zeichen enthalten.",
                                    "paragraph_1_8" => "Beispiel:",
                                    "paragraph_1_9" => "{{1.name_der_variable}}",
                                    "paragraph_2_1" => "Die Variable kann an beliebiger Stelle des Textbereichs platziert werden. Sie wird vom System automatisch erkannt.",
                                    "title_1" => "Variablenformat",
                                    "title_2" => "Nutzung von Variablen"
                                ],
                                "paragraph_1" => "Verwenden Sie Variablen, mit deren Hilfe Sie Ihre Verträge dynamischer gestalten können. Beispiel:",
                                "paragraph_2" => "{{1.name_der_variable}}",
                                "paragraph_3" => "{{1.siret}}",
                                "paragraph_4" => "{{2.firmenbezeichnung}}",
                                "paragraph_5" => "{{1.variable_vertragspartei_1}}",
                                "paragraph_6" => "{{2.variable_vertragspartei_2}}",
                                "paragraph_7" => "{{1.familienname}}",
                                "paragraph_8" => "{{2.familienname}}"
                            ],
                            "is_initialled" => "Initialen",
                            "is_signed" => "Zu unterzeichnen",
                            "no" => "Nein",
                            "order" => "Bestellen",
                            "part_type" => "Art des Elements",
                            "sign_on_last_page" => "Letzte Seite",
                            "signature_mention" => "Anmerkung zur Unterzeichnung",
                            "signature_page" => "Seitenzahl der Unterzeichnung",
                            "signature_position" => "Position der Unterzeichnung (a,b,c,d)",
                            "textarea" => "Text Zone",
                            "yes" => "Ja"
                        ],
                        "_table_head" => [
                            "actions" => "Aktionen",
                            "display_name" => "Name des Elements",
                            "id" => "UUID",
                            "is_initialled" => "Initialen",
                            "is_signed" => "Zu unterzeichnen",
                            "order" => "Bestellen"
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
                            "create" => "Abspeichern",
                            "parties" => "Vertragsparteien",
                            "party" => "Bezeichnung der Vertragspartei :number",
                            "return" => "Zurück",
                            "title" => "Erstellen eines Elements"
                        ],
                        "edit" => [
                            "_actions" => ["delete" => "Löschen", "preview" => "Vorschau"],
                            "_breadcrumb" => [
                                "create" => "Erstellen",
                                "dashboard" => "Dashboard",
                                "edit" => "Ändern",
                                "index" => "Elemente des Modells",
                                "show" => "Nr. :number"
                            ],
                            "edit" => "Ändern",
                            "party" => "Bezeichnung der Vertragspartei :number",
                            "title" => "Bearbeiten des Elements Nr. :number"
                        ],
                        "index" => [
                            "button_create" => "Ein Element hinzufügen",
                            "create" => "Abspeichern",
                            "return" => "Zurück",
                            "table_row_empty" => "Kein Element für das Vertragsmodell gefunden",
                            "title" => "Liste der Elemente des Vertragsmodells"
                        ]
                    ],
                    "contract_model_variable" => [
                        "_breadcrumb" => [
                            "dashboard" => "Dashboard",
                            "edit" => "Ändern",
                            "index" => "Vertragsmodelle",
                            "show" => "Nr. :number",
                            "variables" => "Variablen"
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
                            "contract_model" => "Modell",
                            "default_value" => "Standardwert",
                            "description" => "Beschreibung",
                            "display_name" => "Name der Variable",
                            "enterprise" => "Inhaber des Modells",
                            "enterprise_owner" => "Inhaber des Vertrags",
                            "external_identifier" => "Externe Kennung",
                            "general_information" => "Allgemeine Informationen",
                            "input_type" => "Typ",
                            "is_exportable" => "Exportierbar",
                            "model" => "Name des Elements",
                            "name" => "Name des Vertrags",
                            "options" => "Optionen",
                            "required" => "Erforderlich",
                            "valid_from" => "Anfangsdatum",
                            "valid_until" => "Fälligkeitsdatum",
                            "variable" => "Variable"
                        ],
                        "_form_without_model" => [
                            "actions" => "Aktionen",
                            "contract_informations" => "Informationen zum Vertrag",
                            "designation" => "Bezeichnung der Vertragspartei",
                            "display_name" => "Name des Vertragselements",
                            "enterprise" => "Vertragspartei",
                            "external_identifier" => "Externe Kennung",
                            "file" => "Auszuwählende Datei",
                            "name" => "Name des Vertrags",
                            "number" => "Nummer",
                            "owner" => "Inhabergeführtes Unternehmen",
                            "part_informations" => "Informationen zum Vertragselement",
                            "parties_informations" => "Informationen zu den Vertragsparteien und Unterzeichnern",
                            "select_file" => "Eine Datei auswählen",
                            "signatory" => "Unterzeichner",
                            "valid_from" => "Anfangsdatum",
                            "valid_until" => "Enddatum"
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
                            "actions" => "Aktionen",
                            "default_value" => "Standardwert",
                            "description" => "Beschreibung",
                            "display_name" => "Angezeigter Name",
                            "enterprise" => "Inhabergeführtes Unternehmen",
                            "input_type" => "Typ",
                            "model" => "Modell",
                            "name" => "Name des Vertrags",
                            "part_name" => "Name des Elements",
                            "parties" => "Vertragsparteien",
                            "party_denomination" => "Vertragspartei",
                            "required" => "Erforderlich",
                            "status" => "Status",
                            "valid_from" => "Anfangsdatum",
                            "valid_until" => "Enddatum"
                        ],
                        "create_without_model" => [
                            "return" => "Zurück",
                            "submit" => "Speichern",
                            "title" => "Einen Vertrag einreichen"
                        ],
                        "edit" => [
                            "create_amendment" => "Einen Nachtrag erstellen",
                            "create_part" => "Einen bestimmten Anhang hinzufügen",
                            "edit" => "Ändern",
                            "return" => "Zurück",
                            "title" => "",
                            "upload_signed_contract" => "Unterzeichneten Vertrag aktualisieren"
                        ],
                        "index" => [
                            "create" => "Neuer Vertrag erstellen",
                            "createContractWithoutModel" => "Einen Vertrag einreichen",
                            "edit" => "Variablen aktualisieren",
                            "return" => "Zurück",
                            "table_row_empty" => "Keine Variable für Vertragsmodell gefunden",
                            "title" => "Liste der Variablen des Vertragsmodells"
                        ],
                        "show" => [
                            "return" => "Zurück",
                            "title" => "Änderung der Variablen des Vertrags Nr. :number"
                        ],
                        "upload_signed_contract" => [
                            "display_name" => "Name des Vertragselements",
                            "file" => "Auszuwählende Datei",
                            "party_signed_at" => "Datum der Unterzeichnung durch :party_name",
                            "return" => "Zurück",
                            "select_file" => "Eine Datei auswählen",
                            "submit" => "Hinzufügen",
                            "title" => "Unterzeichneten Vertrag aktualisieren"
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
                        "_form" => ["note" => "Notiz"],
                        "months" => [
                            "april" => "april",
                            "august" => "august",
                            "december" => "dezember",
                            "february" => "februar",
                            "january" => "januar",
                            "july" => "july",
                            "june" => "juni",
                            "march" => "mrz",
                            "may" => "Mai",
                            "november" => "november",
                            "october" => "oktober",
                            "september" => "september"
                        ]
                    ]
                ]
            ]
        ],
        "filters" => [
            "identification_number" => "Handelsregisternummer",
            "name" => "Firmenname",
            "phone" => "Telefon",
            "zipcode" => "Postleitzahl oder Lnder"
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
        "modal" => ["register" => "Abspeichern"],
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
                    "create" => [
                        "denied_must_be_support_user" => "Ein Anhang kann nur von einem Support-Mitglied erstellt werden"
                    ],
                    "create_support" => [
                        "denied_must_be_support_user" => "Diese Seite kann nur von einem Mitglied des AddWorking Supports angezeigt werden"
                    ],
                    "index" => [
                        "denied_must_be_support_user" => "Die Liste der Anhänge kann nur von einem Support-Mitglied angezeigt werden"
                    ],
                    "index_support" => [
                        "denied_must_be_support_user" => "Diese Seite kann nur von einem Mitglied des AddWorking Supports angezeigt werden"
                    ],
                    "update" => [
                        "denied_must_be_support_user" => "Ein Anhang kann nur von einem Support-Mitglied geändert werden"
                    ],
                    "view" => [
                        "denied_must_be_support_user" => "Ein Anhang kann nur von einem Support-Mitglied eingesehen werden"
                    ]
                ],
                "views" => [
                    "mission_tracking_line_attachment" => [
                        "_breadcrumb" => ["create" => "Erstellen", "edit" => "Ändern", "index" => "Anhänge"],
                        "_form" => ["period" => "Zeitraum", "title" => "Informationen zum Anhang"],
                        "_html" => [
                            "amount" => "Nettopreis",
                            "created_at" => "Erstellt am",
                            "direct_billing" => "Direkte Rechnungslegung",
                            "id" => "Kennung",
                            "label" => "Wortlaut",
                            "num_attachment" => "Nummer des Anhangs",
                            "num_order" => "Auftragsnummer",
                            "num_site" => "Baustellennummer",
                            "reverse_charges" => "Reverse-Charge",
                            "signed_at" => "Unterzeichnet am",
                            "submitted_at" => "Datum der Einreichung in DocuSign",
                            "updated_at" => "Aktualisiert am"
                        ],
                        "_period_selector" => [
                            "customer" => "Kunde",
                            "milestone" => "Zeitraum",
                            "mission" => "Mission",
                            "vendor" => "Dienstanbieter"
                        ],
                        "_table_head" => [
                            "customer" => "Kunde",
                            "num_attachment" => "Nummer des Anhangs",
                            "num_order" => "Auftragsnummer",
                            "vendor" => "Dienstanbieter"
                        ],
                        "create" => [
                            "amount" => "Betrag",
                            "direct_billing" => "Direkte Rechnungslegung",
                            "file" => "Datei",
                            "num_attachment" => "Nummer des Anhangs",
                            "num_order" => "Auftragsnummer",
                            "num_site" => "Standortnummer",
                            "return" => "Zurück",
                            "reverse_charges" => "Reverse-Charge",
                            "save" => "Abspeichern",
                            "signed_at" => "Unterzeichnet am",
                            "submitted_at" => "Datum der Einreichung in DocuSign",
                            "title" => "Anhang erstellen"
                        ],
                        "create_support" => [
                            "amount" => "Nettobetrag",
                            "customer" => "Kunde",
                            "direct_billing" => "Direkte Rechnungslegung",
                            "file" => "PDF-Datei",
                            "milestone" => "Zeitraum",
                            "mission" => "Mission",
                            "num_attachment" => "Nummer des Anhangs",
                            "num_order" => "Auftragsnummer",
                            "num_site" => "Baustellennummer",
                            "reverse_charges" => "Reverse Charge",
                            "save" => "Abspeichern",
                            "signed_at" => "Datum der Unterzeichnung",
                            "title" => "Einen Anhang zur Sogetrel Verfolgungslinie erstellen",
                            "vendor" => "Dienstanbieter"
                        ],
                        "edit" => ["return" => "Zurück", "save" => "Abspeichern", "title" => "Ändern"],
                        "index" => [
                            "add" => "Hinzufügen",
                            "amount" => "Betrag",
                            "created_from_airtable" => "Erstellung Airtable",
                            "customer" => "Kunde",
                            "direct_billing" => "Direkte Rechnungslegung",
                            "doesnt_have_inbound_invoice" => "Hat keine eingehende Rechnung",
                            "doesnt_have_outbound_invoice" => "Hat keine ausgehende Rechnung",
                            "empty" => "Leer",
                            "filter_inbound_invoice" => "Eingehende Rechnungen",
                            "filter_outbound_invoice" => "Ausgehende Rechnungen",
                            "has_inbound_invoice" => "Hat eingehende Rechnungen",
                            "has_outbound_invoice" => "Hat ausgehende Rechnungen",
                            "inbound_invoice" => "Eingehende Rechnung",
                            "milestone" => "Zeitraum",
                            "mission" => "Mission",
                            "num_attachment" => "Nummer des Anhangs",
                            "num_order" => "Auftragsnummer",
                            "outbound_invoice" => "Ausgehende Rechnung",
                            "signed_at" => "Unterzeichnet am",
                            "title" => "Sogetrel Anhänge",
                            "vendor" => "Dienstanbieter"
                        ],
                        "show" => [
                            "return" => "Zurück",
                            "tab_file" => "Datei",
                            "tab_summary" => "Eigenschaften",
                            "title" => "Anhang"
                        ]
                    ],
                    "support_mission_tracking_line_attachment" => [
                        "index" => [
                            "add" => "Hinzufügen",
                            "amount" => "Nettobetrag",
                            "customer" => "Kunde",
                            "direct_billing" => "Direkte Rechnungslegung",
                            "doesnt_have_inbound_invoice" => "Ohne Rechnung",
                            "doesnt_have_outbound_invoice" => "Ohne Rechnung",
                            "filter_inbound_invoice" => "Eingehende Rechnungen",
                            "filter_outbound_invoice" => "Ausgehende Rechnungen",
                            "has_inbound_invoice" => "Mit Rechnungen",
                            "has_outbound_invoice" => "Mit Rechnungen",
                            "inbound_invoice" => "Eingehende Rechnung",
                            "milestone" => "Zeitraum",
                            "mission" => "Mission",
                            "num_attachment" => "Anhang",
                            "num_order" => "Auftrag",
                            "outbound_invoice" => "Ausgehende Rechnung",
                            "signed_at" => "Unterzeichnet am",
                            "title" => "Sogetrel Anhänge",
                            "vendor" => "Dienstanbieter"
                        ]
                    ]
                ]
            ]
        ]
    ],
    "infrastructure" => [
        "electronic_signature" => [
            "application" => [
                "views" => [
                    "mail" => [
                        "finished_procedure" => [
                            "sentence_one"   => "Guten Tag",
                            "sentence_two"   => "AddWorking benachrichtigt ihnen, dass das Dokument erfolgreich unterzeichnet wurde.",
                            "sentence_three" => "Auf das Dokument zugreifen",
                            "sentence_four"  => "Mit freundlichen grüßen,",
                            "sentence_five"  => "Das AddWorking Team",
                        ],
                        "refused_procedure" => [
                            "sentence_one"   => "Guten Tag",
                            "sentence_two"   => "AddWorking benachrichtigt ihnen, dass ein Beteiligte das Dokument zu unterzeichnen verweigert hat.",
                            "sentence_three" => "Auf das Dokument zugreifen",
                            "sentence_four"  => "Mit freundlichen grüßen,",
                            "sentence_five"  => "Das AddWorking Team",
                        ]
                    ]
                ]
            ]
        ]
    ]
];
