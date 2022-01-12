<?php
return [
    "milestone" => [
        "type" => [
            "annual" => "Jährlich",
            "biannual" => "Halbjährlich",
            "end_of_mission" => "Ende der Aufgabe",
            "monthly" => "Monatlich",
            "quarterly" => "Vierteljährlich",
            "weekly" => "Wöchentlich"
        ]
    ],
    "mission" => [
        "amount" => "Menge",
        "analytic_code" => "Analytischer Code",
        "analytic_code_placeholder" => "Beispiel: Az9Tr",
        "contract" => "Vertrag",
        "create_title" => "Aufgabe erstellen",
        "customer" => "Kunde",
        "date" => "Datum: :date",
        "date_label" => "Datum",
        "date_placeholder" => "TT/MM/JJJJ",
        "days" => "Tag",
        "delete_success" => "Augabe erfolgreich gelöscht",
        "dispute" => "Anfechten",
        "edit_title" => "Aufgabe ändern",
        "ends_at" => "Enddatum der Aufgabe",
        "ends_at_placeholder" => "TT/MM/JJJJ",
        "external_id" => "Kunden ID",
        "external_id_placeholder" => "Äußere Identifikator",
        "fixed_fees" => "Pauschale",
        "hours" => "Stunde",
        "id" => "Id",
        "inbound_invoice_item" => "Eingehende Rechnungspositionen",
        "outbound_invoice_item" => "Abgehende Rechnungspositionen",
        "price" => "Preis: :price €",
        "price_th" => "Preis",
        "profile" => [
            "diploma" => "Bildungsgrad",
            "job" => "Beruf",
            "job_placeholder" => "Beispiel: Berater",
            "languages" => "Sprache(n)",
            "mobility" => "Mobilität",
            "region" => "Land/Region",
            "should_provide_recommendations" => "Empfehlung",
            "skills" => "Kompetenzen",
            "years_of_experience" => "Berufserfahrung"
        ],
        "quantity" => "Menge",
        "quotation" => [
            "destroy" => [
                "error" => "Kostenvoranschlag könnte nicht gelöscht werden",
                "success" => "Kostenvoranschlag würde gelöscht"
            ],
            "save_date_estimation" => [
                "error" => "Fehler während Speicherung des besuchstermins!",
                "success" => "Besuchstermin würde erfolgreich abgespeichert!"
            ],
            "send" => [
                "error" => "Fehler während Erstellung dem Kostenvoranschlag",
                "success" => "Kostenvoranschlag würde erfolgreich erstellt"
            ],
            "store" => [
                "error" => "Die Erstellung des Kostenvoranschlags ist fehlgeschlagen",
                "success" => "Kostenvoranschlag würde erfolgreich erstellt"
            ],
            "update" => [
                "error" => "Kostenvoranschlag könnte nicht aktualisiert werden",
                "success" => "Kostenvoranschlag würde erfolgreich aktualisiert"
            ]
        ],
        "save_success" => "Aufgabe würde erfolgreich abgespeichert",
        "starts_at" => "Startdatum",
        "starts_at_desired" => "Erwünschtes Startdatum",
        "starts_at_placeholder" => "TT/MM/JJJJ",
        "status" => "Status",
        "status_abandoned" => "Aufgegeben",
        "status_accepted" => "Gültig erklärt",
        "status_answered" => "Geantwortet",
        "status_assigned" => "Zuordnen",
        "status_closed" => "Geschlossen",
        "status_communicated" => "Verteilt",
        "status_disputed" => "Ist gerade angefochten",
        "status_done" => "Fertig",
        "status_draft" => "Entwurf",
        "status_in_progress" => "Laufend",
        "status_paid" => "Bezahlt",
        "status_pending" => "Ausstehend",
        "status_ready_to_start" => "Aufgabe bestätigt",
        "status_refused" => "Abgelehnt",
        "status_to_pay" => "Zu bezahlen",
        "status_to_provide" => "Zu besetzen",
        "status_under_negociation" => "Verhandlung",
        "status_under_negotiation" => "Verhandlung",
        "title" => "Ihre Aufgaben",
        "tracking" => [
            "status" => ["pending" => "Ausstehend", "rejected" => "Abgelehnt", "validated" => "Bestätigt"]
        ],
        "unit" => "Einheit",
        "unit_days" => "Tage",
        "unit_days_short" => "Tage",
        "unit_fixed_fees" => "Pauschale",
        "unit_fixed_fees_short" => "Festpreis",
        "unit_hours" => "Stunden",
        "unit_hours_short" => "Stunden",
        "unit_price" => "Stückpreis",
        "user" => "Benutzer",
        "vendor" => "Dienstanbieter",
        "visit_date" => "Füllen Sie den Besuchstermin dem <br /> Einsatz, zum Endkunde aus",
        "visit_date_failed" => "Fehler während Speicherung des besuchstermins !",
        "visit_date_success" => "Besuchstermin würde erfolgreich abgespeichert!"
    ],
    "proposal" => [
        "details" => "Zusätzliche Informationen",
        "label" => "Zweck der Vorschlag",
        "need_quotation" => [
            "0" => "Nein",
            "1" => "Ja",
            "false" => "Nein",
            "label" => "Kostenvoranschlag verbindlich",
            "true" => "Ja"
        ],
        "send_invitation" => "Zum eingeladeten Dienstanbietern senden",
        "status" => [
            "abandoned" => "Aufgegeben",
            "accepted" => "Angenommen",
            "answered" => "Geantwortet",
            "assigned" => "Zugeordnet",
            "bpu_sended" => "EP-Liste abgeschickt",
            "draft" => "Entwurf",
            "interested" => "Betroffen",
            "received" => "Erhalten",
            "refused" => "Abgelehnt",
            "under_negotiation" => "Verhandlung"
        ],
        "valid_from" => "Startdatum des Vorschlags",
        "valid_from_placeholder" => "TT/MM/JJJJ",
        "valid_until" => "Ablaufdatum des Vorschlags",
        "valid_until_placeholder" => "TT/MM/JJJJ"
    ],
    "response" => [
        "reason_for_rejection" => [
            "answer_not_ok" => "Antwort passt nicht zum Bedürfnis",
            "ends_at_not_ok" => "Enddatum passt nicht zum Bedürfnis",
            "other" => "Anders",
            "quantity_not_ok" => "Menge passt nicht zum Bedürfnis",
            "starts_at_not_ok" => "Anfangsdatum passt nicht zum Bedürfnis",
            "unit_price_not_ok" => "Preis passt nicht zum Bedürfnis"
        ],
        "status" => [
            "final_validation" => "Abschlussgültigserklärung",
            "interview_positive" => "Positiver Austausch",
            "interview_requested" => "Austausch angefordert",
            "ok_to_meet" => "Austausch bestätigt",
            "pending" => "Ausstehend",
            "refused" => "Abgelehnt"
        ],
        "unit" => ["days" => "Tage", "fixed_fees" => "Pauschale", "hours" => "Stunde"]
    ],
    "tracking" => [
        "line" => [
            "reason_for_rejection" => [
                "error_amount" => "Fehler auf dem Betrag",
                "error_quantity" => "Fehler auf der Menge",
                "mission_not_completed" => "Aufgabe würde zum Teil geschafft",
                "mission_not_realized" => "Aufgabe würde nicht geschafft",
                "other" => "Anders"
            ]
        ],
        "pending" => "Ausstehend",
        "refused" => "Abgelehnt",
        "search_for_agreement" => "Vereinbarung suchen",
        "validated" => "Gültig erklärt"
    ]
];
