<?php
return [
    "_actions" => [
        "create_contract" => "Créer un nouveau contrat",
        "delete" => "Supprimer",
        "edit" => "Modifier",
        "link_contract" => "Lier un contrat existant"
    ],
    "_breadcrumb" => [
        "create" => "Créer",
        "dashboard" => "Tableau de bord",
        "edit" => "Modifier",
        "index" => "Missions",
        "workfields" => "Chantiers"
    ],
    "_status" => [
        "abandoned" => "Abandonnée",
        "closed" => "Fermée",
        "done" => "Terminée",
        "draft" => "Brouillon",
        "in_progress" => "En cours",
        "ready_to_start" => "Bon Pour Démarrage"
    ],
    "construction" => [
        "_form" => [
            "amount" => "Montant",
            "analytic_code" => "Code analytique",
            "cost_estimation" => ["amount_before_taxes" => "Prix HT", "file" => "Fichier", "title" => "Devis"],
            "departments" => "Lieu(s)",
            "description" => "Descriptif des travaux confiés",
            "ends_at" => "Date de fin",
            "enterprises" => "Client concerné",
            "external_id" => "Code mission",
            "files" => "Fichier(s)",
            "general_information" => "Informations",
            "label" => "Objet de la mission",
            "referents" => "Référent",
            "starts_at" => "Date de début",
            "vendors" => "Prestataire concerné",
            "workfield" => "Chantier"
        ],
        "_html" => [
            "amount" => "Montant de la mission",
            "analytical_code" => "Code analytique",
            "cost_estimation" => ["amount_before_taxes" => "Montant du devis"],
            "customer" => "Entreprise concernée",
            "departments" => "Départements",
            "description" => "Description",
            "end_date" => "Date de fin",
            "external_id" => "Identifiant",
            "location" => "Département(s) d'intervention",
            "referent" => "Référent",
            "start_date" => "Date de début",
            "status" => "Statut",
            "tabs" => [
                "additional_documents" => "Documents complémentaires",
                "cost_estimation_document" => "Documents de devis"
            ],
            "vendor" => "Prestataire assigné",
            "workfield" => "Chantier"
        ]
    ],
    "create" => [
        "mission_vendor_id_required" => "Le champ \"prestataire concerné\" est obligatoire",
        "no_selection" => "Aucune sélection",
        "return" => "Retour",
        "save_as_draft" => "Enregistrer en brouillon",
        "submit" => "Créer",
        "title" => "Nouvelle mission"
    ],
    "edit" => ["return" => "Retour", "submit" => "Modifier", "title" => "Modifier la mission"],
    "show" => [
        "contractualize" => "Contractualiser cette mission",
        "create_contract" => "Créer un contrat",
        "link_contract" => "Lier à un contrat existant",
        "return" => "Retour",
        "submit_signed_contract" => "Déposer un contrat déjà signé"
    ]
];
