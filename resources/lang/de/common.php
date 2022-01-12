<?php
return [
    "folder" => ["0" => "Nein", "1" => "Ja"],
    "infrastructure" => [
        "export" => [
            "application" => [
                "views" => [
                    "export" => [
                        "_actions" => ["download" => "Herunterladen"],
                        "_breadcrumb" => ["dashboard" => "Dashboard", "index" => "Exports"],
                        "_status" => [
                            "failed" => "Fehl von Generierung",
                            "generated" => "Generiert",
                            "generation_processing" => "Ablaufende Generierung"
                        ],
                        "_table_head" => [
                            "actions" => "Aktionen",
                            "created_at" => "Erstellungsdatum",
                            "filters" => "Filter",
                            "finished_at" => "Export Endzeitpunkt",
                            "name" => "Name",
                            "status" => "Status"
                        ],
                        "build_csv" => [
                            "csv_is_building" => "Ihrer Export ist gerade im Generierung. Ihre Dokumente befinden sich links in dem Bereich Exports."
                        ],
                        "index" => ["title" => "Ihre Exports"]
                    ]
                ]
            ]
        ],
        "search" => [
            "views" => ["operators" => ["contains" => "enthält", "equal" => "ist", "search" => "Suchen"]]
        ]
    ]
];
