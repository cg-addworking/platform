<?php
return [
    "_actions" => ["show" => "Consulter"],
    "_breadcrumb" => ["dashboard" => "Dashboard", "index" => "Companies", "show" => "N° :short_id"],
    "filters" => ["identification_number" => "Numéro d'identification", "name" => "Dénomination"],
    "index" => [
        "actions" => "Actions",
        "dashboard" => "Tableau de bord",
        "enterprise" => "Entreprises",
        "identification_number" => "Numéro d'identification",
        "name" => "Dénomination",
        "return" => "Retour"
    ],
    "show" => [
        "company" => [
            "card_title" => "Informations générales",
            "cessation_date" => "Date de cessation",
            "creation_date" => "Date de création",
            "identification_number" => "Numéro d'identification",
            "is_sole_shareholder" => "Actionnaire unique",
            "last_updated_at" => "Date de dernière mise à jour",
            "legal_form" => "Forme juridique",
            "origin_data" => "Origine de l'information",
            "share_capital" => "Capital social",
            "short_id" => "Numéro AddWorking"
        ],
        "company_activities" => [
            "card_title" => "Activité(s)",
            "code" => "Code activité",
            "domaine" => "Domaine activité",
            "ends_at" => "Date fin",
            "name" => "Libellé de l'activité",
            "origin_data" => "Origine de l'information",
            "sector_display_name" => "Secteur activité (AddWorking)",
            "social_object" => "Object social",
            "starts_at" => "Date debut"
        ],
        "company_employees" => [
            "card_title" => "Effectif",
            "employee" => "salarié",
            "number" => "Nombre d'employé",
            "origin_data" => "Origine de l'information",
            "range" => "Tranche",
            "year" => "Année"
        ],
        "company_establishments" => [
            "address" => "Adresse",
            "card_title" => "Établissement(s)",
            "cessation_date" => "Fermé depuis",
            "commercial_name" => "Nom commercial",
            "creation_date" => "Crée le",
            "establishment_name" => "Nom",
            "establishments" => "Établissement(s)",
            "identification_number" => "Numéro d'identification",
            "is_headquarter" => "Établissement Siège",
            "origin_data" => "Origine de l'information",
            "sirene" => "Avis de situation SIRENE",
            "societecom" => "Societé.com"
        ],
        "company_legal_representatives" => [
            "address" => "Adresse",
            "birth_date" => "Date de naissance : ",
            "card_title" => "Représentants legaux",
            "city_birth" => "Vile de naissance",
            "country_birth" => "Pay de naissance",
            "country_nationality" => "Nationnalité",
            "date_birth" => "Date de naissance",
            "denomination" => "Dénomination",
            "ends_at" => "A quitté ce poste le :",
            "first_name" => "Prénom",
            "identification_number" => "Numéro d'identification",
            "last_name" => "Nom",
            "legal_representative" => "Représentant légal",
            "origin_data" => "Origine de l'information",
            "quality" => "Role",
            "starts_at" => "En poste depuis le : "
        ],
        "company_registration_organizations" => [
            "acronym" => "Acronyme",
            "card_title" => "Organisme d'enregistrement",
            "country_code" => "Code Pay",
            "delisted_at" => "Radié le",
            "location" => "Lieu",
            "name" => "Libellé",
            "registred_at" => "Enregistré le"
        ],
        "denomination" => [
            "acronym" => "Sigle",
            "card_title" => "Dénomination(s)",
            "commercial_name" => "Nom commercial",
            "name" => "Dénomination(s)"
        ],
        "invoicing_detail" => [
            "accounting_year_end_date" => "Date clôture d'exercice comptable",
            "card_title" => "Paramètre(s) de facturation",
            "vat_exemption" => "Franchise TVA",
            "vat_number" => "Numéro tva"
        ],
        "return" => "Retour"
    ]
];
