<?php
return [
    "outbound" => [
        "application" => [
            "views" => [
                "_actions" => [
                    "addworking_commissions" => "Provision für AddWorking",
                    "consult" => "Einsehen",
                    "create_credit_note_invoice" => "Eine Gutschrift erstellen",
                    "credit_lines" => "Gutgeschriebene Positionen",
                    "edit" => "Ändern",
                    "generate_pdf" => "PDF erstellen",
                    "invoice_lines" => "Rechnungspositionen",
                    "payment_orders" => "Zahlungsaufträge",
                    "supplier_invoice_included" => "Dienstanbieter-Rechnungen enthalten"
                ],
                "_breadcrumb" => [
                    "addworking_commission" => "Provision für AddWorking",
                    "addworking_commissions" => "Provision für AddWorking",
                    "addworking_invoices" => "AddWorking Rechnungen",
                    "calculate_commissions" => "Provision berechnen",
                    "create" => "Erstellen",
                    "create_credit_lines" => "Gutschriftspositionen erstellen",
                    "dashboard" => "Dashboard",
                    "edit" => "Ändern",
                    "generate_file" => "Datei erzeugen",
                    "invoice_number" => "Rechnung Nr.",
                    "number" => "Nr",
                    "provider_invoice" => "Dienstanbieterrechnungen"
                ],
                "_filter" => [
                    "bill_number" => "Rechnungsnummer",
                    "billing_period" => "Abrechnungszeitraum",
                    "due_date" => "Fälligkeitsdatum",
                    "filter" => "Filter",
                    "invoice_date" => "Ausstellungsdatum",
                    "payment_deadline" => "Zahlungsfrist",
                    "reset" => "Zurücksetzen",
                    "status" => "Status"
                ],
                "_form" => [
                    "billing_period" => "Abrechnungszeitraum",
                    "due_date" => "Fälligkeitsdatum",
                    "include_fees" => "Provision in der Rechnung angeben?",
                    "innvoice_date" => "Datum",
                    "invoice_date" => "Datum der Rechnungsausstellung",
                    "no" => "Nein",
                    "payment_deadline" => "Zahlungsfrist",
                    "yes" => "Ja"
                ],
                "_html" => [
                    "amount_excluding_taxes" => "Betrag ohne Steuern (Netto)",
                    "amount_including_taxes" => "Betrag einschließend alle Steuern (Brutto)",
                    "client" => "Kunde",
                    "copy_to_clipboard" => "In Zwischenablage kopieren",
                    "created_date" => "Erstellungsdatum",
                    "due_date" => "Fälligkeitsdatum",
                    "issue_date" => "Ausstellungsdatum",
                    "last_modified_date" => "Datum der letzten Änderung",
                    "legal_notice" => "Rechtliche Hinweise",
                    "number" => "Nummer",
                    "parent_invoice_number" => "Nummer der übergeordneten Rechnung",
                    "payment_order_date" => "Zahlungsdatum der Zahlungsaufträge",
                    "period" => "Zeitraum",
                    "received_by_assignment_daily" => "DAILLY Forderungsabtretung",
                    "reverse_vat" => "Reverse-Charge für MwSt.",
                    "status" => "Status",
                    "updated_by" => "Überarbeitet von ",
                    "uuid" => "UUID",
                    "validated_at" => "",
                    "validated_by" => "",
                    "vat_amount" => "Steuerbetrag (MwSt.)"
                ],
                "_status" => [
                    "fees_calculated" => "Berechnete Provision",
                    "file_generated" => "Erzeugte Datei",
                    "fully_paid" => "Voll bezahlt",
                    "partially_paid" => "Teilweise Bezahlt",
                    "pending" => "Ausstehend",
                    "validated" => "Bestätigt"
                ],
                "_table_head" => [
                    "action" => "Aktion",
                    "amount_ht" => "Nettopreis",
                    "bill_number" => "Rechnungsnummer",
                    "create_invoice" => "Rechnung erstellen",
                    "customer_visibility" => "Kundensichtbarkeit",
                    "deadline" => "Zahlungsfrist",
                    "does_not_have_invoices" => "Hat keine Rechnungen",
                    "due_at" => "Fälligkeitsdatum",
                    "invoiced_at" => "Ausstellungsdatum",
                    "month" => "Abrechnungszeitraum",
                    "status" => "Status",
                    "tax" => "Steuerbetrag",
                    "the_enterprise" => "Die Firma",
                    "total" => "Bruttopreis"
                ],
                "_table_row_empty" => [
                    "create_invoice" => "Rechnung erstellen",
                    "does_not_have_invoices" => "hat keine AddWorking Rechnungen.",
                    "the_enterprise" => "Die Firma"
                ],
                "associate" => [
                    "action" => "Aktion",
                    "amount_ht" => "Nettopreis",
                    "associate" => "Assoziieren",
                    "associate_selected_invoice" => "Ausgewählte Rechnungen assoziieren",
                    "billing_period" => "Abrechnungszeitraum",
                    "invoice_number" => "Rechnungsnummer",
                    "note" => "Hinweis: Der abzurechnende Restbetrag bezieht sich auf die Liste der Dienstanbieter-Rechnungen, die in keiner AddWorking Rechnung enthalten sind.",
                    "payment_deadline" => "Zahlungsfrist",
                    "remains_to_be_invoiced" => "Abzurechnender Restbetrag",
                    "return" => "Zurück",
                    "service_provider" => "Dienstanbieter",
                    "status" => "Status",
                    "text_1" => "hat keine zuzuordnenden Dienstanbieter-Rechnungen",
                    "text_2" => "fr den Zeitraum",
                    "text_3" => "Fälligkeit",
                    "the_enterprise" => "Die Firma",
                    "total" => "Bruttopreis"
                ],
                "create" => [
                    "create_invoice" => "Rechnung erstellen",
                    "create_invoice_for" => "Rechnung erstellen fr",
                    "return" => "Zurück"
                ],
                "dissociate" => [
                    "action" => "Aktion",
                    "amount_ht" => "Nettopreis",
                    "associate_invoice" => "Rechnungen zuordnen",
                    "billing_period" => "Abrechnungszeitraum",
                    "dissociate" => "Gruppierung aufheben",
                    "export" => "Export",
                    "invoice_number" => "Rechnungsnummer",
                    "payment_deadline" => "Zahlungsfrist",
                    "reset_invoice" => "Abzurechnender Restbetrag",
                    "return" => "Zurück",
                    "service_provider" => "Dienstanbieter",
                    "status" => "Status",
                    "text_1" => "hat keine Dienstanbieter-Rechnungen, deren Gruppierung aufgehoben werden kann",
                    "text_2" => "fr den Zeitraum",
                    "text_3" => "Fälligkeit",
                    "the_enterprise" => "Die Firma",
                    "title" => "Dienstanbieter-Rechnungen der Rechnung Nr.",
                    "total" => "Bruttopreis",
                    "ungroup_selected_invoice" => "Gruppierung der ausgewählten Rechnungen aufheben"
                ],
                "edit" => [
                    "edit_invoice" => "Rechnung bearbeiten",
                    "return" => "Zurück",
                    "status" => "Status",
                    "title" => "Rechnung Nr. bearbeiten"
                ],
                "fee" => [
                    "_actions" => ["confirm_delete" => "Löschung bestätigen?", "delete" => "Löschen"],
                    "_table_head" => [
                        "actions" => "Aktionen",
                        "amount" => "Betrag",
                        "label" => "Bezeichnung",
                        "number" => "Nummer",
                        "service_provider" => "Dienstanbieter",
                        "tax_amount_invoice_line" => "Nettobetrag der Rechnungsposition",
                        "type" => "Typ",
                        "vat_rate" => "Mehrwertsteuersatz"
                    ],
                    "_table_head_associate" => [
                        "actions" => "Aktionen",
                        "amount" => "Betrag",
                        "label" => "Bezeichnung",
                        "number" => "Nummer",
                        "service_provider" => "Dienstanbieter",
                        "tax_amount_invoice_line" => "Nettobetrag der Rechnungsposition",
                        "type" => "Typ",
                        "vat_rate" => "Mehrwertsteuersatz"
                    ],
                    "_table_head_credit_fees" => [
                        "actions" => "Aktionen",
                        "amount" => "Betrag",
                        "label" => "Bezeichnung",
                        "number" => "Nummer",
                        "service_provider" => "Dienstanbieter",
                        "tax_amount_invoice_line" => "Nettobetrag der Rechnungsposition",
                        "type" => "Typ",
                        "vat_rate" => "Mehrwertsteuersatz"
                    ],
                    "_table_row_associate" => ["cancel" => "Stornieren"],
                    "_type" => [
                        "custom_management_fees" => "Kostensätze (benutzerdefiniert)",
                        "default_management_fees" => "Kostensätze",
                        "discount" => "Rabatt",
                        "fixed_fees" => "Fixkosten",
                        "other" => "Andere",
                        "subscription" => "Abonnement"
                    ],
                    "associate_credit_fees" => [
                        "cancel_selected" => "Ausgewählte Provisionspositionen stornieren",
                        "return" => "Zurück",
                        "text_1" => "Die AddWorking Rechnung Nr.",
                        "text_2" => "enthält keine Provisionspositionen.",
                        "title" => "AddWorking Provisionspositionen stornieren"
                    ],
                    "calculate" => [
                        "calculate_commissions" => "Provision berechnen",
                        "return" => "Zurück",
                        "text_1" => "Die AddWorking Provision wird standardmäßig berechnet basierend auf der AddWorking Rechnung Nr.",
                        "text_2" => "Zu bearbeitende AddWorking Rechnung",
                        "title" => "Provision berechnen für AddWorking Rechnung Nr."
                    ],
                    "create" => [
                        "calculate_commissions" => "",
                        "create" => "Provision erstellen",
                        "return" => "Zurück",
                        "text_1" => "",
                        "text_2" => "",
                        "title" => "Provision hinzufügen für AddWorking Rechnung Nr."
                    ],
                    "index" => [
                        "calculate_commissions" => "Provision berechnen",
                        "create" => "Hinzufügen",
                        "export" => "Export",
                        "return" => "Zurück",
                        "text_1" => "Die AddWorking Rechnung Nr.",
                        "text_2" => "der Firma",
                        "text_3" => "enthält keine AddWorking Provision.",
                        "title" => "Provision der Rechnung Nr."
                    ],
                    "index_credit_fees" => [
                        "cancel_commissions" => "Provision stornieren",
                        "return" => "Zurück",
                        "title" => "Provision der Rechnung Nr."
                    ]
                ],
                "file" => [
                    "_annex" => [
                        "annex_details" => "Anhang: Angaben zu Subunternehmen",
                        "code_analytic" => "Analytischer Code",
                        "management_fees_ht" => "Verwaltungsgebühren netto",
                        "mission_code" => "Missions-Code",
                        "name" => "Name des Subunternehmers",
                        "price_ht" => "Nettopreis",
                        "ref_mission" => "Missionsref",
                        "subcontracter_code" => "Subunternehmercode",
                        "total_ht" => "Gesamt ohne Steuern",
                        "wording" => "Wortlaut"
                    ],
                    "_enterprises" => [
                        "addworking" => "ADDWORKING",
                        "contract_number" => "CPS1 Vertragsnummer",
                        "date" => "Datum:",
                        "france" => "Frankreich",
                        "invoice_number" => "Rechnung Nr",
                        "line_1" => "17 RUE LAC SAINT ANDRE",
                        "line_2" => "73370 LE BOURGET DU LAC",
                        "line_3" => "innergemeinschaftlich USt.-Id.Nr. : FR71810840900 00015",
                        "line_4" => "Vertreten durch Julien PERONA",
                        "line_5" => "DAILLY Forderungsabtretung",
                        "line_6" => "BPI FRANCE FINANCEMENT",
                        "of" => "Von:",
                        "parent_invoice_number" => "Nummer der übergeordneten Rechnung:"
                    ],
                    "_footer" => [
                        "addworking" => "ADDWORKING",
                        "line_1" => "Kapitalgesellschaft in vereinfachter Form mit Kapital von 143.645,00 € – RCS CHAMBERY 810 840 900 – Innergemeinschaftliche USt.-Id.Nr: FR71810840900 00015",
                        "line_2" => "17 rue du Lac Saint André – Savoie Technolac – BP 350 – 73370 Le Bourget du Lac – FRANKREICH",
                        "line_3" => "contact@addworking.com"
                    ],
                    "_header" => ["credit_note_invoice" => "Gutschrift Nr.", "invoice_number" => "Rechnung Nr"],
                    "_legal_notice" => [
                        "line_1" => "Reverse Charge für MwSt. – laut Artikel 242 h A, I-13 Anhang II des CGI (frz. Gesetzbuch zum Steuerrecht)",
                        "line_2" => "Schuldbefreiung tritt ein, wenn die Zahlung dieser Rechnung auf unser Konto bei BPI France Financement eingeht:",
                        "line_3" => "IBAN: CPMEFRPPXXX / FR76 1835 9000 4300 0202 5754 547",
                        "line_4" => "Nummer der Zweigstelle: 18359, Nummer Ansprechpartner: 00043, Kontonummer 00020257545, Schlüssel 47",
                        "line_5" => "BPI France Financement, Comptabilité Mouvements de fonds – Banques",
                        "line_6" => "27-31 avenue du Général Leclerc, 94710 Maisons-Alfort Cedex"
                    ],
                    "_lines" => [
                        "amount_ht" => "Nettopreis",
                        "line_1" => "ADDWORKING – Verwaltungsgebühren Dienstanbieter",
                        "line_2" => "ADDWORKING – Abonnementkosten",
                        "line_3" => "ADDWORKING -",
                        "line_4" => "Referenzierte Dienstanbieter",
                        "line_5" => "ADDWORKING – Rabatt",
                        "name" => "Name des Subunternehmers",
                        "period" => "Zeitraum",
                        "subcontracted_code" => "Subunternehmercode",
                        "subcontracter_code" => "Subunternehmercode"
                    ],
                    "_summary" => [
                        "amount" => "Betrag",
                        "benifits" => "NETTO DIENSTLEISTUNGEN",
                        "iban_for_transfer" => "IBAN für Überweisung",
                        "line_1" => "FR76 1835 9000 4300 0202 5754 547",
                        "management_fees_ht" => "Verwaltungsgebühren (netto)",
                        "payment_deadline" => "Zahlungsfrist",
                        "referrence" => "Hinweis zur Überweisung",
                        "total_ht" => "GESAMT Nettopreis",
                        "total_ttc" => "GESAMT Bruttopreis",
                        "total_vat" => "GESAMT MwSt.",
                        "vat" => "Bezeichnung",
                        "vat_summary" => "davon"
                    ]
                ],
                "generate_file" => [
                    "address" => "Rechnungsadresse des Kunden",
                    "generate_file" => "Datei erzeugen",
                    "legal_notice" => "Rechtliche Hinweise",
                    "received_by_assignment_daily" => "DAILLY Forderungsabtretung",
                    "return" => "Zurück",
                    "reverse_vat" => "Reverse-Charge für MwSt.",
                    "title" => "Datei erzeugen für Rechnung Nr."
                ],
                "index" => [
                    "create_invoice" => "Rechnung erstellen",
                    "text" => "hat keine AddWorking Rechnungen.",
                    "the_enterprise" => "Die Firma",
                    "title" => "AddWorking Rechnungen der Firma"
                ],
                "item" => [
                    "_actions" => ["confirm_delete" => "Löschung bestätigen?", "delete" => "Löschen"],
                    "_breadcrumb" => [
                        "addworking_invoices" => "AddWorking Rechnungen",
                        "create" => "Erstellen",
                        "dashboard" => "Dashboard",
                        "invoice_lines" => "Rechnungspositionen",
                        "invoice_number" => "Rechnung Nr"
                    ],
                    "_form" => [
                        "label" => "Bezeichnung",
                        "quantity" => "Menge",
                        "unit_price" => "Stückpreis",
                        "vat_rate" => "Mehrwertsteuersatz"
                    ],
                    "_table_head" => [
                        "action" => "Aktion",
                        "amount_ht" => "Nettobetrag",
                        "invoice_number" => "Rechnungsnummer",
                        "label" => "Bezeichnung",
                        "number" => "Nummer",
                        "quantity" => "Menge",
                        "service_provider" => "Dienstanbieter",
                        "unit_price" => "Stückpreis",
                        "vat_rate" => "Mehrwertsteuersatz"
                    ],
                    "associate_credit_line" => [
                        "action" => "Aktion",
                        "amount_ht" => "Nettobetrag",
                        "create" => "Erstellen",
                        "invoice_number" => "Rechnungsnummer",
                        "label" => "Bezeichnung",
                        "label_1" => "Gutschriftspositionen für ausgewählte Zeilen erstellen",
                        "number" => "Nummer",
                        "quantity" => "Menge",
                        "return" => "Zurück",
                        "service_provider" => "Dienstanbieter",
                        "text_1" => "Die AddWorking Rechnung Nr.",
                        "text_2" => "Hat keinen Rechnungspositionen",
                        "title" => "Gutschriftspositionen auswählen",
                        "unit_price" => "Stückpreis",
                        "vat_rate" => "Mehrwertsteuersatz"
                    ],
                    "create" => [
                        "create" => "Zeile erstellen",
                        "return" => "Zurück",
                        "title" => "Zeile fr die AddWorking Rechnung erstellen"
                    ],
                    "index" => [
                        "create" => "Zeile erstellen",
                        "create_new" => "Rechnungspositionen erstellen",
                        "return" => "Zurück",
                        "text_1" => "Die Firma",
                        "text_2" => "hat keine Rechnungspositionen",
                        "text_3" => "fr den Zeitraum",
                        "text_4" => "Fälligkeit",
                        "title" => "Positionen der Rechnung Nr."
                    ],
                    "index_credit_line" => [
                        "create" => "Eine Gutschriftsposition erstellen",
                        "lines_number" => "Positionen der Rechnung Nr.",
                        "return" => "Zurück"
                    ]
                ],
                "show" => [
                    "return" => "Zurück",
                    "text" => "Die Rechnungs-PDF wurde noch nicht erstellt",
                    "title" => "Rechnung Nr",
                    "validate" => "",
                    "vendor_invoices" => "Dienstanbieterrechnungen"
                ],
                "support" => [
                    "_breadcrumb" => ["addworking_invoices" => "AddWorking Rechnungen", "support" => "Unterstützung"],
                    "_filter" => [
                        "billing_period" => "Abrechnungszeitraum",
                        "enterprise" => "Unternehmen",
                        "filter" => "Filtern",
                        "filters" => "Filter",
                        "invoice_date" => "Ausstellungsdatum",
                        "invoice_number" => "Rechnungsnummer",
                        "payment_deadline" => "Fälligkeitsdatum",
                        "reset" => "Zurücksetzen",
                        "status" => "Status"
                    ],
                    "_table_head" => [
                        "action" => "Aktion",
                        "amount_ht" => "Nettobetrag",
                        "billing_period" => "Abrechnungszeitraum",
                        "customer_visibility" => "Kundensichtbarkeit",
                        "due_date" => "Ausstellungsdatum",
                        "enterprise" => "Unternehmen",
                        "invoice_date" => "Fälligkeitsdatum",
                        "invoice_number" => "Rechnungsnummer",
                        "payment_deadline" => "Zahlungsfrist",
                        "status" => "Status",
                        "tax_amount" => "Steuerbetrag",
                        "total_ttc" => "Bruttopreis"
                    ],
                    "index" => ["text" => "Keine AddWorking Rechnung."]
                ]
            ]
        ]
    ]
];
