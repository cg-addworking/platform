<?php
return [
    "_actions" => ["show" => "View"],
    "_breadcrumb" => ["dashboard" => "Dashboard", "index" => "Companies", "show" => "No. :short_id"],
    "filters" => ["identification_number" => "ID number", "name" => "Denomination"],
    "index" => [
        "actions" => "Actions",
        "dashboard" => "Dashboard",
        "enterprise" => "Companies",
        "identification_number" => "ID number",
        "name" => "Denomination",
        "return" => "Back"
    ],
    "show" => [
        "company" => [
            "card_title" => "General information",
            "cessation_date" => "Date of termination",
            "creation_date" => "Creation date",
            "identification_number" => "ID number",
            "is_sole_shareholder" => "Single shareholder",
            "last_updated_at" => "Date of last update",
            "legal_form" => "Legal form",
            "origin_data" => "Origin of information",
            "share_capital" => "Share capital",
            "short_id" => "AddWorking number"
        ],
        "company_activities" => [
            "card_title" => "Activity(ies)",
            "code" => "Activity code",
            "domaine" => "Area of activity",
            "ends_at" => "End date",
            "name" => "Description of activity",
            "origin_data" => "Origin of information",
            "sector_display_name" => "Sector of activity (AddWorking)",
            "social_object" => "Company purpose",
            "starts_at" => "Start date"
        ],
        "company_employees" => [
            "card_title" => "Employees",
            "employee" => "employee",
            "number" => "Number of employees",
            "origin_data" => "Origin of information",
            "range" => "Tranche",
            "year" => "Year"
        ],
        "company_establishments" => [
            "address" => "Address",
            "card_title" => "Company(ies)",
            "cessation_date" => "Ceased trading on",
            "commercial_name" => "Trading name",
            "creation_date" => "Created on",
            "establishment_name" => "Name",
            "establishments" => "Company(ies)",
            "identification_number" => "ID number",
            "is_headquarter" => "Head Office",
            "origin_data" => "Origin of information",
            "sirene" => "SIRENE declaration",
            "societecom" => "Company.com"
        ],
        "company_legal_representatives" => [
            "address" => "Address",
            "birth_date" => "Date of birth: ",
            "card_title" => "Legal representatives",
            "city_birth" => "Place of birth",
            "country_birth" => "Country of birth",
            "country_nationality" => "Nationality",
            "date_birth" => "Date of birth",
            "denomination" => "Denomination",
            "ends_at" => "Left this position on:",
            "first_name" => "First name",
            "identification_number" => "ID number",
            "last_name" => "Name",
            "legal_representative" => "Legal representative",
            "origin_data" => "Origin of information",
            "quality" => "Role",
            "starts_at" => "In this position since: "
        ],
        "company_registration_organizations" => [
            "acronym" => "Acronym",
            "card_title" => "Registering body",
            "country_code" => "Country code",
            "delisted_at" => "Removed on",
            "location" => "Location",
            "name" => "Description",
            "registred_at" => "Registered on"
        ],
        "denomination" => [
            "acronym" => "Abbreviation",
            "card_title" => "Name(s)",
            "commercial_name" => "Trading name",
            "name" => "Name(s)"
        ],
        "invoicing_detail" => [
            "accounting_year_end_date" => "Date of financial year end",
            "card_title" => "Billing parameter(s)",
            "vat_exemption" => "VAT allowance",
            "vat_number" => "VAT number"
        ],
        "return" => "Back"
    ]
];
