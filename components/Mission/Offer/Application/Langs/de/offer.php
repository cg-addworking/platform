<?php
return [
    "_actions" => ["delete" => "Löschen", "edit" => "Ändern", "show" => "Zugreifen"],
    "_breadcrumb" => [
        "create" => "Erstellen",
        "dashboard" => "Management-Dashboard",
        "edit" => "Ändern",
        "index" => "Auftragsangebote",
        "offer" => ":label",
        "send_to_enterprise" => "Angebot verteilen",
        "workfields" => "Baustellen"
    ],
    "_filters" => [
        "customer" => "Kunde",
        "referent" => "Ansprechpartner",
        "reset" => "Zurücksetzen",
        "status" => "Status",
        "submit" => "Filtern"
    ],
    "_status" => [
        "abandoned" => "Abgebrochen",
        "closed" => "Abgeschlossen",
        "communicated" => "Verteilt",
        "draft" => "Entwurf",
        "to_provide" => "Zu vergeben"
    ],
    "_table_head" => [
        "actions" => "Aktionen",
        "created_at" => "Datum der Erstellung",
        "customer" => "Kunde",
        "label" => "Gegenstand des Angebots",
        "referent" => "Ansprechpartner",
        "status" => "Status"
    ],
    "construction" => [
        "_form" => [
            "analytic_code" => "Analytischer Code",
            "asked_skills" => "Gewünschte Kompetenzen",
            "departments" => "Standort",
            "description" => "Beschreibung der in Auftrag gegebenen Aufgaben",
            "ends_at" => "Enddatum",
            "enterprises" => "Betroffenes Unternehmen",
            "external_id" => "Angebotscode",
            "file" => "Datei:",
            "files" => "Datei(en)",
            "general_information" => "Informationen",
            "label" => "Gegenstand des Angebots",
            "referents" => "Ansprechpartner (der Empfänger der Antworten)",
            "response_deadline" => "Antwortfrist",
            "starts_at_desired" => "Gewünschter Beginn",
            "workfield" => "Baustelle"
        ],
        "_html" => [
            "analytical_code" => "Analytischer Code",
            "customer" => "Betroffenes Unternehmen",
            "departments" => "Abteilungen",
            "description" => "Beschreibung der in Auftrag gegebenen Aufgaben",
            "end_date" => "Enddatum",
            "external_id" => "Kennung",
            "have_response" => "Beantwortet",
            "location" => "Arbeitsbereich(e)",
            "no_recipients" => "Kein Empfänger",
            "referent" => "Ansprechpartner",
            "response_deadline" => "Antwortfrist",
            "sended_at" => "Verbreitet am: ",
            "skills" => "Gewünschte Kompetenzen",
            "start_date" => "Gewünschter Beginn",
            "status" => "Status",
            "tabs" => [
                "additional_documents" => "Sonstige Unterlagen",
                "info" => "Allgemeine Informationen",
                "recipients" => "Empfänger"
            ],
            "waiting_response" => "Warten auf Antwort",
            "workfield" => "Baustelle"
        ]
    ],
    "create" => [
        "return" => "Zurück",
        "save_as_draft" => "Entwurf speichern",
        "submit" => "Erstellen",
        "title" => "Neues Auftragsangebot"
    ],
    "edit" => ["return" => "Zurück", "submit" => "Ändern", "title" => "Ändern"],
    "index" => [
        "return" => "Zurück",
        "search" => [
            "customer_name" => "Unternehmen",
            "label" => "Gegenstand des Angebots",
            "referent_lastname" => "Ansprechpartner (Name)"
        ],
        "title" => "Auftragsangebote"
    ],
    "send_to_enterprise" => [
        "edit_response_deadline" => "Die Antwortfrist ist abgelaufen, bitte legen Sie eine neue fest.",
        "email" => [
            "access_proposal" => "Auf das Angebot zugreifen",
            "client" => "Kunde",
            "description" => "Beschreibung",
            "details" => "Auftragsangebotsdetails",
            "end_of_mission" => "Auftragsende",
            "hello" => "Hallo",
            "location" => "Standort",
            "purpose" => "Gegenstand des Auftrags",
            "start_of_mission" => "Auftragsbeginn",
            "text_line2" => "Wir teilen Ihnen mit, dass Sie ein neues Auftragsangebot erhalten haben von der Firma ",
            "text_line3" => "Sie können die Details in Ihrem AddWorking-Bereich einsehen."
        ],
        "record" => "Speichern",
        "reset" => "Zurücksetzen",
        "response_deadline" => "Antwortfrist",
        "return" => "Zurück",
        "search" => "Suchen",
        "sended" => "Bereits abgeschickt",
        "skill" => "Kompetenz",
        "skills" => "Kompetenz(en)",
        "submit" => "Verteilen",
        "title" => "Angebot verteilt: ",
        "vendor" => "Dienstanbieter",
        "vendor_skills_no_ok_msg" => "Dieser Dienstanbieter verfügt über keine der im Auftragsangebot geforderten Kompetenzen",
        "vendor_skills_ok_msg" => "Dieser Dienstanbieter verfügt über mindestens eine der im Auftragsangebot geforderten Kompetenzen"
    ],
    "show" => [
        "close_offer" => "Angebot schließen",
        "confirm_closing_offer" => "Dieses Auftragsangebot schließen?",
        "no_possible_response" => "Sie können nicht mehr auf dieses Angebot antworten. Entweder wurde das Auftragsangebot geschlossen oder die Antwortfrist ist abgelaufen.",
        "respond" => "Auf das Angebot antworten",
        "responses" => "Antworten einsehen",
        "return" => "Zurück",
        "send_to_enterprise" => "Angebot verteilen"
    ]
];
