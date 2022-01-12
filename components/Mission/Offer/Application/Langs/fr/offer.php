<?php
return [
    "_actions" => ["delete" => "Supprimer", "edit" => "Modifier", "show" => "Consulter"],
    "_breadcrumb" => [
        "create" => "Créer",
        "dashboard" => "Tableau de bord",
        "edit" => "Modifier",
        "index" => "Offres de mission",
        "offer" => ":label",
        "send_to_enterprise" => "Diffuser l'offre",
        "workfields" => "Chantiers"
    ],
    "_filters" => [
        "customer" => "Client",
        "referent" => "Référent",
        "reset" => "Réinitialiser",
        "status" => "Statut",
        "submit" => "Filtrer"
    ],
    "_status" => [
        "abandoned" => "Abandonnée",
        "closed" => "Clôturée",
        "communicated" => "Diffusée",
        "draft" => "Brouillon",
        "to_provide" => "À pourvoir"
    ],
    "_table_head" => [
        "actions" => "Actions",
        "created_at" => "Date de création",
        "customer" => "Client",
        "label" => "Objet de l'offre",
        "referent" => "Référent",
        "status" => "Statut"
    ],
    "construction" => [
        "_form" => [
            "analytic_code" => "Code analytique",
            "asked_skills" => "Compétences souhaitées",
            "departments" => "Lieu",
            "description" => "Descriptif des travaux confiés",
            "ends_at" => "Date de fin",
            "enterprises" => "Entreprise concernée",
            "external_id" => "Code de l'offre",
            "file" => "Fichier:",
            "files" => "Fichier(s)",
            "general_information" => "Informations",
            "label" => "Objet de l'offre",
            "referents" => "Référent (qui sera destinataire des réponses)",
            "response_deadline" => "Date limite de réponse",
            "starts_at_desired" => "Date de début souhaitée",
            "workfield" => "Chantier"
        ],
        "_html" => [
            "analytical_code" => "Code analytique",
            "customer" => "Entreprise concernée",
            "departments" => "Départements",
            "description" => "Descriptif des travaux confiés",
            "end_date" => "Date de fin",
            "external_id" => "Identifiant",
            "have_response" => "Répondu",
            "location" => "Département(s) d'intervention",
            "no_recipients" => "Aucun destinataire",
            "referent" => "Référent",
            "response_deadline" => "Date limite de réponse",
            "sended_at" => "Diffusée le : ",
            "skills" => "Compétences souhaitées",
            "start_date" => "Date de début souhaitée",
            "status" => "Statut",
            "tabs" => [
                "additional_documents" => "Documents complémentaires",
                "info" => "Informations générales",
                "recipients" => "Destinataires"
            ],
            "waiting_response" => "En attente de réponse",
            "workfield" => "Chantier"
        ]
    ],
    "create" => [
        "return" => "Retour",
        "save_as_draft" => "Enregistrer en brouillon",
        "submit" => "Créer",
        "title" => "Nouvelle offre de mission"
    ],
    "edit" => ["return" => "Retour", "submit" => "Modifier", "title" => "Modifier"],
    "index" => [
        "return" => "Retour",
        "search" => [
            "customer_name" => "Entreprise",
            "label" => "Objet de l'offre",
            "referent_lastname" => "Référent (Nom)"
        ],
        "title" => "Offres de missions"
    ],
    "send_to_enterprise" => [
        "edit_response_deadline" => "La date limite de réponse est dépassée, veuillez en définir une nouvelle.",
        "email" => [
            "access_proposal" => "Accéder à la proposition",
            "client" => "Client",
            "description" => "Description",
            "details" => "Détails de l'offre de mission",
            "end_of_mission" => "Fin de la mission",
            "hello" => "Bonjour",
            "location" => "Lieu",
            "purpose" => "Objet de l'offre mission",
            "start_of_mission" => "Début de la mission",
            "text_line2" => "Nous vous informons que vous avez reçu une nouvelle proposition de mission de la part de la société",
            "text_line3" => "Vous pouvez consulter le détail sur votre espace AddWorking."
        ],
        "record" => "Enregistrer",
        "reset" => "Réinitialiser",
        "response_deadline" => "La date limite de réponse",
        "return" => "Retour",
        "search" => "Rechercher",
        "sended" => "Déjà envoyée",
        "skill" => "Compétence",
        "skills" => "Compétence(s)",
        "submit" => "Diffuser",
        "title" => "Diffuser l'offre : ",
        "vendor" => "Prestataire",
        "vendor_skills_no_ok_msg" => "Ce prestataire ne dispose d'aucune des compétences demandées dans l'offre de mission",
        "vendor_skills_ok_msg" => "Ce prestataire dispose au minimum d'une des compétences demandées dans l'offre de mission"
    ],
    "show" => [
        "close_offer" => "Clôturer l'offre",
        "confirm_closing_offer" => "Clôturer cette offre de mission ?",
        "no_possible_response" => "Vous ne pouvez plus répondre à cette offre. Soit l'offre de réponse est cloturée soit la date limite de réponse est expirée.",
        "respond" => "Répondre à l'offre",
        "responses" => "Voir les réponses",
        "return" => "Retour",
        "send_to_enterprise" => "Diffuser l'offre"
    ]
];
