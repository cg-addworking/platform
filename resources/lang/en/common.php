<?php
return [
    "folder" => ["0" => "No", "1" => "Yes"],
    "infrastructure" => [
        "export" => [
            "application" => [
                "views" => [
                    "export" => [
                        "_actions" => ["download" => "Download"],
                        "_breadcrumb" => ["dashboard" => "Dashboard", "index" => "Exports"],
                        "_status" => [
                            "failed" => "Failed to generate",
                            "generated" => "Generated",
                            "generation_processing" => "Generation in progress"
                        ],
                        "_table_head" => [
                            "actions" => "Actions",
                            "created_at" => "Creation date",
                            "filters" => "Filters",
                            "finished_at" => "Export end date",
                            "name" => "Name",
                            "status" => "Status"
                        ],
                        "build_csv" => [
                            "csv_is_building" => "Your export is being generated. Retrieve your documents from the exports section of the menu on the left."
                        ],
                        "index" => ["title" => "Your exports"]
                    ]
                ]
            ]
        ],
        "search" => [
            "views" => ["operators" => ["contains" => "contain", "equal" => "is", "search" => "Search"]]
        ]
    ]
];
