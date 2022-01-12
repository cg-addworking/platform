<?php
return [
    "folder" => ["0" => "Non", "1" => "Oui"],
    "infrastructure" => [
        "export" => [
            "application" => [
                "views" => [
                    "export" => [
                        "_actions" => ["download" => "Télécharger"],
                        "_breadcrumb" => ["dashboard" => "Dashboard", "index" => "Exports"],
                        "_status" => [
                            "failed" => "Echec de la génération",
                            "generated" => "Généré",
                            "generation_processing" => "Génération en cours"
                        ],
                        "_table_head" => [
                            "actions" => "Actions",
                            "created_at" => "Date de création",
                            "filters" => "Filtres",
                            "finished_at" => "Date de fin d'export",
                            "name" => "Nom",
                            "status" => "Statut"
                        ],
                        "build_csv" => [
                            "csv_is_building" => "Votre export est en cours de génération. Retrouvez vos documents dans la section exports du menu à gauche."
                        ],
                        "index" => ["title" => "Vos exports"]
                    ]
                ]
            ]
        ],
        "search" => [
            "views" => [
                "operators" => ["contains" => "contient", "equal" => "est", "search" => "Rechercher"]
            ]
        ]
    ]
];
