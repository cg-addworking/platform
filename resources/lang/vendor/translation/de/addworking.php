<?php
return [
    "billing" => [
        "inbound_invoice" => [
            "_action" => ["download" => "Download", "items" => "Artikel", "reconciliation" => "Versöhnung"],
            "_dropdown" => [
                "consulter" => "konsultieren",
                "download" => "Download",
                "invoice_lines" => "Rechnungsposten",
                "modifier" => "Veränderung",
                "remove" => "entfernen"
            ],
            "_form" => [
                "amount_all_taxes_included" => "Betrag einschließlich aller Steuern (TTC)",
                "amount_excluding_taxes" => "Betrag ohne Steuern (HT)",
                "amount_of_taxes" => "Steuerbetrag (MwSt.)",
                "current_file" => "Aktuelle Datei",
                "date_of_invoice" => "Datum der Rechnungsausstellung",
                "file" => "Datei",
                "invoice_properties" => "Rechnungseigenschaften",
                "is_factoring_alert_line_1" => "",
                "is_factoring_alert_line_2" => "",
                "is_factoring_check" => "",
                "is_factoring_message" => "",
                "note" => "Notiz",
                "number" => "Anzahl",
                "payment_deadline" => "Zahlungsfrist",
                "replace" => "Ersetzen",
                "replace_rib" => ""
            ],
            "_form_support" => [
                "admin" => "Admin",
                "admin_amount" => "(admin) Betrag ohne Steuern (HT)",
                "admin_amount_all_taxes_included" => "(admin) Betrag einschließlich aller Steuern (TTC)",
                "admin_amount_of_taxes" => "(admin) Steuerbetrag (MwSt.)",
                "outbound_invoice" => "Zugehörige Ausgangsrechnung",
                "paid" => "Bezahlt",
                "pending" => "Warten",
                "status" => "Status",
                "to_validate" => "Zu validieren",
                "validated" => "Bestätigt"
            ],
            "_html" => [
                "admin_amount" => "(admin) Rechnungsbeträge",
                "admin_amount_all_taxes_included" => "Betrag einschließlich aller Steuern (TTC)",
                "admin_amount_of_taxes" => "Betrag ohne Steuern (HT)",
                "administrative_compliance" => "Administrative Compliance",
                "amount_all_taxes_included" => "Betrag einschließlich aller Steuern (TTC)",
                "amount_excluding_taxes" => "Betrag ohne Steuern (HT)",
                "amount_of_taxes" => "Steuerbetrag (MwSt.)",
                "associated_customer_invoice" => "Zugehörige Kundenrechnung",
                "client" => "Kunde",
                "creation_date" => "Erstellungsdatum",
                "date_of_invoice" => "Datum der Rechnungsausstellung",
                "file" => "Datei",
                "is_factoring" => "",
                "last_modified_date" => "Datum der letzten Änderung",
                "no" => "",
                "note" => "Notiz",
                "number" => "Anzahl",
                "payment_deadline" => "Zahlungsfrist",
                "period" => "Zeit",
                "service_provider" => "Dienstleister",
                "status" => "Status",
                "updated_by" => "",
                "username" => "Login",
                "yes" => ""
            ],
            "_status" => [
                "paid" => "Bezahlt",
                "pending" => "Warten",
                "unknown" => "Unbekannt",
                "validate" => "Zu validieren",
                "validated" => "Bestätigt"
            ],
            "_table_row_empty" => [
                "add_from_tracking_lines" => "Von Verfolgungslinien hinzufügen",
                "statement_postfix" => "hat keinen Artikel in dieser Lieferantenrechnung.",
                "statement_prefix" => "die Firma"
            ],
            "_warning" => [
                "address" => "ADDWORKING",
                "attention" => "Aufmerksamkeit",
                "invoice_payable_to" => "Denken Sie daran, Ihre Rechnungen zahlbar zu machen an:",
                "line_1" => "17 rue du Lac Saint André",
                "line_2" => "Savoie Technolac - BP 350",
                "line_3" => "73370 Le Bourget du Lac - Frankreich",
                "line_4" => "AddWorking Intra-Community-Umsatzsteuer-Identifikationsnummer: FR 71 810 840 900 00015"
            ],
            "before_create" => [
                "companies" => "Unternehmen",
                "continue" => "Fortsetzen",
                "create" => "schaffen",
                "customer" => "Kunde",
                "dashboard" => "Dashboard",
                "help_text" => "Der Zeitraum entspricht dem Monat, in dem Sie die Dienstleistung erbracht haben. Beispiel: Wenn es November ist und Ihr Service im Oktober ausgeführt wurde, ist der Abrechnungszeitraum Oktober.",
                "my_bills" => "Meine Rechnungen",
                "new_invoice" => "Neue Rechnung",
                "period" => "Zeit"
            ],
            "create" => [
                "companies" => "Unternehmen",
                "create" => "schaffen",
                "dashboard" => "Dashboard",
                "my_bills" => "Meine Rechnungen",
                "new_invoice" => "Neue Rechnung",
                "return" => "Rückkehr"
            ],
            "edit" => [
                "companies" => "Unternehmen",
                "customer" => "Kunde",
                "dashboard" => "Dashboard",
                "edit" => "Veränderung",
                "edit_invoice" => "Ändern Sie die Rechnung",
                "help_text" => "Der Zeitraum entspricht dem Monat, in dem Sie die Dienstleistung erbracht haben. Beispiel: Wenn es November ist und Ihr Service im Oktober ausgeführt wurde, ist der Abrechnungszeitraum Oktober.",
                "month" => "Monat",
                "my_bills" => "Meine Rechnungen",
                "register" => "Rekord",
                "return" => "Rückkehr",
                "service_provider" => "Dienstleister"
            ],
            "export_ready" => [
                "email_sentence" => "An dieser E-Mail finden Sie den angeforderten Export eingehender Rechnungen.",
                "greeting" => "Hallo, ",
                "have_a_good_day" => "Haben Sie einen guten Tag !"
            ],
            "index" => [
                "action" => "Aktion",
                "amount_excluding" => "Menge HT",
                "amount_including_tax" => "Menge TTC",
                "cannot_create_invoice_sentence" => "Um eine Rechnung hinzuzufügen, müssen Sie mindestens einen Kunden haben und Ihre IBAN eingegeben haben.",
                "companies" => "Unternehmen",
                "create_invoice" => "Erstellen Sie eine Rechnung",
                "created_date" => "Erstellungsdatum",
                "customer" => "Kunde",
                "dashboard" => "Dashboard",
                "empty" => "Leer",
                "fill_iban_button" => "Ich fülle meine IBAN aus",
                "my_bills" => "Meine Rechnungen",
                "number" => "Anzahl",
                "service_provider" => "Dienstleister",
                "status" => "Status",
                "tax_amount" => "Steuerbetrag"
            ],
            "new_inbound_uploaded" => [
                "consult_invoice" => "Ich konsultiere die Rechnung",
                "deposited_new_invoice" => "hinterlegte eine neue Rechnung auf seinem Platz.",
                "your_turn_to_play" => "Es liegt an Ihnen, Antoine zu spielen!"
            ],
            "show" => [
                "alert_business_plus" => "",
                "amount_all_taxes_included" => "Gesamtbetrag einschließlich aller Steuern (TTC):",
                "amount_of_taxes" => "Gesamtbetrag der Steuern (MwSt.):",
                "attention" => "Aufmerksamkeit",
                "bills" => "INVOICE",
                "comments" => "Kommentare",
                "companies" => "Unternehmen",
                "compliant_invoice" => "Diese Rechnung ist konform",
                "dashboard" => "Dashboard",
                "file" => "Datei",
                "general_information" => "Allgemeine Informationen",
                "in_processing_by_addworking" => "Bei der Verarbeitung durch AddWorking",
                "information_calculated_from_mission_monitoring_lines" => "Aus den Missionsüberwachungslinien berechnete Informationen:",
                "information_provided_by_service_provider" => "Informationen des Dienstleisters:",
                "my_bills" => "Meine Rechnungen",
                "not_compliant_invoice" => "Diese Rechnung ist nicht konform",
                "processed_by_addworking" => "Verarbeitet von AddWorking",
                "reconciliation" => "Versöhnung",
                "reconciliation_here" => "Versöhne dich hier",
                "reconciliation_success_text" => "Toll : Diese Dienstleister Rechnung wird abgeglichen!",
                "return" => "Rückkehr",
                "total_amount_excluding_taxes" => "Gesamtbetrag ohne Steuern (HT):",
                "validate_invoice" => "Überprüfen Sie die Rechnung",
                "waiting_administrative_verification" => "Diese Rechnung wartet auf die administrative Überprüfung"
            ]
        ],
        "inbound_invoice_item" => [
            "_actions" => [
                "consult" => "Sehen",
                "dissociate" => "Dissoziieren",
                "edit" => "Modifizieren",
                "remove" => "Löschen"
            ],
            "_form" => [
                "amount" => "Menge",
                "general_information" => "Allgemeine Informationen",
                "label" => "Beschreibung",
                "unit_price" => "Stückpreis",
                "vat_rate" => "Mehrwertsteuersatz"
            ],
            "_html" => [
                "amount" => "Menge",
                "amount_all_taxes_included" => "Betrag einschließlich aller Steuern (TTC)",
                "amount_before_taxes" => "Betrag ohne Steuern (HT)",
                "created_date" => "Erstellungsdatum",
                "last_modified_date" => "Datum der letzten Änderung",
                "tax_amount" => "Steuerbetrag (MwSt.)",
                "unit_price" => "Stückpreis",
                "username" => "Login",
                "wording" => "Zeilenbeschreibung"
            ],
            "_table_items" => [
                "amount" => "Menge",
                "label" => "Zeilenbeschreibung",
                "unit_price" => "Stückpreis",
                "vat_rate" => "Mehrwertsteuersatz"
            ],
            "_table_tracking_lines" => [
                "amount" => "Menge",
                "customer_validation" => "Kundenvalidierung",
                "mission_number" => "Missionsnummer",
                "period" => "Zeit",
                "provider_validation" => "Dienstleisterbestätigung",
                "purpose_of_mission_monitoring_line" => "Zweck der Missionsüberwachungslinie",
                "total_ht" => "Gesamt HT",
                "unit_price" => "Stückpreis",
                "vat_rate" => "Mehrwertsteuersatz"
            ],
            "create" => [
                "companies" => "Unternehmen",
                "create" => "schaffen",
                "create_invoice_line" => "Erstellen Sie eine Rechnungsposition",
                "dashboard" => "Dashboard",
                "invoice_lines" => "Rechnungsposten",
                "my_bills" => "Meine Rechnungen",
                "return" => "Rückkehr"
            ],
            "create_from_tracking_lines" => [
                "associate" => "Assoziieren",
                "companies" => "Unternehmen",
                "create" => "schaffen",
                "dashboard" => "Dashboard",
                "invoice_lines" => "Rechnungsposten",
                "mission_followups_affected_by_this_invoice" => "Nachverfolgung von Missionen, die von dieser Rechnung betroffen sind",
                "my_bills" => "Meine Rechnungen",
                "number_of_lines_selected" => "Anzahl der ausgewählten Zeilen:",
                "return" => "Rückkehr",
                "total_amount_excluding_taxes_of_selected_lines" => "Gesamtbetrag ohne Steuern (HT) der ausgewählten Zeilen:"
            ],
            "edit" => [
                "companies" => "Unternehmen",
                "dashboard" => "Dashboard",
                "edit_invoice_line" => "Ändern Sie eine Rechnungsposition",
                "invoice_lines" => "Rechnungsposten",
                "modifier" => "Veränderung",
                "my_bills" => "Meine Rechnungen",
                "register" => "Rekord",
                "return" => "Rückkehr"
            ],
            "index" => [
                "action" => "Lager",
                "add_from_tracking_lines" => "Von Verfolgungslinien hinzufügen",
                "amount" => "Menge",
                "amount_all_taxes_included" => "Gesamtbetrag einschließlich aller Steuern (TTC):",
                "amount_excluding" => "Menge HT",
                "amount_of_taxes" => "Gesamtbetrag der Steuern (MwSt.):",
                "companies" => "Unternehmen",
                "customer_validation" => "Kundenvalidierung",
                "dashboard" => "Dashboard",
                "invoice_lines" => "Rechnungsposten",
                "label" => "Zeilenbeschreibung",
                "lines_of" => "Linien von",
                "mission" => "Mission",
                "my_bills" => "Meine Rechnungen",
                "provider_validation" => "Dienstleisterbestätigung",
                "return" => "Rückkehr",
                "summary" => "Zusammenfassung",
                "total_amount_excluding_taxes" => "Gesamtbetrag ohne Steuern (HT):",
                "unit_price" => "Stückpreis",
                "vat_rate" => "Mehrwertsteuersatz"
            ],
            "show" => [
                "companies" => "Unternehmen",
                "dashboard" => "Dashboard",
                "invoice_lines" => "Rechnungsposten",
                "my_bills" => "Meine Rechnungen",
                "return" => "Rückkehr"
            ]
        ],
        "outbound_invoice" => [
            "_actions" => [
                "actions" => "Lager",
                "add_row" => "Zeile hinzufügen",
                "assign_number" => "Weisen Sie eine Nummer zu",
                "consult" => "konsultieren",
                "create_balance_invoice" => "Erstellen Sie eine Kontostandrechnung",
                "create_payment_order" => "Erstellen Sie einen Zahlungsauftrag",
                "create_remainder" => "Erstellen Sie einen Rest",
                "details_tse_express_medical" => "TSE Express Medizinische Details",
                "export_charles_lineart" => "Exportieren Sie Charles LIENART",
                "export_for_payment" => "Export zur Zahlung",
                "export_tse_express_medical" => "Exportieren Sie TSE Express Medical",
                "generate" => "erzeugen",
                "numbering" => "Nummerierung",
                "payment_orders" => "Zahlungsaufträge",
                "regenrate" => "Regenerat",
                "service_provider_invoices" => "Rechnungen von Dienstleistern"
            ],
            "_form" => [
                "amount_excluding" => "Menge HT",
                "amount_including_tax" => "Menge TTC",
                "file" => "Datei",
                "include_fix_cost" => "Fixkosten einschließen",
                "issue_date" => "Ausstellungsdatum",
                "number_of_providers" => "Anzahl der Dienstleistern",
                "payable_on" => "Zahlbar am",
                "period" => "Zeit",
                "vat_rate" => "Mehrwertsteuerbetrag"
            ],
            "_html" => [
                "amount_excluding" => "Menge HT",
                "amount_including_tax" => "Menge TTC",
                "created_on" => "Erstellt am",
                "date_of_invoice" => "Rechnungsdatum",
                "download_invoice" => "Laden Sie die Rechnung herunter",
                "enterprise" => "Unternehmen",
                "number" => "Anzahl",
                "payable_on" => "Zahlbar am",
                "payable_to" => "Zahlbar an",
                "status" => "Status",
                "updated_on" => "Update am",
                "username" => "Login",
                "vat_rate" => "Mehrwertsteuerbetrag"
            ],
            "_missions_inbound_invoices" => [
                "amount" => "Betrag",
                "empty" => "Leer",
                "number" => "Anzahl",
                "period" => "Zeit",
                "status" => "Status"
            ],
            "_missions_missions" => [
                "amount_per_day" => "Menge pro Tag",
                "number_of_days" => "Anzahl der Tage",
                "total" => "Gesamt",
                "tour_id" => "Tour ID"
            ],
            "_number" => ["attribute" => "Attribut"],
            "_search" => [
                "enterprise" => "Unternehmen",
                "number" => "Anzahl",
                "reinitialize_search" => "Initialisieren Sie die Suche",
                "search" => "Suche",
                "username" => "Login"
            ],
            "_table" => [
                "amount_excluding" => "Menge HT",
                "amount_including_tax" => "Menge TTC",
                "attribute" => "Attribut",
                "deadline" => "Frist",
                "enterprise" => "Unternehmen",
                "issued_on" => "Ausgegeben am",
                "number" => "Anzahl",
                "payable_on" => "Zahlbar am",
                "period" => "Zeit",
                "status" => "Status",
                "uuid" => "UUID"
            ],
            "_vendors" => ["enterprise" => "Unternehmen", "status" => "Status", "uuid" => "UUID"],
            "create" => [
                "create" => "schaffen",
                "create_invoice" => "Erstellen Sie eine Rechnung",
                "create_new_invoice" => "Erstellen Sie die Rechnung",
                "dashboard" => "Dashboard",
                "invoices" => "Rechnungen",
                "return_to_list_of_invoices" => "Zurück zur Rechnungsliste"
            ],
            "details" => [
                "invoice_details" => "Rechnungs-Details:",
                "label" => "Etikett",
                "properties" => "Eigenschaften",
                "quantity" => "Menge",
                "service_provider_invoices" => "Dienstleisterrechnung (en)",
                "unit_price" => "Stückpreis",
                "vat_rate" => "Mehrwertsteuer"
            ],
            "document" => [
                "_annex" => [
                    "agency_code" => "Agenturcode",
                    "amount" => "Menge",
                    "analytical_code" => "Analytischer Code",
                    "annex" => "Annektieren:",
                    "detail_subcontractors" => "Angaben zu Subunternehmern",
                    "management_fees_ht" => "Verwaltungsgebühren HT",
                    "subcontractor_code" => "Subunternehmercode",
                    "subcontractor_name" => "Name des Subunternehmers",
                    "total_ht" => "Gesamt HT",
                    "tour_code" => "Tour Code",
                    "unit_price_ht" => "Stückpreis HT"
                ],
                "_details" => [
                    "amount_excluding" => "Menge HT",
                    "period_per_number_of_contract" => "Zeitraum / Vertragsnummer",
                    "subcontractor_code" => "Subunternehmercode",
                    "subcontractor_name" => "Name des Subunternehmers"
                ],
                "_enterprises" => [
                    "addworking_sas" => "SAS HINZUFÜGEN",
                    "at" => "Beim:",
                    "cps_contract_number" => "CPS1 Vertragsnummer",
                    "date" => "Datiert:",
                    "invoice_number" => "Rechnung Nr",
                    "line_1" => "17 RUE LAC SAINT ANDRE",
                    "line_2" => "73370 LE BOURGET DU LAC",
                    "line_3" => "Frankreich",
                    "line_4" => "Frankreich",
                    "of" => "Von:",
                    "represented_by" => "Vertreten durch",
                    "represented_by_julien" => "Vertreten durch Julien PERONA",
                    "vat_number" => " FR 718 1084 0900 00015",
                    "vat_number_label" => "MwSt.-Nr.:"
                ],
                "_summary" => [
                    "benifits_ht" => "HT-Dienste",
                    "iban_for_transfer" => "IBAN zur Übertragung:",
                    "iban_number" => "FR76 3000 3005 7100 0201 2497 429",
                    "management_fees_ht" => "Verwaltungsgebühren HT",
                    "payment_deadline" => "Zahlungsfrist:",
                    "reference_tobe_reminded_on_transfer" => "Hinweis zur Überweisung:",
                    "total_ht" => "Gesamt HT",
                    "total_ttc" => "Gesamtpreis",
                    "total_vat" => "GESAMT MwSt"
                ],
                "invoice_number" => "Rechnung Nr"
            ],
            "edit" => [
                "dashboard" => "Dashboard",
                "edit" => "Veränderung",
                "invoices_issued" => "Rechnungen ausgestellt",
                "register" => "Rekord",
                "return" => "Rückkehr"
            ],
            "inbound_invoice_list" => [
                "action" => "Aktion",
                "amount_excluding" => "Menge HT",
                "amount_including_tax" => "Menge TTC",
                "dashboard" => "Dashboard",
                "export" => "Export",
                "invoices" => "Rechnungen",
                "no_result" => "Keine Ergebnisse",
                "number" => "Anzahl",
                "processing" => "wird bearbeitet",
                "provider_invoices_included" => "Dienstleistern Rechnungen enthalten",
                "reconcile" => "Versöhnen",
                "reconciliation_ok" => "Abstimmung OK",
                "return" => "Rückkehr",
                "service_provider" => "Dienstleister",
                "service_provider_invoices" => "Dienstleistern Rechnungen",
                "state" => "Zustand",
                "status" => "Status"
            ],
            "index" => [
                "action" => "Aktion",
                "add_invoice" => "Fügen Sie eine Rechnung hinzu",
                "amount_ht_by_ttc" => "Menge HT / TTC",
                "created_at" => "Erstellt am",
                "dashboard" => "Dashboard",
                "deadline" => "Frist",
                "enterprise" => "Unternehmen",
                "export" => "Export",
                "invoices_issued" => "Rechnungen ausgestellt",
                "issued_on" => "Ausgegeben am",
                "my_bills" => "Meine Rechnungen",
                "number" => "Anzahl",
                "payable_on" => "Zahlbar am",
                "period" => "Zeit",
                "status" => "Status"
            ],
            "missions" => [
                "add_comment" => "Kommentar hinzufügen",
                "add_row" => "Zeile hinzufügen",
                "amount_per_day" => "Menge pro Tag",
                "are_you_sure_delete" => "Möchten Sie diese Zeile wirklich löschen?",
                "are_you_sure_delete_comment" => "Möchten Sie den Kommentar wirklich löschen?",
                "attention_text" => "Bitte beachten Sie: Die Beträge Ihrer Rechnung und die Ihres Dienstleisters stimmen nicht überein. Möchten Sie diese Rechnung trotzdem validieren?",
                "comments_for_info" => "Kommentare (zur Information und nicht auf der Rechnung sichtbar)",
                "entitled" => "Überschrift",
                "final_invoice_tobe_validated" => "Die endgültige Rechnung muss validiert werden",
                "final_invoice_validated" => "Endgültige Rechnung validiert",
                "import_data_from_your_system" => "Importieren Sie Daten aus Ihrem System",
                "import_invoice_from_your_service_provider" => "Importieren Sie Rechnungen von Ihrem Dienstleister",
                "invoice_for_period" => "Rechnung für den Zeitraum:",
                "no_longer_validate_for_invoicing" => "Nicht mehr für die Rechnungsstellung validieren",
                "number_of_days" => "Anzahl der Tage",
                "payable" => "Zahlbar:",
                "providers_list" => "Liste der Dienstleistern",
                "removal" => "Unterdrückung",
                "save_put_on_hold" => "Speichern und in die Warteschleife stellen",
                "service_provider" => "Dienstleister:",
                "total" => "Gesamt",
                "validate_for_invoicing" => "Für die Abrechnung validieren"
            ],
            "show" => [
                "comments" => "Kommentare",
                "dashboard" => "Dashboard",
                "details" => "Details",
                "file" => "Datei",
                "general_information" => "Allgemeine Informationen",
                "invoices" => "Rechnungen",
                "remainder_of" => "Rest von",
                "return" => "Rückkehr",
                "service_provider_invoices" => "Dienstleistern Rechnungen"
            ],
            "validate" => [
                "assign_number" => "Weisen Sie eine Nummer zu",
                "invoice_for_period" => "Rechnung für den Zeitraum:",
                "invoice_has_no_number" => "Diese Rechnung hat keine Nummer",
                "payable" => "Zahlbar:",
                "reconciliation" => "Versöhnung",
                "return_to_invoices" => "Zurück zur Rechnung",
                "total_tobe_invoiced" => "Insgesamt zur Rechnung"
            ]
        ],
        "outbound_invoice_comment" => [
            "_form" => [
                "comment" => "Kommentar:",
                "not_stated_on_invoice" => "(nicht auf der Rechnung angegeben)"
            ]
        ],
        "outbound_invoice_item" => [
            "_actions" => ["remove" => "entfernen"],
            "_form" => [
                "label" => "Wortlaut",
                "label_placeholder" => "Wortlaut",
                "quantity" => "Menge",
                "service_provider" => "Dienstleister",
                "unit_price" => "Stückpreis"
            ],
            "edit" => ["add_title" => "Hinzufügen", "edit_title" => "Veränderung", "save" => "Speichern"]
        ],
        "outbound_invoice_number" => [
            "_html" => [
                "created_at" => "Erstellt am",
                "priority" => "Priorität",
                "updated_at" => "Aktualisiert die"
            ],
            "index" => [
                "associate" => "Assoziieren",
                "bill" => "INVOICE",
                "enterprise" => "Unternehmen",
                "numbering_of_invoices" => "Nummerierung der Rechnungen",
                "reserve_new_number" => "Reservieren Sie eine neue Nummer"
            ]
        ],
        "outbound_invoice_payment_order" => [
            "_form" => [
                "no_result" => "Keine Ergebnisse",
                "service_provider_does_not_have_iban" => "Dieser Dienstleister kann nicht in den Zahlungsauftrag aufgenommen werden. Für diesen Dienstleister ist keine IBAN eingegeben.",
                "service_provider_not_included_in_payment_order" => "Es ist unmöglich, diesen Dienstleister in den Zahlungsauftrag aufzunehmen : eine seiner Rechnungen enthält keinen \"Administrator\" Betrag (vom AddWorking-Support bereitgestellt)."
            ],
            "_html" => [
                "bill" => "INVOICE",
                "change_status" => "Status ändern",
                "created_at" => "Erstellt am",
                "status" => "Status",
                "updated_at" => "Aktualisiert die"
            ],
            "index" => ["button_add" => "Hinzufügen", "title_index" => "Zahlungsaufträge"],
            "show" => ["properties" => "Eigenschaften"]
        ]
    ],
    "common" => [
        "address" => [
            "_form" => ["appartment_floor" => "Wohnung, Etage ...", "city_place" => "Stadt oder Ort sagt"],
            "edit" => ["edit_title" => "Adressen", "save" => "Schutz"],
            "index" => ["title" => "Adressen"],
            "view" => ["address" => "Adresse", "general_information" => "Allgemeine Informationen"]
        ],
        "comment" => [
            "_create" => [
                "add_comment" => "Kommentar hinzufügen",
                "comment" => "Kommentar",
                "help_text" => "Zielgruppe: für alle sichtbar. Geschützt: sichtbar für Mitglieder meiner Firma. Privat: nur für mich sichtbar.",
                "visibility" => "Sichtweite"
            ],
            "_html" => ["added_by" => "Hinzugefügt von", "remove" => "entfernen"]
        ],
        "csv_loader_report" => [
            "_actions" => ["download_csv_of_errors" => "Laden Sie die CSV der Fehler herunter"],
            "_html" => [
                "created_date" => "Erstellungsdatum",
                "errors" => "Fehler",
                "label" => "Etikett",
                "last_modified_date" => "Datum der letzten Änderung",
                "number_of_lines" => "Anzahl der Zeilen",
                "username" => "Login"
            ],
            "index" => [
                "actions" => "Lager",
                "add" => "Hinzufügen",
                "csv_load_reports" => "CSV-Upload-Berichte",
                "dashboard" => "Dashboard",
                "date" => "Datum",
                "errors" => "Fehler",
                "label" => "Wortlaut",
                "number_of_lines" => "Anzahl der Zeilen"
            ],
            "show" => [
                "csv_load_reports" => "CSV-Upload-Berichte",
                "dashboard" => "Dashboard",
                "general_information" => "Allgemeine Informationen",
                "preview" => "Vorschau",
                "return" => "Rückkehr"
            ]
        ],
        "file" => [
            "_actions" => ["download" => "Download"],
            "_form" => [
                "file" => "Datei",
                "general_information" => "Allgemeine Informationen",
                "mime_type" => "Mime Typ",
                "path" => "Pfad"
            ],
            "_html" => [
                "created_at" => "Erstellt am",
                "cut" => "Größe",
                "extension" => "Erweiterung",
                "mime_type" => "MIME-Typ (Mehrzweck-Internet-Mail-Erweiterungen)",
                "owner" => "Eigentümer",
                "path" => "Pfad",
                "url" => "URLs",
                "username" => "Login"
            ],
            "_summary" => ["file" => "Datei:"],
            "create" => [
                "create" => "schaffen",
                "create_file" => "Erstellen Sie eine Datei",
                "dashboard" => "Dashboard",
                "files" => "Dateien",
                "register" => "Rekord",
                "return" => "Rückkehr"
            ],
            "edit" => [
                "dashboard" => "Dashboard",
                "edit" => "Veränderung",
                "edit_file" => "Datei bearbeiten",
                "files" => "Dateien",
                "register" => "Rekord",
                "return" => "Rückkehr"
            ],
            "index" => [
                "actions" => "Lager",
                "add_file" => "Fügen Sie eine Datei hinzu",
                "associated_to" => "Verbunden sein mit",
                "creation" => "Schaffung",
                "cut" => "Größe",
                "dashboard" => "Dashboard",
                "files" => "Dateien",
                "owner" => "Eigentümer",
                "path" => "Pfad",
                "type" => "Typ"
            ],
            "show" => [
                "content" => "Inhalt",
                "dashboard" => "Dashboard",
                "files" => "Dateien",
                "general_information" => "Allgemeine Informationen"
            ]
        ],
        "folder" => [
            "1" => "Zum Ordner hinzufügen",
            "" => "Zum Ordner hinzufügen",
            "_form" => [
                "folder_name" => "Ordnernamen",
                "general_information" => "Allgemeine Informationen",
                "owner" => "Eigentümer",
                "visible_to_providers" => "Datei für Dienstleistern sichtbar?"
            ],
            "_html" => [
                "actions" => "Lager",
                "created_at" => "Erstellt am",
                "created_date" => "Erstellungsdatum",
                "description" => "Beschreibung",
                "folder_shared_with_service_providers" => "Geteilte Datei für Dienstleistern ",
                "label" => "Etikett",
                "last_modified_date" => "Datum der letzten Änderung",
                "owner" => "Eigentümer",
                "username" => "Login"
            ],
            "_items" => [
                "actions" => "Lager",
                "created_at" => "Erstellt am",
                "description" => "beschreibend",
                "title" => "Titel"
            ],
            "attach" => [
                "add_to_folder" => "Zum Ordner hinzufügen",
                "attach" => "befestigen",
                "dashboard" => "Dashboard",
                "enterprises" => "Unternehmen",
                "file" => "Rekord",
                "files" => "Dateien",
                "link_to_file" => "Link zur Datei",
                "object_to_add_to_file" => "Objekt, das der Datei hinzugefügt werden soll",
                "register" => "Rekord",
                "return" => "Rückkehr"
            ],
            "create" => [
                "create" => "schaffen",
                "create_folder" => "Erstellen Sie einen Ordner",
                "dashboard" => "Dashboard",
                "enterprises" => "Unternehmen",
                "files" => "Dateien",
                "register" => "Rekord",
                "return" => "Rückkehr"
            ],
            "edit" => [
                "dashboard" => "Dashboard",
                "edit" => "Veränderung",
                "enterprises" => "Unternehmen",
                "files" => "Dateien",
                "register" => "Rekord",
                "return" => "Rückkehr"
            ],
            "index" => [
                "actions" => "Lager",
                "add" => "Hinzufügen",
                "created_at" => "Erstellt am",
                "createed_at" => "Erstellt am",
                "dashboard" => "Dashboard",
                "enterprises" => "Unternehmen",
                "file" => "Rekord",
                "files" => "Dateien",
                "my_clients_files" => "Die Dateien meiner Kunden",
                "my_folders" => "Meine Ordner",
                "owner" => "Eigentümer"
            ],
            "show" => [
                "content" => "Inhalt",
                "dashboard" => "Dashboard",
                "enterprises" => "Unternehmen",
                "files" => "Dateien",
                "general_information" => "Allgemeine Informationen",
                "return" => "Rückkehr"
            ]
        ],
        "job" => [
            "_actions" => ["skills" => "Fähigkeiten"],
            "_form" => [
                "description" => "Beschreibung",
                "general_information" => "Allgemeine Informationen",
                "job" => "Job",
                "parent" => "Relativ"
            ],
            "_html" => [
                "description" => "Beschreibung",
                "last_name" => "Name",
                "owner" => "Eigentümer",
                "parent" => "Relativ",
                "skills" => "Fähigkeiten"
            ],
            "create" => [
                "create_new_skill" => "Schaffen Sie einen neuen Beruf",
                "create_skill" => "Erstellen Sie einen Beruf",
                "dashboard" => "Dashboard",
                "enterprises" => "Unternehmen",
                "job" => "Trades",
                "register" => "Rekord",
                "return" => "Rückkehr",
                "save_create_again" => "Speichern und erneut erstellen"
            ],
            "edit" => [
                "dashboard" => "Dashboard",
                "edit" => "Veränderung",
                "edit_job" => "Ändern Sie den Beruf",
                "enterprises" => "Unternehmen",
                "job" => "Trades",
                "register" => "Rekord",
                "return" => "Rückkehr"
            ],
            "index" => [
                "actions" => "Lager",
                "add" => "Hinzufügen",
                "created_at" => "Erstellt am",
                "dashboard" => "Dashboard",
                "enterprises" => "Unternehmen",
                "job" => "Trades",
                "job_catalog" => "Handelskatalog",
                "last_name" => "Name",
                "skills" => "Fähigkeiten"
            ],
            "show" => [
                "dashboard" => "Dashboard",
                "enterprises" => "Unternehmen",
                "job" => "Trades",
                "return" => "Rückkehr"
            ]
        ],
        "passwork" => [
            "_html" => ["client" => "Kunde", "owner" => "Eigentümer", "skills" => "Fähigkeiten"],
            "create" => [
                "client" => "Kunde",
                "continue" => "Fortsetzen",
                "create_new_passwork" => "Erstellen Sie ein neues Passwork",
                "create_passwork" => "Erstellen Sie ein Passwork",
                "dashboard" => "Dashboard",
                "enterprises" => "Unternehmen",
                "general_information" => "Allgemeine Informationen",
                "passwork" => "Passworks",
                "return" => "Rückkehr"
            ],
            "edit" => [
                "advance" => "Fortgeschritten",
                "beginner" => "Anfänger",
                "dashboard" => "Dashboard",
                "edit" => "Veränderung",
                "edit_passwork" => "Passwork bearbeiten",
                "enterprises" => "Unternehmen",
                "intermediate" => "Mittlere",
                "job" => "Job",
                "level" => "Niveau",
                "passwork" => "Passworks",
                "register" => "Rekord",
                "return" => "Rückkehr",
                "skill" => "Fertigkeit"
            ],
            "index" => [
                "actions" => "Lager",
                "add" => "Hinzufügen",
                "client" => "Kunde",
                "created_at" => "Erstellt am",
                "dashboard" => "Dashboard",
                "enterprises" => "Unternehmen",
                "owner" => "Eigentümer",
                "passworks" => "Passworks",
                "passworks_catalogs" => "Passworks-Katalog",
                "skills" => "Fähigkeiten",
                "username" => "Login"
            ],
            "show" => [
                "dashboard" => "Dashboard",
                "enterprises" => "Unternehmen",
                "passwork" => "Passarbeit",
                "passworks" => "Passworks",
                "return" => "Rückkehr"
            ]
        ],
        "phone_number" => [
            "_form" => [
                "note" => "Notiz",
                "note_placeholder" => "Notiz",
                "number" => "Telefonnummer",
                "number_placeholder" => "Tel. Nr."
            ]
        ],
        "skill" => [
            "_form" => [
                "description" => "Beschreibung",
                "general_information" => "Allgemeine Informationen",
                "skill" => "Fertigkeit"
            ],
            "_html" => [
                "description" => "Beschreibung",
                "enterprise" => "Unternehmen",
                "job" => "Job",
                "skill" => "Fertigkeit"
            ],
            "create" => [
                "create" => "schaffen",
                "create_new_skill" => "Erstelle eine neue Fähigkeit",
                "create_skill" => "Erstelle eine Fertigkeit",
                "dashboard" => "Dashboard",
                "enterprises" => "Unternehmen",
                "job" => "Trades",
                "return" => "Rückkehr",
                "skills" => "Fähigkeiten"
            ],
            "edit" => [
                "dashboard" => "Dashboard",
                "edit" => "Veränderung",
                "edit_skill" => "Fertigkeit bearbeiten",
                "enterprises" => "Unternehmen",
                "job" => "Trades",
                "register" => "Rekord",
                "return" => "Rückkehr",
                "skills" => "Fähigkeiten"
            ],
            "index" => [
                "actions" => "Lager",
                "add" => "Hinzufügen",
                "created_at" => "Erstellt am",
                "dashboard" => "Dashboard",
                "enterprises" => "Unternehmen",
                "job" => "Trades",
                "job_skills" => "Handelsfähigkeiten",
                "skills" => "Fähigkeiten"
            ],
            "show" => [
                "dashboard" => "Dashboard",
                "enterprises" => "Unternehmen",
                "job" => "Trades",
                "return" => "Rückkehr",
                "skills" => "Fähigkeiten"
            ]
        ]
    ],
    "components" => [
        "billing" => [
            "inbound" => [
                "index" => [
                    "breadcrumb" => ["dashboard" => "", "inbound" => ""],
                    "button" => ["return" => ""],
                    "card" => [
                        "amount_all_taxes_included" => "",
                        "amount_before_taxes" => "",
                        "amount_of_taxes" => "",
                        "number_total_of_invoices" => ""
                    ],
                    "filters" => [
                        "associated" => "",
                        "customer" => "",
                        "filter" => "",
                        "month" => "",
                        "paid" => "",
                        "pending" => "",
                        "pending_association" => "",
                        "reset" => "",
                        "status" => "",
                        "to_validate" => "",
                        "validated" => ""
                    ],
                    "table_head" => [
                        "actions" => "",
                        "amount_all_taxes_included" => "",
                        "amount_before_taxes" => "",
                        "amount_of_taxes" => "",
                        "customer" => "",
                        "due_at" => "",
                        "month" => "",
                        "status" => "",
                        "vendor" => ""
                    ],
                    "title" => ""
                ]
            ],
            "outbound" => [
                "payment_order" => [
                    "_actions" => [
                        "associated_invoices" => "Enthalten Rechnungen ",
                        "confirm_delete" => "Bestätigen Sie die Löschung des Zahlungsauftrags?",
                        "delete" => "Löschen"
                    ],
                    "associate" => [
                        "actions" => "Aktionen",
                        "amount_all_taxes_included" => "Betrag inklusive Steuern",
                        "amount_without_taxes" => "Betrag exklusive Steuern",
                        "associate" => "Assoziieren",
                        "billing_period" => "Abrechnungszeitraum",
                        "customer" => "Die Firma",
                        "deadline" => "Fälligkeitsdatum",
                        "invoice_number" => "Rechnung",
                        "is_factoring" => "",
                        "outbound_invoice_number" => "Kundenrechnungsnummer",
                        "return" => "Rückkehr",
                        "select" => "Verknüpfen Sie diese Rechnungen der Dienstleistern mit dem Zahlungsauftrag",
                        "status" => "Status",
                        "table_row_empty" => "hat keine Rechnungen des Dienstleisters, die dem Zahlungsauftrag zugeordnet werden können.",
                        "title" => "Zuordnende Dienstleisterrechnungen",
                        "vendor" => "Dienstleister"
                    ],
                    "dissociate" => [
                        "actions" => "Lager",
                        "amount_all_taxes_included" => "Menge TTC",
                        "amount_without_taxes" => "Menge HT",
                        "billing_period" => "Abrechnungszeitraum",
                        "customer" => "die Firma",
                        "deadline" => "Zahlungsfrist",
                        "dissociate" => "Gruppierung aufheben",
                        "invoice_number" => "Rechnungsnummer",
                        "left_to_pay" => "noch zu zahlen",
                        "return" => "Rückkehr",
                        "select" => "Lösen Sie die Verknüpfung dieser Dienstleisterrechnungen mit dem Zahlungsauftrag",
                        "status" => "Status",
                        "table_row_empty" => "Der Zahlungsauftrag enthält keine Rechnungen des Dienstleisters.",
                        "title" => "Dienstleistern Rechnungen enthalten",
                        "vendor" => "Dienstleister"
                    ],
                    "html" => [
                        "bank_reference" => "Bankreferenz",
                        "count_items" => "Anzahl der Überweisungen enthalten",
                        "created_at" => "Erstellungsdatum",
                        "customer" => "Name des Kunden",
                        "debtor_info" => "Schuldnerinformationen",
                        "deleted_at" => "Lösche es",
                        "download" => "Download",
                        "executed_at" => "Ausführungsdatum",
                        "file" => "XML-Datei",
                        "number" => "Zahlungsauftragsnummer",
                        "outbound_invoice" => "AddWorking Rechnungsnummer",
                        "reference" => "Referenz",
                        "status" => "Status",
                        "total_amount" => "Gesamtbetrag",
                        "updated_at" => "Datum der letzten Änderung"
                    ],
                    "index" => [
                        "button_create" => "Erstellen Sie einen Zahlungsauftrag",
                        "button_return" => "Rückkehr",
                        "table_row_empty" => "Diese Addworking-Rechnung enthält keinen Zahlungsauftrag.",
                        "title" => "Zahlungsaufträge"
                    ],
                    "show" => [
                        "button_return" => "Rückkehr",
                        "execute" => "Ausführen",
                        "generate" => "erzeugen",
                        "title" => "Zahlungsauftrag Nr."
                    ],
                    "table_head" => [
                        "actions" => "Lager",
                        "created_at" => "Erstellt am",
                        "executed_at" => "Ausgeführt auf",
                        "number" => "Anzahl",
                        "status" => "Status"
                    ]
                ],
                "received_payment" => [
                    "_actions" => ["edit" => "Veränderung"],
                    "buttons" => [
                        "actions" => "Lager",
                        "create" => "schaffen",
                        "edit" => "Veränderung",
                        "return" => "Rückkehr"
                    ],
                    "create" => ["title" => "Bestätigen Sie den Zahlungseingang für das Unternehmen"],
                    "edit" => ["title" => "Ändern Sie die Zahlung erhalten Nr."],
                    "index" => [
                        "table_row_empty" => "Auf dieser Rechnung sind keine Zahlungen eingegangen.",
                        "title" => "Zahlungen für das Geschäft erhalten"
                    ],
                    "received_payments" => "eingegangene Zahlungen",
                    "table_head" => [
                        "amount" => "Betrag",
                        "bank_reference" => "Bankreferenz",
                        "bic" => "BIC",
                        "iban" => "IBAN",
                        "invoices" => "Rechnungen",
                        "number" => "Anzahl",
                        "received_at" => "Datum des Eingangs"
                    ]
                ]
            ]
        ],
        "enterprise" => [
            "activity_report" => [
                "application" => [
                    "views" => [
                        "activity_report" => [
                            "_breadcrumb" => ["activity_report" => "Aktivitätsüberwachung"],
                            "_form" => ["missions" => "Liste der Missionen nach Kunden"],
                            "create" => [
                                "create" => "Rekord",
                                "return" => "Rückkehr",
                                "title" => "Aktivität - von: start_date bis: end_date"
                            ]
                        ],
                        "emails" => [
                            "request" => [
                                "addworking_team" => "Das AddWorking-Team",
                                "cordially" => "herzlich",
                                "hello" => "Hallo",
                                "submit_activity_report" => "Ich klicke hier",
                                "text_line1" => "Sie haben einen oder mehrere aktuelle Verträge mit Ihrem SOGETREL-Kunden.",
                                "text_line2" => "Nehmen Sie sich bitte 1 Minute Zeit, um uns mitzuteilen, an welchen Websites Sie gerade arbeiten.",
                                "text_line3" => "Sie können auch die folgende URL kopieren und in die Adressleiste Ihres Browsers einfügen"
                            ]
                        ]
                    ]
                ]
            ],
            "enterprise" => [
                "email" => [
                    "export" => [
                        "have_a_good_day" => "Haben Sie einen guten Tag !",
                        "hello" => "Hallo, ",
                        "join_sentence" => ""
                    ]
                ]
            ],
            "export" => [
                "email" => [
                    "export" => [
                        "have_a_good_day" => "Haben Sie einen guten Tag !",
                        "hello" => "Hallo, ",
                        "join_sentence" => "Hiermit die gewünschten Exporte: Unternehmen und ihre Aktivitäten, Benutzer nach Unternehmen, Beziehungen zwischen Unternehmen und Rechnungsstellung."
                    ]
                ]
            ]
        ]
    ],
    "contract" => [
        "contract" => [
            "_actions" => [
                "annexes" => "Zubehör",
                "create_addendum" => "Erstellen Sie einen Nachtrag",
                "download" => "Download",
                "model" => "Modell",
                "stakeholders" => "Interessengruppen",
                "variables" => "Variablen"
            ],
            "_breadcrumb" => [
                "addendums" => "Vermerke",
                "contracts" => "Verträge",
                "create" => "schaffen",
                "edit" => "Veränderung"
            ],
            "_form" => [
                "contract_due_date" => "Fälligkeitsdatum",
                "contract_properties" => "Vertragseigenschaften",
                "contract_start_date" => "Vertragsbeginn",
                "external_identifier" => "Externe Kennung",
                "last_name" => "Name"
            ],
            "_html" => [
                "consult" => "konsultieren",
                "created_at" => "Erstellt am",
                "effective_date" => "Datum des Inkrafttretens",
                "external_identifier" => "Externe Kennung",
                "file" => "Datei",
                "model" => "Modell",
                "number" => "Anzahl",
                "owner" => "Eigentümer",
                "sign_in_hub" => "SigningHub",
                "status" => "Status",
                "term" => "Begriff",
                "username" => "Login"
            ],
            "_summary" => [
                "contract_created" => "Der Vertrag wird erstellt",
                "contract_is" => "Der Vertrag ist",
                "contract_with_atleast_2_stakeholders" => "Der Vertrag hat mindestens 2 Stakeholder",
                "required_documents_valid" => "Die erforderlichen Unterlagen sind gültig",
                "signatories_assigned" => "Unterzeichner werden zugewiesen",
                "signatories_signed" => "Die Unterzeichner unterschrieben"
            ],
            "_table_head" => [
                "actions" => "Lager",
                "clients" => "",
                "deadline" => "Frist",
                "last_name" => "Name",
                "model" => "Modell",
                "parties" => "Interessengruppen",
                "providers" => "",
                "status" => "Status"
            ],
            "_table_row_empty" => [
                "create_addendum" => "Erstellen Sie einen Nachtrag",
                "create_contract" => "Erstellen Sie einen Vertrag",
                "for_those_filters" => "für ausgewählte Filter",
                "has_no_addendum" => " hat keine Billigung",
                "has_no_contract" => " hat keinen Vertrag",
                "the_company" => "die Firma",
                "the_contract" => "Der Vertrag"
            ],
            "create" => [
                "create_blank_contract" => "Erstellen Sie einen leeren Vertrag",
                "create_contract" => "Erstellen Sie einen Vertrag",
                "create_from_existing_file" => "Aus einer vorhandenen Datei erstellen",
                "create_from_mockup" => "Aus einem Modell erstellen",
                "return" => "Rückkehr"
            ],
            "create_blank" => [
                "create" => "schaffen",
                "create_contract" => "Erstellen Sie einen Vertrag",
                "return" => "Rückkehr"
            ],
            "create_from_file" => [
                "contract" => "Vertrag",
                "create" => "schaffen",
                "create_contract" => "Erstellen Sie einen Vertrag",
                "return" => "Rückkehr"
            ],
            "create_from_template" => [
                "create" => "schaffen",
                "create_contract" => "Erstellen Sie einen Vertrag",
                "return" => "Rückkehr"
            ],
            "edit" => [
                "contract" => "Vertrag",
                "edit" => "Veränderung",
                "register" => "Rekord",
                "return" => "Rückkehr",
                "status" => "Status"
            ],
            "index" => [
                "add" => "Hinzufügen",
                "contract" => "Contrathèque",
                "filter" => "Filter",
                "reset_filter" => "rücksetzen"
            ],
            "show" => ["return" => "Rückkehr"]
        ],
        "contract_annex" => [
            "_breadcrumb" => ["annexes" => "Zubehör", "create" => "schaffen", "edit" => "Veränderung"],
            "_form" => ["general_information" => "Allgemeine Informationen"],
            "_html" => [
                "created_date" => "Erstellungsdatum",
                "label" => "Etikett",
                "last_modified_date" => "Datum der letzten Änderung",
                "username" => "Login"
            ],
            "_table_head" => ["action" => "Aktion", "file" => "Datei"],
            "_table_row_empty" => [
                "add_document" => "Fügen Sie ein Dokument hinzu",
                "does_not_have_annex" => "hat keinen Anhang",
                "the_contract" => "Der Vertrag"
            ],
            "create" => [
                "add_annex" => "Fügen Sie einen Anhang hinzu",
                "create" => "schaffen",
                "return" => "Rückkehr"
            ],
            "edit" => ["edit" => "Veränderung", "register" => "Rekord", "return" => "Rückkehr"],
            "index" => ["add" => "Hinzufügen", "annexes" => "Zubehör"],
            "show" => ["return" => "Rückkehr"]
        ],
        "contract_document" => [
            "_breadcrumb" => ["create" => "schaffen", "documents" => "Unterlagen", "edit" => "Veränderung"],
            "_form" => ["general_information" => "Allgemeine Informationen"],
            "_html" => [
                "created_date" => "Erstellungsdatum",
                "label" => "Etikett",
                "last_modified_date" => "Datum der letzten Änderung",
                "username" => "Login"
            ],
            "_table_head" => [
                "action" => "Aktion",
                "document" => "Dokument",
                "provider" => "Dienstleister",
                "status" => "Status"
            ],
            "_table_row_empty" => [
                "add_document" => "Fügen Sie ein Dokument hinzu",
                "has_no_document" => "hat kein Dokument",
                "the_contract" => "Der Vertrag"
            ],
            "create" => [
                "add_document" => "Fügen Sie ein Dokument hinzu",
                "create" => "schaffen",
                "return" => "Rückkehr"
            ],
            "edit" => ["edit" => "Veränderung", "register" => "Rekord", "return" => "Rückkehr"],
            "index" => ["add" => "Hinzufügen", "documents" => "Unterlagen"],
            "show" => ["return" => "Rückkehr"]
        ],
        "contract_party" => [
            "_actions" => [
                "dissociate_signer" => "Trennen Sie den Unterzeichner",
                "required_document" => "Dokument erforderlich",
                "signatory" => "Unterzeichner"
            ],
            "_assign_signatory" => ["signatory" => "Unterzeichner"],
            "_breadcrumb" => [
                "create" => "schaffen",
                "edit" => "Veränderung",
                "stakeholders" => "Interessengruppen"
            ],
            "_form" => [
                "declined" => "Abgelehnt",
                "declined_on" => "Abgelehnt am",
                "denomination" => "Konfession",
                "general_information" => "Allgemeine Informationen",
                "has_signed" => "Hat unterschrieben",
                "signatory" => "Unterzeichner",
                "signed_on" => "Angemeldet"
            ],
            "_html" => [
                "created_date" => "Erstellungsdatum",
                "label" => "Etikett",
                "last_modified_date" => "Datum der letzten Änderung",
                "username" => "Login"
            ],
            "_signatory" => ["for" => "für"],
            "_status" => [
                "assign_signer" => "Weisen Sie einen Unterzeichner zu",
                "at" => "die",
                "decline" => "Rückgang",
                "must_assign_signer" => "Muss einen Unterzeichner zuweisen",
                "must_sign" => "Muss unterschreiben",
                "sign" => "Unterzeichnet",
                "status_unknown" => "Unbekannter Status",
                "waiting" => "Warten"
            ],
            "_table_head" => [
                "actions" => "Lager",
                "denomination" => "Konfession",
                "documents_provided" => "Dokument zur Verfügung gestellt",
                "signatory" => "Unterzeichner",
                "status" => "Status"
            ],
            "_table_row_empty" => [
                "add_stakeholder" => "Fügen Sie einen Stakeholder hinzu",
                "has_no_stakeholder" => "hat keinen Stakeholder.",
                "the_contract" => "Der Vertrag"
            ],
            "assign_signatory" => ["assign" => "Zuordnen", "edit" => "Veränderung", "return" => "Rückkehr"],
            "create" => [
                "add_stakeholder" => "Fügen Sie einen Stakeholder hinzu",
                "create" => "schaffen",
                "denomination" => "Konfession",
                "enterprise" => "Unternehmen",
                "help_text" => "Beispiel: \"Der Dienstleister\" oder \"Der Subunternehmer\"",
                "my_enterprise" => "Mein Geschäft",
                "return" => "Rückkehr"
            ],
            "edit" => ["edit" => "Veränderung", "register" => "Rekord", "return" => "Rückkehr"],
            "index" => ["add" => "Hinzufügen", "stakeholders" => "Interessengruppen"],
            "show" => ["return" => "Rückkehr"]
        ],
        "contract_party_document_type" => [
            "_actions" => [
                "associate_existing_document" => "Verknüpfen Sie ein vorhandenes Dokument",
                "associate_new_document" => "Verknüpfen Sie ein neues Dokument",
                "detach_document" => "Nehmen Sie das Dokument ab"
            ],
            "_breadcrumb" => [
                "attach_document" => "Fügen Sie ein Dokument hinzu",
                "create" => "schaffen",
                "edit" => "Veränderung",
                "required_document" => "Dokument erforderlich"
            ],
            "_form" => [
                "mandatory" => "obligatorisch",
                "properties" => "Eigenschaften",
                "validation_required" => "Validierung erforderlich"
            ],
            "_html" => [
                "created_date" => "Erstellungsdatum",
                "label" => "Etikett",
                "last_modified_date" => "Datum der letzten Änderung",
                "username" => "Login"
            ],
            "_table_head" => [
                "actions" => "Lager",
                "dcoument" => "",
                "document" => "Dokument",
                "mandatory" => "obligatorisch",
                "type" => "Typ",
                "validation_required" => "Validierung erforderlich"
            ],
            "_table_row_empty" => [
                "add_required_document" => "Fügen Sie ein erforderliches Dokument hinzu",
                "has_no_document" => "hat kein Dokument zur Verfügung zu stellen.",
                "the_stakeholder" => "Der Stakeholder"
            ],
            "attach_existing_document" => [
                "associate" => "Assoziieren",
                "associate_document" => "Verknüpfen Sie ein Dokument",
                "document" => "Dokument",
                "return" => "Rückkehr"
            ],
            "attach_new_document" => [
                "associate_document" => "Verknüpfen Sie ein Dokument",
                "create_and_associate" => "Erstellen und verknüpfen",
                "document" => "Dokument",
                "return" => "Rückkehr"
            ],
            "create" => [
                "add_required_document" => "Fügen Sie ein erforderliches Dokument hinzu",
                "create" => "schaffen",
                "return" => "Rückkehr",
                "type_of_document" => "Art des Dokuments",
                "types_of_document" => "Arten von Dokumenten"
            ],
            "edit" => ["edit" => "Veränderung", "register" => "Rekord", "return" => "Rückkehr"],
            "index" => ["add" => "Hinzufügen", "document_required_for" => "Dokument erforderlich für"],
            "show" => ["return" => "Rückkehr"]
        ],
        "contract_template" => [
            "_actions" => [
                "annexes" => "Zubehör",
                "contracts" => "Verträge",
                "stakeholders" => "Interessengruppen",
                "variables" => "Variablen"
            ],
            "_breadcrumb" => [
                "contract_templates" => "Vertragsvorlagen",
                "create" => "schaffen",
                "edit" => "Veränderung"
            ],
            "_form" => [
                "general_information" => "Allgemeine Informationen",
                "model" => "Modell",
                "model_name" => "Modellname"
            ],
            "_html" => [
                "created_date" => "Erstellungsdatum",
                "deleted_date" => "Datum der Löschung",
                "label" => "Etikett",
                "last_modified_date" => "Datum der letzten Änderung",
                "username" => "Login"
            ],
            "_table_head" => ["action" => "Aktion", "name_of_contract_template" => "Name der Vertragsvorlage"],
            "_table_row_empty" => [
                "create_contract_template" => "Erstellen Sie eine Vertragsvorlage",
                "has_no_contract_template" => "hat keine Vertragsvorlage",
                "the_enterprise" => "die Firma"
            ],
            "create" => [
                "create" => "schaffen",
                "create_contract_template" => "Erstellen Sie eine Vertragsvorlage",
                "return" => "Rückkehr"
            ],
            "edit" => ["edit" => "Veränderung", "register" => "Rekord", "return" => "Rückkehr"],
            "index" => ["add" => "Hinzufügen", "contract_templates" => "Vertragsvorlagen"],
            "show" => ["return" => "Rückkehr"]
        ],
        "contract_template_annex" => [
            "_breadcrumb" => ["annexes" => "Zubehör", "create" => "schaffen", "edit" => "Veränderung"],
            "_form" => ["general_information" => "Allgemeine Informationen"],
            "_html" => [
                "created_date" => "Erstellungsdatum",
                "label" => "Etikett",
                "last_modified_date" => "Datum der letzten Änderung",
                "username" => "Login"
            ],
            "_table_row_empty" => [
                "add_document" => "Fügen Sie ein Dokument hinzu",
                "does_not_have_annex" => "hat keinen Anhang",
                "the_template" => "Das Model"
            ],
            "create" => [
                "add_annex" => "Fügen Sie einen Anhang hinzu",
                "create" => "schaffen",
                "return" => "Rückkehr"
            ],
            "edit" => ["edit" => "Veränderung", "return" => "Rückkehr"],
            "index" => ["add" => "Hinzufügen", "annexes" => "Zubehör"],
            "show" => ["return" => "Rückkehr"]
        ],
        "contract_template_party" => [
            "_actions" => ["documents_to_provide" => "Zu liefernde Dokumente"],
            "_breadcrumb" => [
                "create" => "schaffen",
                "edit" => "Veränderung",
                "stakeholders" => "Interessengruppen"
            ],
            "_form" => [
                "denomination" => "Konfession",
                "general_information" => "Allgemeine Informationen"
            ],
            "_html" => [
                "created_date" => "Erstellungsdatum",
                "label" => "Etikett",
                "last_modified_date" => "Datum der letzten Änderung",
                "username" => "Login"
            ],
            "_table_head" => [
                "actions" => "Lager",
                "denomination" => "Konfession",
                "documents_to_provide" => "Zu liefernde Dokumente",
                "order" => "Bestellen"
            ],
            "_table_row_empty" => [
                "add_stakeholder" => "Fügen Sie einen Stakeholder hinzu",
                "has_no_stakeholder" => "hat keinen Stakeholder",
                "the_template" => "Das Model"
            ],
            "create" => [
                "add_stakeholder" => "Fügen Sie einen Stakeholder hinzu",
                "create" => "schaffen",
                "return" => "Rückkehr"
            ],
            "edit" => ["edit" => "Veränderung", "register" => "Rekord", "return" => "Rückkehr"],
            "index" => ["add" => "Hinzufügen", "stakeholders" => "Interessengruppen"],
            "show" => ["return" => "Rückkehr"]
        ],
        "contract_template_party_document_type" => [
            "_breadcrumb" => [
                "create" => "schaffen",
                "documents_to_provide" => "Zu liefernde Dokumente",
                "edit" => "Veränderung"
            ],
            "_form" => [
                "general_information" => "Allgemeine Informationen",
                "mandatory_document" => "Obligatorisches Dokument",
                "type_of_document" => "Art des Dokuments",
                "validation_required" => "Validierung erforderlich"
            ],
            "_html" => [
                "created_date" => "Erstellungsdatum",
                "label" => "Etikett",
                "last_modified_date" => "Datum der letzten Änderung",
                "username" => "Login"
            ],
            "_table_head" => [
                "actions" => "Lager",
                "document" => "Dokument",
                "mandatory" => "obligatorisch",
                "validated_by" => "Bestätigt von",
                "validation_required" => "Validierung erforderlich"
            ],
            "_table_row_empty" => [
                "add_required_document" => "Fügen Sie ein erforderliches Dokument hinzu",
                "does_not_require_document" => "benötigt kein Dokument",
                "the_stakeholder" => "Der Stakeholder"
            ],
            "create" => [
                "add_document_to_provide" => "Fügen Sie ein Dokument hinzu, das bereitgestellt werden soll",
                "create" => "schaffen",
                "return" => "Rückkehr"
            ],
            "edit" => ["edit" => "Veränderung", "register" => "Rekord", "return" => "Rückkehr"],
            "index" => ["add" => "Hinzufügen", "documents_to_provide" => "Zu liefernde Dokumente"],
            "show" => ["return" => "Rückkehr"]
        ],
        "contract_template_variable" => [
            "_breadcrumb" => ["create" => "schaffen", "edit" => "Veränderung", "variables" => "Variablen"],
            "_form" => ["general_information" => "Allgemeine Informationen"],
            "_html" => [
                "created_date" => "Erstellungsdatum",
                "label" => "Etikett",
                "last_modified_date" => "Datum der letzten Änderung",
                "username" => "Login"
            ],
            "_table_row_empty" => [
                "add_variable" => "Fügen Sie eine Variable hinzu",
                "has_no_variables" => "hat keine Variablen",
                "the_template" => "Das Model"
            ],
            "create" => [
                "add_variable" => "Fügen Sie eine Variable hinzu",
                "create" => "schaffen",
                "return" => "Rückkehr"
            ],
            "edit" => ["edit" => "Veränderung", "register" => "Rekord", "return" => "Rückkehr"],
            "index" => ["add" => "Hinzufügen", "variables" => "Variablen"],
            "show" => ["return" => "Rückkehr"]
        ],
        "contract_variable" => [
            "_breadcrumb" => ["create" => "schaffen", "edit" => "Veränderung", "variables" => "Variablen"],
            "_form" => ["general_information" => "Allgemeine Informationen"],
            "_html" => [
                "created_date" => "Erstellungsdatum",
                "label" => "Etikett",
                "last_modified_date" => "Datum der letzten Änderung",
                "username" => "Login"
            ],
            "_table_row_empty" => [
                "add_variable" => "Fügen Sie eine Variable hinzu",
                "has_no_variables" => "hat keine Variablen",
                "the_contract" => "Der Vertrag"
            ],
            "create" => [
                "add_variable" => "Fügen Sie eine Variable hinzu",
                "create" => "schaffen",
                "return" => "Rückkehr"
            ],
            "edit" => ["edit" => "Veränderung", "register" => "Rekord", "return" => "Rückkehr"],
            "index" => ["add" => "Hinzufügen", "variables" => "Variablen"],
            "show" => ["return" => "Rückkehr"]
        ]
    ],
    "emails" => [
        "enterprise" => [
            "document" => [
                "expires_soon" => [
                    "addworking_supports_guarantee" => "AddWorking unterstützt Sie dabei, um Ihre Einhaltung zum Kunden zu gewährleisten.",
                    "cordially" => "Grüße,",
                    "hello" => "Hallo !",
                    "inform_legal_text_plurial" => "In diesem Zusammenhang weisen wir Sie darauf hin, dass die folgenden Rechtsdokumente ablaufen",
                    "inform_legal_text_singular" => "In diesem Zusammenhang informieren wir Sie darüber, dass das folgende Rechtsdokument fällig ist",
                    "team_signature" => "Das AddWorking-Team",
                    "update_on_account" => "Um die Beziehungen zu Ihren Kunden zu sichern, aktualisieren Sie diese bitte in Ihrem Konto.",
                    "update_on_account_button" => "Ich aktualisiere meine Dokumente",
                    "valid_until" => "Gültig bis"
                ],
                "outdated" => [
                    "addworking_supports_guarantee" => "AddWorking unterstützt Sie dabei, um Ihre Einhaltung zum Kunden zu gewährleisten.",
                    "cordially" => "Grüße,",
                    "hello" => "Hallo !",
                    "inform_legal_text_plurial" => "In diesem Zusammenhang informieren wir Sie, dass die folgenden Rechtsdokumente ablaufen",
                    "inform_legal_text_singular" => "In diesem Zusammenhang informieren wir Sie, dass das folgende Rechtsdokumente ablauft",
                    "team_signature" => "Das AddWorking-Team",
                    "update_on_account" => "Um die Beziehungen zu Ihren Kunden zu sichern, aktualisieren Sie diese bitte in Ihrem Konto.",
                    "update_on_account_button" => "Ich aktualisiere meine Dokumente",
                    "valid_until" => "Gültig bis"
                ]
            ],
            "vendor" => [
                "noncompliance" => [
                    "addworking_supports_guarantee" => "AddWorking unterstützt Sie dabei, die Einhaltung der Vorschriften Ihrer Subunternehmer und Dienstleister sicherzustellen.",
                    "after_last_week" => "Seit letzter Woche:",
                    "before_last_week" => "Vor der letzten Woche:",
                    "compliance_service" => "AddWorking Compliance-Abteilung",
                    "cordially" => "Grüße,",
                    "hello" => "Hallo, ",
                    "inform_legal_text_plural" => "In diesem Zusammenhang informieren wir Sie, dass die folgenden Konten eine Nichteinhaltung darstellen, die sich auf Ihr Vertragsverhältnis auswirken kann",
                    "inform_legal_text_plurial" => "In diesem Zusammenhang informieren wir Sie, dass die folgenden Konten eine Nichteinhaltung, die sich auf Ihr Vertragsverhältnis auswirken kann",
                    "inform_legal_text_singular" => "In diesem Zusammenhang informieren wir Sie, dass das folgende Konto eine Nichteinhaltung, die sich auf Ihr Vertragsverhältnis auswirken kann",
                    "log_in" => "Einloggen",
                    "reminder_compliance_email" => "Zur Erinnerung, die Dienstleister wurden benachrichtigt und werden daran erinnert, ihre Profile zu aktualisieren."
                ]
            ]
        ]
    ],
    "enterprise" => [
        "document" => [
            "_actions" => [
                "download" => "Herunterladen",
                "remove_precheck" => "Pre-Check-Tag entfernen",
                "replace" => "Ersetzen",
                "replacement_of_document" => "Den Ersatz des Dokuments bestätigen?",
                "tag_in_precheck" => "Als Pre-Check taggen"
            ],
            "_form" => [
                "accept_by" => "Gültig erklärt von",
                "accept_it" => "Gültig erklärt am",
                "reject_by" => "Abgelehnt von",
                "reject_on" => "Abgelehnt am",
                "reject_reason" => "Grund für die Ablehnung",
                "validity_end" => "Ende der Gültigkeit",
                "validity_start" => "Anfang der Gültigkeit"
            ],
            "_form_accept" => ["expiration_date" => "Ablaufdatum"],
            "_form_create" => ["expiration_date" => "Ablaufdatum", "publish_date" => "Änderungsdatum"],
            "_form_fields" => ["additional_fields" => "Zusätzliche Felder"],
            "_form_reject" => ["refusal_reason" => "Grund für die Ablehnung"],
            "_html" => [
                "by" => "von",
                "created_the" => "Hochgeladen am",
                "customer_attached" => "Kunden, die an den Dienstleister angeschlossen sind",
                "days" => "Tage",
                "delete_it" => "Gelöscht am",
                "document_owner" => "Besitzer des Dokumentes",
                "expiration_date" => "Ablaufdatum",
                "further_information" => "Zusätzliche Informationen",
                "modified" => "geändert am",
                "pattern" => "Grund",
                "publish_date" => "Veröffentlichungsdatum",
                "reject_on" => "Abgelehnt am",
                "status" => "Status",
                "the" => "Der",
                "username" => "Benutzername",
                "valid" => "Gültig erklärt am",
                "validity_period" => "Gültigkeitszeitraum"
            ],
            "_status" => [
                "expired" => "Abgelaufen",
                "missing" => "Fehlend",
                "precheck" => "Vorgeprüft",
                "refusal_comment" => "Ablehnungskommentar:",
                "rejected" => "Abgelehnt",
                "valid" => "Gültig erklärt",
                "waiting" => "Wird geprüft"
            ],
            "accept" => [
                "accept" => "Gültig erklären",
                "accept_document" => "Erklären Sie das Dokument gültig",
                "company" => "Unternehmen",
                "dashboard" => "Dashboard",
                "document" => "Dokument",
                "return" => "Rückkehr"
            ],
            "create" => [
                "company" => "Unternehmen",
                "create_document" => "Dokument erstellen",
                "dashboard" => "Dashboard",
                "document" => "Dokument",
                "record" => "Abspeichern",
                "return" => "Rückkehr"
            ],
            "edit" => [
                "active" => "Aktiv",
                "company" => "Unternehmen",
                "dashboard" => "Dashboard",
                "document" => "Dokument",
                "modify" => "Ändern",
                "record" => "Abspeichern",
                "return" => "Rückkehr"
            ],
            "expires_soon" => [
                "addworking_supports_guarantee" => "AddWorking unterstützt Sie dabei, die Einhaltung Ihrer Kunden zu gewährleisten.",
                "inform_legal_text" => "In diesem Zusammenhang informieren wir Sie darüber, dass das folgende Rechtsdokument fällig ist",
                "inform_legal_text_general" => "In diesem Zusammenhang weisen wir Sie darauf hin, dass die folgenden Rechtsdokumente ablaufen",
                "update_documents" => "Ich aktualisiere meine Dokumente",
                "update_on_account" => "Um die Beziehungen zu Ihren Kunden zu sichern, aktualisieren Sie diese bitte in Ihrem Konto.",
                "update_on_account_general" => "Um die Beziehungen zu Ihren Kunden zu sichern, aktualisieren Sie diese bitte in Ihrem Konto.",
                "validity_end" => "Gültigkeitsende: am"
            ],
            "history" => [
                "active" => "Aktiv",
                "company" => "Unternehmen",
                "dashboard" => "Dashboard",
                "deleted" => "Gelöscht",
                "deletion_date" => "Gelöscht am",
                "deposit_date" => "Hochgeladen am",
                "document" => "Dokument",
                "expiration_date" => "Ablaufdatum",
                "history" => "Verlauf",
                "no_result" => "Kein Ergebnis",
                "return" => "Rückkehr",
                "service_provider" => "Dienstleister",
                "state" => "Zustand",
                "status" => "Status"
            ],
            "index" => [
                "company" => "Unternehmen",
                "consult" => "",
                "dashboard" => "Dashboard",
                "deposit_date" => "Hochgeladen am",
                "document" => "Dokument (e) von",
                "document_name" => "Dokumentname",
                "download_validated_documents" => "Laden Sie gültig erkärte Dokumente herunter",
                "expiration_date" => "Ablaufdatum",
                "no_document" => "Kein Dokument",
                "status" => "Status"
            ],
            "reject" => [
                "comment" => "Kommentar",
                "company" => "Unternehmen",
                "dashboard" => "Dashboard",
                "decline_document" => "Dokument ablehnen",
                "document" => "Dokument",
                "refuse" => "Ablehnen",
                "return" => "Rückkehr"
            ],
            "rejected" => [
                "addworking_supports_guarantee" => "AddWorking unterstützt Sie dabei, um Ihre Übereinstimmung zum Kunden zu sichern.",
                "cordially" => "Mit freundlichen Grüßen,",
                "greeting" => "Hallo, ",
                "inform_legal_text" => "In diesem Zusammenhang informieren wir Sie, dass das Dokument",
                "pattern" => "Grund",
                "please_update_account" => "Bitte aktualisieren Sie es in Ihrem Konto.",
                "show_non_compliance" => "ist nicht Konform.",
                "update_documents" => "Ich aktualisiere meine Dokumente"
            ],
            "show" => [
                "accept" => "Gültig erklären",
                "company" => "Unternehmen",
                "dashboard" => "Dashboard",
                "document" => "Dokument",
                "no_file" => "Keine Datei verfügbar.",
                "pre_validate" => "Vorprüfen",
                "refuse" => "Ablehnen"
            ]
        ],
        "document_collection" => [
            "_status" => [
                "all_document_valid" => "Alle Dokumente sind gültig",
                "atleast_one_document_non_compliant" => "Mindestens ein Dokument ist fehlerhaft",
                "atleast_one_document_out_dated" => "Mindestens ein Dokument ist abgelaufen",
                "atleast_one_document_pending" => "Mindestens ein Dokument steht noch aus",
                "no_document_received" => "Kein Dokument erhalten"
            ]
        ],
        "document_type" => [
            "_actions" => [
                "add_to_folder" => "Zum Ordner hinzufügen",
                "consult" => "Einsehen",
                "edit" => "Ändern",
                "remove" => "Entfernen"
            ],
            "_add_model" => [
                "add_modify_template" => "Vorlagendokument hinzufügen / ändern",
                "file" => "Datei"
            ],
            "_form" => [
                "country_document" => "",
                "document_code" => "Code des Dokuments",
                "document_description" => "Beschreibung des Dokuments",
                "document_name" => "Name des Dokuments",
                "document_template" => "Vorlagendokument",
                "document_type" => "Art des Dokuments",
                "enter_document_description" => "Dokumentbeschreibung eingeben...",
                "example_driver_name" => "Beispiel: Führerschein",
                "exmaple_dmpc_v0" => "Beispiel: DMPC_V0",
                "is_mandatory" => "Erforderliches Dokument?",
                "request_document" => "Fordern Sie das Dokument für welche Rechtsform (en) an?",
                "validity_period" => "Geltungsdauer",
                "validity_period_days" => "Geltungsdauer in Tagen."
            ],
            "_html" => [
                "created_at" => "Erstellt am",
                "days" => "Tag(e)",
                "delete_it" => "Gelöscht am",
                "document_template" => "Vorlagendokument",
                "legal_forms" => "Erlaubte Rechtsformen",
                "mandatory" => "Erforderlich",
                "modified" => "Geändert am",
                "no" => "Nein",
                "yes" => "Ja"
            ],
            "_summary" => [
                "ask_by" => "Gefragt bei",
                "download_model" => "Vorlage herunterladen",
                "job" => "Beruf",
                "legal" => "Behördlich",
                "mandatory" => "Erforderlich",
                "optional" => "Wahlfrei"
            ],
            "_table_row" => ["add" => "Hinzufügen", "replace" => "Ersetzen"],
            "create" => [
                "company" => "Unternehmen",
                "create" => "Erstellen",
                "create_document" => "Dokument erstellen",
                "create_new_document" => "Neues Dokument erstellen",
                "dashboard" => "Dashboard",
                "document_type_management" => "Dokumentarten bewirtschaften",
                "return" => "Rückkehr"
            ],
            "edit" => [
                "company" => "Unternehmen",
                "dashboard" => "Dashboard",
                "document_type_management" => "Dokumentarten bewirtschaften",
                "edit" => "Ändern",
                "edit_document" => "Dokument ändern",
                "return" => "Rückkehr"
            ],
            "index" => [
                "add" => "Hinzufügen",
                "dashboard" => "Dashboard",
                "document_list" => "Liste der Dokumente zu liefern für",
                "document_type_management" => "Dokumentarten Bewirtschaften",
                "mandatory" => "Erforderlich",
                "return" => "Rückkehr"
            ],
            "show" => [
                "add_field" => "Feld Hinzufügen",
                "add_modify_template" => "Vorlagendokument hinzufügen / ändern",
                "company" => "Unternehmen",
                "dashboard" => "Dashboard",
                "document_type_management" => "Dokumentarten Bewirtschaften",
                "general_information" => "Allgemeine Informationen "
            ]
        ],
        "document_type_field" => [
            "_create" => [
                "add_modify_field" => "Feld hinzufügen / ändern",
                "bubble_info" => "Kurzinfo",
                "filed_name" => "Feldname",
                "filed_type" => "Feldtyp",
                "required_filed" => "Pflichtfeld"
            ],
            "_edit" => [
                "bubble_info" => "Kurzinfo",
                "edit_field" => "Feld ändern",
                "filed_name" => "Feldname",
                "filed_type" => "Feldtyp",
                "required_filed" => "Pflichtfeld"
            ]
        ],
        "enterprise" => [
            "_actions" => [
                "billing_settings" => "Abrechnungseinstellungen",
                "contract_mockups" => "Vertragsvorlage",
                "customer_invoice" => "Kundenrechnungen",
                "customer_invoice_beta" => "",
                "document_management" => "Bewirtschaftung der Dokumente",
                "edenred_codes" => "Edenred-Codes",
                "files" => "Dateien",
                "membership_management" => "Benutzerverwaltung",
                "passworks" => "Passworks",
                "payment_order" => "Geleistete Zahlungen ",
                "providers" => "Dienstleister",
                "purchase_order" => "Auftragsformulare",
                "refer_service_provider" => "Dienstleister erfassen",
                "refer_user" => "Benutzer erfassen",
                "resource_management" => "Personalverwaltung",
                "service_provider_invoices" => "Rechnungen von Dienstleistern",
                "subsidiaries" => "Tochterfirmen",
                "trades" => "Berufe"
            ],
            "_activities" => ["employee" => "Arbeitnehmer"],
            "_badges" => ["client" => "Kunde", "service_provider" => "Dienstleister"],
            "_breadcrumb" => ["dashboard" => "Dashboard"],
            "_departments" => ["intervention_department" => "Arbeitsbereiche"],
            "_form" => [
                "business_plus" => "",
                "business_plus_message" => "",
                "company_name" => "Firmenname",
                "company_registered_at" => "Firma registriert in",
                "country" => "",
                "external_identifier" => "Äußere Identifikator",
                "general_information" => "Allgemeine Informationen",
                "legal_form" => "Rechtsform",
                "main_activity_code" => "APE-Kode",
                "siren_14_digit_help" => "Dies ist eine 14-stellige Zeichen, die aus SIREN (9 Zahlen) und NIC (5 Zahlen) besteht.",
                "siret_number" => "Französische SIRET Nummer (14 Zahlen)",
                "social_reason" => "Firmenbezeichnung",
                "structure_created" => "Firma im gründungsprozess?",
                "vat_number" => "USt.-Id.Nr."
            ],
            "_form_disabled_inputs" => [
                "company_name" => "Firmenname",
                "company_registered_at" => "Firma registriert in",
                "contact_support" => "Bitte wenden Sie sich an den Support, um Ihre allgemeinen Geschäftsinformationen zu aktualisieren",
                "external_identifier" => "Äußere Identifikator",
                "general_information" => "Allgemeine Informationen",
                "legal_form" => "Rechtsform",
                "main_activity_code" => "APE-Kode",
                "siren_14_digit_help" => "Dies ist eine 14-stellige Zeichen, die aus SIREN (9 Ziffern) und NIC (5 Ziffern) besteht.",
                "siret_number" => "Französische SIRET Nummer (14 Zeichen)",
                "social_reason" => "Firmenbezeichnung",
                "structure_created" => "Firma im gründungsprozess?",
                "vat_number" => "USt.-Id.Nr."
            ],
            "_html" => [
                "activity" => "Aktivität",
                "activity_department" => "Arbeitsbereiche",
                "add_one" => "Fügen Sie eins hinzu",
                "address" => "Adresse",
                "affiliate" => "Tochterfirma von",
                "applicable_vat" => "Anwendbare Mehrwertsteuer",
                "client_id" => "Kunden ID",
                "created_the" => "Erstellt am",
                "legal_representative" => "Gesetzliche Vertreter",
                "modified" => "geändert am",
                "no_logo" => "Noch kein Logo",
                "number" => "Nummer",
                "phone_number" => "Telefonnummer",
                "social_reason" => "Firmenbezeichnung",
                "vat_number" => "USt.-Id.Nr."
            ],
            "_iban" => [
                "cannot_see_company_iban" => "Sie können die IBAN dieses Unternehmens nicht sehen"
            ],
            "_index_form" => [
                "all_companies" => "Alle Unternehmen",
                "hybrid" => "Hybrid",
                "providers" => "Dienstleister",
                "subsidiaries" => "Tochterfirmen"
            ],
            "_type" => ["service_provider" => "Dienstleister"],
            "create" => [
                "activity" => "Aktivität",
                "address_line_1" => "Adresszeile 1",
                "address_line_2" => "Adresszeile 2",
                "ape_code_help" => "Der APE-Code (Hauptaktivität ausgeführt) besteht aus 4 Ziffern + 1 Buchstaben",
                "city" => "Stadt",
                "company_activity" => "Geschäftstätigkeit des Unternehmens",
                "country" => "",
                "create" => "schaffen",
                "create_company" => "Erstellen Sie die Firma",
                "dashboard" => "Dashboard",
                "department" => "Abteilung",
                "department_help" => "Sie können mehrere Abteilungen auswählen, indem Sie die [Strg] -Taste auf Ihrer Tastatur gedrückt halten.",
                "enterprise" => "",
                "main_address" => "HAUPTADRESSE",
                "number_of_employees" => "Mitarbeiteranzahl",
                "postal_code" => "Postleitzahl",
                "return" => "Rückkehr",
                "sector" => "Sektor",
                "start_new_business" => "Starten Sie ein neues Unternehmen",
                "telephone_1" => "Telefonleitung 1",
                "telephone_2" => "Telefonleitung 2",
                "telephone_3" => "Telefonleitung 3"
            ],
            "edit" => [
                "activity" => "Aktivität",
                "address_line_1" => "Adresszeile 1",
                "address_line_2" => "Adresszeile 2",
                "business_type" => "Geschäftsart (en)",
                "choice_legal_representative" => "Wahl des gesetzlichen Vertreters und Unterzeichners",
                "city" => "Stadt",
                "dashboard" => "Dashboard",
                "legal_representative" => "Gesetzlicher Vertreter",
                "main_address" => "Hauptadresse",
                "modifier" => "Veränderung",
                "postal_code" => "Postleitzahl",
                "record" => "Rekord",
                "return" => "Rückkehr",
                "service_provider" => "Dienstleister",
                "sign" => "Unterzeichner"
            ],
            "index" => [
                "actions" => "",
                "activity" => "Aktivität",
                "add" => "Hinzufügen",
                "company" => "Unternehmen",
                "create" => "",
                "created" => "Erstellt am",
                "customer" => "",
                "dashboard" => "Dashboard",
                "enterprise" => "",
                "filter" => [
                    "activity" => "",
                    "activity_field" => "",
                    "identification_number" => "",
                    "legal_form" => "",
                    "legal_representative" => "",
                    "main_activity_code" => "",
                    "name" => "",
                    "phone" => "",
                    "reinitialize" => "",
                    "type" => "",
                    "zip_code" => ""
                ],
                "hybrid" => "",
                "identification_number" => "",
                "leader" => "Führer",
                "legal_form" => "",
                "legal_representative" => "",
                "main_activity_code" => "",
                "name" => "",
                "phone" => "Telefon",
                "return" => "Rückkehr",
                "service_provider" => "Dienstleister",
                "society" => "Unternehmen",
                "type" => "",
                "update" => "Aktualisiert die",
                "vendor" => ""
            ],
            "show" => [
                "dashboard" => "Dashboard",
                "general_information" => "Allgemeine Informationen",
                "phone_number" => "Telefonnummern",
                "providers" => "Dienstleistern",
                "return" => "Rückkehr",
                "sogetrel_data" => "Sogetrel-Daten"
            ],
            "tabs" => [
                "_phone_number" => [
                    "add" => "Hinzufügen",
                    "date_added" => "Datum hinzugefügt",
                    "phone_number" => "Telefonnummer"
                ],
                "_sogetrel_data" => [
                    "group_counted_march" => "Compta Group \"Markt\"",
                    "no" => "Nicht",
                    "product_accounting_group" => "Compta Group \"Produkt\"",
                    "sent_navibat" => "Nach Navibat geschickt",
                    "vat_group_accounting" => "Compta Group \"Markt\" - Mehrwertsteuer",
                    "yes" => "Ja"
                ],
                "_vendor" => [
                    "company" => "Unternehmen",
                    "legal_representative" => "Gesetzlicher Vertreter",
                    "provide_since" => "Dienstleister seit"
                ]
            ]
        ],
        "enterprise_activity" => [
            "_form" => [
                "enterprise_activity_help" => "Beispiel: Handel, Catering, persönliche Dienstleistungen usw.",
                "select_multiple_departments_help" => "Halten Sie die STRG-Taste auf Ihrer Tastatur gedrückt, um mehrere Abteilungen gleichzeitig auszuwählen."
            ],
            "create" => [
                "create" => "schaffen",
                "create_company" => "Erstellen Sie die Firma",
                "dashboard" => "Dashboard",
                "general_information" => "Allgemeine Informationen",
                "return" => "Rückkehr"
            ],
            "edit" => [
                "company_activity" => "Geschäftstätigkeit des Unternehmens",
                "modify_activity" => "Ändern Sie die Aktivität des Unternehmens"
            ]
        ],
        "enterprise_signatory" => [
            "_form" => [
                "director" => "Direktor",
                "function_legal_representative" => "Funktion des gesetzlichen Vertreters",
                "legal_representative" => "Gesetzlicher Vertreter",
                "quality_legal_representative" => "Qualität des gesetzlichen Vertreters",
                "signatory_contracts" => "Unterzeichner von Verträgen"
            ]
        ],
        "enterprise_subsidiaries" => [
            "create" => [
                "create" => "schaffen",
                "create_subsidiary" => "Erstellen Sie eine Tochtergesellschaft von",
                "dashboard" => "Dashboard",
                "return" => "Rückkehr",
                "subsidiaries" => "Tochterunternehmen"
            ],
            "index" => [
                "create_subsidiary" => "Erstellen Sie eine Tochtergesellschaft von",
                "dashboard" => "Dashboard",
                "return" => "Rückkehr",
                "subsidiaries" => "Tochterunternehmen",
                "subsidiaries_of" => "Tochterunternehmen von"
            ]
        ],
        "enterprise_vendors" => [
            "_actions" => [
                "dereference" => "Dereferenzierung",
                "see_documents" => "Siehe seine Dokumente",
                "see_passwork" => "Siehe seine Passarbeit",
                "see_passworks" => "Sehen Sie seine Passarbeiten"
            ]
        ],
        "iban" => [
            "_actions" => ["download" => "Download", "replace" => "Ersetzen"],
            "_form" => [
                "bank_code" => "Bankleitzahl (BIC oder SWIFT)",
                "label" => "Wortlaut",
                "rib_account_statement" => "Kontoauszug (RIB)"
            ],
            "_html" => ["download" => "Download", "status" => "Status"],
            "create" => [
                "company_iban" => "Firma IBAN",
                "dashboard" => "Dashboard",
                "general_information" => "Allgemeine Informationen",
                "record" => "Rekord",
                "return" => "Rückkehr"
            ],
            "show" => [
                "check_mailbox" => "Bitte überprüfen Sie Ihr E-Mail-Feld.",
                "company_iban" => "IBAN des Unternehmens",
                "dashboard" => "Dashboard",
                "iban_awaiting_confirmation" => "IBAN wartet auf Ihre Bestätigung",
                "resend_confirmation_email" => "Senden Sie die Bestätigungs-E-Mail zurück"
            ]
        ],
        "invitation" => [
            "_actions" => ["consult" => "konsultieren", "revive" => "Relaunch"],
            "_index_form" => [
                "accepted" => "Angenommen",
                "all_invitations" => "Alle Einladungen",
                "in_progress" => "In Validierung",
                "pending" => "Warten auf Empfang",
                "rejected" => "Abgelaufen / Abgelehnt"
            ],
            "_invitation_status" => [
                "accepted" => "Akzeptiert",
                "in_progress" => "In Validierung",
                "pending" => "Warten auf Empfang",
                "rejected" => "Abgelaufen / Abgelehnt"
            ],
            "_invitation_types" => ["member" => "Benutzer", "mission" => "Mission", "vendor" => "Dienstleister"],
            "_table_head" => ["guest" => "Gast", "status" => "Status"],
            "index" => [
                "dashboard" => "Dashboard",
                "expired" => "Abgelaufen",
                "index_relaunch" => "In Charge erhöhen",
                "invite_member" => "Lade ein Mitglied ein",
                "invite_provider" => "Laden Sie einen Dienstleister ein",
                "my_invitations" => "Meine Einladungen",
                "return" => "Rückkehr"
            ],
            "show" => [
                "dashboard" => "Dashboard",
                "expired_on" => "Abgelaufen am",
                "expires_on" => "Läuft am ab",
                "guest" => "Gast",
                "invitation_for" => "Einladung für",
                "my_invitations" => "Meine Einladungen",
                "return" => "Rückkehr",
                "revive" => "Relaunch"
            ]
        ],
        "legal_form" => [
            "_form" => [
                "acronym" => "Akronym",
                "general_information" => "Allgemeine Informationen",
                "wording" => "Wortlaut"
            ],
            "_html" => [
                "acronym" => "Akronym",
                "creation_date" => "Erstellungsdatum",
                "last_modification_date" => "Datum der letzten Änderung",
                "username" => "Login",
                "wording" => "Wortlaut"
            ],
            "create" => [
                "create" => "schaffen",
                "create_legal_form" => "Rechtsform erstellen",
                "dashboard" => "Dashboard",
                "legal_form" => "Rechtsform",
                "return" => "Rückkehr"
            ],
            "edit" => [
                "dashboard" => "Dashboard",
                "edit" => "Veränderung",
                "legal_form" => "Rechtsform",
                "record" => "Rekord",
                "return" => "Rückkehr"
            ],
            "index" => [
                "acronym" => "Akronym",
                "add" => "Hinzufügen",
                "dashboard" => "Dashboard",
                "legal_form" => "Rechtsform",
                "wording" => "Wortlaut"
            ],
            "show" => ["dashboard" => "Dashboard", "legal_form" => "Rechtsform", "return" => "Rückkehr"]
        ],
        "member" => [
            "_actions" => [
                "assign_provider" => "Dienstleiter zuweisen",
                "confirm_delisting_of_member" => "Die Entfernung diesem Benutzer aus der Liste bestätigen?",
                "consult" => "Einsehen",
                "dereference" => "Aus der Liste entfernen",
                "edit" => "Ändern"
            ],
            "_form" => [
                "access_application" => "Auf die Anwendung zugreifen",
                "general_information" => "Allgemeine Informationen",
                "general_project_manager" => "(Geschäftsführender Direktor, Projektleiter, Praktikant ...)"
            ],
            "_member_accesses" => ["access" => "Zugriff"],
            "_table_head" => ["access" => "zugriff", "last_name" => "Name"],
            "create" => [
                "dashboard" => "Dashboard",
                "platform_user" => "Benutzer der Plattform",
                "record" => "Abspeichern",
                "refer_user" => "Benutzer erfassen",
                "return" => "Rückkehr",
                "users" => "Benutzer"
            ],
            "edit" => [
                "company_members" => "Mitglieder der Firma",
                "dashboard" => "Dashboard",
                "edit" => "Ändern",
                "record" => "Abspeichern",
                "return" => "Rückkehr"
            ],
            "index" => [
                "company_members" => "Mitglieder der Firma",
                "dashboard" => "Dashboard",
                "invite_member" => "Mitglied einladen",
                "refer_user" => "Benutzer erfassen",
                "return" => "Rückkehr"
            ],
            "invitation" => [
                "accept" => "Annehmen",
                "accept_invitation" => "Um die Einladung anzunehmen, klicken Sie einfach auf die Schaltfläche unten.",
                "copy_paste_url" => "Sie können auch die folgende URL kopieren und in die Adresszeile Ihres Browsers einfügen",
                "create" => [
                    "dashboard" => "Dashboard",
                    "invite" => "Einladen",
                    "invite_member" => "Mitglied einladen",
                    "my_invitations" => "Meine Einladungen",
                    "return" => "Rückkehr",
                    "user_invite" => "Benutzer zu Einladen"
                ],
                "exchanges_with_subcontractors" => "AddWorking unterstützt Sie bei der Digitalisierung Ihres Austauschs mit Ihren Zulieferanten und Dienstleistern",
                "greeting" => "Hallo, ",
                "i_accept_invitation" => "Ich nehme die Einladung an",
                "invitation_to_join" => "Sie sind eingeladen, sich dem Unternehmen anzuschließen",
                "need_support" => "Benötigen Sie Hilfe beim Einstieg in das App? Kontaktieren Sie uns!",
                "notification" => [
                    "accept" => "Annehmen",
                    "accept_invitation" => "Um die Einladung anzunehmen, klicken Sie einfach auf die Schaltfläche unten.",
                    "copy_paste_url" => "Sie können auch eine der folgenden URLs kopieren und in die Adresszeile Ihres Browsers einfügen, um:",
                    "exchanges_with_subcontractors" => "AddWorking unterstützt Sie bei der Digitalisierung Ihres Austauschs mit Ihren Zulieferanten und Dienstleistern.",
                    "greeting" => "Hallo, ",
                    "i_accept_invitation" => "Ich nehme die Einladung an",
                    "invitation_to_join" => "Sie sind eingeladen, sich dem Unternehmen anzuschließen",
                    "need_support" => "Benötigen Sie Hilfe beim Einstieg in das App? Kontaktieren Sie uns!",
                    "refuse" => "Ablehnen",
                    "see_you_soon" => "Bis bald !",
                    "team_addworking" => "Das AddWorking-Team"
                ],
                "refuse" => "Ablehnen",
                "review" => ["join_company" => "Schließen Sie die Unternehmen an", "rejoin" => "Anschließen "],
                "see_you_soon" => "Bis bald !",
                "team_addworking" => "Das AddWorking-Team"
            ],
            "show" => [
                "access" => "zugriff",
                "access_company_information" => "Daten der Firma einsehen",
                "access_company_user" => "Benutzer der Firma einsehen",
                "access_contracts" => "Verträge einsehen",
                "access_invoicing" => "Rechnungen einsehen",
                "access_mission" => "Aufgaben einsehen",
                "access_purchase_order" => "Auftragsformulare einsehen",
                "become_member" => "Mitglied werden",
                "company_members" => "Mitglieder der Firma",
                "contact" => "Kontaktieren",
                "dashboard" => "Dashboard",
                "edit" => "Ändern",
                "identity" => "Identität",
                "return" => "Rückkehr",
                "title" => "Titel",
                "to_log_in" => "Einloggen"
            ]
        ],
        "membership_request" => [
            "create" => [
                "associate_user_with_company" => "Beteiligen Sie einen Benutzer mit dem Unternehmen",
                "create_association" => "Beteiligung erstellen"
            ]
        ],
        "phone_number" => [
            "create" => [
                "add_phone_number" => "Telefonnummer zu .. hinzufügen",
                "dashboard" => "Dashboard",
                "phone" => "Telefon",
                "phone_number" => "Telefonnummer",
                "record" => "Abspeichern",
                "return" => "Rückkehr"
            ]
        ],
        "referent" => [
            "_form_assigned_vendors" => [
                "general_information" => "Allgemeine Informationen",
                "provider_of" => "Dienstleister von"
            ],
            "edit_assigned_vendors" => [
                "assigned_by" => "Unterlegt bei",
                "assigned_providers_list" => "Liste den zugewiesenen Dienstleistern",
                "company_members" => "Mitglieder der Firma",
                "dashboard" => "Dashboard",
                "modify_assigned_providers" => "Ändern Sie die Liste den zugewiesenen Dienstleistern",
                "record" => "Abspeichern",
                "return" => "Rückkehr"
            ]
        ],
        "site" => [
            "_actions" => ["to_consult" => "Einsehen"],
            "create" => [
                "address_line_1" => "Adresszeile 1",
                "address_line_2" => "Adresszeile 2",
                "analytical_code" => "Analytischer Code",
                "city" => "Stadt",
                "create_new_site" => "Neue Webseite erstellen",
                "create_site" => "Webseite erstellen",
                "create_sites" => "Webseiten erstellen",
                "dashboard" => "Dashboard",
                "general_information" => "Allgemeine Informationen",
                "last_name" => "Name",
                "main_address" => "Hauptadresse",
                "postal_code" => "Postleitzahl",
                "return" => "Rückkehr",
                "telephone_1" => "Telefonleitung 1",
                "telephone_2" => "Telefonleitung 2",
                "telephone_3" => "Telefonleitung 3"
            ],
            "edit" => [
                "address_line_1" => "Adresszeile 1",
                "address_line_2" => "Adresszeile 2",
                "analytical_code" => "Analytischer Code",
                "city" => "Stadt",
                "dashboard" => "Dashboard",
                "edit" => "Ändern",
                "edit_site" => "Webseite bearbeiten",
                "general_information" => "Allgemeine Informationen",
                "last_name" => "Name",
                "main_address" => "Hauptadresse",
                "postal_code" => "Postleitzahl",
                "record" => "Abspeichern",
                "return" => "Rückkehr"
            ],
            "index" => [
                "add" => "Hinzufügen",
                "address" => "Adresse",
                "company_sites" => "Webseiten der Firma",
                "created_the" => "Erstellt am",
                "dashboard" => "Dashboard",
                "last_name" => "Name",
                "phone" => "Telefon",
                "return" => "Rückkehr"
            ],
            "phone_number" => [
                "create" => [
                    "add_phone_number" => "Telefonnummer zu .. hinzufügen",
                    "dashboard" => "Dashboard",
                    "phone" => "Telefon",
                    "phone_number" => "Telefonnummer",
                    "record" => "Abspeichern",
                    "return" => "Rückkehr"
                ]
            ],
            "show" => [
                "" => "",
                "add" => "Hinzufügen",
                "address" => "Adresse",
                "analytical_code" => "Analytischer Code",
                "dashboard" => "Dashboard",
                "date_added" => "Hinzugefügt am",
                "general_information" => "Allgemeine Informationen",
                "phone_number" => "Telefonnummer",
                "phone_numbers" => "Telefonnummern",
                "remove" => "Entfernen",
                "return" => "Rückkehr"
            ]
        ],
        "vendor" => [
            "_actions" => [
                "billing_options" => "Abrechnungseinstellungen",
                "confirm_delisting_of_service_provider" => "Aufhebung dieser Dienstleister aus der Liste Bestätigen?",
                "consult_contract" => "Verträge einsehen",
                "consult_document" => "Dokumente einsehen",
                "consult_passwork" => "Passwork einsehen",
                "dereference" => "Aus der Liste entfernen"
            ],
            "attach" => [
                "dashboard" => "Dashboard",
                "general_information" => "Allgemeine Informationen",
                "list_prestataries" => "Liste der Dienstleister",
                "record" => "Abspeichern",
                "referencing_providers" => "Dienstleister für .. erfassen",
                "return" => "Rückkehr"
            ],
            "billing_deadline" => [
                "edit" => [
                    "dashboard" => "Dashboard",
                    "my_providers" => "Meine Dienstleister",
                    "payment_deadline" => "Zahlungsfrist",
                    "payment_terms" => "Zahlungstermine Einstellungen für",
                    "record" => "Abspeichern",
                    "return" => "Rückkehr",
                    "setting" => "Einstellungen"
                ],
                "index" => [
                    "creation_date" => "Erstellungsdatum",
                    "dashboard" => "Dashboard",
                    "edit" => "Ändern",
                    "my_providers" => "Meine Dienstleister",
                    "number_of_days" => "Anzahl der Tage",
                    "payment_deadline" => "Zahlungsfrist",
                    "payment_due_for" => "Zahlung fällig für",
                    "return" => "Rückkehr",
                    "wording" => "Denominierung"
                ]
            ],
            "detached" => ["by" => "Durch", "dereferenced" => "wurde aus der Firma entfernt"],
            "import" => [
                "csv_file" => "CSV-Datei",
                "dashboard" => "Dashboard",
                "import" => "Importieren",
                "import_providers" => "Dienstleiter importieren",
                "my_providers" => "Meine Dienstleister"
            ],
            "index" => [
                "activity_status" => "Status",
                "business_documents_compliance" => "Übereinstimmung vom Kunden Gefragte Dokumente",
                "complaint_service_provider" => "Konformer Dienstleister",
                "dashboard" => "Dashboard",
                "dedicated_resources" => "Gewidmete Hilfsmittel",
                "division_by_skills" => "Aussortieren durch Kompetenzen",
                "export" => "Exportieren",
                "import" => "Importieren",
                "leader" => "GEschäftsführer",
                "legal_documents_compliance" => "Übereinstimmung vom gesetzlicher Dokumente",
                "my_providers" => "Meine Dienstleiter",
                "non_complaint_service_provider" => "Nicht konformer Dienstleister",
                "onboarding_completed" => "Onboarding abgeschlossen",
                "onboarding_inprogress" => "Onboarding läuft",
                "onboarding_non_existent" => "Nicht vorhandenes Onboarding",
                "onboarding_status" => "Status von Onboarding",
                "return" => "Rückkehr",
                "see_only_assigned_providers" => "Nur meine bestimmte Dienstleister einsehen",
                "society" => "Unternehmen"
            ],
            "index_division_by_skills" => [
                "breadcrumb" => [
                    "dashboard" => "Dashboard",
                    "division_by_skills" => "Aussortieren durch Kompetenzen",
                    "enterprise" => "Unternehmen",
                    "my_vendors" => "Meine Dienstleiter"
                ],
                "jobs_catalog_button" => "Berufskatalog",
                "return_button" => "Rückkehr",
                "table_head" => ["job" => "Beruf", "skill" => "Kompetenz", "vendors" => "Anzahl der Dienstleister"],
                "table_row_empty" => "Dieses Unternehmen erfasst keine Kompetenz.",
                "title" => "Aussortieren durch Kompetenzen"
            ],
            "invitation" => [
                "accept" => "Annehmen",
                "accept_invitation" => "Nehmen Sie die Einladung an, indem Sie auf die Schaltfläche unten klicken.",
                "access_from_account" => "Zugriff über Ihr AddWorking-Konto",
                "and_its_done" => "Und es ist ja schon vorbei!",
                "company_information" => "Bitte geben Sie Ihre Unternehmensdaten ein",
                "copy_paste_url" => "",
                "create" => [
                    "dashboard" => "Dashboard",
                    "invite" => "Einladen",
                    "invite_several_providers_once" => "Um mehrere Dienstleister auf ein mal einzuladen, müssen Sie eine E-Mail, einen Namen / Vornamen des Empfängers und einen Firmennamen pro Zeile, wie folgt, eingeben",
                    "my_invitations" => "Meine Einladungen",
                    "provider1" => "Dienstleister1@beispiel.com, Otto Normalverbraucher, Firma-a",
                    "provider2" => "Dienstleister2@beispiel.com, Anna Normalverbraucher, firma-b",
                    "provider3" => "Dienstleister3@beispiel.com, Daniel Normalverbraucher, firma-c",
                    "provider4" => "Dienstleister4@beispiel.com, Lea Normalverbraucher, firma-d",
                    "provider5" => "Dienstleister5@beispiel.com, Jonas Normalverbraucher, firma-e",
                    "provider_invitation" => "Einladung des Dienstleisters",
                    "return" => "Rückkehr",
                    "service_provider_information" => "Angaben zur Einladung des Dienstleisters",
                    "user_invite" => "Benutzer zu einladen"
                ],
                "greeting" => "Hallo, ",
                "i_accept_invitation" => "Ich nehme die Einladung an",
                "instant_messaging" => "Instant Messaging",
                "legal_documents" => "Gesetzliche Dokumente",
                "notification" => [
                    "accept" => "Annehmen",
                    "accept_invitation" => "Nehmen Sie die Einladung an, indem Sie auf die Schaltfläche unten klicken.",
                    "access_from_account" => "Zugriff über Ihr AddWorking-Konto",
                    "and_its_done" => "Und es ist ja schon vorbei!",
                    "company_information" => "Geben Sie Ihre Unternehmensdaten ein,",
                    "copy_paste_url" => "Sie können auch eine der folgenden URLs kopieren und in die Adressleiste Ihres Browsers einfügen um:",
                    "email" => "E-Mail",
                    "greeting" => "Hallo, ",
                    "have_questions" => "Haben Sie Fragen? Unser Team antwortet Ihnen",
                    "i_accept_invitation" => "Ich nehme die Einladung an",
                    "instant_messaging" => "Instant Messaging",
                    "legal_documents" => "Hochladen Sie die von Ihrem Kunden angeforderten gesetztlichen Dokumente.",
                    "our_app" => "Unsere App, die Sie auf alle Medien zugegreiffen können, unterstützt Sie dabei, den gesamten Austausch mit Ihrem Kunden zu vereinfachen und gleichzeitig Ihre Übereinstimmung sicherzustellen.",
                    "phone" => "Telefon",
                    "refuse" => "Ablehnen",
                    "register_free" => "Die Registrierung ist sehr einfach (und kostenlos!)",
                    "team_addworking" => "Das AddWorking-Team",
                    "welcome" => "Willkommen bei AddWorking!",
                    "wish_to_reference" => "möchtet Sie auf AddWorking erfassen. Herzliche Glückwünsche!"
                ],
                "our_app" => "",
                "questions" => "Haben Sie Fragen ? Unser Support-Team antwortet Ihnen",
                "refuse" => "",
                "register_free" => "",
                "review" => [
                    "become_provider" => "Dienstleister von .. werden",
                    "choose_company" => "Wählen Sie eine Firma",
                    "create_account" => "Mein Konto erstellen"
                ],
                "team_addworking" => "Das AddWorking-Team",
                "telephone" => "",
                "welcome" => "",
                "wish_to_reference" => ""
            ],
            "invitation_create" => [
                "dashboard" => "Dashboard",
                "invite_provider" => "Laden Sie einen Dienstleister ein",
                "invite_provider_join_client" => "Laden Sie einen Dienstleister ein, sich dem Kunden anzuschließen",
                "my_invitations" => "Meine Einladungen"
            ],
            "noncompliance" => [
                "addworking_supports_guarantee" => "AddWorking unterstützt Sie dabei, um Ihre Übereinstimmung zum Kunden zu sichern.",
                "compliance_service" => "",
                "consult_documents" => "Dokumente einsehen",
                "cordially" => "Mit freundlichen Grüßen,",
                "greeting" => "Hallo, ",
                "nonconformity" => "ist nicht Konform.",
                "not_confirm" => "",
                "we_inform" => "Wir informieren Sie, dass das folgende Gesetzliche dokument"
            ],
            "partnership" => [
                "edit" => [
                    "activity_ends_at" => "Ende Datum dem Betrieb",
                    "activity_starts_at" => "Anfangsdatum dem Betrieb",
                    "custom_management_fees_tag" => "Möglichkeit zum personnalisierte Spesen",
                    "dashboard" => "Dashboard",
                    "my_providers" => "Meine Dienstleister",
                    "partnership" => "Aktuelle Betriebsamkeit",
                    "record" => "Abspeichern",
                    "return" => "Rückkehr",
                    "updated_at" => "Letzte Änderung am",
                    "updated_by" => "Letzte Änderung von"
                ]
            ]
        ]
    ],
    "mission" => [
        "mission" => [
            "_actions" => [
                "complete_mission" => "Schließe die Mission ab",
                "confirm_deletion" => "Löschung bestätigen?",
                "confirm_generate_purchase_order" => "Sind Sie sich Ihrer Informationen sicher, bevor Sie das Bestellformular erstellen? Einmal generiert, kann es nicht mehr geändert werden.",
                "consult" => "konsultieren",
                "define_tracking_mode" => "Definieren Sie den Tracking-Modus",
                "delete_purchase_order" => "Bestellung löschen",
                "edit" => "Veränderung",
                "generate_order_form" => "Bestellformular erstellen",
                "mission_followup" => "Erstellen Sie ein Missionsüberwachung",
                "mission_monitoring" => "Auftragessüberwachung",
                "order_form" => "Siehe Bestellformular",
                "remove" => "Entfernen"
            ],
            "_breadcrumb" => ["create" => "Schaffen", "edit" => "Veränderung", "index" => "Aufgaben"],
            "_departments" => ["departments" => "Abteilungen"],
            "_form" => [
                "assignment_purpose" => "Zweck der Aufgabe",
                "describe_mission_help" => "Beschreiben Sie die Mission hier ausführlich.",
                "identifier_help" => "Geben Sie gegebenenfalls eine zusätzliche Kennung ein.",
                "location" => "Platz",
                "project_development_help" => "Beispiel: Projektentwicklung",
                "tracking_mode" => "Tracking-Modus"
            ],
            "_html" => [
                "add_note" => "Notiz hinzufügen",
                "amount" => "Betrag",
                "end" => "Ende",
                "location" => "Platz",
                "number" => "Anzahl",
                "permalink" => "Permalink",
                "rate_mission" => "Bewerte die Mission",
                "service_provider" => "Dienstleister",
                "start" => "Anfang",
                "status" => "Status",
                "unit" => "Einheit",
                "user_id" => "Login"
            ],
            "create" => [
                "affected_companies" => "Betroffene Unternehmen",
                "create" => "schaffen",
                "create_mission" => "Erstelle eine Mission",
                "create_the_mission" => "Erstelle die Mission",
                "dashboard" => "Dashboard",
                "general_information" => "Allgemeine Informationen",
                "mission" => "Mission",
                "return" => "Rückkehr"
            ],
            "create_milestone_type" => [
                "create" => "schaffen",
                "dashboard" => "Dashboard",
                "define_tracking_mode" => "Definieren Sie den Tracking-Modus",
                "mission" => "Mission",
                "mission_information" => "Missionsinformationen",
                "return" => "Rückkehr",
                "tracking_mode" => "Tracking-Modus"
            ],
            "edit" => [
                "assignment_purpose" => "Zweck der Aufgabe",
                "dashboard" => "Dashboard",
                "describe_mission_help" => "Beschreiben Sie die Mission hier ausführlich.",
                "edit" => "Veränderung",
                "edit_mission" => "Mission bearbeiten",
                "identifier_help" => "Geben Sie gegebenenfalls eine zusätzliche Kennung ein.",
                "location" => "Platz",
                "mission" => "Missionen",
                "mission_information" => "Missionsinformationen",
                "project_development_help" => "Beispiel: Projektentwicklung",
                "return" => "Rückkehr"
            ],
            "index" => [
                "add" => "Hinzufügen",
                "amount" => "Betrag",
                "dashboard" => "Dashboard",
                "finish" => "fertiggestellt",
                "mission_closed_by" => "Mission geschlossen von",
                "new" => "Neu",
                "no" => "Nicht",
                "number" => "Anzahl",
                "return" => "Rückkehr",
                "service_provider" => "Dienstleister",
                "start_date" => "Startdatum",
                "status" => "Status"
            ],
            "show" => [
                "abondend_by" => "Verlassen von",
                "abondend_date" => "Datum der Aufgabe",
                "amount" => "Menge",
                "assigned_provider" => "Zugewiesener Dienstleister",
                "billing" => "Abrechnung",
                "change_status" => "Status ändern",
                "closed_by" => "Geschlossen durch",
                "closing_date" => "Einsendeschluss",
                "consult_proposal" => "Konsultieren Sie den Vorschlag",
                "created_by" => "Erstellt von",
                "creation_date" => "Erstellungsdatum",
                "dashboard" => "Dashboard",
                "determine" => "Bestimmen",
                "end_date" => "Enddatum",
                "further_information" => "Zusätzliche Informationen",
                "general_information" => "Allgemeine Informationen",
                "incoming_invoice" => "Zugehörige Eingangsrechnung",
                "last_update" => "Letztes Update",
                "location" => "Platz",
                "mission_proposal" => "Missionsvorschlag",
                "price" => "Preis",
                "start_date" => "Startdatum",
                "status" => "Status",
                "tracking_mode" => "Tracking-Modus"
            ]
        ],
        "mission_tracking" => [
            "_actions" => ["consult" => "Konsultieren", "edit" => "Veränderung", "remove" => "Löschen"],
            "_breadcrumb" => ["create" => "Schaffen", "edit" => "Veränderung", "index" => "Überwachung"],
            "_status" => [
                "agreement_search" => "Vereinbarung suchen",
                "refuse" => "Abgelehnt",
                "valid" => "Bestätigt",
                "waiting" => "Warten"
            ],
            "create" => [
                "addtional_files" => "Zusätzliche Dateien",
                "amount" => "Menge",
                "create" => "Schaffen",
                "dashboard" => "Dashboard",
                "general_information" => "Allgemeine Informationen",
                "mission_followup" => "Neues Missionsüberwachung",
                "mission_followup_ref" => "Referenz zur Nachverfolgung der Mission",
                "mission_monitoring" => "Missionsüberwachung",
                "notify_customer" => "Benachrichtigen Sie den Kunden",
                "notify_provider" => "Benachrichtigen Sie den Dienstleister",
                "order_attached_help" => "Bsp.: Bestellnummer, Anhang usw.",
                "period_concerned" => "Betroffener Zeitraum",
                "record" => "Rekord",
                "return" => "Rückkehr",
                "unit" => "Einheit",
                "unit_price" => "Stückpreis"
            ],
            "created" => [
                "access_mission_tracking" => "Missionsüberwachung",
                "copy_paste_url" => "Sie können auch die folgende URL kopieren und in die Adressleiste Ihres Browsers einfügen",
                "cordially" => "Grüße,",
                "greeting" => "Hallo, ",
                "new_vision_tracking" => "",
                "team_addworking" => "Das AddWorking-Team",
                "validate" => "Bestätigen"
            ],
            "edit" => [
                "addtional_files" => "Zusätzliche Dateien",
                "dashboard" => "Dashboard",
                "edit" => "Veränderung",
                "edit_mission_tracking" => "Missionsverfolgung bearbeiten",
                "external_identifier" => "Externe Kennung",
                "general_information" => "Allgemeine Informationen",
                "mission_followup" => "Missions-Follow-ups",
                "mission_monitoring" => "Missionsüberwachung",
                "order_attached_help" => "Bsp.: Bestellnummer, Anhang usw.",
                "period_concerned" => "Betroffener Zeitraum",
                "record" => "Rekord",
                "return" => "Rückkehr"
            ],
            "index" => [
                "client" => "Kunde",
                "dashboard" => "Dashboard",
                "edit_mission_tracking" => "Missionsverfolgung bearbeiten",
                "end_date" => "Enddatum",
                "mission" => "Mission",
                "mission_monitoring" => "Missionsüberwachung",
                "mission_number" => "Missionsnummer",
                "return" => "Rückkehr",
                "service_provider" => "Dienstleister",
                "start_date" => "Startdatum",
                "status" => "Status"
            ],
            "show" => [
                "add_row" => "Zeile hinzufügen",
                "amount" => "Menge",
                "attachement" => "Anhänge",
                "commenting_text" => "Ein Kommentarsystem ermöglicht den Austausch gegen gegenseitige Vereinbarung.",
                "comments" => "Kommentare",
                "customer_status" => "Kundenstatus",
                "dashboard" => "Dashboard",
                "express_agreement" => "Sie haben Ihre Zustimmung bereits zum Ausdruck gebracht (oder nicht)",
                "external_identifier" => "Externe Kennung",
                "general_information" => "Allgemeine Informationen",
                "information_note" => "Hinweis zur Information",
                "mission_followup" => "Missions-Follow-ups",
                "mission_followup_text" => "Sie können so viele Missions-Follow-up-Zeilen wie nötig erstellen (Beispiel: Missionsschritte, zusätzliche Kosten im Zusammenhang mit einem oder mehreren unerwarteten Ereignissen usw.).",
                "mission_monitoring" => "Missionsüberwachung",
                "mission_monitoring_statement" => "Eine Missionsüberwachungslinie ermöglicht es den Stakeholdern (Kunden und Subunternehmer), die Konformität der erbrachten Dienstleistung mit der im Hinblick auf eine faire Rechnungsstellung beauftragten Mission zu überprüfen.",
                "period_concerned" => "Betroffener Zeitraum",
                "provider_status" => "Dienstleisterstatus",
                "reason_for_rejection" => "Grund für die Ablehnung",
                "refusal_reason" => "Grund für die Ablehnung",
                "return" => "Rückkehr",
                "tracking_lines" => "Linien verfolgen",
                "unit_price" => "Stückpreis"
            ]
        ],
        "mission_tracking_line" => [
            "_actions" => [
                "accept_mission" => "Missionsüberwachungslinie akzeptieren?",
                "customer_refusal" => "Kundenverweigerung",
                "customer_validation" => "Kundenvalidierung",
                "edit" => "Veränderung",
                "mission_tracking_deletion_confirm" => "Löschen der Missionsverfolgungslinie bestätigen?",
                "provider_validation" => "Dienstleisterbestätigung",
                "remove" => "entfernen",
                "service_provider_refusal" => "Ablehnung des Dienstleisters"
            ],
            "_breadcrumb" => ["create" => "schaffen", "edit" => "Veränderung", "index" => "Linien"],
            "_reject" => [
                "client" => "Kunde",
                "decline_tracking" => "Verfolgen Sie die Verfolgungslinie",
                "refusal_reason" => "Grund für die Ablehnung",
                "service_provider" => "Dienstleister"
            ],
            "_table_row_empty" => [
                "add_line" => "Zeile hinzufügen",
                "doesnt_have_lines" => "hat keine Zeilen",
                "the_tracking" => "Missionsüberwachung"
            ],
            "create" => [
                "amount" => "Menge",
                "create_row" => "Zeile erstellen",
                "dashboard" => "Dashboard",
                "general_information" => "Allgemeine Informationen",
                "line_label" => "Linienbeschriftung",
                "mission" => "Missionen",
                "mission_monitoring" => "Missionsüberwachung",
                "mission_monitoring_new" => "Neue Linie der Missionsüberwachung",
                "record" => "Rekord",
                "return" => "Rückkehr",
                "unit" => "Einheit",
                "unit_price" => "Stückpreis"
            ],
            "edit" => [
                "amount" => "Menge",
                "dashboard" => "Dashboard",
                "edit" => "Veränderung",
                "general_information" => "Allgemeine Informationen",
                "line_label" => "Linienbeschriftung",
                "lines" => "Linien",
                "mission" => "Missionen",
                "mission_monitoring" => "Missions-Follow-ups",
                "modify_mission_tracking" => "Missionsverfolgungslinie bearbeiten",
                "modify_row" => "Zeile ändern",
                "return" => "Rückkehr",
                "unit" => "Einheit",
                "unit_price" => "Stückpreis"
            ],
            "index" => [
                "amount" => "Betrag",
                "label" => "Linien verfolgen",
                "title" => "Linien von Suvis",
                "validation" => "Bestätigung"
            ]
        ],
        "offer" => [
            "_actions" => [
                "change_status" => "Status ändern",
                "change_status_offer" => "Ändern Sie den Status des Angebots",
                "choose_recp_offer" => "Wählen Sie die Empfänger des Angebots",
                "close_offer" => "Schließen Sie das Angebot",
                "closing_request" => "Abschlussanfrage",
                "consult" => "konsultieren",
                "edit" => "Veränderung",
                "relaunch_mission_proposal" => "Missionsvorschläge neu starten",
                "remove" => "entfernen",
                "responses" => "Antworten",
                "see_missions" => "Siehe verwandte Missionen",
                "status" => "Status",
                "summary" => "Zusammenfassung"
            ],
            "_form" => [
                "desc_mission_details" => "Beschreibe hier alle Details der Mission",
                "referent" => "Referent"
            ],
            "_proposal_actions" => [
                "consult_passwork" => "Konsultieren Sie die Passarbeit",
                "consult_proposal" => "Konsultieren Sie den Vorschlag",
                "view_responses" => "Antworten anzeigen"
            ],
            "_status" => [
                "abondend" => "Verlassen",
                "broadcast" => "Übertragung",
                "closed" => "Geschlossen",
                "diffuse" => "Zu verbreiten",
                "rough_draft" => "Grober Entwurf"
            ],
            "accept_offer" => [
                "congratulations" => "Glückwunsch!",
                "cordially" => "Grüße,",
                "greeting" => "Hallo, ",
                "i_consult" => "konsultieren",
                "legal_statement" => "",
                "response_to_mission_proposal" => "Ihre Antwort auf den Missionsvorschlag",
                "team_addworking" => "Das AddWorking-Team",
                "validate" => "Bestätigen"
            ],
            "assign" => [
                "assign" => "",
                "assign_offer_service_provider" => "Weisen Sie das Angebot einem Dienstleister zu",
                "dashboard" => "Dashboard",
                "mission_offer" => "Missionsangebot",
                "return" => "Rückkehr",
                "service_provider" => "Dienstleister"
            ],
            "assign_modal" => ["close" => "", "close_offer" => "", "register" => "", "title" => ""],
            "create" => [
                "additional_file" => "Zusätzliche Datei",
                "assignment_desired_skills" => "Gewünschte Fähigkeit (en) für diese Aufgabe",
                "assignment_offer_info" => "Angaben zum Auftragsangebot",
                "assignment_purpose" => "Zweck der Aufgabe",
                "create" => "schaffen",
                "dashboard" => "Dashboard",
                "mission_offer" => "Missionsangebot",
                "new_mission_offer" => "Neues Missionsangebot",
                "project_development_help" => "Beispiel: Projektentwicklung",
                "return" => "Rückkehr",
                "select_multiple_departments_help" => "Sie können mehrere Abteilungen auswählen, indem Sie die [Strg] -Taste auf Ihrer Tastatur gedrückt halten."
            ],
            "edit" => [
                "additional_file" => "Zusätzliche Datei",
                "assignment_offer_info" => "Angaben zum Auftragsangebot",
                "assignment_purpose" => "Zweck der Aufgabe",
                "dashboard" => "Dashboard",
                "department_help" => "Sie können mehrere Abteilungen auswählen, indem Sie die [Strg] -Taste auf Ihrer Tastatur gedrückt halten.",
                "edit" => "Veränderung",
                "location" => "Platz",
                "mission_offer" => "Missionsangebot",
                "modify_assignment_offer" => "Ändern Sie ein Auftragsangebot",
                "project_development_help" => "Beispiel: Projektentwicklung",
                "return" => "Rückkehr"
            ],
            "index" => [
                "create_assignment_offer" => "Erstellen Sie ein Auftragsangebot",
                "created_on" => "Erstellt am",
                "dashboard" => "Dashboard",
                "mission_offer" => "Missionsangebote",
                "referent" => "Referent",
                "status" => "Status"
            ],
            "pending_offer" => [
                "greeting" => "Hallo, ",
                "no_longer_respond" => "Sie können auf dieses Angebot nicht mehr antworten.",
                "offer_closed" => "",
                "see_you_soon" => "Bis bald !"
            ],
            "refuse_offer" => [
                "greeting" => "Hallo, ",
                "has_refused_by" => "wurde von abgelehnt",
                "i_consult" => "Ich berate",
                "see_you_soon" => "Bis bald !",
                "your_response" => ""
            ],
            "request_close_offer" => [
                "confirm_choice" => "Auftragsangebot schließen?",
                "cordially" => "Grüße,",
                "greeting" => "Hallo, ",
                "legal_statement" => "",
                "mission_offer_close" => "Schließen Sie das Angebot",
                "retained_respondent" => "Zugewiesener Dienstleister",
                "team_addworking" => "Das AddWorking-Team"
            ],
            "send_request_close" => [
                "dashboard" => "Dashboard",
                "mission_offer" => "Missionsangebot",
                "offer_close_req" => "Antrag auf Abschluss des Auftragsangebots",
                "return" => "Rückkehr",
                "send_request" => "Senden Sie die Anfrage",
                "solicit_responsible" => "Verantwortlich für die Anwerbung",
                "you_selected" => "Sie haben ausgewählt",
                "you_selected_text" => "Antwort (en) bei der endgültigen Validierung dieses Angebots. Es ist jetzt notwendig, das Angebot zu schließen. Bitte wählen Sie eine autorisierte Person aus der folgenden Liste."
            ],
            "show" => [
                "action" => "Lager",
                "additional_document" => "Zusätzliche Dokumente",
                "analytical_code" => "Analytischer Code",
                "assignment_desired_skills" => "Gewünschte Fähigkeit (en) für diese Aufgabe",
                "assignment_purpose" => "Zweck der Aufgabe",
                "assing_mission_directly" => "Weisen Sie die Mission direkt zu",
                "choose_recp_offer" => "Wählen Sie die Empfänger des Angebots",
                "client_id" => "Kunden ID",
                "close_offer" => "Schließen Sie das Angebot",
                "closing_request" => "Abschlussanfrage",
                "confirm_close_assignment" => "Antwort (en) in der endgültigen Validierung, sind Sie sicher, dass Sie dieses Auftragsangebot schließen möchten?",
                "dashboard" => "Dashboard",
                "end_date" => "Enddatum",
                "general_information" => "Allgemeine Informationen",
                "location" => "Platz",
                "mission_offer" => "Missionsangebote",
                "mission_proposal" => "Empfänger",
                "no_document" => "Kein Dokument",
                "no_proposal" => "Kein Vorschlag",
                "provider_company" => "Dienstleisterfirma",
                "referent" => "Referent",
                "response_number" => "Anzahl der Antworten",
                "start_date" => "Startdatum",
                "status" => "Status",
                "you_have" => "Du hast "
            ],
            "summary" => [
                "create" => "schaffen",
                "dashboard" => "Dashboard",
                "enterprise" => "Unternehmen",
                "mission" => "Mission",
                "mission_offer" => "Missionsangebot",
                "reply_date" => "Antwortdatum",
                "response_not_in_final_validation" => "Diese Antwort befindet sich nicht im Status \"Endgültige Validierung\"",
                "responses_summary" => "Zusammenfassung der Antworten auf das Auftragsangebot",
                "see_mission" => "Sehen Sie diese Mission",
                "status" => "Status",
                "summary" => "Zusammenfassung"
            ]
        ],
        "profile" => [
            "create" => [
                "dashboard" => "Dashboard",
                "disseminate_offer" => "Verbreiten Sie das Auftragsangebot an",
                "enterprise" => "Unternehmen",
                "mission_offer" => "Missionsangebot",
                "provider_selection" => "Auswahl den Dienstleistern",
                "return" => "Rückkehr",
                "selected_company" => "Ausgewählte Firma (n)",
                "service_provider_selection" => "Auswahl der Dienstleister für das Auftragsangebot",
                "trades_skill" => "Trades & Skills"
            ]
        ],
        "proposal" => [
            "_actions" => [
                "assign_proposal_confirm" => "Sind Sie sicher, dass Sie die Mission zuweisen möchten?",
                "assing_mission" => "Weisen Sie die Mission zu",
                "confirmation" => "Bestätigung",
                "consult" => "konsultieren",
                "delete_proposal_confirm" => "Möchten Sie den Zuweisungsvorschlag wirklich löschen?",
                "edit" => "Veränderung",
                "remove" => "entfernen",
                "responses" => "Antworten"
            ],
            "create" => ["broadcast" => "Übertragung", "close" => "Schließen"],
            "edit" => [
                "dashboard" => "Dashboard",
                "edit" => "Veränderung",
                "mission_offer" => "Missionsangebot",
                "mission_proposal" => "Missionsvorschlag",
                "mission_proposal_info" => "Informationen zum Missionsvorschlag",
                "modify_proposal" => "Ändern Sie den Missionsvorschlag",
                "return" => "Rückkehr",
                "service_provider" => "Dienstleister"
            ],
            "index" => [
                "dashboard" => "Dashboard",
                "desired_start_date" => "Bevorzugtes Anfangsdatum",
                "mission_offer" => "Missionsangebot",
                "mission_proposal" => "Missionsvorschläge",
                "referent" => "Referent",
                "service_provider" => "Dienstleister",
                "status" => "Status"
            ],
            "show" => [
                "additional_document" => "Zusätzliche Dokumente",
                "amount" => "Menge",
                "client_id" => "Kunden ID",
                "comments" => "Kommentare",
                "customer" => "Kunde",
                "dashboard" => "Dashboard",
                "desired_start_date" => "Bevorzugtes Anfangsdatum",
                "details_assignment_offer" => "Details zum Auftragsangebot",
                "download" => "Download",
                "files_title" => "Zusätzliche Dokumente",
                "further_information" => "Zusätzliche Informationen",
                "information_req" => "BPU anfordern",
                "mission_end" => "Ende der Mission",
                "mission_location" => "Missionsort",
                "mission_proposal" => "Missionsvorschlag",
                "mission_proposal_response" => "Antworten auf den Missionsvorschlag",
                "no_file_sentence" => "Keine Datei angehängt",
                "no_response_sentence" => "Keine Antwort",
                "offer_closed" => "Das Angebot ist jetzt geschlossen, Sie können nicht mehr antworten",
                "offer_description" => "Beschreibung des Auftragsangebots",
                "offer_label" => "Zweck des Auftragsangebots",
                "offer_status" => "Angebotsstatus",
                "proposal_start_date" => "Startdatum des Vorschlags",
                "proposal_status" => "Angebotsstatus",
                "quote_required" => "Angebot erforderlich",
                "read_more" => "Mehr sehen",
                "replace" => "Ersetzen",
                "req_sent" => "Ihre Informationsanfrage wurde gesendet, ein Sogetrel-Mitarbeiter wird Ihnen antworten",
                "respond_deadline" => "Antwortfrist",
                "respond_tenders" => "Reagieren Sie auf die Ausschreibung",
                "response" => "Siehe Antwort von",
                "response_title" => "Antworten",
                "send_bpu" => "Senden Sie eine BPU",
                "service_provider" => "Dienstleister",
                "show_bpu" => "BPU anzeigen",
                "to_respond_update" => "Um auf diese Ausschreibung zu reagieren, müssen Sie Ihre Dokumente aktualisieren",
                "total_amount" => "Gesamtbetrag",
                "unit" => "Einheit",
                "unit_price" => "Stückpreis"
            ],
            "status" => [
                "_interested" => [
                    "audience_text" => "Zielgruppe: für alle sichtbar. Geschützt: sichtbar für Mitglieder meiner Firma. Privat: nur für mich sichtbar.",
                    "information_req" => "Informationsanfrage",
                    "information_requested" => "Informationen angefordert",
                    "visibility" => "Sichtweite"
                ]
            ]
        ],
        "proposal_response" => [
            "_actions" => ["edit" => "Veränderung"],
            "_status" => [
                "exchange_positive" => "Positiver Austausch",
                "exchange_req" => "Austausch angefordert",
                "final_validation" => "Endgültige Validierung",
                "refuse" => "verweigern",
                "validate_price" => "Preis validieren",
                "waiting" => "Warten"
            ],
            "create" => [
                "additional_file" => "Zusätzliche Dateien",
                "amount" => "Menge",
                "availability_end_date" => "Enddatum der Verfügbarkeit",
                "create_response" => "Erstellen Sie eine Antwort",
                "create_response1" => "Erstellen Sie die Antwort",
                "dashboard" => "Dashboard",
                "general_information" => "Allgemeine Informationen",
                "mission_proposal" => "Missionsvorschlag",
                "possible_start_date" => "Mögliches Startdatum",
                "price" => "Preis",
                "respond_offer" => "Antworten Sie auf das Angebot",
                "return" => "Rückkehr",
                "unit" => "Einheit"
            ],
            "edit" => [
                "additional_file" => "Zusätzliche Dateien",
                "amount" => "Menge",
                "availability_end_date" => "Enddatum der Verfügbarkeit",
                "dashboard" => "Dashboard",
                "edit_response" => "Antwort bearbeiten",
                "edit_response1" => "Bearbeiten Sie eine Antwort",
                "general_information" => "Allgemeine Informationen",
                "mission_proposal" => "Missionsvorschlag",
                "possible_start_date" => "Mögliches Startdatum",
                "price" => "Preis",
                "return" => "Rückkehr",
                "unit" => "Einheit"
            ],
            "index" => [
                "action" => "Lager",
                "client_company" => "Kundenfirma",
                "close_assignment_confirm" => "Antwort (en) in der endgültigen Validierung, sind Sie sicher, dass Sie dieses Auftragsangebot schließen möchten?",
                "close_offer" => "Schließen Sie das Angebot",
                "closing_request" => "Abschlussanfrage",
                "created" => "Erstellt am",
                "dashboard" => "Dashboard",
                "mission_offer" => "Missionsangebote",
                "mission_proposal" => "Missionsvorschläge",
                "new_response" => "Neue Antworten",
                "offer_answer" => "Antworten auf das Angebot",
                "provider_company" => "Dienstleisterfirma",
                "response" => "Antworten",
                "status" => "Status"
            ],
            "show" => [
                "accept_it" => "Akzeptieren",
                "accepted_by" => "Akzeptiert von",
                "additional_document" => "Zusätzliche Dokumente",
                "amount" => "Menge",
                "change_status" => "Status ändern",
                "client" => "Kunde",
                "close_assignment_confirm" => "Antwort (en) in der endgültigen Validierung, sind Sie sicher, dass Sie dieses Auftragsangebot schließen möchten?",
                "close_offer" => "Schließen Sie das Angebot",
                "closing_request" => "Abschlussanfrage",
                "comment" => "Kommentare",
                "dashboard" => "Dashboard",
                "description" => "Beschreibung",
                "general_information" => "Allgemeine Informationen",
                "mission_offer" => "Missionsangebot",
                "mission_proposal" => "Missionsvorschlag",
                "no_document" => "Kein Dokument",
                "offer_answer" => "Antwort auf das Angebot",
                "possible_end_date" => "Mögliches Enddatum",
                "possible_start_date" => "Mögliches Startdatum",
                "price" => "Preis",
                "refusal_reason" => "Grund für die Ablehnung",
                "refused_by" => "Abgelehnt von",
                "refused_on" => "Abgelehnt am",
                "response" => "Antworten",
                "service_provider" => "Dienstleister",
                "status" => "Status"
            ],
            "status" => [
                "_final_validation" => [
                    "audience_text" => "Zielgruppe: für alle sichtbar. Geschützt: sichtbar für Mitglieder meiner Firma. Privat: nur für mich sichtbar.",
                    "change_resp_status" => "Wechsel von Antwort zu Status",
                    "close_assignment" => "Auftragsangebot schließen?",
                    "comment" => "Kommentar",
                    "visibility" => "Sichtweite"
                ],
                "_interview_positive" => [
                    "audience_text" => "Zielgruppe: für alle sichtbar. Geschützt: sichtbar für Mitglieder meiner Firma. Privat: nur für mich sichtbar.",
                    "change_resp_status" => "Wechsel von Antwort zu Status",
                    "comment" => "Kommentar",
                    "visibility" => "Sichtweite"
                ],
                "_interview_requested" => [
                    "audience_text" => "Zielgruppe: für alle sichtbar. Geschützt: sichtbar für Mitglieder meiner Firma. Privat: nur für mich sichtbar.",
                    "change_resp_status" => "Wechsel von Antwort zu Status",
                    "comment" => "Kommentar",
                    "visibility" => "Sichtweite"
                ],
                "_ok_to_meet" => [
                    "audience_text" => "Zielgruppe: für alle sichtbar. Geschützt: sichtbar für Mitglieder meiner Firma. Privat: nur für mich sichtbar.",
                    "change_resp_status" => "Wechsel von Antwort zu Status",
                    "comment" => "Kommentar",
                    "visibility" => "Sichtweite"
                ],
                "_pending" => [
                    "audience_text" => "Zielgruppe: für alle sichtbar. Geschützt: sichtbar für Mitglieder meiner Firma. Privat: nur für mich sichtbar.",
                    "change_resp_status" => "Wechsel von Antwort zu Status",
                    "comment" => "Kommentar",
                    "visibility" => "Sichtweite"
                ],
                "_reject" => [
                    "audience_text" => "Zielgruppe: für alle sichtbar. Geschützt: sichtbar für Mitglieder meiner Firma. Privat: nur für mich sichtbar.",
                    "comment" => "Kommentar",
                    "refuse_assign_offer" => "Lehnen Sie die Antwort auf das Auftragsangebot ab",
                    "visibility" => "Sichtweite"
                ]
            ]
        ],
        "purchase_order" => [
            "document" => [
                "_details" => [
                    "amount" => "Menge",
                    "assignment_purpose" => "Zweck der Aufgabe",
                    "uht_amount" => "Betrag H.T.",
                    "uht_price" => "U.H.T. Preis",
                    "unit" => "Einheit"
                ],
                "_enterprises" => [
                    "address" => "17 rue du Lac Saint André<br/>Savoie Technolac - BP 350<br/>73370 Le Bourget du Lac - Frankreich",
                    "address1" => "Adresse",
                    "addworking" => "ADDWORKING",
                    "billing_address" => "Rechnungsadresse",
                    "buyer" => "Käufer",
                    "last_name" => "Name",
                    "legal_entity" => "Juristische Person",
                    "mail" => "E-Mail",
                    "net_transfer" => "30 Tage Nettotransfer",
                    "payment_condition" => "Zahlungsbedingung",
                    "phone" => "AS",
                    "provider" => "Dienstleister"
                ],
                "_header" => [
                    "created" => "Erstellt am",
                    "purchase_order" => "Bestellung",
                    "reference_mission" => "Missionsreferenz",
                    "remind_correspondence" => "(um <u>obligatorisch</u> an Ihre gesamte Korrespondenz, <strong>Lieferscheine</strong> und <strong>Rechnungen</strong> erinnert zu werden)"
                ],
                "_shipping_informations" => [
                    "by_receiving_supplier_undertakes" => "Mit Erhalt dieses Bestellformulars verpflichtet sich der Lieferant zu",
                    "delivery_information" => "Versandinformationen",
                    "description" => "Beschreibung",
                    "destination_site" => "Zielort",
                    "expected_start_date" => "Erwartetes Startdatum",
                    "referent" => "Referent",
                    "shipping_site" => "Versandstelle",
                    "supplier_undertake_1" => "1. Bearbeiten Sie diese Bestellung gemäß den oben aufgeführten Preisen, Bedingungen, Lieferanweisungen und Spezifikationen.",
                    "supplier_undertake_2" => "2. Senden Sie Ihre Rechnung auf der AddWorking-Plattform.",
                    "supplier_undertake_3" => "3. Benachrichtigen Sie den Käufer unverzüglich, wenn er die Bestellung nicht wie angegeben versenden kann."
                ],
                "_terms" => ["spf_purchase_condition" => "SPF Allgemeine Einkaufsbedingungen"],
                "_total" => [
                    "total_net_excl_tax" => "Netto-Gesamt-HT in €",
                    "total_price" => "Gesamtpreis",
                    "vat" => "Mehrwertsteuer"
                ],
                "page" => "Seite"
            ],
            "index" => [
                "action" => "Lager",
                "assignment_purpose" => "Zweck der Aufgabe",
                "creation_date" => "Erstellungsdatum",
                "dashboard" => "Dashboard",
                "enterprise" => "Unternehmen",
                "ht_price" => "HT Preis",
                "mission_reference" => "Missionsreferenz",
                "order_form" => "Bestellformulare für",
                "purchase_order" => "Kauforder",
                "status" => "Status"
            ],
            "show" => [
                "dashboard" => "Dashboard",
                "details" => "Details",
                "enterprise" => "Unternehmen",
                "mission" => "Mission",
                "order_form" => "Bestellformular für",
                "order_form_help_text" => "Dieses Bestellformular wurde aus der entsprechenden Mission generiert. Sie können die Mission ändern (und das Bestellformular neu generieren), solange das Bestellformular nicht an den Dienstleister gesendet wurde",
                "purchase_order" => "Bestellung",
                "return" => "Rückkehr",
                "send_order_form" => "Bestätigen Sie den Versand des Bestellformulars?",
                "send_to_service_provider_and_referrer" => "An Dienstleister und Überweiser senden"
            ]
        ]
    ],
    "mssion" => [
        "mission_tracking_line" => [
            "_html" => [
                "amout" => "Betrag",
                "label" => "Schilderung",
                "reason_for_rejection" => "Grund für die Ablehnung",
                "validation" => "Bestätigung",
                "validation_customer" => "Kundenbestätigung",
                "validation_vendro" => "Dienstleisterbestätigung"
            ]
        ]
    ],
    "navbar" => ["need_help" => "Brauchen Hilfe ?"],
    "user" => [
        "auth" => [
            "login" => [
                "email_address" => "E-Mail-Adresse",
                "forgot_password" => "Passwort vergessen?",
                "log_in" => "Einloggen",
                "login" => "Einloggen",
                "password" => "Passwort"
            ],
            "passwords" => [
                "email" => [
                    "email_address" => "E-Mail-Adresse",
                    "reset_password" => "Passwort zurücksetzen",
                    "send" => "Senden"
                ],
                "reset" => [
                    "confirm_password" => "Passwort bestätigen",
                    "email_address" => "E-Mail-Adresse",
                    "password" => "Passwort",
                    "record" => "Rekord",
                    "reset_password" => "Passwort zurücksetzen"
                ]
            ],
            "register" => [
                "reCaptcha_failed" => "ReCaptcha-Überprüfung fehlgeschlagen",
                "registration" => "Anmeldung"
            ]
        ],
        "chat" => [
            "index" => [
                "converse" => "Sie unterhalten sich mit",
                "refresh" => "cool",
                "sent" => "Abgesandte",
                "to_send" => "Senden",
                "view_document" => "Dokument anzeigen"
            ],
            "rooms" => [
                "access_your_conversation" => "Greifen Sie auf Ihre Gespräche zu",
                "chatroom_list" => "Chatroom-Listen",
                "chatroom_list_participate" => "Listen der Chatrooms, an denen Sie teilnehmen",
                "conversation_with" => "Gespräch mit",
                "see_conversation" => "Siehe das Gespräch"
            ]
        ],
        "dashboard" => [
            "_customer" => [
                "active_contract" => "Aktive Verträge",
                "contract" => "",
                "invoices" => "Rechnungen",
                "mission" => "Missionen",
                "missions_this_month" => "Missionen in diesem Monat",
                "new_response" => "Neue Antworten",
                "pending_contract" => "Ausstehende Verträge",
                "performance" => "Performance",
                "providers" => "Dienstleister",
                "validate_offer" => "Angebote zur Validierung"
            ],
            "_onboarding" => [
                "boarding" => "Einsteigen",
                "step" => [
                    "confirm_email" => ["call_to_action" => "", "description" => "", "message" => ""],
                    "create_enterprise" => ["call_to_action" => "", "description" => "", "message" => ""],
                    "create_passwork" => ["call_to_action" => "", "description" => "", "message" => ""],
                    "on" => "",
                    "step" => "",
                    "steps" => "",
                    "upload_legal_document" => ["call_to_action" => "", "description" => "", "message" => ""]
                ]
            ],
            "_vendor" => [
                "active_contract" => "Aktive Verträge",
                "alert_expired_document" => "Sie müssen Dokumente aktualisieren",
                "alert_expired_document_button" => "Ich aktualisiere meine Dokumente",
                "client" => "Kundschaft",
                "contract" => "",
                "mission_proposal" => "Missionsvorschläge",
                "missions_this_month" => "Missionen in diesem Monat",
                "pending_contract" => "Ausstehende Verträge"
            ]
        ],
        "log" => [
            "index" => [
                "dashboard" => "Dashboard",
                "date" => "Datum",
                "email" => "E-Mail",
                "export_sogetrel_user_activities" => "Sogetrel Benutzeraktivitäten exportieren",
                "http_method" => "HTTP-Methode",
                "impersonating" => "Das bist nicht du ?",
                "ip" => "IP",
                "rout" => "Straße",
                "url" => "URLs",
                "user_logs" => "Benutzerprotokolle"
            ]
        ],
        "notification_process" => [
            "edit" => [
                "iban_change_confirmation" => "IBAN-Änderungsbestätigungen erhalten",
                "notification_setting" => "Benachrichtigungseinstellungen",
                "notify_service_provider_paid" => "Sie werden benachrichtigt, wenn einer meiner Dienstleister bezahlt wurde",
                "receive_emails" => "E-Mails erhalten",
                "receive_mission_followup_email" => "Erhalten Sie E-Mails, um Missionsnachverfolgungen zu erstellen"
            ]
        ],
        "onboarding_process" => [
            "_actions" => [
                "add_context_tag" => "Fügen Sie das So'connext-Tag hinzu",
                "confirm_activation" => "Aktivierung bestätigen?",
                "confirm_deactivation" => "Deaktivierung bestätigen?",
                "remove_context_tag" => "Entfernen Sie das So’connext-Tag",
                "to_log_in" => "Einloggen"
            ],
            "_form" => [
                "concern_domain" => "Betroffene Domain",
                "onboarding_completed" => "Onboarding abgeschlossen",
                "user" => "Benutzer"
            ],
            "_html" => [
                "completion_date" => "Fertigstellungstermin",
                "creation_date" => "Erstellungsdatum",
                "enterprise" => "Unternehmen",
                "field" => "Feld",
                "onboarding_completed" => "Onboarding abgeschlossen",
                "step_in_process" => "Schritt in den Prozess",
                "user" => "Benutzer"
            ],
            "create" => [
                "concerned_domain" => "Betroffene Domain",
                "create" => "schaffen",
                "create_new_onboaring_process" => "Erstellen Sie einen neuen Onboarding-Prozess",
                "dashboard" => "Dashboard",
                "general_information" => "Allgemeine Informationen",
                "onboarding_completed" => "Onboarding abgeschlossen",
                "onboarding_process" => "Onboarding-Prozess",
                "record" => "Rekord",
                "return" => "Rückkehr",
                "user" => "Benutzer"
            ],
            "edit" => [
                "dashboard" => "Dashboard",
                "edit" => "Veränderung",
                "edit_onboarding_process" => "Bearbeiten des Onboarding-Prozesses",
                "general_information" => "Allgemeine Informationen",
                "onboarding_completed" => "Onboarding abgeschlossen",
                "onboarding_process" => "Onboarding-Prozess",
                "record" => "Rekord",
                "return" => "Rückkehr",
                "step_in_process" => "Schritt in den Prozess"
            ],
            "index" => [
                "action" => "Aktion",
                "add" => "Hinzufügen",
                "client" => "Kunde",
                "concerned_domain" => "Betroffene Domain",
                "created" => "Erstellt am",
                "dashboard" => "Dashboard",
                "entreprise" => "Unternehmen",
                "export" => "Export",
                "finish" => "Fertig",
                "in_progress" => "In Bearbeitung",
                "onboarding_process" => "Onboarding-Prozess",
                "return" => "Rückkehr",
                "status" => "Status",
                "step_in_process" => "Schritt in den Prozess",
                "user" => "Benutzer"
            ],
            "show" => [
                "dashboard" => "Dashboard",
                "general_information" => "Allgemeine Informationen",
                "onboarding" => "Beim Einsteigen",
                "onboarding_process" => "Onboarding-Prozess",
                "return" => "Rückkehr"
            ]
        ],
        "profile" => [
            "customers" => [
                "dashboard" => "Dashboard",
                "entreprise" => "Unternehmen",
                "my_clients" => "Meine Kunden",
                "return" => "Rückkehr"
            ],
            "edit" => [
                "change_password" => "Passwort ändern",
                "dashboard" => "Dashboard",
                "edit" => "Veränderung",
                "edit_email" => "E-Mail bearbeiten",
                "edit_profile" => "Profil bearbeiten von",
                "profile" => "Profil",
                "profile_information" => "Profil Information",
                "record" => "Rekord",
                "return" => "Rückkehr"
            ],
            "edit_password" => [
                "change_password" => "Ändern Sie Ihr Passwort",
                "current_password" => "Aktuelles Passwort",
                "dashboard" => "Dashboard",
                "new_password" => "Neues Passwort",
                "profile" => "Profil",
                "record" => "Rekord",
                "repeat_new_password" => "Wiederhole das neue Passwort"
            ],
            "index" => [
                "additional_address" => "Zusätzliche Adresse",
                "address" => "Adresse (n)",
                "change_password" => "Passwort ändern",
                "dashboard" => "Dashboard",
                "edit_email" => "E-Mail bearbeiten",
                "edit_profile" => "Mein Profil bearbeiten",
                "enterprise" => "Unternehmen",
                "first_name" => "Vorname",
                "function" => "Funktion",
                "last_name" => "Nachname",
                "notification" => "Benachrichtigungen",
                "phone_number" => "Telefonnummer.",
                "phone_numbers" => "Telefonnummern",
                "postal_code" => "Postleitzahl",
                "profile_of" => "Profil von",
                "profile_picture" => "Profilbild",
                "user_identity" => "Benutzeridentität"
            ]
        ],
        "terms_of_use" => [
            "show" => [
                "accept_general_condition" => "Akzeptanz der Allgemeinen Nutzungsbedingungen",
                "general_information" => "Allgemeine Informationen",
                "validate" => "Bestätigen"
            ]
        ],
        "user" => [
            "_badges" => [
                "client" => "Kunde",
                "service_provider" => "Dienstleister",
                "support" => "Unterstützung"
            ],
            "_form" => ["first_name" => "Vorname", "last_name" => "Name"],
            "_html" => [
                "activation" => "Aktivierung",
                "active" => "Aktiva",
                "email" => "E-Mail",
                "enterprises" => "Firma (n)",
                "identity" => "Identität",
                "inactive" => "Inaktiv",
                "last_activity" => "Letzte Aktivität",
                "last_authentication" => "Letzte Authentifizierung",
                "number" => "Anzahl",
                "phone_number" => "Telefon",
                "registration_date" => "Datum der Registrierung",
                "tags" => "Tags",
                "username" => "Login"
            ],
            "_index_form" => [
                "all" => "Alle",
                "clients" => "Kundschaft",
                "providers" => "Dienstleister",
                "support" => "Unterstützung"
            ],
            "_tags" => ["na" => "N / A"],
            "create" => [
                "create" => "schaffen",
                "create_new_user" => "Erstellen Sie einen neuen Benutzer",
                "create_user" => "Benutzer erstellen",
                "dashboard" => "Dashboard",
                "general_information" => "Allgemeine Informationen",
                "return" => "Rückkehr",
                "users" => "Benutzer"
            ],
            "edit" => [
                "dashboard" => "Dashboard",
                "edit" => "Veränderung",
                "edit_user" => "Benutzer bearbeiten",
                "general_information" => "Allgemeine Informationen",
                "modify_user" => "Benutzer bearbeiten",
                "return" => "Rückkehr",
                "users" => "Benutzer"
            ],
            "index" => [
                "action" => "Aktion",
                "add" => "Hinzufügen",
                "created_at" => "Erstellt am",
                "dashboard" => "Dashboard",
                "email" => "E-Mail",
                "enterprise" => "Unternehmen",
                "name" => "Name",
                "title" => "Benutzer",
                "type" => "Typ",
                "users" => "Benutzer"
            ],
            "show" => [
                "comments" => "Kommentare",
                "connect" => "Einloggen",
                "contact" => "Kontakt",
                "dashboard" => "Dashboard",
                "files" => "Dateien",
                "general_information" => "Allgemeine Informationen",
                "users" => "Benutzer"
            ]
        ]
    ]
];
