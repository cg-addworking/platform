<?php
return [
    "milestone" => [
        "type" => [
            "annual" => "Annuel",
            "biannual" => "Semestriel",
            "end_of_mission" => "Fin de mission",
            "monthly" => "Mensuel",
            "quarterly" => "Trimestriel",
            "weekly" => "Hebdomadaire"
        ]
    ],
    "mission" => [
        "amount" => "Qté",
        "analytic_code" => "Code analytique",
        "analytic_code_placeholder" => "Exemple: Az9Tr",
        "contract" => "Contrat",
        "create_title" => "Créer une mission",
        "customer" => "Client",
        "date" => "Date: :date",
        "date_label" => "Date",
        "date_placeholder" => "jj/mm/AAAA",
        "days" => "Jour",
        "delete_success" => "Mission supprimée avec succès",
        "dispute" => "Contester",
        "edit_title" => "Modifier la mission",
        "ends_at" => "Date de fin de la mission",
        "ends_at_placeholder" => "jj/mm/aaaa",
        "external_id" => "Identifiant client",
        "external_id_placeholder" => "Identifiant externe",
        "fixed_fees" => "forfait",
        "hours" => "heure",
        "id" => "Id",
        "inbound_invoice_item" => "Lignes de facture entrantes",
        "outbound_invoice_item" => "Lignes de facture sortantes",
        "price" => "Prix: :price €",
        "price_th" => "Prix",
        "profile" => [
            "diploma" => "Niveau d'étude",
            "job" => "Métier",
            "job_placeholder" => "Exemple : Consultant(e)",
            "languages" => "Langue(s)",
            "mobility" => "Mobilité",
            "region" => "Pays/Région",
            "should_provide_recommendations" => "Recommandation",
            "skills" => "Compétences",
            "years_of_experience" => "Expériences professionnelles"
        ],
        "quantity" => "Quantité",
        "quotation" => [
            "destroy" => [
                "error" => "Le devis n'a pas pu être supprimé",
                "success" => "Le devis est supprimé"
            ],
            "save_date_estimation" => [
                "error" => "Erreur lors de l'enregistrement de la date de visite!",
                "success" => "La date de visite a bien été enregistrée!"
            ],
            "send" => [
                "error" => "Erreur lors de la création du devis",
                "success" => "Devis créé avec succès"
            ],
            "store" => [
                "error" => "La création du devis a échouée",
                "success" => "Le devis a été créé avec succès"
            ],
            "update" => ["error" => "Le devis n'a pas pu être mis à jour", "success" => "Devis mis à jour"]
        ],
        "save_success" => "La mission a bien été enregistrée",
        "starts_at" => "Date de début",
        "starts_at_desired" => "Date de début souhaitée",
        "starts_at_placeholder" => "jj/mm/aaaa",
        "status" => "Statut",
        "status_abandoned" => "Abandonnée",
        "status_accepted" => "Acceptée",
        "status_answered" => "Répondu",
        "status_assigned" => "Assignée",
        "status_closed" => "Clôturée",
        "status_communicated" => "Diffusée",
        "status_disputed" => "En cours de contestation",
        "status_done" => "Terminée",
        "status_draft" => "Brouillon",
        "status_in_progress" => "En cours",
        "status_paid" => "Payé",
        "status_pending" => "En Attente",
        "status_ready_to_start" => "Bon Pour Démarrage",
        "status_refused" => "Refusée",
        "status_to_pay" => "À payer",
        "status_to_provide" => "À pourvoir",
        "status_under_negociation" => "Négociation",
        "status_under_negotiation" => "Négociation",
        "title" => "Vos missions",
        "tracking" => [
            "status" => ["pending" => "En attente", "rejected" => "Rejetée", "validated" => "Acceptée"]
        ],
        "unit" => "Unité",
        "unit_days" => "Jours",
        "unit_days_short" => "Jours",
        "unit_fixed_fees" => "Forfait",
        "unit_fixed_fees_short" => "Tarif fixe",
        "unit_hours" => "Heures",
        "unit_hours_short" => "Heures",
        "unit_price" => "Prix Unitaire",
        "user" => "Intervenant",
        "vendor" => "Prestataire",
        "visit_date" => "Renseigner la date de visite pour <br /> l'intervention, auprès du client final.",
        "visit_date_failed" => "Erreur lors de la sauvegarde de la date de visite !",
        "visit_date_success" => "La date de visite a bien été enregistrée !"
    ],
    "proposal" => [
        "details" => "Informations complémentaires",
        "label" => "Objet de la proposition",
        "need_quotation" => [
            "0" => "Non",
            "1" => "Oui",
            "false" => "Non",
            "label" => "Devis obligatoire",
            "true" => "Oui"
        ],
        "send_invitation" => "Envoyer aux prestataires invités",
        "status" => [
            "abandoned" => "Abandonné",
            "accepted" => "Accepté",
            "answered" => "Répondu",
            "assigned" => "Assigné",
            "bpu_sended" => "BPU transmis",
            "draft" => "Brouillon",
            "interested" => "Intéressé",
            "received" => "Reçu",
            "refused" => "Refusé",
            "under_negotiation" => "Négociation"
        ],
        "valid_from" => "Date de début de la proposition",
        "valid_from_placeholder" => "JJ/MM/AAAA",
        "valid_until" => "Date d'expiration de la proposition",
        "valid_until_placeholder" => "JJ/MM/AAAA"
    ],
    "response" => [
        "reason_for_rejection" => [
            "answer_not_ok" => "La réponse ne correspond pas au besoin",
            "ends_at_not_ok" => "La date de fin ne répond pas au besoin",
            "other" => "Autre",
            "quantity_not_ok" => "La quantité n'est pas alignée avec le besoin",
            "starts_at_not_ok" => "La date de démarrage ne répond pas au besoin",
            "unit_price_not_ok" => "Le prix ne répond pas au besoin"
        ],
        "status" => [
            "final_validation" => "Validation finale",
            "interview_positive" => "Échange positif",
            "interview_requested" => "Échange demandé",
            "ok_to_meet" => "Bon pour échange",
            "pending" => "En attente",
            "refused" => "Refusé"
        ],
        "unit" => ["days" => "Jour", "fixed_fees" => "Forfait", "hours" => "Heure"]
    ],
    "tracking" => [
        "line" => [
            "reason_for_rejection" => [
                "error_amount" => "Erreur sur le montant",
                "error_quantity" => "Erreur sur la quantité",
                "mission_not_completed" => "Mission réalisée partiellement",
                "mission_not_realized" => "Mission non réalisée",
                "other" => "Autre"
            ]
        ],
        "pending" => "En attente",
        "refused" => "Refusé",
        "search_for_agreement" => "Recherche d'accord",
        "validated" => "Validé"
    ]
];
