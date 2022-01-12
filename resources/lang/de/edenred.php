<?php
return [
    "common" => [
        "average_daily_rate" => [
            "_actions" => [
                "actions" => "Aktionen",
                "code" => "Code",
                "consult" => "Einsehen",
                "edit" => "Ändern",
                "remove" => "Löschen"
            ],
            "_form" => [
                "general_information" => "Allgemeine Informationen",
                "rate" => "Satz",
                "service_provider" => "Dienstanbieter"
            ],
            "_html" => ["code" => "Code", "rate" => "Satz", "service_provider" => "Dienstanbieter"],
            "create" => [
                "average_daily_rate" => "Mittlerer Tagessatz (MTS)",
                "codes" => "Codes",
                "create" => "Erstellen",
                "create_average_daily_rate" => "Einen mittleren Tagessatz erstellen",
                "create_average_daily_rate_for" => "Einen mittleren Tagessatz erstellen für",
                "dashboard" => "Dashboard",
                "return" => "Zurück"
            ],
            "edit" => [
                "average_daily_rate" => "Mittlerer Tagessatz",
                "change_code_rate" => "Satz des Codes ändern",
                "codes" => "Codes",
                "dashboard" => "Dashboard",
                "edit" => "Ändern",
                "for" => "für",
                "register" => "Abspeichern",
                "return" => "Zurück"
            ],
            "index" => [
                "actions" => "Aktionen",
                "add" => "Hinzufügen",
                "average_daily_rate" => "Mittlerer Tagessatz (MTS)",
                "average_daily_rates_for" => "Mittlere Tagessätze für",
                "codes" => "Codes",
                "created_at" => "Erstellt am",
                "dashboard" => "Dashboard",
                "rate" => "Satz",
                "service_provider" => "Dienstanbieter"
            ],
            "show" => [
                "average_daily_code_rate" => "Mittlerer Tagessatz des Codes",
                "average_daily_rate" => "Mittlerer Tagessatz",
                "codes" => "Codes",
                "dashboard" => "Dashboard",
                "for" => "für",
                "return" => "Zurück"
            ]
        ],
        "code" => [
            "_actions" => [
                "actions" => "Aktionen",
                "average_daily_rates" => "Mittlere Tagessätze",
                "confirm_delete" => "Löschung bestätigen?",
                "consult" => "Einsehen",
                "edit" => "Ändern",
                "remove" => "Löschen",
                "skill" => "Kompetenz"
            ],
            "_form" => [
                "bussiness_competence" => "Trades & Skills",
                "code" => "Code",
                "general_information" => "Allgemeine Informationen",
                "level" => "Niveau"
            ],
            "_html" => [
                "competence" => "Kompetenz",
                "last_name" => "Name",
                "level" => "Niveau",
                "skill" => "Beruf"
            ],
            "create" => [
                "codes" => "Codes",
                "create" => "Erstellen",
                "create_code" => "Einen Code erstellen",
                "create_new_code" => "Neuen Code erstellen",
                "dashboard" => "Dashboard",
                "return" => "Zurück"
            ],
            "edit" => [
                "codes" => "Codes",
                "dashboard" => "Dashboard",
                "edit" => "Ändern",
                "edit_code" => "Code ändern",
                "register" => "Abspeichern",
                "return" => "Zurück"
            ],
            "index" => [
                "actions" => "Aktionen",
                "add" => "Hinzufügen",
                "code" => "Code",
                "code_catalog" => "Code-Katalog",
                "codes" => "Codes",
                "created_at" => "Erstellt am",
                "dashboard" => "Dashboard",
                "job" => "Beruf",
                "providers" => "Dienstanbieter",
                "skill" => "Kompetenz"
            ]
        ]
    ],
    "mission" => [
        "offer" => ["create" => ["assignment_purpose" => "Zweck der Aufgabe", "client" => "Kunde"]],
        "profile" => [
            "create" => [
                "already_sent" => "Bereits gesendet",
                "enterprise" => "Unternehmen",
                "esn_on_mission_code" => "Auf diesem Missions-Code positioniertes IT-Serviceunternehmen"
            ]
        ],
        "proposal_response" => [
            "index" => [
                "actions" => "Aktionen",
                "created_at" => "Erstellt am",
                "reference_tjm" => "Referenz-MTS",
                "service_provider" => "Dienstanbieter",
                "status" => "Status",
                "tjm_proposed" => "Vorgeschlagener MTS"
            ]
        ]
    ],
    "user" => [
        "passwork" => ["create" => ["edenred_passwork" => "Dies hier ist das EDENRED Passwork"]]
    ]
];
