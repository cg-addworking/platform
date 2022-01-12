<?php
return [
    "_actions" => [
        "create_contract" => "Neuen Vertrag erstellen",
        "delete" => "Supprimer",
        "edit" => "Ändern",
        "link_contract" => "Einen bestehenden Vertrag verbinden"
    ],
    "_breadcrumb" => [
        "create" => "Erstellen",
        "dashboard" => "Management-Dashboard",
        "edit" => "Ändern",
        "index" => "Aufträge",
        "workfields" => "Baustellen"
    ],
    "_status" => [
        "abandoned" => "Abgebrochen",
        "closed" => "Geschlossen",
        "done" => "Beendet",
        "draft" => "Entwurf",
        "in_progress" => "In Bearbeitung",
        "ready_to_start" => "Start genehmigt"
    ],
    "construction" => [
        "_form" => [
            "amount" => "Betrag",
            "analytic_code" => "Analytischer Code",
            "cost_estimation" => [
                "amount_before_taxes" => "Nettopreis",
                "file" => "Datei",
                "title" => "Kostenvoranschlag"
            ],
            "departments" => "Standort(e)",
            "description" => "Beschreibung der in Auftrag gegebenen Aufgaben",
            "ends_at" => "Enddatum",
            "enterprises" => "Betroffener Kunde",
            "external_id" => "Missions-Code",
            "files" => "Datei(en)",
            "general_information" => "Informationen",
            "label" => "Zweck der Aufgabe",
            "referents" => "Ansprechpartner",
            "starts_at" => "Anfangsdatum",
            "vendors" => "Betroffener Dienstanbieter",
            "workfield" => "Baustelle"
        ],
        "_html" => [
            "amount" => "Auftragsbetrag",
            "analytical_code" => "Analytischer Code",
            "cost_estimation" => ["amount_before_taxes" => "Betrag des Kostenvoranschlags"],
            "customer" => "Betroffenes Unternehmen",
            "departments" => "Abteilungen",
            "description" => "Beschreibung",
            "end_date" => "Enddatum",
            "external_id" => "Kennung",
            "location" => "Arbeitsbereich(e)",
            "referent" => "Ansprechpartner",
            "start_date" => "Anfangsdatum",
            "status" => "Status",
            "tabs" => [
                "additional_documents" => "Sonstige Unterlagen",
                "cost_estimation_document" => "Dokumente des Kostenvoranschlags"
            ],
            "vendor" => "Zugewiesener Dienstanbieter",
            "workfield" => "Baustelle"
        ]
    ],
    "create" => [
        "mission_vendor_id_required" => "Das Feld „betroffener Dienstanbieter“ muss ausgefüllt werden",
        "no_selection" => "Keine Auswahl",
        "return" => "Zurück",
        "save_as_draft" => "Entwurf speichern",
        "submit" => "Erstellen",
        "title" => "Neuer Auftrag"
    ],
    "edit" => ["return" => "Zurück", "submit" => "Ändern", "title" => "Auftrag ändern"],
    "show" => [
        "contractualize" => "Diesen Auftrag vertraglich vereinbaren",
        "create_contract" => "Vertrag erstellen",
        "link_contract" => "Mit einem bestehenden Vertrag verbinden",
        "return" => "Zurück",
        "submit_signed_contract" => "Einen bereits unterzeichneten Vertrag einreichen"
    ]
];
