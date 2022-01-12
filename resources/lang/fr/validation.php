<?php
return [
    "accepted" => "Le champ :attribute doit être accepté",
    "active_url" => "Le champ :attribute n'est pas une URL valide",
    "after" => "Le champ :attribute doit être une date postérieure au :date",
    "after_or_equal" => "Le champ :attribute doit être une date postérieure ou égale au :date",
    "alpha" => "Le champ :attribute ne peut contenir que des lettres",
    "alpha_dash" => "Le champ :attribute ne peut contenir que des lettres, nombres et tirets",
    "alpha_num" => "Le champ :attribute ne peut contenir que des lettres et nombres",
    "array" => "Le champ :attribute doit être un tableau",
    "attributes" => [
        "enterprise.identification_number" => "Numéro SIRET",
        "enterprise.name" => "Raison sociale",
        "enterprise.tax_identification_number" => "Numéro de TVA Intracommunautaire",
        "passwork" => [
            "brands" => "Marques installées",
            "insurances" => [
                "decennale" => [
                    "expires_at" => "Date d'expiration Assurance décennale",
                    "file" => "Justificatif Assurance décennale",
                    "subscribed" => "Assurance décennale"
                ],
                "rc_pro" => [
                    "expires_at" => "Date d'expiration Assurance RC Pro",
                    "file" => "Justificatif Assurance RC Pro",
                    "subscribed" => "Assurance RC Pro"
                ]
            ],
            "qualifications" => [
                "ev_ready" => [
                    "file" => "Justificatif qualification EV Ready",
                    "obtained" => "Qualification EV Ready"
                ],
                "irve" => ["file" => "Justificatif qualification IRVE", "obtained" => "Qualification IRVE"],
                "ze_ready" => [
                    "file" => "Justificatif qualification ZE Ready",
                    "obtained" => "Qualification ZE Ready"
                ]
            ],
            "regions" => "Régions",
            "skills" => "Compétences"
        ],
        "passwork.data.electrician" => "Êtes-vous électricien ?",
        "passwork.data.engineering_office" => "Travaillez-vous en Bureau d'études ?",
        "passwork.data.independant" => "Êtes-vous à votre compte ? ",
        "passwork.data.multi_activities" => "Êtes-vous technicien (fibre, raccordement, bornes...) ?",
        "passwork.data.phone" => "Quel est votre numéro de téléphone ?",
        "passwork.data.years_of_experience" => "Depuis combien de temps exercez-vous ?"
    ],
    "before" => "Le champ :attribute doit être une date antérieure au :date",
    "before_or_equal" => "Le champ :attribute doit être une date antérieure ou égale au :date",
    "between" => [
        "array" => "Le champ :attribute doit être entre :min and :max éléments",
        "file" => "Le champ :attribute doit être entre :min et :max kilo-octets",
        "numeric" => "Le champ :attribute doit être entre :min et :max",
        "string" => "Le champ :attribute doit être entre :min et :max caractères"
    ],
    "boolean" => "Le champ :attribute doit être vrai ou faux",
    "confirmed" => "Le champ de confirmation :attribute ne correspond pas",
    "custom" => ["attribute-name" => ["rule-name" => "custom-message"]],
    "date" => "Le champ :attribute n'est pas une date valable",
    "date_format" => "Le champ :attribute ne correspond pas au format :format",
    "different" => "Les champs :attribute et :other doivent être différents",
    "digits" => "Le champ :attribute doit contenir :digits chiffres",
    "digits_between" => "Le champ :attribute doit contenir entre :min et :max chiffres",
    "dimensions" => "Le champ :attribute a des dimensions d'image invalides",
    "distinct" => "Le champ :attribute existe déjà dans le système",
    "email" => "Le champ :attribute doit être une adresse email valide",
    "exists" => "Le champ :attribute sélectionné est invalide",
    "file" => "Le champ :attribute doit être un fichier",
    "filled" => "Le champ :attribute doit avoir une valeur",
    "french_phone_number" => "Le champ :attribute doit être un numéro de téléphone valide",
    "image" => "Le champ :attribute doit être une image",
    "in" => "Le champ :attribute sélectionné est invalide",
    "in_array" => "Le champ :attribute n'existe pas dans :other",
    "integer" => "Le champ :attribute doit être un entier",
    "ip" => "Le champ :attribute doit être une adresse IP valide.",
    "ipv4" => "Le champ :attribute doit être une adresse IPv4 valide.",
    "ipv6" => "Le champ :attribute doit être une adresse IPv6 valide.",
    "json" => "Le champ :attribute doit être une chaine JSON valide.",
    "max" => [
        "array" => "Le champ :attribute ne doit pas être supérieur à :max éléments.",
        "file" => "Le champ :attribute ne doit pas être supérieur à :max kilo-octets.",
        "numeric" => "Le champ :attribute ne doit pas être supérieur à :max.",
        "string" => "Le champ :attribute ne doit pas être supérieur à :max caractères."
    ],
    "mimes" => "Le champ :attribute doit être un fichier du type: :values.",
    "mimetypes" => "Le champ :attribute doit être un fichier du type: :values.",
    "min" => [
        "array" => "Le champ :attribute doit avoir au minimum :min éléments.",
        "file" => "Le champ :attribute doit être au minimum à :min kilo-octets.",
        "numeric" => "Le champ :attribute doit être au minimum à :min.",
        "string" => "Le champ :attribute doit contenir au minimum :min caractères."
    ],
    "not_in" => "Le champ :attribute sélectionné est invalide.",
    "numeric" => "Le champ :attribute doit être un nombre.",
    "present" => "Le champ :attribute doit être présent.",
    "regex" => "Le format du champ :attribute est invalide.",
    "required" => "Le champ :attribute est obligatoire.",
    "required_if" => "Le champ :attribute est obligatoire lorsque le champ :other est égal à :value.",
    "required_unless" => "Le champ :attribute est obligatoire à moins que le champ :other est égal à :values.",
    "required_with" => "Le champ :attribute est obligatoire lorsque :values est présent.",
    "required_with_all" => "Le champ :attribute est obligatoire lorsque :values est présent.",
    "required_without" => "Le champ :attribute est obligatoire lorsque :values n'est pas présent.",
    "required_without_all" => "Le champ :attribute est obligatoire lorsque aucun des autres :values ne sont présents.",
    "same" => "Les champs :attribute et :other doivent correspondre.",
    "size" => [
        "array" => "Le champ :attribute doit contenir :size éléments.",
        "file" => "Le champ :attribute doit avoir une taille de :size kilo-octets.",
        "numeric" => "Le champ :attribute doit avoir une taille de :size.",
        "string" => "Le champ :attribute doit avoir une taille de :size caractères."
    ],
    "string" => "Le champ :attribute doit être une chaine de caractères.",
    "timezone" => "Le champ :attribute doit être une zone de temps valide.",
    "unique" => "Le champ :attribute a déjà été pris.",
    "uploaded" => "Le champ :attribute n'a pas pu être téléchargé.",
    "url" => "Le format du champ :attribute n'est pas valide."
];
