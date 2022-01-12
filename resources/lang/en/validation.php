<?php
return [
    "accepted" => "The :attribute field must be accepted",
    "active_url" => "The :attribute field is not a valid URL",
    "after" => "The :attribute field must be a date after :date",
    "after_or_equal" => "The :attribute field must be a date after or equal to :date",
    "alpha" => "The :attribute field may only contain letters",
    "alpha_dash" => "The :attribute field may only contain letters, numbers and dashes",
    "alpha_num" => "The :attribute field may only contain letters and numbers",
    "array" => "The :attribute field must be an table",
    "attributes" => [
        "enterprise.identification_number" => "Company Register Number",
        "enterprise.name" => "Business name",
        "enterprise.tax_identification_number" => "Intra-community VAT number",
        "passwork" => [
            "brands" => "Installed brands",
            "insurances" => [
                "decennale" => [
                    "expires_at" => "10-year Insurance expiry date",
                    "file" => "10-year Insurance certificate",
                    "subscribed" => "10-year Insurance"
                ],
                "rc_pro" => [
                    "expires_at" => "Professional Indemnity Insurance expiry date ",
                    "file" => "Professional Indemnity Insurance certificate",
                    "subscribed" => "Professional Indemnity Insurance"
                ]
            ],
            "qualifications" => [
                "ev_ready" => ["file" => "EV Ready qualification proof", "obtained" => "EV Ready qualification"],
                "irve" => ["file" => "IRVE qualification proof", "obtained" => "IRVE qualification"],
                "ze_ready" => ["file" => "ZE Ready qualification proof", "obtained" => "ZE Ready qualification"]
            ],
            "regions" => "Regions",
            "skills" => "Skills"
        ],
        "passwork.data.electrician" => "Are you an electrician?",
        "passwork.data.engineering_office" => "Do you work in a Design Office?",
        "passwork.data.independant" => "Are you self-employed?",
        "passwork.data.multi_activities" => "Are you a technician (fiber, connection, terminals ...)?",
        "passwork.data.phone" => "What is your phone number ?",
        "passwork.data.years_of_experience" => "How long have you been working in this field?"
    ],
    "before" => "The :attribute field must be dated before :date",
    "before_or_equal" => "The :attribute field must be a date before or equal to :date",
    "between" => [
        "array" => "The :attribute field must have between :min and :max items",
        "file" => "The :attribute field must be between :min and :max kilobytes",
        "numeric" => "The :attribute field must be between :min and :max",
        "string" => "The :attribute field must be between :min and :max characters"
    ],
    "boolean" => "The :attribute field must be true or false",
    "confirmed" => "The :attribute confirmation field does not match",
    "custom" => ["attribute-name" => ["rule-name" => "custom-message"]],
    "date" => "The :attribute field is not a valid date",
    "date_format" => "The :attribute field does not match the format :format",
    "different" => "The :attribute and :other fields must be different",
    "digits" => "The :attribute field must be :digits digits",
    "digits_between" => "The :attribute field must be between :min and :max digits",
    "dimensions" => "The :attribute field has invalid image dimensions",
    "distinct" => "The :attribute field has a duplicate value",
    "email" => "The :attribute field must be a valid email address",
    "exists" => "The selected :attribute field is invalid",
    "file" => "The :attribute field must be a file",
    "filled" => "The :attribute field must have a value",
    "french_phone_number" => "The :attribute field must be a valid phone number",
    "image" => "The :attribute field must be an image",
    "in" => "The selected :attribute field is invalid",
    "in_array" => "The :attribute field does not exist in :other",
    "integer" => "The :attribute field must be a whole number.",
    "ip" => "The :attribute field must be a valid IP address.",
    "ipv4" => "The :attribute field must be a valid IPv4 address.",
    "ipv6" => "The :attribute field must be a valid IPv6 address.",
    "json" => "The :attribute field must be a valid JSON chain.",
    "max" => [
        "array" => "The :attribute field may not have more than :max items.",
        "file" => "The :attribute field may not be greater than :max kilobytes.",
        "numeric" => "The :attribute field may not be greater than :max.",
        "string" => "The :attribute field may not be greater than :max characters."
    ],
    "mimes" => "The :attribute field must be a file of type: :values.",
    "mimetypes" => "The :attribute field must be a file of type: :values.",
    "min" => [
        "array" => "The :attribute field must have at least :min items.",
        "file" => "The :attribute field must be at least :min kilobytes.",
        "numeric" => "The :attribute field must be at least :min.",
        "string" => "The :attribute field must be at least :min characters."
    ],
    "not_in" => "The selected :attribute field is invalid.",
    "numeric" => "The :attribute field must be a number.",
    "present" => "The :attribute field must be present.",
    "regex" => "The :attribute field format is invalid.",
    "required" => "The :attribute field is required.",
    "required_if" => "The :attribute field is required when :other field is :value.",
    "required_unless" => "The :attribute field is required unless :other field is :values.",
    "required_with" => "The :attribute field is required when :values is present.",
    "required_with_all" => "The :attribute field is required when :values is present.",
    "required_without" => "The :attribute field is required when :values is not present.",
    "required_without_all" => "The :attribute field is required when none of :values are present.",
    "same" => "The :attribute and :other fields must match.",
    "size" => [
        "array" => "The :attribute field must contain :size items.",
        "file" => "The :attribute field must be :size kilobytes.",
        "numeric" => "The :attribute field must be :size.",
        "string" => "The :attribute field must be :size characters."
    ],
    "string" => "The :attribute field must be a chain of characters.",
    "timezone" => "The :attribute field must be a valid time zone.",
    "unique" => "The :attribute field has already been taken.",
    "uploaded" => "The :attribute field failed to upload.",
    "url" => "The :attribute field format is invalid."
];
