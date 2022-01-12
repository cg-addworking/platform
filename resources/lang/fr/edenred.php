<?php
return [
    "common" => [
        "average_daily_rate" => [
            "_actions" => [
                "actions" => "Actions",
                "code" => "Code",
                "consult" => "Consulter",
                "edit" => "Modifier",
                "remove" => "Supprimer"
            ],
            "_form" => [
                "general_information" => "Informations Générales",
                "rate" => "Taux",
                "service_provider" => "Prestataire"
            ],
            "_html" => ["code" => "Code", "rate" => "Taux", "service_provider" => "Prestataire"],
            "create" => [
                "average_daily_rate" => "Taux Journalier Moyen (TJM)",
                "codes" => "Codes",
                "create" => "Créer",
                "create_average_daily_rate" => "Créer un taux journalier moyen",
                "create_average_daily_rate_for" => "Créer un taux journalier moyen pour",
                "dashboard" => "Tableau de bord",
                "return" => "Retour"
            ],
            "edit" => [
                "average_daily_rate" => "Taux Journalier Moyen",
                "change_code_rate" => "Modifier le taux du code",
                "codes" => "Codes",
                "dashboard" => "Tableau de bord",
                "edit" => "Modifier",
                "for" => "pour",
                "register" => "Enregistrer",
                "return" => "Retour"
            ],
            "index" => [
                "actions" => "Actions",
                "add" => "Ajouter",
                "average_daily_rate" => "Taux Journalier Moyen (TJR)",
                "average_daily_rates_for" => "Taux journaliers moyens pour",
                "codes" => "Codes",
                "created_at" => "Créé le",
                "dashboard" => "Tableau de bord",
                "rate" => "Taux",
                "service_provider" => "Prestataire"
            ],
            "show" => [
                "average_daily_code_rate" => "Taux journalier moyen du code",
                "average_daily_rate" => "Taux Journalier Moyen",
                "codes" => "Codes",
                "dashboard" => "Tableau de bord",
                "for" => "pour",
                "return" => "Retour"
            ]
        ],
        "code" => [
            "_actions" => [
                "actions" => "Actions",
                "average_daily_rates" => "Taux Journaliers Moyens",
                "confirm_delete" => "Confirmer la suppression ?",
                "consult" => "Consulter",
                "edit" => "Modifier",
                "remove" => "Supprimer",
                "skill" => "Compétence"
            ],
            "_form" => [
                "bussiness_competence" => "Métiers & Compétences",
                "code" => "Code",
                "general_information" => "Informations Générales",
                "level" => "Niveau"
            ],
            "_html" => [
                "competence" => "Compétence",
                "last_name" => "Nom",
                "level" => "Niveau",
                "skill" => "Métier"
            ],
            "create" => [
                "codes" => "Codes",
                "create" => "Créer",
                "create_code" => "Créer un code",
                "create_new_code" => "Créer un nouveau code",
                "dashboard" => "Tableau de bord",
                "return" => "Retour"
            ],
            "edit" => [
                "codes" => "Codes",
                "dashboard" => "Tableau de bord",
                "edit" => "Modifier",
                "edit_code" => "Modifier le code",
                "register" => "Enregistrer",
                "return" => "Retour"
            ],
            "index" => [
                "actions" => "Actions",
                "add" => "Ajouter",
                "code" => "Code",
                "code_catalog" => "Catalogue des codes",
                "codes" => "Codes",
                "created_at" => "Créé le",
                "dashboard" => "Tableau de bord",
                "job" => "Métier",
                "providers" => "Prestataires",
                "skill" => "Compétence"
            ]
        ]
    ],
    "mission" => [
        "offer" => [
            "create" => ["assignment_purpose" => "Objet de la mission", "client" => "Client"]
        ],
        "profile" => [
            "create" => [
                "already_sent" => "Déjà envoyé",
                "enterprise" => "Entreprise",
                "esn_on_mission_code" => "ESN positionnée sur ce code mission"
            ]
        ],
        "proposal_response" => [
            "index" => [
                "actions" => "Actions",
                "created_at" => "Créé le",
                "reference_tjm" => "TJM de référence",
                "service_provider" => "Prestataire",
                "status" => "Statut",
                "tjm_proposed" => "TJM proposé"
            ]
        ]
    ],
    "user" => [
        "passwork" => ["create" => ["edenred_passwork" => "Je suis le passwork EDENRED"]]
    ]
];
