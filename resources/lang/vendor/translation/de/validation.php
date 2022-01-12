<?php
return [
    "accepted" => "Das Feld :attribute muss angenommen werden",
    "active_url" => "Das Feld :attribute ist keine gültige URL",
    "after" => "Das Feld :attribute ist eine Späteredatum als :date",
    "after_or_equal" => "Das Feld :attribute ist eine Spätere oder gleiche-datum als :date",
    "alpha" => "Das Feld :attribute muss nur Buchstaben enthalten",
    "alpha_dash" => "Das Feld :attribute muss nur Buchstaben, Zahlen und Gedankenstrich enthalten",
    "alpha_num" => "Das Feld :attribute kann nur Buchstaben und Zahlen enthalten",
    "array" => "Das Feld :attribute muss eine Tabelle werden",
    "attributes" => [
        "enterprise.identification_number" => "Französische SIRET Nummer (14 Zeichen)",
        "enterprise.name" => "Firmenbezeichnung",
        "enterprise.tax_identification_number" => "Umsatzsteuer-Identifikationsnummer",
        "passwork" => [
            "brands" => "Aufgestellte Marke",
            "insurances" => [
                "decennale" => [
                    "expires_at" => "Ablaufdatum zehnjährige Versicherung",
                    "file" => "Zehnjährige Versicherung Berechtigungsnachweis",
                    "subscribed" => "Zehnjährige Versicherung"
                ],
                "rc_pro" => [
                    "expires_at" => "Ablaufdatum Berufliche Haftpflichtversicherung",
                    "file" => "Berufliche Haftpflichtversicherung Berechtigungsnachweis",
                    "subscribed" => "Berufliche Haftpflichtversicherung"
                ]
            ],
            "qualifications" => [
                "ev_ready" => [
                    "file" => "EV Ready Befähigung Berechtigungsnachweis",
                    "obtained" => "EV Ready Befähigung"
                ],
                "irve" => [
                    "file" => "IRVE Befähigung Berechtigungsnachweis",
                    "obtained" => "IRVE Befähigung"
                ],
                "ze_ready" => [
                    "file" => "ZE Ready Befähigung Berechtigungsnachweis",
                    "obtained" => "ZE Ready Befähigung "
                ]
            ],
            "regions" => "Bundesländer",
            "skills" => "Fähigkeiten"
        ],
        "passwork.data.electrician" => "Sind Sie Elektriker ?",
        "passwork.data.engineering_office" => "Arbeiten Sie in einem Ingenieurbüro ?",
        "passwork.data.independant" => "Sind Sie Selbständig ?",
        "passwork.data.multi_activities" => "Sind Sie Techniker (Faser, Anschluss, Automat...) ?",
        "passwork.data.phone" => "Was ist Ihre Telefonummer ?",
        "passwork.data.years_of_experience" => "Seit Wann ausüben Sie ?"
    ],
    "before" => "Das Feld :attribute ist eine Früheredatum als :date",
    "before_or_equal" => "Das Feld :attribute ist eine Frühere oder Gleiche-datum als :date",
    "between" => [
        "array" => "Das Feld :attribute muss sich zwischen :min und :max Items befinden",
        "file" => "Das Feld :attribute muss sich zwischen :min und :max Kilobytes befinden",
        "numeric" => "Das Feld :attribute muss sich zwischen :min und :max befinden",
        "string" => "Das Feld :attribute muss sich zwischen :min und :max Schriften befinden"
    ],
    "boolean" => "Das Feld :attribute muss richtig oder falsch werden",
    "confirmed" => "Das Bestätigungsfeld :attribute übereinstimmt nicht",
    "custom" => ["attribute-name" => ["rule-name" => "custom-message"]],
    "date" => "Das Feld :attribute ist keine gültige Datum",
    "date_format" => "Das Bestätigungsfeld :attribute übereinstimmt nicht zum Format :format",
    "different" => "Die Felder :attribute und :other müssen unterschiedlich werden",
    "digits" => "Das Feld :attribute muss Zahlen :digits enthalten",
    "digits_between" => "Das Feld :attribute muss Zahlen zwischen :min und :max enthalten",
    "dimensions" => "Das Feld :attribute hat ungültige Bildmaße",
    "distinct" => "Das Feld :attribute existiert schon im System ",
    "email" => "Das Feld :attribute muss eine gültige E-mail werden",
    "exists" => "Das ausgewählt Feld :attribute ist ungültig",
    "file" => "Das Feld :attribute muss eine Datei werden",
    "filled" => "Das Feld :attribute muss einen Wert haben",
    "french_phone_number" => "Das Feld :attribute muss ein gültiges Handynummer werden",
    "image" => "Das Feld :attribute muss eine Bild werden",
    "in" => "Das ausgewählt Feld :attribute ist ungültig",
    "in_array" => "Das Feld :attribute existiert nicht in :other",
    "integer" => "Das Feld :attribute muss eine Ganzzahl werden",
    "ip" => "Das Feld :attribute muss eine gültige IP Adresse werden",
    "ipv4" => "Das Feld :attribute muss eine gültige IPv4 Adresse werden",
    "ipv6" => "Das Feld :attribute muss eine gültige IPv6 Adresse werden",
    "json" => "Das Feld :attribute muss eine gültige JSON Zeichenkette werden",
    "max" => [
        "array" => "Das Feld :attribute muss nicht grösser als :max Items",
        "file" => "Das Feld :attribute muss nicht grösser als :max Megabytes",
        "numeric" => "Das Feld :attribute muss nicht grösser als :max",
        "string" => "Das Feld :attribute muss nicht grösser als :max Schriften"
    ],
    "mimes" => "Das Feld :attribute muss eine :values Dateiart werden",
    "mimetypes" => "Das Feld :attribute muss eine :values Dateiart werden",
    "min" => [
        "array" => "Das Feld :attribute muss mindestens :min Items enthalten",
        "file" => "Das Feld :attribute muss mindestens :min kilo-octets werden",
        "numeric" => "Das Feld :attribute muss mindestens :min werden",
        "string" => "Das Feld :attribute muss mindestens :min Schriften enthalten"
    ],
    "not_in" => "Das ausgewählt Feld :attribute ist ungültig",
    "numeric" => "Das Feld :attribute muss eine zahl werden",
    "present" => "Das Feld :attribute muss ausgefüllt werden",
    "regex" => "Das Formatfeld :attribute ist ungültig",
    "required" => "Das Feld :attribute ist verbindlich",
    "required_if" => "Das Feld :attribute ist verbindlich wenn das Feld :other ist gleich :value.",
    "required_unless" => "Das Feld :attribute ist verbindlich außer wenn das Feld :other ist gleich :values.",
    "required_with" => "Das Feld :attribute ist verbindlich wenn das Feld :value existiert.",
    "required_with_all" => "Das Feld :attribute ist verbindlich wenn :values existiert.",
    "required_without" => "Das Feld :attribute ist verbindlich wenn :values existiert nicht.",
    "required_without_all" => "Das Feld :attribute ist verbindlich wennn keine andere :values existieren.",
    "same" => "Die Felder :attribute und :other müssen übereinstimmen.",
    "size" => [
        "array" => "Das Feld :attribute muss :size Items enthalten",
        "file" => "Das Feld :attribute muss eine Grösse von :size Megabytes haben",
        "numeric" => "Das Feld :attribute muss eine Grösse von :size haben",
        "string" => "Das Feld :attribute muss eine Grösse von :size Schriften haben"
    ],
    "string" => "Das Feld :attribute muss eine Zeichenkette werden.",
    "timezone" => "Das Feld :attribute muss einem gültigen Zeitfeld werden",
    "unique" => "Das Feld :attribute ist schon vergeben.",
    "uploaded" => "Das Feld :attribute könnte nicht hochgeladet werden.",
    "url" => "Das Formatfeld :attribute ist ungültig."
];
