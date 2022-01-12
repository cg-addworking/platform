<?php
return [
    "outbound" => [
        "application" => [
            "views" => [
                "_actions" => [
                    "addworking_commissions" => "Commissions AddWorking",
                    "consult" => "Consulter",
                    "create_credit_note_invoice" => "Créer une facture d'avoir",
                    "credit_lines" => "Lignes d'avoir",
                    "edit" => "Modifier",
                    "generate_pdf" => "Générer le PDF",
                    "invoice_lines" => "Lignes de facture",
                    "payment_orders" => "Ordres de paiement",
                    "supplier_invoice_included" => "Factures prestataires incluses"
                ],
                "_breadcrumb" => [
                    "addworking_commission" => "Commission AddWorking",
                    "addworking_commissions" => "Commissions AddWorking",
                    "addworking_invoices" => "Factures AddWorking",
                    "calculate_commissions" => "Calculer les commissions",
                    "create" => "Créer",
                    "create_credit_lines" => "Créer des lignes d'avoir",
                    "dashboard" => "Tableau de bord",
                    "edit" => "Modifier",
                    "generate_file" => "Générer le fichier",
                    "invoice_number" => "Facture N°",
                    "number" => "N°",
                    "provider_invoice" => "Factures prestataires"
                ],
                "_filter" => [
                    "bill_number" => "Numéro de facture",
                    "billing_period" => "Période de facturation",
                    "due_date" => "Date d'échéance",
                    "filter" => "Filtres",
                    "invoice_date" => "Date d'émission",
                    "payment_deadline" => "Échéance de paiement",
                    "reset" => "Réinitialiser",
                    "status" => "Statut"
                ],
                "_form" => [
                    "billing_period" => "Période de facturation",
                    "due_date" => "Date d'échéance",
                    "include_fees" => "Inclure les commissions dans la facture ?",
                    "innvoice_date" => "Date",
                    "invoice_date" => "Date d'émission de la facture",
                    "no" => "Non",
                    "payment_deadline" => "Échéance de paiement",
                    "yes" => "Oui"
                ],
                "_html" => [
                    "amount_excluding_taxes" => "Montant hors taxes (HT)",
                    "amount_including_taxes" => "Montant toute taxe comprise (TTC)",
                    "client" => "Client",
                    "copy_to_clipboard" => "Copier dans le presse-papier",
                    "created_date" => "Date de création",
                    "due_date" => "Date d’échéance",
                    "issue_date" => "Date d’émission",
                    "last_modified_date" => "Date de dernière modification",
                    "legal_notice" => "Mentions légales",
                    "number" => "Numéro",
                    "parent_invoice_number" => "Numéro de facture parent",
                    "payment_order_date" => "Date de paiement des ordres de paiements",
                    "period" => "Période",
                    "received_by_assignment_daily" => "Cession de créance DAILLY",
                    "reverse_vat" => "Autoliquidation de la TVA",
                    "status" => "Statut",
                    "updated_by" => "Modifié par ",
                    "uuid" => "UUID",
                    "validated_at" => "Validée le",
                    "validated_by" => "Validée par",
                    "vat_amount" => "Montant des taxes (TVA)"
                ],
                "_status" => [
                    "fees_calculated" => "Commissions calculées",
                    "file_generated" => "Fichier généré",
                    "fully_paid" => "Payée intégralement",
                    "partially_paid" => "Payée partiellement",
                    "pending" => "En attente",
                    "validated" => "Validée"
                ],
                "_table_head" => [
                    "action" => "Action",
                    "amount_ht" => "Montant HT",
                    "bill_number" => "Numéro de facture",
                    "create_invoice" => "Créer une facture",
                    "customer_visibility" => "Visibilité Client",
                    "deadline" => "Échéance de paiement",
                    "does_not_have_invoices" => "N'a pas de factures",
                    "due_at" => "Date d'échéance",
                    "invoiced_at" => "Date d'émission",
                    "month" => "Période de facturation",
                    "status" => "Statut",
                    "tax" => "Montant Taxes",
                    "the_enterprise" => "L'entreprise",
                    "total" => "Montant TTC"
                ],
                "_table_row_empty" => [
                    "create_invoice" => "Créer une facture",
                    "does_not_have_invoices" => "n'a pas de factures AddWorking.",
                    "the_enterprise" => "L'entreprise"
                ],
                "associate" => [
                    "action" => "Action",
                    "amount_ht" => "Montant HT",
                    "associate" => "Associer",
                    "associate_selected_invoice" => "Associer les factures sélectionnées",
                    "billing_period" => "Période de facturation",
                    "invoice_number" => "Numéro de facture",
                    "note" => "Note: le reste à facturer correspond à la liste des factures prestataires qui ne sont pas incluses dans une facture AddWorking.",
                    "payment_deadline" => "Échéance de paiement",
                    "remains_to_be_invoiced" => "Reste à facturer",
                    "return" => "Retour",
                    "service_provider" => "Prestataire",
                    "status" => "Statut",
                    "text_1" => "n'a pas de factures Prestataires à associer",
                    "text_2" => "pour la période",
                    "text_3" => "échéance",
                    "the_enterprise" => "L'entreprise",
                    "total" => "Montant TTC"
                ],
                "create" => [
                    "create_invoice" => "Créer la facture",
                    "create_invoice_for" => "Créer une facture pour",
                    "return" => "Retour"
                ],
                "dissociate" => [
                    "action" => "Action",
                    "amount_ht" => "Montant HT",
                    "associate_invoice" => "Associer des factures",
                    "billing_period" => "Période de facturation",
                    "dissociate" => "Dissocier",
                    "export" => "Export",
                    "invoice_number" => "Numéro de facture",
                    "payment_deadline" => "Échéance de paiement",
                    "reset_invoice" => "Reste à facturer",
                    "return" => "Retour",
                    "service_provider" => "Prestataire",
                    "status" => "Statut",
                    "text_1" => "n'a pas de factures Prestataires à dissocier",
                    "text_2" => "pour la période",
                    "text_3" => "échéance",
                    "the_enterprise" => "L'entreprise",
                    "title" => "Factures prestataires de la facture N°",
                    "total" => "Montant TTC",
                    "ungroup_selected_invoice" => "Dissocier les factures sélectionnées"
                ],
                "edit" => [
                    "edit_invoice" => "Éditer la facture",
                    "return" => "Retour",
                    "status" => "Statut",
                    "title" => "Éditer la facture n°"
                ],
                "fee" => [
                    "_actions" => ["confirm_delete" => "Confirmer la suppression ?", "delete" => "Supprimer"],
                    "_table_head" => [
                        "actions" => "Actions",
                        "amount" => "Montant",
                        "label" => "Label",
                        "number" => "Numéro",
                        "service_provider" => "Prestataire",
                        "tax_amount_invoice_line" => "Montant HT ligne de facture",
                        "type" => "Type",
                        "vat_rate" => "Taux TVA"
                    ],
                    "_table_head_associate" => [
                        "actions" => "Actions",
                        "amount" => "Montant",
                        "label" => "Label",
                        "number" => "Numéro",
                        "service_provider" => "Prestataire",
                        "tax_amount_invoice_line" => "Montant HT ligne de facture",
                        "type" => "Type",
                        "vat_rate" => "Taux TVA"
                    ],
                    "_table_head_credit_fees" => [
                        "actions" => "Actions",
                        "amount" => "Montant",
                        "label" => "Label",
                        "number" => "Numéro",
                        "service_provider" => "Prestataire",
                        "tax_amount_invoice_line" => "Montant HT ligne de facture",
                        "type" => "Type",
                        "vat_rate" => "Taux TVA"
                    ],
                    "_table_row_associate" => ["cancel" => "Annuler"],
                    "_type" => [
                        "custom_management_fees" => "Taux de gestion personnalisé",
                        "default_management_fees" => "Taux de gestion par défaut",
                        "discount" => "Remise",
                        "fixed_fees" => "Coût fixe",
                        "other" => "Autre",
                        "subscription" => "Abonnement"
                    ],
                    "associate_credit_fees" => [
                        "cancel_selected" => "Annuler les lignes de commissions sélectionnées",
                        "return" => "Retour",
                        "text_1" => "La facture AddWorking n°",
                        "text_2" => "n'a pas de lignes de commissions.",
                        "title" => "Annuler les lignes de commissions AddWorking"
                    ],
                    "calculate" => [
                        "calculate_commissions" => "Calculer les commissions",
                        "return" => "Retour",
                        "text_1" => "Par défaut, les commissions AddWorking seront calculées sur la facture AddWorking n°",
                        "text_2" => "Facture AddWorking à traiter",
                        "title" => "Calculer les commissions de la facture AddWorking n°"
                    ],
                    "create" => [
                        "calculate_commissions" => "",
                        "create" => "Créer la commission",
                        "return" => "Retour",
                        "text_1" => "",
                        "text_2" => "",
                        "title" => "Ajouter une commission à la facture AddWorking n°"
                    ],
                    "index" => [
                        "calculate_commissions" => "Calculer les commissions",
                        "create" => "Ajouter",
                        "export" => "Export",
                        "return" => "Retour",
                        "text_1" => "La facture AddWorking n°",
                        "text_2" => "de l'entreprise",
                        "text_3" => "n'a pas de commissions AddWorking.",
                        "title" => "Commissions de la facture n°"
                    ],
                    "index_credit_fees" => [
                        "cancel_commissions" => "Annuler les commissions",
                        "return" => "Retour",
                        "title" => "Commissions de la facture n°"
                    ]
                ],
                "file" => [
                    "_annex" => [
                        "annex_details" => "Annexe : détail sous-traitants",
                        "code_analytic" => "Code Analytique",
                        "management_fees_ht" => "Frais Gestion HT",
                        "mission_code" => "Code mission",
                        "name" => "Nom du Sous-traitant",
                        "price_ht" => "Prix HT",
                        "ref_mission" => "Ref mission",
                        "subcontracter_code" => "Code sous-traitant",
                        "total_ht" => "Total HT",
                        "wording" => "Libellé"
                    ],
                    "_enterprises" => [
                        "addworking" => "ADDWORKING",
                        "contract_number" => "Contrat CPS1 n°",
                        "date" => "Date:",
                        "france" => "France",
                        "invoice_number" => "Facture n°",
                        "line_1" => "17 RUE LAC SAINT ANDRE",
                        "line_2" => "73370 LE BOURGET DU LAC",
                        "line_3" => "N°TVA intracommunautaire : FR71810840900 00015",
                        "line_4" => "Représentée par Julien PERONA",
                        "line_5" => "Cession de créance DAILLY",
                        "line_6" => "BPI FRANCE FINANCEMENT",
                        "of" => "De:",
                        "parent_invoice_number" => "Numéro de facture parent:"
                    ],
                    "_footer" => [
                        "addworking" => "ADDWORKING",
                        "line_1" => "Société par Actions Simplifiée au capital de 143.645,00 € – RCS CHAMBERY 810 840 900 – N° TVA intracommunautaire : FR71810840900 00015",
                        "line_2" => "17 rue du Lac Saint André – Savoie Technolac – BP 350 – 73370 Le Bourget du Lac – FRANCE",
                        "line_3" => "contact@addworking.com"
                    ],
                    "_header" => ["credit_note_invoice" => "Facture d'avoir n°", "invoice_number" => "Facture n°"],
                    "_legal_notice" => [
                        "line_1" => "AUTOLIQUIDATION DE LA TVA - en application de l'article 242 nonies A, I-13° Annexe II au CGI",
                        "line_2" => "Pour être libératoire, le règlement de cette facture doit être effectué sur notre compte ouvert chez BPI France Financement:",
                        "line_3" => "IBAN : CPMEFRPPXXX / FR76 1835 9000 4300 0202 5754 547",
                        "line_4" => "Code Etablissement : 18359, Code Guichet : 00043, N° de Compte 00020257545, Clé 47",
                        "line_5" => "BPI France Financement, Comptabilité Mouvements de fonds – Banques",
                        "line_6" => "27-31 avenue du Général Leclerc, 94710 Maisons-Alfort Cedex"
                    ],
                    "_lines" => [
                        "amount_ht" => "Montant HT",
                        "line_1" => "ADDWORKING - Frais de gestion prestataires",
                        "line_2" => "ADDWORKING - Frais abonnement",
                        "line_3" => "ADDWORKING -",
                        "line_4" => "Prestataires référencés",
                        "line_5" => "ADDWORKING - Réduction",
                        "name" => "Nom du Sous-traitant",
                        "period" => "Période",
                        "subcontracted_code" => "Code sous-traitant",
                        "subcontracter_code" => "Code sous-traitant"
                    ],
                    "_summary" => [
                        "amount" => "Montant",
                        "benifits" => "PRESTATIONS HT",
                        "iban_for_transfer" => "IBAN pour virement",
                        "line_1" => "FR76 1835 9000 4300 0202 5754 547",
                        "management_fees_ht" => "Frais de gestion HT",
                        "payment_deadline" => "Date limite de paiement",
                        "referrence" => "Référence à rappeler sur le virement",
                        "total_ht" => "TOTAL HT",
                        "total_ttc" => "TOTAL TTC",
                        "total_vat" => "TOTAL TVA",
                        "vat" => "Désignation",
                        "vat_summary" => "dont"
                    ]
                ],
                "generate_file" => [
                    "address" => "Adresse de facturation du client",
                    "generate_file" => "Générer le fichier",
                    "legal_notice" => "Mentions légales",
                    "received_by_assignment_daily" => "Cession de créance DAILLY",
                    "return" => "Retour",
                    "reverse_vat" => "Autoliquidation de la TVA",
                    "title" => "Générer le fichier de la facture n°"
                ],
                "index" => [
                    "create_invoice" => "Créer une facture",
                    "text" => "n'a pas de factures AddWorking.",
                    "the_enterprise" => "L'entreprise",
                    "title" => "Factures AddWorking de l'entreprise"
                ],
                "item" => [
                    "_actions" => ["confirm_delete" => "Confirmer la suppression ?", "delete" => "Supprimer"],
                    "_breadcrumb" => [
                        "addworking_invoices" => "Factures AddWorking",
                        "create" => "Créer",
                        "dashboard" => "Tableau de bord",
                        "invoice_lines" => "Lignes de la facture",
                        "invoice_number" => "Facture n°"
                    ],
                    "_form" => [
                        "label" => "Label",
                        "quantity" => "Quantité",
                        "unit_price" => "Prix unitaire",
                        "vat_rate" => "Taux de TVA"
                    ],
                    "_table_head" => [
                        "action" => "Action",
                        "amount_ht" => "Montant HT",
                        "invoice_number" => "N° facture",
                        "label" => "Label",
                        "number" => "Numéro",
                        "quantity" => "Quantité",
                        "service_provider" => "Prestataire",
                        "unit_price" => "Prix unitaire",
                        "vat_rate" => "Taux de TVA"
                    ],
                    "associate_credit_line" => [
                        "action" => "Action",
                        "amount_ht" => "Montant HT",
                        "create" => "Créer",
                        "invoice_number" => "N° facture",
                        "label" => "Label",
                        "label_1" => "Créer les lignes d'avoir pour les lignes sélectionnées",
                        "number" => "Numéro",
                        "quantity" => "Quantité",
                        "return" => "Retour",
                        "service_provider" => "Prestataire",
                        "text_1" => "La facture AddWorking n°",
                        "text_2" => "n'a pas de lignes de facture.",
                        "title" => "Sélectionner des lignes d'avoir",
                        "unit_price" => "Prix unitaire",
                        "vat_rate" => "Taux de TVA"
                    ],
                    "create" => [
                        "create" => "Créer la ligne",
                        "return" => "Retour",
                        "title" => "Créer une ligne pour la facture Addworking n°"
                    ],
                    "index" => [
                        "create" => "Créer une ligne",
                        "create_new" => "Créer une ligne de facture",
                        "return" => "Retour",
                        "text_1" => "L'entreprise",
                        "text_2" => "n'a pas de lignes de facturation",
                        "text_3" => "pour la période",
                        "text_4" => "échéance",
                        "title" => "Lignes de la facture N°"
                    ],
                    "index_credit_line" => [
                        "create" => "Créer une ligne d'avoir",
                        "lines_number" => "Lignes de la facture N°",
                        "return" => "Retour"
                    ]
                ],
                "show" => [
                    "return" => "Retour",
                    "text" => "La facture PDF n'est pas encore générée",
                    "title" => "Facture n°",
                    "validate" => "Valider",
                    "vendor_invoices" => "Factures prestataires"
                ],
                "support" => [
                    "_breadcrumb" => ["addworking_invoices" => "Factures AddWorking", "support" => "Support"],
                    "_filter" => [
                        "billing_period" => "Période de facturation",
                        "enterprise" => "Entreprise",
                        "filter" => "Filtrer",
                        "filters" => "Filtres",
                        "invoice_date" => "Date d'émission",
                        "invoice_number" => "Numéro de facture",
                        "payment_deadline" => "Echéance de paiement",
                        "reset" => "Réinitialiser",
                        "status" => "Statut"
                    ],
                    "_table_head" => [
                        "action" => "Action",
                        "amount_ht" => "Montant HT",
                        "billing_period" => "Période facturation",
                        "customer_visibility" => "Visibilité Client",
                        "due_date" => "Date d'émission",
                        "enterprise" => "Entreprise",
                        "invoice_date" => "Date d'échéance",
                        "invoice_number" => "Numéro de facture",
                        "payment_deadline" => "Échéance de paiement",
                        "status" => "Statut",
                        "tax_amount" => "Montant Taxes",
                        "total_ttc" => "Montant TTC"
                    ],
                    "index" => ["text" => "Aucune facture AddWorking."]
                ]
            ]
        ]
    ]
];
