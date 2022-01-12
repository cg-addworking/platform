<?php
return [
    "billing" => [
        "inbound_invoice" => [
            "_action" => [
                "download" => "Télécharger",
                "items" => "Items",
                "reconciliation" => "Réconciliation"
            ],
            "_dropdown" => [
                "consulter" => "Consulter",
                "download" => "Télécharger",
                "invoice_lines" => "Lignes de facture",
                "modifier" => "Modifier",
                "remove" => "Supprimer"
            ],
            "_form" => [
                "amount_all_taxes_included" => "Montant toute taxe comprise (TTC)",
                "amount_excluding_taxes" => "Montant hors taxes (HT)",
                "amount_of_taxes" => "Montant des taxes (TVA)",
                "current_file" => "Fichier actuel",
                "date_of_invoice" => "Date d’émission de facture",
                "file" => "Fichier",
                "invoice_properties" => "Propriétés de la facture",
                "is_factoring_alert_line_1" => "Voici l'IBAN dans votre compte AddWorking : :iban",
                "is_factoring_alert_line_2" => "Si cet IBAN n'est pas celui de votre factor, merci de bien vouloir le remplacer ",
                "is_factoring_check" => "J’atteste que cette facture est cédée à un factor et que j’ai mis à jour les informations du RIB dans mon compte AddWorking",
                "is_factoring_message" => "Dans le cas où vous avez cédé votre facture à un factor, merci de le déclarer ci-dessous :",
                "note" => "Note",
                "number" => "Numéro",
                "payment_deadline" => "Échéance de paiement",
                "replace" => "Remplacer",
                "replace_rib" => "ici",
                "tracking_lines" => "Lignes de suivi de mission",
                "tracking_lines_amount_before_taxes" => "Montant Hors Taxes (HT)",
                "tracking_lines_description" => "Libellé",
                "tracking_lines_not_found" => "Je ne trouve pas l'élément facturable à associer.",
                "tracking_lines_quantity" => "Quantité",
                "tracking_lines_unit_price" => "Prix unitaire",
                "tracking_lines_vat_rate" => "TVA"
            ],
            "_form_support" => [
                "admin" => "Admin",
                "admin_amount" => "(admin) Montant hors taxes (HT)",
                "admin_amount_all_taxes_included" => "(admin) Montant toutes taxes comprises (TTC)",
                "admin_amount_of_taxes" => "(admin) Montant des taxes (TVA)",
                "outbound_invoice" => "Facture sortante associée (outbound)",
                "paid" => "Payée",
                "pending" => "En attente",
                "status" => "Statut",
                "to_validate" => "À valider",
                "validated" => "Validée"
            ],
            "_html" => [
                "admin_amount" => "(admin) Montants de la facture",
                "admin_amount_all_taxes_included" => "Montant toute taxe comprise (TTC)",
                "admin_amount_of_taxes" => "Montant hors taxes (HT)",
                "administrative_compliance" => "Conformité administrative",
                "amount_all_taxes_included" => "Montant toute taxe comprise (TTC)",
                "amount_excluding_taxes" => "Montant hors taxes (HT)",
                "amount_of_taxes" => "Montant des taxes (TVA)",
                "associated_customer_invoice" => "Facture client associée",
                "client" => "Client",
                "creation_date" => "Date de création",
                "date_of_invoice" => "Date d’émission de facture",
                "file" => "Fichier",
                "is_factoring" => "Affacturage",
                "last_modified_date" => "Date de dernière modification",
                "no" => "Non",
                "note" => "Note",
                "number" => "Numéro",
                "payment_deadline" => "Échéance de paiement",
                "period" => "Période",
                "service_provider" => "Prestataire",
                "status" => "Statut",
                "tracking" => "Suivi",
                "updated_by" => "Modifié par ",
                "username" => "Identifiant",
                "yes" => "Oui"
            ],
            "_status" => [
                "paid" => "Payée",
                "pending" => "En attente",
                "unknown" => "Inconnu",
                "validate" => "À valider",
                "validated" => "Validée"
            ],
            "_table_row_empty" => [
                "add_from_tracking_lines" => "Ajouter depuis les lignes de suivis",
                "statement_postfix" => "ne possède aucun item dans cette facture Prestataire.",
                "statement_prefix" => "L'entreprise"
            ],
            "_warning" => [
                "address" => "ADDWORKING",
                "address_deutschland" => "ADDWORKING GmbH",
                "attention" => "Attention",
                "invoice_payable_to" => "N'oubliez pas d'établir vos factures à l'ordre de :",
                "line_1" => "17 rue du Lac Saint André",
                "line_2" => "Savoie Technolac - BP 350",
                "line_3" => "73370 Le Bourget du Lac - France",
                "line_4" => "Numéro de TVA intracommunautaire AddWorking : FR 71 810 840 900 00015",
                "line_5" => "Lebacher Strasse 4",
                "line_6" => "66113 Saarbrücken"
            ],
            "before_create" => [
                "companies" => "Entreprises",
                "continue" => "Continuer",
                "create" => "Créer",
                "customer" => "Client",
                "dashboard" => "Tableau de bord",
                "help_text" => "La période correspond au mois où vous avez effectué la prestation. Par exemple: si nous sommes en Novembre et que votre prestation à été effectuée en Octobre, alors la période de facturation est Octobre.",
                "my_bills" => "Mes factures",
                "new_invoice" => "Nouvelle Facture",
                "period" => "Période"
            ],
            "create" => [
                "companies" => "Entreprises",
                "create" => "Créer",
                "dashboard" => "Tableau de bord",
                "my_bills" => "Mes factures",
                "new_invoice" => "Nouvelle Facture",
                "return" => "Retour"
            ],
            "edit" => [
                "companies" => "Entreprises",
                "customer" => "Client",
                "dashboard" => "Tableau de bord",
                "edit" => "Modifier",
                "edit_invoice" => "Modifier la facture",
                "help_text" => "La période correspond au mois où vous avez effectué la prestation. Par exemple: si nous sommes en Novembre et que votre prestation à été effectuée en Octobre, alors la période de facturation est Octobre.",
                "month" => "Mois",
                "my_bills" => "Mes factures",
                "register" => "Enregistrer",
                "return" => "Retour",
                "service_provider" => "Prestataire"
            ],
            "export" => [
                "addworking_team" => "L'équipe AddWorking",
                "download_button" => "Télécharger",
                "greetings" => "Bonjour,",
                "sentence_one" => "Votre export est prêt !",
                "sentence_two" => "Cliquez sur le lien ci-dessous pour le télécharger :",
                "success" => "Votre export est en cours de génération, vous recevrez un lien par mail pour le télécharger.",
                "thanks_you" => "Cordialement,"
            ],
            "export_ready" => [
                "email_sentence" => "Vous trouverez en pièce jointe à cet email l'export des factures entrantes comme demandé.",
                "greeting" => "Bonjour,",
                "have_a_good_day" => "Bonne journée !"
            ],
            "inbound_invoice_reconciliation" => [
                "consult_invoice" => "Voir la facture",
                "sentence" => "n'a pas trouvé d'éléments facturables pour sa facture."
            ],
            "index" => [
                "action" => "Action",
                "amount_excluding" => "Montant HT",
                "amount_including_tax" => "Montant TTC",
                "cannot_create_invoice_sentence" => "Pour ajouter une facture, vous devez avoir au moins un client et avoir renseigné votre IBAN.",
                "companies" => "Entreprises",
                "create_invoice" => "Créer une facture",
                "created_date" => "Date de création",
                "customer" => "Client",
                "dashboard" => "Tableau de bord",
                "empty" => "Vide",
                "fill_iban_button" => "Je renseigne mon IBAN",
                "my_bills" => "Mes Factures",
                "number" => "Numéro",
                "service_provider" => "Prestataire",
                "status" => "Statut",
                "tax_amount" => "Montant taxes"
            ],
            "new_inbound_uploaded" => [
                "consult_invoice" => "Je consulte la facture",
                "deposited_new_invoice" => "a déposé une nouvelle facture sur son espace.",
                "your_turn_to_play" => "A toi de jouer Antoine !"
            ],
            "show" => [
                "alert_business_plus" => "L'offre souscrite par votre client permet le dépot et la consultation des factures. Dans ce cadre, le statut de votre facture est géré hors de la plateforme AddWorking.",
                "alert_inbound_invoice_item_not_found" => "Le prestataire n'a pas trouvé d'élément facturable pour cette facture.",
                "amount_all_taxes_included" => "Montant total toutes taxes comprises (TTC) : ",
                "amount_of_taxes" => "Montant total des taxes (TVA): ",
                "attention" => "Attention",
                "bills" => "Facture",
                "comments" => "Commentaires",
                "companies" => "Entreprises",
                "compliant_invoice" => "Cette facture est conforme",
                "create_outbound_invoice" => "Créer la facture AddWorking",
                "dashboard" => "Tableau de bord",
                "file" => "Fichier",
                "general_information" => "Informations générales",
                "in_processing_by_addworking" => "En traitement par AddWorking",
                "information_calculated_from_mission_monitoring_lines" => "Informations calculées depuis les lignes de suivis de missions :",
                "information_provided_by_service_provider" => "Informations renseignées par le prestataire :",
                "my_bills" => "Mes factures",
                "not_compliant_invoice" => "Cette facture n'est pas conforme",
                "processed_by_addworking" => "Traité par AddWorking",
                "reconciliation" => "Réconciliation",
                "reconciliation_here" => "Réconcilier ici",
                "reconciliation_success_text" => "Bravo : cette facture prestataire est réconciliée !",
                "return" => "Retour",
                "total_amount_excluding_taxes" => "Montant total hors taxes (HT): ",
                "validate_invoice" => "Valider la facture",
                "waiting_administrative_verification" => "Cette facture est en attente de vérification administrative"
            ],
            "tracking" => [
                "paid" => "Facture payée par AddWorking le :date à :datetime",
                "replace_file" => "Facture remplacée par :user le :date à :datetime",
                "validate" => "Facture validée par AddWorking le :date à :datetime"
            ]
        ],
        "inbound_invoice_item" => [
            "_actions" => [
                "consult" => "Consulter",
                "dissociate" => "Dissocier",
                "edit" => "Modifier",
                "remove" => "Supprimer"
            ],
            "_form" => [
                "amount" => "Quantité",
                "general_information" => "Informations générales",
                "label" => "Description",
                "unit_price" => "Prix unitaire",
                "vat_rate" => "Taux de TVA"
            ],
            "_html" => [
                "amount" => "Quantité",
                "amount_all_taxes_included" => "Montant toutes taxes comprises (TTC)",
                "amount_before_taxes" => "Montant hors taxes (HT)",
                "consult_invoice" => "",
                "created_date" => "Date de création",
                "last_modified_date" => "Date de dernière modification",
                "tax_amount" => "Montant des taxes (TVA)",
                "unit_price" => "Prix unitaire",
                "username" => "Identifiant",
                "wording" => "Description ligne"
            ],
            "_table_items" => [
                "amount" => "Quantité",
                "label" => "Description ligne",
                "unit_price" => "Prix unitaire",
                "vat_rate" => "Taux de TVA"
            ],
            "_table_tracking_lines" => [
                "amount" => "Quantité",
                "customer_validation" => "Validation client",
                "mission_number" => "N° de mission",
                "period" => "Période",
                "provider_validation" => "Validation prestataire",
                "purpose_of_mission_monitoring_line" => "Objet de la ligne de suivi de mission",
                "total_ht" => "Total HT",
                "unit_price" => "Prix unitaire",
                "vat_rate" => "Taux TVA"
            ],
            "create" => [
                "companies" => "Entreprises",
                "create" => "Créer",
                "create_invoice_line" => "Créer une ligne de facture",
                "dashboard" => "Tableau de bord",
                "invoice_lines" => "Lignes de facture",
                "my_bills" => "Mes Factures",
                "return" => "Retour"
            ],
            "create_from_tracking_lines" => [
                "associate" => "Associer",
                "companies" => "Entreprises",
                "create" => "Créer",
                "dashboard" => "Tableau de bord",
                "invoice_lines" => "Lignes de facture",
                "mission_followups_affected_by_this_invoice" => "Suivis de missions concernés par cette facture",
                "my_bills" => "Mes Factures",
                "number_of_lines_selected" => "Nombre de lignes sélectionnées : ",
                "return" => "Retour",
                "total_amount_excluding_taxes_of_selected_lines" => "Montant total hors taxes (HT) des lignes sélectionnées : "
            ],
            "edit" => [
                "companies" => "Entreprises",
                "dashboard" => "Tableau de bord",
                "edit_invoice_line" => "Modifier une ligne de facture",
                "invoice_lines" => "Lignes de facture",
                "modifier" => "Modifier",
                "my_bills" => "Mes Factures",
                "register" => "Enregistrer",
                "return" => "Retour"
            ],
            "index" => [
                "action" => "Actions",
                "add_from_tracking_lines" => "Ajouter depuis les lignes de suivis",
                "amount" => "Quantité",
                "amount_all_taxes_included" => "Montant total toutes taxes comprises (TTC) : ",
                "amount_excluding" => "Montant HT",
                "amount_of_taxes" => "Montant total des taxes (TVA) : ",
                "companies" => "Entreprises",
                "customer_validation" => "Validation client",
                "dashboard" => "Tableau de bord",
                "invoice_lines" => "Lignes de facture",
                "label" => "Description ligne",
                "lines_of" => "Lignes de ",
                "mission" => "Mission",
                "my_bills" => "Mes Factures",
                "provider_validation" => "Validation prestataire",
                "return" => "Retour",
                "summary" => "Récapitulatif",
                "total_amount_excluding_taxes" => "Montant total hors taxes (HT) : ",
                "unit_price" => "Prix unitaire",
                "vat_rate" => "Taux TVA"
            ],
            "show" => [
                "companies" => "Entreprises",
                "dashboard" => "Tableau de bord",
                "invoice_lines" => "Lignes de facture",
                "my_bills" => "Mes Factures",
                "return" => "Retour"
            ]
        ],
        "outbound_invoice" => [
            "_actions" => [
                "actions" => "Actions",
                "add_row" => "Ajouter une ligne",
                "assign_number" => "Attribuer un numéro",
                "consult" => "Consulter",
                "create_balance_invoice" => "Créer une facture de reliquat",
                "create_payment_order" => "Créer un ordre de paiement",
                "create_remainder" => "Créer un reliquat",
                "details_tse_express_medical" => "Détails TSE Express Medical",
                "export_charles_lineart" => "Export Charles LIENART",
                "export_for_payment" => "Export pour Paiement",
                "export_tse_express_medical" => "Export TSE Express Medical",
                "generate" => "Générer",
                "numbering" => "Numérotation",
                "payment_orders" => "Ordres de paiement",
                "regenrate" => "Régénérer",
                "service_provider_invoices" => "Factures prestataires"
            ],
            "_form" => [
                "amount_excluding" => "Montant HT",
                "amount_including_tax" => "Montant TTC",
                "file" => "Fichier",
                "include_fix_cost" => "Inclure les frais fixes",
                "issue_date" => "Date d'émission",
                "number_of_providers" => "Nombre de prestataires",
                "payable_on" => "Payable le",
                "period" => "Période",
                "vat_rate" => "Montant TVA"
            ],
            "_html" => [
                "amount_excluding" => "Montant HT",
                "amount_including_tax" => "Montant TTC",
                "created_on" => "Créée le",
                "date_of_invoice" => "Date facture",
                "download_invoice" => "Télécharger la facture",
                "enterprise" => "Entreprise",
                "number" => "Numéro",
                "payable_on" => "Payable le",
                "payable_to" => "Payable à",
                "status" => "Statut",
                "updated_on" => "Mise à jour le",
                "username" => "Identifiant",
                "vat_rate" => "Montant TVA"
            ],
            "_missions_inbound_invoices" => [
                "amount" => "Montant",
                "empty" => "Vide",
                "number" => "Numéro",
                "period" => "Période",
                "status" => "Statut"
            ],
            "_missions_missions" => [
                "amount_per_day" => "Montant par jour",
                "number_of_days" => "Nombre de jours",
                "total" => "Total",
                "tour_id" => "ID Tournée"
            ],
            "_number" => ["attribute" => "Attribuer"],
            "_search" => [
                "enterprise" => "Entreprise",
                "number" => "Numéro",
                "reinitialize_search" => "(ré)initialiser la recherche",
                "search" => "Rechercher",
                "username" => "Identifiant"
            ],
            "_table" => [
                "amount_excluding" => "Montant HT",
                "amount_including_tax" => "Montant TTC",
                "attribute" => "Attribuer",
                "company" => "",
                "deadline" => "Échéance",
                "enterprise" => "Entreprise",
                "issued_on" => "Émise le",
                "number" => "Numéro",
                "payable_on" => "Payable le",
                "period" => "Période",
                "status" => "Statut",
                "uuid" => "UUID"
            ],
            "_vendors" => ["enterprise" => "Entreprise", "status" => "Statut", "uuid" => "UUID"],
            "create" => [
                "create" => "Créer",
                "create_invoice" => "Créer une facture",
                "create_new_invoice" => "Créer la facture",
                "dashboard" => "Tableau de bord",
                "invoices" => "Factures",
                "return_to_list_of_invoices" => "Retour à la liste des factures"
            ],
            "details" => [
                "invoice_details" => "Détails de la facture: ",
                "label" => "Label",
                "properties" => "Propriétés",
                "quantity" => "Qté",
                "service_provider_invoices" => "Facture(s) des prestataires",
                "unit_price" => "Prix unitaire",
                "vat_rate" => "TVA"
            ],
            "document" => [
                "_annex" => [
                    "agency_code" => "Code Agence",
                    "amount" => "Quantité",
                    "analytical_code" => "Code Analytique",
                    "annex" => "Annexe:",
                    "detail_subcontractors" => "Détail sous-traitants",
                    "management_fees_ht" => "Frais Gestion HT",
                    "subcontractor_code" => "Code sous-traitant",
                    "subcontractor_name" => "Nom du Sous-traitant",
                    "total_ht" => "Total HT",
                    "tour_code" => "Code Tournée",
                    "unit_price_ht" => "Prix Unitaire HT"
                ],
                "_details" => [
                    "amount_excluding" => "Montant HT",
                    "period_per_number_of_contract" => "Période / N° de contrat",
                    "subcontractor_code" => "Code sous-traitant",
                    "subcontractor_name" => "Nom du Sous-traitant"
                ],
                "_enterprises" => [
                    "addworking_sas" => "ADDWORKING SAS",
                    "at" => "A:",
                    "cps_contract_number" => "Contrat CPS1 n°",
                    "date" => "Date:",
                    "invoice_number" => "Facture n°",
                    "line_1" => "17 RUE LAC SAINT ANDRE",
                    "line_2" => "73370 LE BOURGET DU LAC",
                    "line_3" => "FRANCE",
                    "line_4" => "France",
                    "of" => "De:",
                    "represented_by" => "Représentée par",
                    "represented_by_julien" => "Représentée par Julien PERONA",
                    "vat_number" => " FR 718 1084 0900 00015",
                    "vat_number_label" => "N°TVA intracommunautaire :"
                ],
                "_summary" => [
                    "benifits_ht" => "Prestations HT",
                    "iban_for_transfer" => "IBAN pour virement :",
                    "iban_number" => "FR76 3000 3005 7100 0201 2497 429",
                    "management_fees_ht" => "Frais de gestion HT",
                    "payment_deadline" => "Date limite de paiement:",
                    "reference_tobe_reminded_on_transfer" => "Référence à rappeler sur le virement :",
                    "total_ht" => "TOTAL HT",
                    "total_ttc" => "TOTAL TTC",
                    "total_vat" => "TOTAL TVA"
                ],
                "invoice_number" => "Facture n°"
            ],
            "edit" => [
                "dashboard" => "Tableau de bord",
                "edit" => "Modifier",
                "invoices_issued" => "Factures émises",
                "register" => "Enregistrer",
                "return" => "Retour"
            ],
            "inbound_invoice_list" => [
                "action" => "Action",
                "amount_excluding" => "Montant HT",
                "amount_including_tax" => "Montant TTC",
                "dashboard" => "Tableau de bord",
                "export" => "Exporter",
                "invoices" => "Factures",
                "no_result" => "Aucun résultat",
                "number" => "Numéro",
                "processing" => "En traitement",
                "provider_invoices_included" => "Factures prestataires incluses",
                "reconcile" => "A réconcilier",
                "reconciliation_ok" => "Réconciliation OK",
                "return" => "Retour",
                "service_provider" => "Prestataire",
                "service_provider_invoices" => "Factures prestataires",
                "state" => "État",
                "status" => "Statut"
            ],
            "index" => [
                "action" => "Action",
                "add_invoice" => "Ajouter une facture",
                "amount_ht_by_ttc" => "Montant HT/TTC",
                "created_at" => "Créée le",
                "dashboard" => "Tableau de bord",
                "deadline" => "Échéance",
                "enterprise" => "Entreprise",
                "export" => "Exporter",
                "invoices_issued" => "Factures Émises",
                "issued_on" => "Émise le",
                "my_bills" => "Mes Factures",
                "number" => "Numéro",
                "payable_on" => "Payable le",
                "period" => "Période",
                "status" => "Statut"
            ],
            "missions" => [
                "add_comment" => "Ajouter un commentaire",
                "add_row" => "Ajouter une ligne",
                "amount_per_day" => "Montant par jour",
                "are_you_sure_delete" => "Voulez-vous vraiment supprimer cette ligne ?",
                "are_you_sure_delete_comment" => "Voulez-vous vraiment supprimer le commentaire ?",
                "attention_text" => "Attention : les montants de votre facture et de celle(s) de votre prestataire ne correspondent pas. Souhaitez-vous valider malgré tout cette facture ?",
                "comments_for_info" => "Commentaires (pour information et non visible sur la facture)",
                "entitled" => "Intitulé",
                "final_invoice_tobe_validated" => "Facture finale à valider",
                "final_invoice_validated" => "Facture finale validée",
                "import_data_from_your_system" => "Importer les données de votre système",
                "import_invoice_from_your_service_provider" => "Importer les factures de votre prestataire",
                "invoice_for_period" => "Facture de la période:",
                "no_longer_validate_for_invoicing" => "Ne plus valider pour facturation",
                "number_of_days" => "Nombre de jours",
                "payable" => "Payable:",
                "providers_list" => "Liste des prestataires",
                "removal" => "Suppression",
                "save_put_on_hold" => "Enregistrer et mettre en attente",
                "service_provider" => "Prestataire :",
                "total" => "Total",
                "validate_for_invoicing" => "Valider pour facturation"
            ],
            "show" => [
                "comments" => "Commentaires",
                "dashboard" => "Tableau de bord",
                "details" => "Détails",
                "file" => "Fichier",
                "general_information" => "Informations générales",
                "invoices" => "Factures",
                "remainder_of" => "Reliquat de",
                "return" => "Retour",
                "service_provider_invoices" => "Factures prestataires"
            ],
            "validate" => [
                "assign_number" => "Attribuer un numéro",
                "invoice_for_period" => "Facture de la période:",
                "invoice_has_no_number" => "Cette facture n'a pas de numéro",
                "payable" => "Payable:",
                "reconciliation" => "Réconciliation",
                "return_to_invoices" => "Retour à la facture",
                "total_tobe_invoiced" => "Total à facturer"
            ]
        ],
        "outbound_invoice_comment" => [
            "_form" => [
                "comment" => "Commentaire :",
                "not_stated_on_invoice" => "(non relevé sur la facture)"
            ]
        ],
        "outbound_invoice_item" => [
            "_actions" => ["remove" => "Supprimer"],
            "_form" => [
                "label" => "Intitulé",
                "label_placeholder" => "Libellé",
                "quantity" => "Quantité",
                "service_provider" => "Prestataire",
                "unit_price" => "Prix unitaire"
            ],
            "edit" => ["add_title" => "Ajouter", "edit_title" => "Modifier", "save" => "Sauvegarder"]
        ],
        "outbound_invoice_number" => [
            "_html" => [
                "created_at" => "Créé le",
                "priority" => "Prioritaire",
                "updated_at" => "Mis à jour le"
            ],
            "index" => [
                "associate" => "Associer",
                "bill" => "Facture",
                "enterprise" => "Entreprise",
                "numbering_of_invoices" => "Numérotation des factures",
                "reserve_new_number" => "Réserver un nouveau numéro"
            ]
        ],
        "outbound_invoice_payment_order" => [
            "_form" => [
                "no_result" => "Aucun résultat",
                "service_provider_does_not_have_iban" => "Impossible d'inclure ce prestataire dans l'ordre de paiement : ce prestataire n'a pas d'IBAN renseigné.",
                "service_provider_not_included_in_payment_order" => "Impossible d'inclure ce prestataire dans l'ordre de paiement : une de ses factures n'a pas de montant \"administrateur\" (renseigné par le Support d'AddWorking)"
            ],
            "_html" => [
                "bill" => "Facture",
                "change_status" => "Changer le statut",
                "created_at" => "Créé le",
                "status" => "Status",
                "updated_at" => "Mis à jour le"
            ],
            "index" => ["button_add" => "Ajouter", "title_index" => "Ordres de paiements"],
            "show" => ["properties" => "Propriétés"]
        ]
    ],
    "common" => [
        "address" => [
            "_form" => [
                "appartment_floor" => "Appartement, Étage...",
                "city_place" => "Ville ou Lieu dit"
            ],
            "edit" => ["edit_title" => "Adresses", "save" => "Sauvegardé"],
            "index" => ["title" => "Adresses"],
            "view" => ["address" => "Adresse", "general_information" => "Informations générales"]
        ],
        "comment" => [
            "_create" => [
                "add_comment" => "Ajouter un commentaire",
                "comment" => "Commentaire",
                "help_text" => "Public : visible par tout le monde. Protégé : visible par les membres de mon entreprise. Privé : visible seulement par moi.",
                "users_to_notify" => "Notifier",
                "visibility" => "Visibilité"
            ],
            "_html" => ["added_by" => "Ajouté par", "remove" => "Supprimer"]
        ],
        "csv_loader_report" => [
            "_actions" => ["download_csv_of_errors" => "Télécharger le CSV des erreurs"],
            "_html" => [
                "created_date" => "Date de création",
                "errors" => "Erreurs",
                "label" => "Label",
                "last_modified_date" => "Date de dernière modification",
                "number_of_lines" => "Nombre de lignes",
                "username" => "Identifiant"
            ],
            "index" => [
                "actions" => "Actions",
                "add" => "Ajouter",
                "csv_load_reports" => "Rapports de chargement CSV",
                "dashboard" => "Tableau de bord",
                "date" => "Date",
                "errors" => "Erreurs",
                "label" => "Libellé",
                "number_of_lines" => "Nombre de lignes"
            ],
            "show" => [
                "csv_load_reports" => "Rapports de chargement CSV",
                "dashboard" => "Tableau de bord",
                "general_information" => "Informations générales",
                "preview" => "Prévisualisation",
                "return" => "Retour"
            ]
        ],
        "file" => [
            "_actions" => ["download" => "Télécharger"],
            "_form" => [
                "file" => "Fichier",
                "general_information" => "Informations Générales",
                "mime_type" => "Type mime",
                "path" => "Chemin"
            ],
            "_html" => [
                "created_at" => "Créé le",
                "cut" => "Taille",
                "extension" => "Extension",
                "mime_type" => "Type MIME (Multipurpose Internet Mail Extensions)",
                "name" => "Nom du fichier",
                "owner" => "Propriétaire",
                "path" => "Chemin",
                "url" => "URL",
                "username" => "Identifiant"
            ],
            "_summary" => ["file" => "Fichier:"],
            "create" => [
                "create" => "Créer",
                "create_file" => "Créer un fichier",
                "dashboard" => "Tableau de bord",
                "files" => "Fichiers",
                "register" => "Enregistrer",
                "return" => "Retour"
            ],
            "edit" => [
                "dashboard" => "Tableau de bord",
                "edit" => "Modifier",
                "edit_file" => "Modifier le fichier",
                "files" => "Fichiers",
                "register" => "Enregistrer",
                "return" => "Retour"
            ],
            "index" => [
                "actions" => "Actions",
                "add_file" => "Ajouter un fichier",
                "associated_to" => "Associé à",
                "creation" => "Création",
                "cut" => "Taille",
                "dashboard" => "Tableau de bord",
                "files" => "Fichiers",
                "owner" => "Propriétaire",
                "path" => "Chemin",
                "type" => "Type"
            ],
            "show" => [
                "content" => "Contenu",
                "dashboard" => "Tableau de bord",
                "error" => "Une erreur s'est produite lors de la récupération du fichier; veuillez recharger la page",
                "files" => "Fichiers",
                "general_information" => "Informations générales"
            ]
        ],
        "folder" => [
            "1" => "Ajouter au dossier",
            "" => "Ajouter au dossier",
            "_form" => [
                "folder_name" => "Nom du dossier",
                "general_information" => "Informations Générales",
                "owner" => "Propriétaire",
                "visible_to_providers" => "Dossier visible par les prestataires ?"
            ],
            "_html" => [
                "actions" => "Actions",
                "created_at" => "Créé le",
                "created_date" => "Date de création",
                "description" => "Description",
                "folder_shared_with_service_providers" => "Dossier partagé avec les prestataires",
                "label" => "Label",
                "last_modified_date" => "Date de dernière modification",
                "owner" => "Propriétaire",
                "username" => "Identifiant"
            ],
            "_items" => [
                "actions" => "Actions",
                "created_at" => "Créé le",
                "description" => "Descriptif",
                "title" => "Titre"
            ],
            "attach" => [
                "add_to_folder" => "Ajouter au dossier",
                "attach" => "Attacher",
                "dashboard" => "Tableau de bord",
                "enterprises" => "Entreprises",
                "file" => "Dossier",
                "files" => "Dossiers",
                "link_to_file" => "Lier au dossier",
                "object_to_add_to_file" => "Objet à ajouter au dossier",
                "register" => "Enregistrer",
                "return" => "Retour"
            ],
            "create" => [
                "create" => "Créer",
                "create_folder" => "Créer un dossier",
                "dashboard" => "Tableau de bord",
                "enterprises" => "Entreprises",
                "files" => "Dossiers",
                "register" => "Enregistrer",
                "return" => "Retour"
            ],
            "edit" => [
                "dashboard" => "Tableau de bord",
                "edit" => "Modifier",
                "enterprises" => "Entreprises",
                "files" => "Dossiers",
                "register" => "Enregistrer",
                "return" => "Retour"
            ],
            "index" => [
                "actions" => "Actions",
                "add" => "Ajouter",
                "created_at" => "Créé le",
                "createed_at" => "Créé le",
                "dashboard" => "Tableau de bord",
                "enterprises" => "Entreprise",
                "file" => "Dossier",
                "files" => "Dossiers",
                "my_clients_files" => "Dossiers de mes clients",
                "my_folders" => "Mes dossiers",
                "owner" => "Propriétaire"
            ],
            "show" => [
                "content" => "Contenu",
                "dashboard" => "Tableau de bord",
                "enterprises" => "Entreprises",
                "files" => "Dossiers",
                "general_information" => "Informations générales",
                "return" => "Retour"
            ]
        ],
        "job" => [
            "_actions" => ["skills" => "Compétences"],
            "_form" => [
                "description" => "Description",
                "general_information" => "Informations Générales",
                "job" => "Métier",
                "parent" => "Parent"
            ],
            "_html" => [
                "description" => "Description",
                "last_name" => "Nom",
                "owner" => "Propriétaire",
                "parent" => "Parent",
                "skills" => "Compétences"
            ],
            "create" => [
                "create_new_skill" => "Créer un nouveau métier",
                "create_skill" => "Créer un métier",
                "dashboard" => "Tableau de bord",
                "enterprises" => "Entreprises",
                "job" => "Métiers",
                "register" => "Enregistrer",
                "return" => "Retour",
                "save_create_again" => "Enregistrer et créer à nouveau"
            ],
            "edit" => [
                "dashboard" => "Tableau de bord",
                "edit" => "Modifier",
                "edit_job" => "Modifier le métier",
                "enterprises" => "Entreprises",
                "job" => "Métiers",
                "register" => "Enregistrer",
                "return" => "Retour"
            ],
            "index" => [
                "actions" => "Actions",
                "add" => "Ajouter",
                "created_at" => "Créé le",
                "dashboard" => "Tableau de bord",
                "enterprises" => "Entreprises",
                "job" => "Métiers",
                "job_catalog" => "Catalogue des métiers",
                "last_name" => "Nom",
                "skills" => "Compétences"
            ],
            "show" => [
                "dashboard" => "Tableau de bord",
                "enterprises" => "Entreprises",
                "job" => "Métiers",
                "return" => "Retour"
            ]
        ],
        "passwork" => [
            "_html" => ["client" => "Client", "owner" => "Propriétaire", "skills" => "Compétences"],
            "create" => [
                "client" => "Client",
                "continue" => "Continuer",
                "create_new_passwork" => "Créer un nouveau Passwork",
                "create_passwork" => "Créer un Passwork",
                "dashboard" => "Tableau de bord",
                "enterprises" => "Entreprises",
                "general_information" => "Informations Générales",
                "passwork" => "Passworks",
                "return" => "Retour"
            ],
            "edit" => [
                "advance" => "Avancé",
                "beginner" => "Débutant",
                "dashboard" => "Tableau de bord",
                "edit" => "Modifier",
                "edit_passwork" => "Modifier le Passwork",
                "enterprises" => "Entreprises",
                "intermediate" => "Intermédiaire",
                "job" => "Métier",
                "level" => "Niveau",
                "passwork" => "Passworks",
                "register" => "Enregistrer",
                "return" => "Retour",
                "skill" => "Compétence"
            ],
            "index" => [
                "actions" => "Actions",
                "add" => "Ajouter",
                "client" => "Client",
                "created_at" => "Créé le",
                "dashboard" => "Tableau de bord",
                "enterprises" => "Entreprises",
                "owner" => "Propriétaire",
                "passworks" => "Passworks",
                "passworks_catalogs" => "Catalogue des Passworks",
                "skills" => "Compétences",
                "username" => "Identifiant"
            ],
            "show" => [
                "dashboard" => "Tableau de bord",
                "enterprises" => "Entreprises",
                "passwork" => "Passwork",
                "passworks" => "Passworks",
                "return" => "Retour"
            ]
        ],
        "phone_number" => [
            "_form" => [
                "note" => "Note",
                "note_placeholder" => "Note",
                "number" => "Numéro de téléphone",
                "number_placeholder" => "N° de tel."
            ]
        ],
        "skill" => [
            "_form" => [
                "description" => "Description",
                "general_information" => "Informations Générales",
                "skill" => "Compétence"
            ],
            "_html" => [
                "description" => "Description",
                "enterprise" => "Entreprise",
                "job" => "Métier",
                "skill" => "Compétence"
            ],
            "create" => [
                "create" => "Créer",
                "create_new_skill" => "Créer une nouvelle compétence",
                "create_skill" => "Créer une compétence",
                "dashboard" => "Tableau de bord",
                "enterprises" => "Entreprises",
                "job" => "Métiers",
                "return" => "Retour",
                "skills" => "Compétences"
            ],
            "edit" => [
                "dashboard" => "Tableau de bord",
                "edit" => "Modifier",
                "edit_skill" => "Modifier la compétence",
                "enterprises" => "Entreprises",
                "job" => "Métiers",
                "register" => "Enregistrer",
                "return" => "Retour",
                "skills" => "Compétences"
            ],
            "index" => [
                "actions" => "Actions",
                "add" => "Ajouter",
                "created_at" => "Créé le",
                "dashboard" => "Tableau de bord",
                "enterprises" => "Entreprises",
                "job" => "Métiers",
                "job_skills" => "Compétences du métier",
                "skills" => "Compétences"
            ],
            "show" => [
                "dashboard" => "Tableau de bord",
                "enterprises" => "Entreprises",
                "job" => "Métiers",
                "return" => "Retour",
                "skills" => "Compétences"
            ]
        ]
    ],
    "components" => [
        "billing" => [
            "inbound" => [
                "index" => [
                    "breadcrumb" => ["dashboard" => "Tableau de bord", "inbound" => "Factures prestataires"],
                    "button" => ["return" => "Retour"],
                    "card" => [
                        "amount_all_taxes_included" => "Montant TTC",
                        "amount_before_taxes" => "Montant HT",
                        "amount_of_taxes" => "Montant TVA",
                        "number_total_of_invoices" => "Nombre total de facture"
                    ],
                    "filters" => [
                        "associated" => "Associée",
                        "customer" => "Client",
                        "filter" => "Filtrer",
                        "month" => "Période",
                        "paid" => "Payée",
                        "pending" => "En attente",
                        "pending_association" => "En attente d'association",
                        "reset" => "Réinitialiser",
                        "status" => "Statut",
                        "to_validate" => "A valider",
                        "validated" => "Validée",
                        "vendor" => "Prestataire"
                    ],
                    "table_head" => [
                        "actions" => "Actions",
                        "amount_all_taxes_included" => "Montant TTC",
                        "amount_before_taxes" => "Montant HT",
                        "amount_of_taxes" => "Montant TVA",
                        "customer" => "",
                        "due_at" => "Echéance",
                        "enterprises" => "Prestataire / Client",
                        "month" => "Période",
                        "outbound_invoice" => "Facture AddWorking",
                        "status" => "Statut",
                        "vendor" => ""
                    ],
                    "title" => "Factures prestataires"
                ]
            ],
            "outbound" => [
                "payment_order" => [
                    "_actions" => [
                        "associated_invoices" => "Factures incluses",
                        "confirm_delete" => "Confirmer la suppression de l'ordre de paiement ?",
                        "delete" => "Supprimer"
                    ],
                    "associate" => [
                        "actions" => "Actions",
                        "amount_all_taxes_included" => "Montant TTC",
                        "amount_without_taxes" => "Montant HT",
                        "associate" => "Associer",
                        "billing_period" => "Période de facturation",
                        "customer" => "L'entreprise",
                        "deadline" => "Échéance de paiement",
                        "invoice_number" => "N° de facture",
                        "is_factoring" => "Affacturage",
                        "outbound_invoice_number" => "N° de facture Addworking",
                        "return" => "Retour",
                        "select" => "Associer ces factures Prestataires à l'ordre de paiement",
                        "status" => "Statut",
                        "table_row_empty" => "n'a pas de factures Prestataires à associer à l'ordre de paiement.",
                        "title" => "Factures Prestataires à associer",
                        "vendor" => "Prestataire"
                    ],
                    "dissociate" => [
                        "actions" => "Actions",
                        "amount_all_taxes_included" => "Montant TTC",
                        "amount_without_taxes" => "Montant HT",
                        "billing_period" => "Période de facturation",
                        "customer" => "L'entreprise",
                        "deadline" => "Échéance de paiement",
                        "dissociate" => "Dissocier",
                        "invoice_number" => "N° de facture prestataire",
                        "left_to_pay" => "Reste à payer",
                        "return" => "Retour",
                        "select" => "Dissocier ces factures Prestataires de l'ordre de paiement",
                        "status" => "Statut",
                        "table_row_empty" => "n'a pas de factures Prestataires incluses à l'ordre de paiement.",
                        "title" => "Factures Prestataires incluses",
                        "vendor" => "Prestataire"
                    ],
                    "html" => [
                        "bank_reference" => "Référence bancaire",
                        "count_items" => "Nombre de virements inclus",
                        "created_at" => "Date de création",
                        "customer" => "Nom du client",
                        "debtor_info" => "Informations du débiteur",
                        "deleted_at" => "Supprimé le",
                        "download" => "Télécharger",
                        "executed_at" => "Date d'exécution",
                        "file" => "Fichier XML",
                        "number" => "Numéro de l'ordre de paiement",
                        "outbound_invoice" => "Numéro de la facture AddWorking",
                        "reference" => "Référence",
                        "status" => "Statut",
                        "total_amount" => "Montant total",
                        "updated_at" => "Date de dernière modification"
                    ],
                    "index" => [
                        "button_create" => "Créer un ordre de paiement",
                        "button_return" => "Retour",
                        "table_row_empty" => "Cette facture Addworking n'a pas d'ordre de paiement.",
                        "title" => "Ordres de paiement"
                    ],
                    "show" => [
                        "button_return" => "Retour",
                        "execute" => "Exécuter",
                        "generate" => "Générer",
                        "title" => "Ordre de paiement n°"
                    ],
                    "table_head" => [
                        "actions" => "Actions",
                        "created_at" => "Crée le",
                        "executed_at" => "Exécuté le",
                        "number" => "Numéro",
                        "status" => "Statut"
                    ]
                ],
                "received_payment" => [
                    "_actions" => ["delete" => "Supprimer", "edit" => "Modifier"],
                    "buttons" => [
                        "actions" => "Actions",
                        "create" => "Créer",
                        "edit" => "Modifier",
                        "return" => "Retour"
                    ],
                    "create" => ["title" => "Confirmer la réception du paiement pour l'entreprise "],
                    "edit" => ["title" => "Modifier le paiement reçu n°"],
                    "import" => [
                        "_breadcrumb" => [
                            "dashboard" => "Tableau de bord",
                            "import" => "Import des paiements reçus",
                            "received_payments" => "Paiements reçus"
                        ],
                        "_form" => ["csv_file" => "Fichier CSV", "general_information" => "Informations générales"],
                        "import" => "Importer",
                        "title" => "Import des paiements reçus"
                    ],
                    "index" => [
                        "table_row_empty" => "Cette facture ne possède pas de paiements reçus.",
                        "title" => "Paiements reçus pour l'entreprise ",
                        "title_support" => "Paiements reçus"
                    ],
                    "received_payments" => "Paiements reçus",
                    "table_head" => [
                        "amount" => "Montant disponible",
                        "amount_consumed" => "Total facturé",
                        "bank_reference" => "Référence bancaire",
                        "bic" => "BIC",
                        "iban" => "IBAN",
                        "invoices" => "Factures",
                        "number" => "Numéro",
                        "received_at" => "Date de réception"
                    ]
                ]
            ]
        ],
        "enterprise" => [
            "activity_report" => [
                "application" => [
                    "views" => [
                        "activity_report" => [
                            "_breadcrumb" => ["activity_report" => "Suivi d'activité"],
                            "_form" => ["missions" => "Liste des missions par client"],
                            "create" => [
                                "create" => "Enregistrer",
                                "return" => "Retour ",
                                "title" => "Activité - du :start_date au :end_date"
                            ]
                        ],
                        "emails" => [
                            "request" => [
                                "addworking_team" => "L’équipe AddWorking",
                                "cordially" => "Cordialement",
                                "hello" => "Bonjour",
                                "submit_activity_report" => "Je clique ici",
                                "text_line1" => "Vous avez un ou plusieurs contrat(s) en cours avec votre client SOGETREL.",
                                "text_line2" => "Afin de faciliter votre suivi d’activité, merci de prendre 1 minute pour nous préciser sur quel(s) chantier(s) vous avez travaillé au mois de ",
                                "text_line3" => "Vous pouvez également copier-coller l'URL suivante dans la barre d'adresse de votre navigateur"
                            ]
                        ]
                    ]
                ]
            ],
            "enterprise" => [
                "_breadcrumb" => ["enterprise" => ""],
                "email" => [
                    "export" => [
                        "have_a_good_day" => "Bonne journée !",
                        "hello" => "Bonjour,",
                        "join_sentence" => ""
                    ]
                ]
            ],
            "export" => [
                "email" => [
                    "export" => [
                        "have_a_good_day" => "Bonne journée !",
                        "hello" => "Bonjour, ",
                        "join_sentence" => "Ci-joint les exports souhaités : entreprises et leurs activités, utilisateurs par entreprise, relations entre entreprises et facturation."
                    ]
                ]
            ]
        ]
    ],
    "contract" => [
        "contract" => [
            "_actions" => [
                "annexes" => "Annexes",
                "create_addendum" => "Créer un avenant",
                "download" => "Télécharger le contrat",
                "model" => "Maquette",
                "stakeholders" => "Parties prenantes",
                "variables" => "Variables"
            ],
            "_breadcrumb" => [
                "addendums" => "Avenants",
                "contracts" => "Contrats",
                "create" => "Créer",
                "edit" => "Modifier"
            ],
            "_form" => [
                "contract_due_date" => "Date d'échéance",
                "contract_properties" => "Propriétés du contrat",
                "contract_start_date" => "Date de début du contrat",
                "external_identifier" => "Identifiant externe",
                "last_name" => "Nom"
            ],
            "_html" => [
                "consult" => "Consulter",
                "created_at" => "Créé le",
                "effective_date" => "Date d'effet",
                "external_identifier" => "Identifiant externe",
                "file" => "Fichier",
                "model" => "Maquette",
                "number" => "Numéro",
                "owner" => "Propriétaire",
                "sign_in_hub" => "SigningHub",
                "status" => "Statut",
                "term" => "Terme",
                "username" => "Identifiant"
            ],
            "_summary" => [
                "contract_created" => "Le contrat est créé",
                "contract_is" => "Le contrat est ",
                "contract_with_atleast_2_stakeholders" => "Le contrat possède au moins 2 parties prenantes",
                "required_documents_valid" => "Les documents requis sont valides",
                "signatories_assigned" => "Les signataires sont assignés",
                "signatories_signed" => "Les signataires ont signé"
            ],
            "_table_head" => [
                "actions" => "Actions",
                "clients" => "",
                "deadline" => "Échéance",
                "last_name" => "Nom",
                "model" => "Maquette",
                "parties" => "Parties prenantes",
                "providers" => "",
                "status" => "Statut"
            ],
            "_table_row_empty" => [
                "create_addendum" => "Créer un avenant",
                "create_contract" => "Créer un contrat",
                "for_those_filters" => "pour les filtres sélectionnés",
                "has_no_addendum" => " n'a aucun avenant",
                "has_no_contract" => " ne possède aucun contrat",
                "the_company" => "L'entreprise ",
                "the_contract" => "Le contrat"
            ],
            "create" => [
                "create_blank_contract" => "Créer un contrat vierge",
                "create_contract" => "Créer un contrat",
                "create_from_existing_file" => "Créer à partir d'un fichier existant",
                "create_from_mockup" => "Créer à partir d'une maquette",
                "return" => "Retour"
            ],
            "create_blank" => ["create" => "Créer", "create_contract" => "Créer un contrat", "return" => "Retour"],
            "create_from_file" => [
                "contract" => "Contrat",
                "create" => "Créer",
                "create_contract" => "Créer un contrat",
                "return" => "Retour"
            ],
            "create_from_template" => ["create" => "Créer", "create_contract" => "Créer un contrat", "return" => "Retour"],
            "edit" => [
                "contract" => "Contrat",
                "edit" => "Modifier",
                "register" => "Enregistrer",
                "return" => "Retour",
                "status" => "Statut"
            ],
            "index" => [
                "add" => "Ajouter",
                "contract" => "Contrathèque",
                "filter" => "Filtrer",
                "reset_filter" => "Réinitialiser"
            ],
            "show" => ["return" => "Retour"]
        ],
        "contract_annex" => [
            "_breadcrumb" => ["annexes" => "Annexes", "create" => "Créer", "edit" => "Modifier"],
            "_form" => ["general_information" => "Informations Générales"],
            "_html" => [
                "created_date" => "Date de création",
                "label" => "Label",
                "last_modified_date" => "Date de dernière modification",
                "username" => "Identifiant"
            ],
            "_table_head" => ["action" => "Action", "file" => "Fichier"],
            "_table_row_empty" => [
                "add_document" => "Ajouter un document",
                "does_not_have_annex" => "ne possède aucune annexe",
                "the_contract" => "Le contrat"
            ],
            "create" => ["add_annex" => "Ajouter une annexe", "create" => "Créer", "return" => "Retour"],
            "edit" => ["edit" => "Modifier", "register" => "Enregistrer", "return" => "Retour"],
            "index" => ["add" => "Ajouter", "annexes" => "Annexes"],
            "show" => ["return" => "Retour"]
        ],
        "contract_document" => [
            "_breadcrumb" => ["create" => "Créer", "documents" => "Documents", "edit" => "Modifier"],
            "_form" => ["general_information" => "Informations Générales"],
            "_html" => [
                "created_date" => "Date de création",
                "label" => "Label",
                "last_modified_date" => "Date de dernière modification",
                "username" => "Identifiant"
            ],
            "_table_head" => [
                "action" => "Action",
                "document" => "Document",
                "provider" => "Prestataire",
                "status" => "Statut"
            ],
            "_table_row_empty" => [
                "add_document" => "Ajouter un document",
                "has_no_document" => "ne possède aucun document",
                "the_contract" => "Le contrat"
            ],
            "create" => ["add_document" => "Ajouter un document", "create" => "Créer", "return" => "Retour"],
            "edit" => ["edit" => "Modifier", "register" => "Enregistrer", "return" => "Retour"],
            "index" => ["add" => "Ajouter", "documents" => "Documents"],
            "show" => ["return" => "Retour"]
        ],
        "contract_party" => [
            "_actions" => [
                "dissociate_signer" => "Dissocier le signataire",
                "required_document" => "Document requis",
                "signatory" => "Signataire"
            ],
            "_assign_signatory" => ["signatory" => "Signataire"],
            "_breadcrumb" => ["create" => "Créer", "edit" => "Modifier", "stakeholders" => "Parties prenantes"],
            "_form" => [
                "declined" => "A décliné",
                "declined_on" => "Décliné le",
                "denomination" => "Dénomination",
                "general_information" => "Informations Générales",
                "has_signed" => "A signé",
                "signatory" => "Signataire",
                "signed_on" => "Signé le"
            ],
            "_html" => [
                "created_date" => "Date de création",
                "label" => "Label",
                "last_modified_date" => "Date de dernière modification",
                "username" => "Identifiant"
            ],
            "_signatory" => ["for" => "pour"],
            "_status" => [
                "assign_signer" => "Assigner un signataire",
                "at" => "le",
                "decline" => "Décliné",
                "must_assign_signer" => "Doit assigner un signataire",
                "must_sign" => "Doit signer",
                "sign" => "Signé",
                "status_unknown" => "Statut inconnu",
                "waiting" => "En attente"
            ],
            "_table_head" => [
                "actions" => "Actions",
                "denomination" => "Dénomination",
                "documents_provided" => "Document fournis",
                "signatory" => "Signataire",
                "status" => "Statut"
            ],
            "_table_row_empty" => [
                "add_stakeholder" => "Ajouter une partie prenante",
                "has_no_stakeholder" => "n'a aucune partie prenante.",
                "the_contract" => "Le contrat"
            ],
            "assign_signatory" => ["assign" => "Assigner", "edit" => "Modifier", "return" => "Retour"],
            "create" => [
                "add_stakeholder" => "Ajouter une partie prenante",
                "create" => "Créer",
                "denomination" => "Dénomination",
                "enterprise" => "Entreprise",
                "help_text" => "Exemple: 'Le Prestataire' ou 'Le Sous-Traitant'",
                "my_enterprise" => "Mon Entreprise",
                "return" => "Retour"
            ],
            "edit" => ["edit" => "Modifier", "register" => "Enregistrer", "return" => "Retour"],
            "index" => ["add" => "Ajouter", "stakeholders" => "Parties prenantes"],
            "show" => ["return" => "Retour"]
        ],
        "contract_party_document_type" => [
            "_actions" => [
                "associate_existing_document" => "Associer un document existant",
                "associate_new_document" => "Associer un nouveau document",
                "detach_document" => "Détacher le document"
            ],
            "_breadcrumb" => [
                "attach_document" => "Attacher un document",
                "create" => "Créer",
                "edit" => "Modifier",
                "required_document" => "Document requis"
            ],
            "_form" => [
                "mandatory" => "Obligatoire",
                "properties" => "Propriétés",
                "validation_required" => "Validation requise"
            ],
            "_html" => [
                "created_date" => "Date de création",
                "label" => "Label",
                "last_modified_date" => "Date de dernière modification",
                "username" => "Identifiant"
            ],
            "_table_head" => [
                "actions" => "Actions",
                "dcoument" => "",
                "document" => "Document",
                "mandatory" => "Obligatoire",
                "type" => "Type",
                "validation_required" => "Validation requise"
            ],
            "_table_row_empty" => [
                "add_required_document" => "Ajouter un document requis",
                "has_no_document" => "n'a aucun document à fournir.",
                "the_stakeholder" => "La partie prenante"
            ],
            "attach_existing_document" => [
                "associate" => "Associer",
                "associate_document" => "Associer un document",
                "document" => "Document",
                "return" => "Retour"
            ],
            "attach_new_document" => [
                "associate_document" => "Associer un document",
                "create_and_associate" => "Créer et associer",
                "document" => "Document",
                "return" => "Retour"
            ],
            "create" => [
                "add_required_document" => "Ajouter un document requis",
                "create" => "Créer",
                "return" => "Retour",
                "type_of_document" => "Type de document",
                "types_of_document" => "Types de documents"
            ],
            "edit" => ["edit" => "Modifier", "register" => "Enregistrer", "return" => "Retour"],
            "index" => ["add" => "Ajouter", "document_required_for" => "Document requis pour"],
            "show" => ["return" => "Retour"]
        ],
        "contract_template" => [
            "_actions" => [
                "annexes" => "Annexes",
                "contracts" => "Contrats",
                "stakeholders" => "Parties prenantes",
                "variables" => "Variables"
            ],
            "_breadcrumb" => [
                "contract_templates" => "Modèles de contrat",
                "create" => "Créer",
                "edit" => "Modifier"
            ],
            "_form" => [
                "general_information" => "Informations Générales",
                "model" => "Maquette",
                "model_name" => "Nom du modèle"
            ],
            "_html" => [
                "created_date" => "Date de création",
                "deleted_date" => "Date de suppression",
                "label" => "Label",
                "last_modified_date" => "Date de dernière modification",
                "username" => "Identifiant"
            ],
            "_table_head" => ["action" => "Action", "name_of_contract_template" => "Nom du modèle de contrat"],
            "_table_row_empty" => [
                "create_contract_template" => "Créer un modèle de contrat",
                "has_no_contract_template" => "ne possède aucun modèle de contrat",
                "the_enterprise" => "L'entreprise"
            ],
            "create" => [
                "create" => "Créer",
                "create_contract_template" => "Créer un modèle de contrat",
                "return" => "Retour"
            ],
            "edit" => ["edit" => "Modifier", "register" => "Enregistrer", "return" => "Retour"],
            "index" => ["add" => "Ajouter", "contract_templates" => "Modèles de contrat"],
            "show" => ["return" => "Retour"]
        ],
        "contract_template_annex" => [
            "_breadcrumb" => ["annexes" => "Annexes", "create" => "Créer", "edit" => "Modifier"],
            "_form" => ["general_information" => "Informations Générales"],
            "_html" => [
                "created_date" => "Date de création",
                "label" => "Label",
                "last_modified_date" => "Date de dernière modification",
                "username" => "Identifiant"
            ],
            "_table_row_empty" => [
                "add_document" => "Ajouter un document",
                "does_not_have_annex" => "ne possède aucune annexe",
                "the_template" => "La maquette"
            ],
            "create" => ["add_annex" => "Ajouter une annexe", "create" => "Créer", "return" => "Retour"],
            "edit" => ["edit" => "Modifier", "return" => "Retour"],
            "index" => ["add" => "Ajouter", "annexes" => "Annexes"],
            "show" => ["return" => "Retour"]
        ],
        "contract_template_party" => [
            "_actions" => ["documents_to_provide" => "Documents à fournir"],
            "_breadcrumb" => ["create" => "Créer", "edit" => "Modifier", "stakeholders" => "Parties prenantes"],
            "_form" => [
                "denomination" => "Dénomination",
                "general_information" => "Informations Générales"
            ],
            "_html" => [
                "created_date" => "Date de création",
                "label" => "Label",
                "last_modified_date" => "Date de dernière modification",
                "username" => "Identifiant"
            ],
            "_table_head" => [
                "actions" => "Actions",
                "denomination" => "Dénomination",
                "documents_to_provide" => "Documents à fournir",
                "order" => "Ordre"
            ],
            "_table_row_empty" => [
                "add_stakeholder" => "Ajouter une partie prenante",
                "has_no_stakeholder" => "ne possède aucune partie prenante",
                "the_template" => "La maquette"
            ],
            "create" => [
                "add_stakeholder" => "Ajouter une partie prenante",
                "create" => "Créer",
                "return" => "Retour"
            ],
            "edit" => ["edit" => "Modifier", "register" => "Enregistrer", "return" => "Retour"],
            "index" => ["add" => "Ajouter", "stakeholders" => "Parties prenantes"],
            "show" => ["return" => "Retour"]
        ],
        "contract_template_party_document_type" => [
            "_breadcrumb" => [
                "create" => "Créer",
                "documents_to_provide" => "Documents à fournir",
                "edit" => "Modifier"
            ],
            "_form" => [
                "general_information" => "Informations Générales",
                "mandatory_document" => "Document obligatoire",
                "type_of_document" => "Type de document",
                "validation_required" => "Validation requise"
            ],
            "_html" => [
                "created_date" => "Date de création",
                "label" => "Label",
                "last_modified_date" => "Date de dernière modification",
                "username" => "Identifiant"
            ],
            "_table_head" => [
                "actions" => "Actions",
                "document" => "Document",
                "mandatory" => "Obligatoire",
                "validated_by" => "Validé par",
                "validation_required" => "Validation Requise"
            ],
            "_table_row_empty" => [
                "add_required_document" => "Ajouter un document requis",
                "does_not_require_document" => "ne requiert aucun document",
                "the_stakeholder" => "La partie prenante"
            ],
            "create" => [
                "add_document_to_provide" => "Ajouter un document à fournir",
                "create" => "Créer",
                "return" => "Retour"
            ],
            "edit" => ["edit" => "Modifier", "register" => "Enregistrer", "return" => "Retour"],
            "index" => ["add" => "Ajouter", "documents_to_provide" => "Documents à fournir"],
            "show" => ["return" => "Retour"]
        ],
        "contract_template_variable" => [
            "_breadcrumb" => ["create" => "Créer", "edit" => "Modifier", "variables" => "Variables"],
            "_form" => ["general_information" => "Informations Générales"],
            "_html" => [
                "created_date" => "Date de création",
                "label" => "Label",
                "last_modified_date" => "Date de dernière modification",
                "username" => "Identifiant"
            ],
            "_table_row_empty" => [
                "add_variable" => "Ajouter une variable",
                "has_no_variables" => "n'a aucune variable",
                "the_template" => "La maquette"
            ],
            "create" => [
                "add_variable" => "Ajouter une variable",
                "create" => "Créer",
                "return" => "Retour"
            ],
            "edit" => ["edit" => "Modifier", "register" => "Enregistrer", "return" => "Retour"],
            "index" => ["add" => "Ajouter", "variables" => "Variables"],
            "show" => ["return" => "Retour"]
        ],
        "contract_variable" => [
            "_breadcrumb" => ["create" => "Créer", "edit" => "Modifier", "variables" => "Variables"],
            "_form" => ["general_information" => "Informations Générales"],
            "_html" => [
                "created_date" => "Date de création",
                "label" => "Label",
                "last_modified_date" => "Date de dernière modification",
                "username" => "Identifiant"
            ],
            "_table_row_empty" => [
                "add_variable" => "Ajouter une variable",
                "has_no_variables" => "n'a aucune variable",
                "the_contract" => "Le contrat"
            ],
            "create" => [
                "add_variable" => "Ajouter une variable",
                "create" => "Créer",
                "return" => "Retour"
            ],
            "edit" => ["edit" => "Modifier", "register" => "Enregistrer", "return" => "Retour"],
            "index" => ["add" => "Ajouter", "variables" => "Variables"],
            "show" => ["return" => "Retour"]
        ]
    ],
    "emails" => [
        "enterprise" => [
            "document" => [
                "expires_soon" => [
                    "addworking_supports_guarantee" => "AddWorking vous accompagne afin de garantir votre conformité auprès de vos clients.",
                    "cordially" => "Cordialement,",
                    "hello" => "Bonjour !",
                    "inform_legal_text_plurial" => "Dans ce cadre, nous vous informons que les documents légaux suivants arrivent à échéance",
                    "inform_legal_text_singular" => "Dans ce cadre, nous vous informons que le document légal suivant arrive à échéance",
                    "team_signature" => "L'équipe AddWorking",
                    "update_on_account" => "Afin de sécuriser les relations avec vos clients, merci de le mettre à jour sur votre compte.",
                    "update_on_account_button" => "J'actualise mes documents",
                    "valid_until" => "Valide jusqu'au"
                ],
                "outdated" => [
                    "addworking_supports_guarantee" => "AddWorking vous accompagne afin de garantir votre conformité auprès de vos clients.",
                    "cordially" => "Cordialement,",
                    "hello" => "Bonjour !",
                    "inform_legal_text_plurial" => "Dans ce cadre, nous vous informons que les documents légaux suivants arrivent à échéance",
                    "inform_legal_text_singular" => "Dans ce cadre, nous vous informons que le document légal suivant arrive à échéance",
                    "team_signature" => "L'équipe AddWorking",
                    "update_on_account" => "Afin de sécuriser les relations avec vos clients, merci de le mettre à jour sur votre compte.",
                    "update_on_account_button" => "J'actualise mes documents",
                    "valid_until" => "Expiré depuis le"
                ]
            ],
            "vendor" => [
                "noncompliance" => [
                    "addworking_supports_guarantee" => "AddWorking vous accompagne afin de garantir la conformité de vos sous-traitants et prestataires.",
                    "after_last_week" => "Depuis la semaine dernière :",
                    "before_last_week" => "Avant la semaine dernière :",
                    "compliance_service" => "Service Conformité AddWorking",
                    "cordially" => "Cordialement,",
                    "hello" => "Bonjour,",
                    "inform_legal_text_plural" => "Dans ce cadre, nous vous informons que les comptes suivants présentent une non-conformité susceptible d’impacter votre relation contractuelle ",
                    "inform_legal_text_plurial" => "Dans ce cadre, nous vous informons que les comptes suivants présentent une non-conformité susceptible d’impacter votre relation contractuelle ",
                    "inform_legal_text_singular" => "Dans ce cadre, nous vous informons que le compte suivant présente une non-conformité susceptible d’impacter votre relation contractuelle ",
                    "log_in" => "Me connecter",
                    "reminder_compliance_email" => "Pour rappel, les prestataires ont été notifiés et sont relancés afin d’actualiser leurs profils."
                ]
            ]
        ]
    ],
    "enterprise" => [
        "document" => [
            "_actions" => [
                "add_proof_authenticity" => "Ajouter une preuve d'authenticité",
                "download" => "Télécharger",
                "download_proof_authenticity" => "Télécharger la preuve d'authenticité",
                "download_proof_authenticity_from_yousign" => "Télécharger la preuve de signature",
                "edit_proof_authenticity" => "Modifier la preuve d'authenticité",
                "history" => "Suivi",
                "remove_precheck" => "Enlever le tag pré-check",
                "replace" => "Remplacer",
                "replacement_of_document" => "Confirmer le remplacement du document ?",
                "tag_in_precheck" => "Taguer en pré-check"
            ],
            "_form" => [
                "accept_by" => "Accepté par",
                "accept_it" => "Accepté le",
                "reject_by" => "Rejeté par",
                "reject_on" => "Rejeté le",
                "reject_reason" => "Raison de rejet",
                "validity_end" => "Fin de validité",
                "validity_start" => "Début de validité"
            ],
            "_form_accept" => ["expiration_date" => "Valable jusqu'au"],
            "_form_create" => [
                "expiration_date" => "Valable jusqu'au",
                "files" => "Fichier(s)",
                "publish_date" => "Date d'édition"
            ],
            "_form_fields" => ["additional_fields" => "Champs supplémentaires"],
            "_form_reject" => ["refusal_reason" => "Motif de refus"],
            "_html" => [
                "address" => "Adresse",
                "by" => "par",
                "code" => "Code",
                "created_the" => "Date de dépôt",
                "customer_attached" => "Clients rattachés au Prestataire",
                "days" => "jours",
                "delete_it" => "Supprimé le",
                "document_owner" => "Propriétaire du document",
                "expiration_date" => "Valable jusqu'au",
                "further_information" => "Informations complémentaires",
                "legal_representative" => "Représentants légaux",
                "modified" => "Modifié le",
                "pattern" => "Motif",
                "publish_date" => "Date de début de validité",
                "registration_town" => "Ville d'immatriculation",
                "reject_on" => "Date du rejet",
                "signed_at" => "Signé le",
                "status" => "Statut",
                "the" => "Le",
                "tracking_document" => "Suivi des relances",
                "type" => "Type",
                "username" => "Identifiant",
                "valid" => "Date de validation",
                "validity_period" => "Période de validité"
            ],
            "_status" => [
                "expired" => "Périmé",
                "missing" => "Manquant",
                "pending_signature" => "En attente de signature",
                "precheck" => "Pré-check",
                "refusal_comment" => "Commentaire de refus :",
                "rejected" => "Rejeté",
                "valid" => "Validé",
                "waiting" => "En attente"
            ],
            "accept" => [
                "accept" => "Accepter",
                "accept_document" => "Accepter le document",
                "company" => "Entreprise",
                "dashboard" => "Tableau de bord",
                "document" => "Document",
                "return" => "Retour"
            ],
            "actions_history" => [
                "action" => "Action",
                "active" => "Actif",
                "company" => "Entreprise",
                "created_by" => "Faite par",
                "dashboard" => "Tableau de bord",
                "date" => "Date",
                "document" => "Document",
                "history" => "Historique",
                "no_result" => "Aucun résultat",
                "return" => "Retour"
            ],
            "create" => [
                "choose" => "Générer l'attestation",
                "choose_model" => "Choisir une attestation sur l'honneur",
                "choose_model_for" => "Choisir une attestation pour ",
                "choose_model_sentence" => "Vous devez choisir une attestation à remplir selon votre situation.",
                "company" => "Entreprises",
                "create_document" => "Créer le document",
                "create_document_2" => " de ",
                "dashboard" => "Tableau de bord",
                "date_of_file_is_not_valid" => "Le document que vous déposez est expiré. Merci de transmettre une attestation en cours de validité.",
                "document" => "Document",
                "message" => "Je déclare ce document authentique et reconnais avoir pris connaissance de l'article 441-7 du code pénal (ci-dessous) :",
                "record" => "Enregistrer",
                "return" => "Retour",
                "scan_compliance_document_couldnt_read_security_code" => "La lecture automatique n'a pas pu lire le code de vérification à :time",
                "scan_compliance_document_couldnt_save_proof_of_authenticity" => "Le code de sécurité n'a pas permis de récupérer la preuve d'authenticité à :time",
                "scan_compliance_document_couldnt_validate_security_code" => "Le code de vérification n'a pas permis de valider le document à :time",
                "scan_compliance_document_error_occurred" => "<i class=\"fas fa-fw fa-times text-primary\" style=\"color: red !important;\"></i> Une erreur est survenue lors de la lecture automatique du document à :time",
                "scan_extract_kbis_document_couldnt_validate_address" => "<i class=\"fas fa-fw fa-times text-primary\" style=\"color: red !important;\"></i> L’adresse de l’entreprise (:time)",
                "scan_extract_kbis_document_couldnt_validate_company_name" => "<i class=\"fas fa-fw fa-times text-primary\" style=\"color: red !important;\"></i> Raison sociale (:time)",
                "scan_extract_kbis_document_couldnt_validate_end_of_extract" => "<i class=\"fas fa-fw fa-times text-primary\" style=\"color: red !important;\"></i> Mention fin de l’extrait (:time)",
                "scan_extract_kbis_document_couldnt_validate_legal_form" => "<i class=\"fas fa-fw fa-times text-primary\" style=\"color: red !important;\"></i> Forme légale (:time)",
                "scan_extract_kbis_document_couldnt_validate_town" => "<i class=\"fas fa-fw fa-times text-primary\" style=\"color: red !important;\"></i> La ville d’immatriculation (:time)",
                "scan_extract_kbis_document_has_validated_address" => "<i class=\"fas fa-fw fa-check text-primary\" style=\"color: green !important;\"></i> L’adresse de l’entreprise (:time)",
                "scan_extract_kbis_document_has_validated_company_name" => "<i class=\"fas fa-fw fa-check text-primary\" style=\"color: green !important;\"></i> Raison sociale (:time)",
                "scan_extract_kbis_document_has_validated_end_of_extract" => "<i class=\"fas fa-fw fa-check text-primary\" style=\"color: green !important;\"></i> Mention fin de l’extrait (:time)",
                "scan_extract_kbis_document_has_validated_legal_form" => "<i class=\"fas fa-fw fa-check text-primary\" style=\"color: green !important;\"></i> Forme légale (:time)",
                "scan_extract_kbis_document_has_validated_town" => "<i class=\"fas fa-fw fa-check text-primary\" style=\"color: green !important;\"></i> La ville d’immatriculation (:time)",
                "scan_urssaf_certificate_document_rejection" => "La lecture automatique n'a pas validé le document à :time",
                "scan_urssaf_certificate_document_validation" => "La lecture automatique a pré-check le document à :time",
                "scan_urssaf_certificate_extracted_date_is_not_valid" => "La lecture automatique n'a pas extraite une date valide à :time",
                "scan_urssaf_certificate_extracted_date_is_valid" => "<i class=\"fas fa-fw fa-check text-primary\" style=\"color: green !important;\"></i> La lecture automatique a extraite une date valide à :time",
                "scan_urssaf_certificate_extractors_could_not_read_date" => "La lecture automatique n'a pas pu lire la date du document à :time",
                "scan_urssaf_certificate_save_proof_of_authenticity" => "La preuve d'authenticité a été prise à :time",
                "scan_urssaf_certificate_siren_is_not_valid" => "La lecture automatique a détecté que le siren/siret du document est différent de celui de l'entreprise à :time",
                "scan_urssaf_certificate_siren_is_valid" => "<i class=\"fas fa-fw fa-check text-primary\" style=\"color: green !important;\"></i> SIREN/SIRET (:time)",
                "sentence_five" => "Les peines sont portées à 3 ans d’emprisonnement et à 45 000 € d’amende lorsqu’une infraction est commise en vue de porter",
                "sentence_four" => " ",
                "sentence_one" => "« Article 441-7 du code pénal : Indépendamment des cas prévus au présent chapitre, est puni d’un an d’emprisonnement et de 15 000 € d’amende le fait :",
                "sentence_six" => "préjudice au Trésor Public ou au patrimoine d’autrui, soit en vue d'obtenir un titre de séjour ou le bénéfice d'une protection contre l'éloignement. »",
                "sentence_three" => "- De falsifier une attestation ou un certificat originairement sincère ;",
                "sentence_two" => "- D’établir une attestation ou un certificat faisant état de faits matériellement inexacts ;"
            ],
            "edit" => [
                "active" => "Actif",
                "company" => "Entreprise",
                "dashboard" => "Tableau de bord",
                "document" => "Document",
                "modify" => "Modifier",
                "record" => "Enregistrer",
                "return" => "Retour"
            ],
            "expires_soon" => [
                "addworking_supports_guarantee" => "AddWorking vous accompagne afin de garantir votre conformité auprès de vos clients.",
                "inform_legal_text" => "Dans ce cadre, nous vous informons que le document légal suivant arrive à échéance",
                "inform_legal_text_general" => "Dans ce cadre, nous vous informons que les documents légaux suivants arrivent à échéance",
                "update_documents" => "J'actualise mes documents",
                "update_on_account" => "Afin de sécuriser les relations avec vos clients, merci de le mettre à jour sur votre compte.",
                "update_on_account_general" => "Afin de sécuriser les relations avec vos clients, merci de les mettre à jour sur votre compte.",
                "validity_end" => "fin de validité: le "
            ],
            "history" => [
                "active" => "Actif",
                "company" => "Entreprise",
                "dashboard" => "Tableau de bord",
                "deleted" => "Supprimé",
                "deletion_date" => "Date de suppression",
                "deposit_date" => "Date de dépôt",
                "document" => "Document",
                "expiration_date" => "Date d'expiration",
                "history" => "Historique",
                "no_result" => "Aucun résultat",
                "return" => "Retour",
                "service_provider" => "Prestataire",
                "state" => "État",
                "status" => "Statut"
            ],
            "index" => [
                "action" => "Actions",
                "company" => "Entreprise",
                "consult" => "Consulter",
                "contract" => "Contrat :",
                "dashboard" => "Tableau de bord",
                "deposit_date" => "Date de dépôt",
                "document" => "Document(s) de",
                "document_name" => "Nom du document",
                "documents" => "Documents",
                "documents_contractuels" => "Documents contractuels",
                "documents_contractuels_specifiques" => "Documents contractuels spécifiques",
                "documents_legaux" => "Documents légaux",
                "documents_metier" => "Documents métier",
                "download_validated_documents" => "Télécharger les documents validés",
                "enterprise_name" => "Entreprise concernée",
                "expiration_date" => "Date d'expiration",
                "expire_in" => "Expiré depuis :days jours",
                "no_document" => "Aucun document",
                "status" => "Statut"
            ],
            "proof_authenticity" => [
                "create" => [
                    "add_proof_authenticity" => "Ajouter une preuve d'authenticité",
                    "company" => "Entreprise",
                    "dashboard" => "Tableau de bord",
                    "document" => "Document",
                    "record" => "Enregistrer",
                    "return" => "Retour"
                ],
                "edit" => [
                    "company" => "Entreprise",
                    "dashboard" => "Tableau de bord",
                    "document" => "Document",
                    "edit" => "Modifier la preuve d'authenticité",
                    "record" => "Enregistrer",
                    "return" => "Retour"
                ],
                "proof_authenticity" => "Preuve d'authenticité"
            ],
            "reject" => [
                "comment" => "Commentaire",
                "company" => "Entreprise",
                "dashboard" => "Tableau de bord",
                "decline_document" => "Refuser le document",
                "document" => "Document",
                "refuse" => "Refuser",
                "return" => "Retour"
            ],
            "rejected" => [
                "addworking_supports_guarantee" => "AddWorking vous accompagne afin de garantir votre conformité auprès de vos clients.",
                "cordially" => "Cordialement,",
                "greeting" => "Bonjour,",
                "inform_legal_text" => "Dans ce cadre, nous vous informons que le document",
                "pattern" => "Motif",
                "please_update_account" => "Merci de le mettre à jour sur votre compte.",
                "show_non_compliance" => "présente une non-conformité.",
                "update_documents" => "J'actualise mes documents"
            ],
            "show" => [
                "accept" => "Accepter",
                "code" => "Code",
                "company" => "Entreprise",
                "dashboard" => "Tableau de bord",
                "document" => "Document",
                "no_file" => "Pas de fichier disponible.",
                "pre_validate" => "Pré-valider",
                "proof_authenticity" => "Preuve d'authenticité",
                "refuse" => "Refuser",
                "return" => "Retour",
                "type" => "Type"
            ],
            "show_model" => [
                "add_documents" => "Cette attestation nécessite des documents à déposer avant de la signer",
                "company" => "Entreprise",
                "dashboard" => "Tableau de bord",
                "document" => "Documents",
                "no_file" => "Pas de fichier correspondant",
                "return" => "Retour",
                "sign" => "Signer",
                "sign_sentence" => "Veuillez vérifier l'exactitude des informations de cette attestation avant de signer."
            ],
            "tracking" => [
                "create_document_type" => "Document :document_type_name déposé",
                "expire" => "Le document :doc_type_name de :enterprise_name a expiré",
                "expired" => ":user_name a été notifié de l'arrivée à expiration de son document :doc_type_name dans :expire_in jours",
                "expired_many_users" => "Les responsables conformité ont été notifié de l'arrivée à expiration du document :doc_type_name dans :expire_in jours",
                "outdated" => ":user_name a été notifié pour déposer le document :doc_type_name expiré",
                "outdated_many_users" => "Les responsables conformité ont été notifié pour déposer le document :doc_type_name expiré",
                "reject" => "Document :document_type_name refusé",
                "reject_notification" => "Notification de refus envoyée",
                "validate" => "Document :document_type_name validé"
            ]
        ],
        "document_collection" => [
            "_status" => [
                "all_document_valid" => "Tous les documents sont valides",
                "atleast_one_document_non_compliant" => "Au moins un document est non conforme",
                "atleast_one_document_out_dated" => "Au moins un document est périmé",
                "atleast_one_document_pending" => "Au moins un document est en attente",
                "no_document_received" => "Aucun document reçu"
            ]
        ],
        "document_type" => [
            "_actions" => [
                "add_to_folder" => "Ajouter au dossier",
                "consult" => "Consulter",
                "document_type_model" => "Attestations sur l'honneur",
                "edit" => "Modifier",
                "reject_reason_index" => "Motifs de refus",
                "remove" => "Supprimer"
            ],
            "_add_model" => [
                "add_modify_template" => "Ajouter/Modifier le document modèle",
                "file" => "Fichier"
            ],
            "_form" => [
                "country_document" => "Pays",
                "customer" => "Client",
                "deadline_date" => "Date butoir de validité (incluse)",
                "document_code" => "Code du document",
                "document_description" => "Description du document",
                "document_name" => "Nom du document",
                "document_template" => "Document modèle",
                "document_type" => "Type du document",
                "enter_document_description" => "Entrez la description du document...",
                "example_driver_name" => "Exemple: Permis de conduire",
                "exmaple_dmpc_v0" => "Exemple : DMPC_V0",
                "is_automatically_generated" => "Cocher si le document a besoin d'une attestation sur l'honneur auto-générée",
                "is_mandatory" => "Document obligatoire?",
                "need_proof_authenticity" => "Cocher si le document a besoin d'une preuve d'authenticité",
                "needs_validation" => "Validateur de la conformité document",
                "request_document" => "Demander le document pour quelle(s) forme(s) légale(s)?",
                "support" => "Support",
                "validity_period" => "Période de validité",
                "validity_period_days" => "Période de validité en jours."
            ],
            "_html" => [
                "created_at" => "Créé le",
                "customer" => "Client",
                "days" => "jour(s)",
                "deadline_date" => "Date butoir de validité (incluse)",
                "delete_it" => "Supprimé le",
                "document_template" => "Document modèle",
                "legal_forms" => "Formes légales autorisées",
                "mandatory" => "Obligatoire",
                "modified" => "Modifié le",
                "no" => "Non",
                "possible_validation_by" => "Validation possible par :",
                "support" => "Support",
                "yes" => "Oui"
            ],
            "_summary" => [
                "ask_by" => "demandé par",
                "business" => "Document métier",
                "contractual" => "Document contractuel",
                "download_model" => "télécharger le modèle",
                "informative" => "Document d'informations",
                "job" => "",
                "legal" => "Document légal",
                "mandatory" => "Obligatoire",
                "optional" => "Optionnel"
            ],
            "_table_row" => [
                "add" => "Ajouter",
                "replace" => "Remplacer",
                "replacement_of_document" => "Confirmer le remplacement du document ?"
            ],
            "create" => [
                "company" => "Entreprise",
                "create" => "Créer",
                "create_document" => "Créer le document",
                "create_new_document" => "Créer un nouveau document",
                "dashboard" => "Tableau de bord",
                "document_type_management" => "Gestion des types de documents",
                "return" => "Retour"
            ],
            "edit" => [
                "company" => "Entreprise",
                "dashboard" => "Tableau de bord",
                "document_type_management" => "Gestion des types de documents",
                "edit" => "Modifier",
                "edit_document" => "Modifier le document",
                "return" => "Retour"
            ],
            "index" => [
                "add" => "Ajouter",
                "dashboard" => "Tableau de bord",
                "document_list" => "Liste des documents à fournir pour",
                "document_type_management" => "Gestion des types de documents",
                "mandatory" => "Obligatoire",
                "missing_documents_before_sign_contract" => "Il manque des documents avant de pouvoir signer votre contrat.",
                "return" => "Retour"
            ],
            "show" => [
                "add_field" => "Ajouter un champ",
                "add_modify_template" => "Ajouter/Modifier le document modèle",
                "company" => "Entreprise",
                "dashboard" => "Tableau de bord",
                "document_type_management" => "Gestion des types de documents",
                "general_information" => "Informations générales"
            ]
        ],
        "document_type_field" => [
            "_create" => [
                "add_modify_field" => "Ajouter/Modifier un champ",
                "bubble_info" => "Info bulle",
                "filed_name" => "Nom du champ",
                "filed_type" => "Type du champ",
                "required_filed" => "Champ obligatoire"
            ],
            "_edit" => [
                "bubble_info" => "Info bulle",
                "edit_field" => "Modifier le champ",
                "filed_name" => "Nom du champ",
                "filed_type" => "Type du champ",
                "required_filed" => "Champ obligatoire"
            ]
        ],
        "enterprise" => [
            "_actions" => [
                "accounting_expense" => "Options comptables",
                "addworking_invoice" => "Factures Addworking",
                "billing_settings" => "Paramètres de facturation",
                "consult_contract" => "Contrats",
                "consult_document" => "Documents",
                "consult_invoice" => "Factures",
                "consult_passwork" => "Passwork",
                "contract_mockups" => "Maquettes de contrat",
                "contracts" => "Contrats",
                "customer_invoice" => "",
                "customer_invoice_beta" => "",
                "document_management" => "Gestion des documents",
                "documents" => "Documents",
                "edenred_codes" => "Codes Edenred",
                "files" => "Dossiers",
                "invoicing" => "Facturation",
                "membership_management" => "Gestion des membres",
                "passworks" => "Passworks",
                "payment" => "Paiement",
                "payment_order" => "Ordre de paiement",
                "providers" => "Prestataires",
                "purchase_order" => "Bons de commande",
                "received_payments" => "Paiements reçus",
                "refer_service_provider" => "Référencer un prestataire",
                "refer_user" => "Référencer un utilisateur",
                "resource_management" => "Gestion des ressources",
                "service_provider_invoices" => "Factures Prestataire",
                "sites" => "Sites",
                "subsidiaries" => "Filiales",
                "trades" => "Métiers"
            ],
            "_activities" => ["employee" => "employé(s)"],
            "_badges" => ["client" => "Client", "service_provider" => "Prestataire"],
            "_breadcrumb" => ["companies" => "", "dashboard" => "Tableau de bord", "enterprise" => "Entreprises"],
            "_departments" => ["intervention_department" => "Départements d'intervention"],
            "_form" => [
                "business_plus" => "Business +",
                "business_plus_message" => "Business +: permettant aux clients de laisser leurs prestataires déposer leurs factures pour consultation",
                "collect_business_turnover" => "Collecter le CA",
                "company_name" => "Nom de l'entreprise",
                "company_registered_at" => "Entreprise immatriculée à",
                "contractualization_language" => "Veuillez choisir la langue de contractualisation souhaitée ?",
                "country" => "Pays",
                "external_identifier" => "Identifiant externe",
                "general_information" => "Informations générales",
                "legal_form" => "Forme légale",
                "main_activity_code" => "Code APE",
                "registration_date" => "Entreprise immatriculée le",
                "siren_14_digit_help" => "Il s’agit d’un identifiant formé de 14 chiffres composé du SIREN (9 chiffres) et du NIC (5 chiffres).",
                "siret_number" => "Numéro SIRET",
                "social_reason" => "Raison sociale",
                "structure_created" => "Structure en cours de création ?",
                "vat_number" => "N° TVA"
            ],
            "_form_disabled_inputs" => [
                "company_name" => "Nom de l'entreprise",
                "company_registered_at" => "Entreprise immatriculée à",
                "contact_support" => "Veuillez contacter le Support pour mettre à jour les informations générales de votre entreprise",
                "external_identifier" => "Identifiant externe",
                "general_information" => "Informations générales",
                "legal_form" => "Forme légale",
                "main_activity_code" => "Code APE",
                "siren_14_digit_help" => "Il s’agit d’un identifiant formé de 14 chiffres composé du SIREN (9 chiffres) et du NIC (5 chiffres).",
                "siret_number" => "Numéro SIRET",
                "social_reason" => "Raison sociale",
                "structure_created" => "Structure en cours de création ?",
                "vat_number" => "N° TVA"
            ],
            "_html" => [
                "activity" => "Activité",
                "activity_department" => "Départements d'activité",
                "add_one" => "ajoutez-en un",
                "address" => "Adresse",
                "affiliate" => "Filiale de",
                "applicable_vat" => "TVA Applicable",
                "client_id" => "Identifiant Client",
                "created_the" => "Créé le",
                "customer" => "Client",
                "iban" => "IBAN",
                "id" => "Identifiant",
                "legal_representative" => "Représentants légaux",
                "main_activity_code" => "Code APE",
                "modified" => "Modifié le",
                "no_logo" => "Pas encore de logo",
                "number" => "Numéro",
                "phone_number" => "Numéros de téléphone",
                "registration_town" => "Immatriculée à",
                "sectors" => "Secteurs",
                "siret" => "SIRET",
                "social_reason" => "Raison sociale",
                "type" => "Type",
                "vat_number" => "Numéro de TVA"
            ],
            "_iban" => [
                "cannot_see_company_iban" => "Vous ne pouvez pas voir l'IBAN de cette entreprise"
            ],
            "_index_form" => [
                "all_companies" => "Toutes les entreprises",
                "hybrid" => "Hybride",
                "providers" => "Prestataires",
                "subsidiaries" => "Filiales"
            ],
            "_type" => ["customer" => "Client", "service_provider" => "Prestataire"],
            "create" => [
                "activity" => "Activité",
                "address_line_1" => "Adresse ligne 1",
                "address_line_2" => "Adresse ligne 2",
                "ape_code_help" => "Le code APE (activité principale exercée), est composé de 4 chiffres + 1 lettre",
                "city" => "Ville",
                "company_activity" => "Activité de l'entreprise",
                "contact" => "Contact",
                "country" => "Pays",
                "create" => "Créer",
                "create_company" => "Créer l'entreprise",
                "dashboard" => "Tableau de bord",
                "department" => "Département",
                "department_help" => "Vous pouvez choisir plusieurs départements en maintenant la touche [Ctrl] de votre clavier.",
                "enterprise" => "Entreprises",
                "job_title_in_company" => "Quelle fonction occupez-vous au sein de votre entreprise ?",
                "main_address" => "Adresse principale",
                "note" => "Note",
                "number_of_employees" => "Nombre d'employés",
                "postal_code" => "Code postal",
                "return" => "Retour",
                "sector" => "Secteur",
                "start_new_business" => "Créer une nouvelle entreprise",
                "telephone_1" => "Téléphone ligne 1",
                "telephone_2" => "Téléphone ligne 2",
                "telephone_3" => "Téléphone ligne 3",
                "user_job_title" => "Rôle dans l'entreprise"
            ],
            "edit" => [
                "activity" => "Activité",
                "address_line_1" => "Adresse ligne 1",
                "address_line_2" => "Adresse ligne 2",
                "business_type" => "Type(s) d'entreprise",
                "choice_legal_representative" => "Choix représentant légal et signataire",
                "city" => "Ville",
                "dashboard" => "Tableau de bord",
                "legal_representative" => "Représentant légal",
                "main_address" => "Adresse principale",
                "modifier" => "Modifier",
                "postal_code" => "Code postal",
                "record" => "Enregistrer",
                "return" => "Retour",
                "sectors" => "Secteurs",
                "service_provider" => "Prestataire",
                "sign" => "Signataire"
            ],
            "index" => [
                "actions" => "Actions",
                "activity" => "Activité",
                "add" => "Ajouter",
                "company" => "Entreprises",
                "create" => "Créer",
                "created" => "Créé le",
                "customer" => "Client",
                "dashboard" => "Tableau de bord",
                "enterprise" => "Entreprises",
                "filter" => [
                    "activity" => "Activité",
                    "activity_field" => "Secteur d'activité",
                    "identification_number" => "SIRET ou SIREN",
                    "legal_form" => "Forme juridique",
                    "legal_representative" => "Représentant légal",
                    "main_activity_code" => "Code APE",
                    "name" => "Nom d'entreprise",
                    "phone" => "Téléphone",
                    "reinitialize" => "Réinitialiser",
                    "type" => "Type",
                    "zip_code" => "Code postal ou Département"
                ],
                "hybrid" => "Hybride",
                "identification_number" => "SIRET",
                "leader" => "Dirigeant",
                "legal_form" => "Forme juridique",
                "legal_representative" => "Représentant légal",
                "main_activity_code" => "Code APE (secteur d'activité)",
                "name" => "Nom d'enterprise",
                "phone" => "Téléphone",
                "return" => "Retour",
                "service_provider" => "Prestataire",
                "society" => "Société",
                "type" => "Type",
                "update" => "Mis à jour le",
                "vendor" => "Prestataire"
            ],
            "language" => ["english" => "Anglais", "french" => "Français", "german" => "Allemand"],
            "requests" => [
                "store_enterprise_request" => [
                    "messages" => [
                        "unique" => "Le numéro SIRET renseigné existe déjà. Merci de vérifier que votre entreprise n’a pas déjà été créée sur AddWorking par un membre de votre équipe."
                    ]
                ]
            ],
            "show" => [
                "business_turnover" => "CA annuel",
                "dashboard" => "Tableau de bord",
                "enterprise" => "Entreprise",
                "general_information" => "Informations générales",
                "phone_number" => "Numéros de téléphone",
                "providers" => "Prestataires",
                "return" => "Retour",
                "sogetrel_data" => "Données Sogetrel"
            ],
            "tabs" => [
                "_business_turnover" => [
                    "amount" => "CA",
                    "business_turnover" => "",
                    "created_by_name" => "Déclarant",
                    "no_activity" => "Pas d'activité",
                    "no_activity_message" => "(a déclaré ne pas avoir eu d'activité sur cette année)",
                    "year" => "Année"
                ],
                "_phone_number" => [
                    "action" => "Actions",
                    "add" => "Ajouter",
                    "date_added" => "Date d'ajout",
                    "note" => "Notes",
                    "phone_number" => "Numéro de téléphone"
                ],
                "_sogetrel_data" => [
                    "edit_oracle_id" => "Modifier l'Oracle Id",
                    "group_counted_march" => "Compta Groupe \"Marché\"",
                    "no" => "Non",
                    "product_accounting_group" => "Compta Groupe \"Produit\"",
                    "record" => "Enregistrer",
                    "sent_navibat" => "Envoyé à Oracle",
                    "vat_group_accounting" => "Compta Groupe \"Marché\" - TVA",
                    "yes" => "Oui"
                ],
                "_vendor" => [
                    "company" => "Entreprise",
                    "legal_representative" => "Représentant légal",
                    "provide_since" => "Prestataire depuis"
                ]
            ]
        ],
        "enterprise_activity" => [
            "_form" => [
                "enterprise_activity_help" => "Exemple : Commerce, Restauration, Services à la personne, etc.",
                "select_multiple_departments_help" => "Maintenez la touche CTRL de votre clavier enfoncée pour sélectionner plusieurs départements à la fois."
            ],
            "create" => [
                "create" => "Créer",
                "create_company" => "Créer l'entreprise",
                "dashboard" => "Tableau de bord",
                "general_information" => "Informations générales",
                "return" => "Retour"
            ],
            "edit" => [
                "company_activity" => "Activité de l'entreprise",
                "modify_activity" => "Modifier l'activité de l'entreprise"
            ]
        ],
        "enterprise_signatory" => [
            "_form" => [
                "director" => "Directeur",
                "function_legal_representative" => "Fonction du représentant légal",
                "legal_representative" => "Représentant légal",
                "quality_legal_representative" => "Qualité du représentant légal",
                "signatory_contracts" => "Signataire des contrats"
            ]
        ],
        "enterprise_subsidiaries" => [
            "create" => [
                "create" => "Créer",
                "create_subsidiary" => "Créer une filiale de",
                "dashboard" => "Tableau de bord",
                "return" => "Retour",
                "subsidiaries" => "Filiales"
            ],
            "index" => [
                "create_subsidiary" => "Créer une filiale de",
                "dashboard" => "Tableau de bord",
                "return" => "Retour",
                "subsidiaries" => "Filiales",
                "subsidiaries_of" => "Filiales de"
            ]
        ],
        "enterprise_vendors" => [
            "_actions" => [
                "dereference" => "Déréférencer",
                "see_documents" => "Voir ses documents",
                "see_passwork" => "Voir son passwork",
                "see_passworks" => "Voir ses passworks"
            ]
        ],
        "iban" => [
            "_actions" => ["actions" => "Actions", "download" => "Télécharger", "replace" => "Remplacer"],
            "_form" => [
                "bank_code" => "Code Banque (BIC ou SWIFT)",
                "label" => "Libellé",
                "rib_account_statement" => "Relevé d'Identité Bancaire (RIB)"
            ],
            "_html" => ["download" => "Télécharger", "status" => "Statut"],
            "create" => [
                "company_iban" => "IBAN de l'entreprise",
                "dashboard" => "Tableau de bord",
                "enterprise" => "Entreprise",
                "general_information" => "Informations générales",
                "record" => "Enregistrer",
                "return" => "Retour"
            ],
            "show" => [
                "check_mailbox" => "Merci de vérifier votre boîte email.",
                "company_iban" => "IBAN de la société",
                "dashboard" => "Tableau de bord",
                "enterprise" => "Entreprise",
                "iban_awaiting_confirmation" => "IBAN en attente de votre confirmation",
                "label" => "Libellé",
                "resend_confirmation_email" => "Renvoyer l'email de confirmation",
                "title" => "IBAN de la société "
            ]
        ],
        "invitation" => [
            "_actions" => ["consult" => "Consulter", "revive" => "Relancer"],
            "_index_form" => [
                "accepted" => "Acceptée(s)",
                "all_invitations" => "Toutes les invitations",
                "in_progress" => "En cours de validation",
                "pending" => "En attente de réception",
                "rejected" => "Expirée / Rejetée"
            ],
            "_invitation_status" => [
                "accepted" => "Acceptée",
                "in_progress" => "En cours de validation",
                "pending" => "En attente de réception",
                "rejected" => "Expirée / Rejetée"
            ],
            "_invitation_types" => ["member" => "Utilisateur", "mission" => "Mission", "vendor" => "Prestataire"],
            "_table_head" => [
                "actions" => "Actions",
                "email" => "Email",
                "guest" => "Invité",
                "status" => "Statut",
                "type" => "Type"
            ],
            "index" => [
                "dashboard" => "Tableau de bord",
                "enterprise" => "Entreprise",
                "expire" => "Expire :date",
                "expired" => "A expiré",
                "index_relaunch" => "Relancer en lot",
                "invite_member" => "Inviter un membre",
                "invite_provider" => "Inviter un prestataire",
                "my_invitations" => "Mes Invitations",
                "of" => "de",
                "return" => "Retour"
            ],
            "show" => [
                "dashboard" => "Tableau de bord",
                "enterprise" => "Entreprise",
                "expired_on" => "A expiré le",
                "expires_on" => "Expiré le",
                "guest" => "Invité",
                "invitation_for" => "Invitation pour",
                "my_invitations" => "Mes Invitations",
                "return" => "Retour",
                "revive" => "Relancer",
                "status" => "Statut",
                "type" => "Type"
            ]
        ],
        "legal_form" => [
            "_actions" => [
                "edit" => "Modifier",
                "show" => "Consulter"
            ],
            "_form" => [
                "acronym" => "Acronyme",
                "general_information" => "Informations générales",
                "wording" => "Libellé"
            ],
            "_html" => [
                "acronym" => "Acronyme",
                "creation_date" => "Date de création",
                "last_modification_date" => "Date de dernière modification",
                "username" => "Identifiant",
                "wording" => "Libellé"
            ],
            "create" => [
                "create" => "Créer",
                "create_legal_form" => "Créer forme légale",
                "dashboard" => "Tableau de bord",
                "legal_form" => "Forme légale",
                "return" => "Retour"
            ],
            "edit" => [
                "dashboard" => "Tableau de bord",
                "edit" => "Modifier",
                "legal_form" => "Forme légale",
                "record" => "Enregistrer",
                "return" => "Retour"
            ],
            "index" => [
                "acronym" => "Acronyme",
                "add" => "Ajouter",
                "dashboard" => "Tableau de bord",
                "legal_form" => "Forme légale",
                "wording" => "Libellé"
            ],
            "show" => [
                "dashboard" => "Tableau de bord",
                "legal_form" => "Forme légale",
                "return" => "Retour"
            ]
        ],
        "member" => [
            "_actions" => [
                "assign_provider" => "Attribuer des prestataires",
                "confirm_delisting_of_member" => "Confirmer le déréférencement de ce membre?",
                "consult" => "Consulter",
                "dereference" => "Déréférencer",
                "edit" => "Modifier"
            ],
            "_form" => [
                "access_application" => "Accès à l'Application",
                "fonction" => "Fonction",
                "general_information" => "Informations générales",
                "general_project_manager" => "(Directeur général, Chef de projet, Stagiaire...)",
                "is_accounting_monitoring" => "Suivi comptable des contrats",
                "is_admin" => "Administrateur",
                "is_allowed_to_invite_vendors" => "Peut inviter des prestataires",
                "is_allowed_to_send_contract_to_signature" => "Peut mettre les contrats en signature",
                "is_allowed_to_view_business_turnover" => "Peut voir la déclaration de CA des prestataires",
                "is_customer_compliance_manager" => "Gestionnaire de conformité avec les prestataires",
                "is_financial" => "Financier",
                "is_legal_representative" => "Représentant Légal",
                "is_mission_offer_broadcaster" => "Peut diffuser des offres de mission",
                "is_mission_offer_closer" => "Peut fermer des offres de mission",
                "is_operator" => "Opérateur",
                "is_readonly" => "Observateur",
                "is_signatory" => "Signataire",
                "is_vendor_compliance_manager" => "Gestionnaire de conformité avec les clients",
                "is_work_field_creator" => "Peut créer un chantier",
                "role" => "Rôles",
                "role_contract_creator" => "Peut créer un contrat"
            ],
            "_member_accesses" => ["access" => "Accès"],
            "_table_head" => ["access" => "Accès", "last_name" => "Nom"],
            "create" => [
                "dashboard" => "Tableau de bord",
                "platform_user" => "Utilisateurs de la plateforme",
                "record" => "Enregistrer",
                "refer_user" => "Référencer un utilisateur",
                "return" => "Retour",
                "users" => "Utilisateurs"
            ],
            "edit" => [
                "company_members" => "Membres de l'entreprise",
                "dashboard" => "Tableau de bord",
                "edit" => "Modifier",
                "record" => "Enregistrer",
                "return" => "Retour"
            ],
            "index" => [
                "company_members" => "Membres de l'entreprise",
                "dashboard" => "Tableau de bord",
                "invite_member" => "Inviter un membre",
                "refer_user" => "Référencer un utilisateur",
                "return" => "Retour"
            ],
            "invitation" => [
                "accept" => "Accepter",
                "accept_invitation" => "Pour accepter l'invitation, cliquez simplement sur le bouton ci-dessous.",
                "copy_paste_url" => "Vous pouvez également copier-coller l'URL suivante dans la barre d'adresse de votre navigateur",
                "create" => [
                    "dashboard" => "Tableau de bord",
                    "invite" => "Inviter",
                    "invite_member" => "Inviter un membre",
                    "my_invitations" => "Mes Invitations",
                    "return" => "Retour",
                    "user_invite" => "Utilisateur à inviter"
                ],
                "exchanges_with_subcontractors" => "AddWorking vous accompagne dans la digitalisation de vos échanges avec vos sous-traitants et prestataires",
                "greeting" => "Bonjour,",
                "i_accept_invitation" => "J'accepte l'invitation",
                "invitation_to_join" => "Vous êtes invité à rejoindre l'entreprise",
                "need_support" => "Besoin d'aide pour la prise en main de l'outil ? Contactez-nous !",
                "notification" => [
                    "accept" => "Accepter",
                    "accept_invitation" => "Pour accepter l'invitation, il vous suffit de cliquer sur le bouton ci-dessous.",
                    "copy_paste_url" => "Vous pouvez également copier-coller une des URLs suivantes dans la barre d'adresse de votre navigateur pour :",
                    "exchanges_with_subcontractors" => "AddWorking vous accompagne dans la digitalisation de vos échanges avec vos sous-traitants et prestataires.",
                    "greeting" => "Bonjour,",
                    "i_accept_invitation" => "J'accepte l'invitation",
                    "invitation_to_join" => "Vous êtes invité à rejoindre l'entreprise",
                    "need_support" => "Besoin d'aide pour la prise en main de l'outil ? Contactez-nous !",
                    "refuse" => "Refuser",
                    "see_you_soon" => "A bientôt !",
                    "team_addworking" => "L'équipe AddWorking"
                ],
                "refuse" => "Refuser",
                "review" => ["join_company" => "Rejoindre l'entreprise", "rejoin" => "Rejoindre"],
                "see_you_soon" => "A bientôt !",
                "team_addworking" => "L'équipe AddWorking"
            ],
            "show" => [
                "access" => "Accès",
                "access_company_information" => "Accès aux infos de l'entreprise",
                "access_company_user" => "Accès aux utilisateurs de l'entreprise",
                "access_contracts" => "Accès aux contrats",
                "access_invoicing" => "Accès à la facturation",
                "access_mission" => "Accès aux missions",
                "access_purchase_order" => "Accès aux bons de commande",
                "become_member" => "Devenu membre",
                "company_members" => "Membres de l'entreprise",
                "contact" => "Contacter",
                "dashboard" => "Tableau de bord",
                "edit" => "Modifier",
                "identity" => "Identité",
                "return" => "Retour",
                "title" => "Titre",
                "to_log_in" => "Se connecter"
            ]
        ],
        "membership_request" => [
            "create" => [
                "associate_user_with_company" => "Associer un utilisateur à l'entreprise",
                "create_association" => "Créer l'association"
            ]
        ],
        "phone_number" => [
            "create" => [
                "add_phone_number" => "Ajouter un numéro de téléphone à",
                "dashboard" => "Tableau de bord",
                "phone" => "Téléphone",
                "phone_number" => "Numéro de téléphone",
                "record" => "Enregistrer",
                "return" => "Retour"
            ]
        ],
        "referent" => [
            "_form_assigned_vendors" => [
                "general_information" => "Informations générales",
                "provider_of" => "Prestataires de"
            ],
            "edit_assigned_vendors" => [
                "assigned_by" => "Attribué par",
                "assigned_providers_list" => "Liste des prestataires assignés",
                "company_members" => "Membres de l'entreprise",
                "dashboard" => "Tableau de bord",
                "modify_assigned_providers" => "Modifier la liste des prestataires assignés",
                "record" => "Enregistrer",
                "return" => "Retour"
            ]
        ],
        "site" => [
            "_actions" => ["to_consult" => "Consulter"],
            "create" => [
                "address_line_1" => "Adresse ligne 1",
                "address_line_2" => "Adresse ligne 2",
                "analytical_code" => "Code analytique",
                "city" => "Ville",
                "create_new_site" => "Créer un nouveau site",
                "create_site" => "Créer un site",
                "create_sites" => "Créer des sites",
                "dashboard" => "Tableau de bord",
                "general_information" => "Informations générales",
                "last_name" => "Nom",
                "main_address" => "Adresse principale",
                "postal_code" => "Code postal",
                "return" => "Retour",
                "telephone_1" => "Téléphone ligne 1",
                "telephone_2" => "Téléphone ligne 2",
                "telephone_3" => "Téléphone ligne 3"
            ],
            "edit" => [
                "address_line_1" => "Adresse ligne 1",
                "address_line_2" => "Adresse ligne 2",
                "analytical_code" => "Code analytique",
                "city" => "Ville",
                "dashboard" => "Tableau de bord",
                "edit" => "Modifier",
                "edit_site" => "Modifier le site",
                "general_information" => "Informations générales",
                "last_name" => "Nom",
                "main_address" => "Adresse principale",
                "postal_code" => "Code postal",
                "record" => "Enregistrer",
                "return" => "Retour"
            ],
            "index" => [
                "add" => "Ajouter",
                "address" => "Adresse",
                "company_sites" => "Sites de l'entreprise",
                "created_the" => "Créé le",
                "dashboard" => "Tableau de bord",
                "last_name" => "Nom",
                "phone" => "Téléphone",
                "return" => "Retour"
            ],
            "phone_number" => [
                "create" => [
                    "add_phone_number" => "Ajouter un numéro de téléphone à",
                    "dashboard" => "Tableau de bord",
                    "phone" => "Téléphone",
                    "phone_number" => "Numéro de téléphone",
                    "record" => "Enregistrer",
                    "return" => "Retour"
                ]
            ],
            "show" => [
                "" => "",
                "add" => "Ajouter",
                "address" => "Adresse",
                "analytical_code" => "Code analytique",
                "dashboard" => "Tableau de bord",
                "date_added" => "Date d'ajout",
                "general_information" => "Informations générales",
                "phone_number" => "Numéro de téléphone",
                "phone_numbers" => "Numéros de téléphone",
                "remove" => "Supprimer",
                "return" => "Retour"
            ]
        ],
        "vendor" => [
            "_actions" => [
                "action" => "Actions",
                "billing_options" => "Options de facturation",
                "confirm_delisting_of_service_provider" => "Confirmer le déréférencement de ce prestataire?",
                "consult_contract" => "Consulter les contrats",
                "consult_document" => "Consulter les documents",
                "consult_invoice" => "Consulter les factures",
                "consult_passwork" => "Consulter le passwork",
                "dereference" => "Déréférencer"
            ],
            "attach" => [
                "dashboard" => "Tableau de bord",
                "general_information" => "Informations générales",
                "list_prestataries" => "Liste des prestataires",
                "record" => "Enregistrer",
                "referencing_providers" => "Référencement des prestataires pour",
                "return" => "Retour"
            ],
            "billing_deadline" => [
                "edit" => [
                    "dashboard" => "Tableau de bord",
                    "my_providers" => "Mes Prestataires",
                    "payment_deadline" => "Échéance de paiement",
                    "payment_terms" => "Paramétrage des échéances de paiement pour",
                    "record" => "Enregistrer",
                    "return" => "Retour",
                    "setting" => "Paramétrage"
                ],
                "index" => [
                    "active" => "Actif",
                    "creation_date" => "Date de création",
                    "dashboard" => "Tableau de bord",
                    "edit" => "Modifier",
                    "inactive" => "Inactif",
                    "my_providers" => "Mes Prestataires",
                    "number_of_days" => "Nombre de jours",
                    "payment_deadline" => "Échéance de paiement",
                    "payment_due_for" => "Échéance de paiement pour",
                    "return" => "Retour",
                    "wording" => "Libellé"
                ]
            ],
            "detached" => ["by" => "Par", "dereferenced" => "a été déréférencé de l'entreprise"],
            "import" => [
                "csv_file" => "Fichier CSV",
                "dashboard" => "Tableau de bord",
                "import" => "Importer",
                "import_providers" => "Import prestataires",
                "my_providers" => "Mes Prestataires"
            ],
            "index" => [
                "action" => "Actions",
                "active" => "Actif",
                "activity_status" => "Statut",
                "business_documents_compliance" => "Conformité documents métier",
                "complaint_service_provider" => "Prestataire conforme",
                "dashboard" => "Tableau de bord",
                "dedicated_resources" => "Ressources dédiées",
                "division_by_skills" => "Répartition par compétences",
                "enterprise" => "Entreprise",
                "export" => "Exporter",
                "import" => "Importer",
                "inactive" => "Inactif",
                "leader" => "Dirigeant",
                "legal_documents_compliance" => "Conformité documents légaux",
                "my_providers" => "Mes Prestataires",
                "non_complaint_service_provider" => "Prestataire non conforme",
                "onboarding_completed" => "Onboarding terminé",
                "onboarding_inprogress" => "Onboarding en cours étape",
                "onboarding_non_existent" => "Onboarding inexistant",
                "onboarding_status" => "Statut onboarding",
                "return" => "Retour",
                "see_only_assigned_providers" => "Voir uniquement mes prestataires attribués",
                "society" => "Société"
            ],
            "index_division_by_skills" => [
                "breadcrumb" => [
                    "dashboard" => "Tableau de bord",
                    "division_by_skills" => "Répartition par compétences",
                    "enterprise" => "Entreprises",
                    "my_vendors" => "Mes Prestataires"
                ],
                "jobs_catalog_button" => "Catalogue des métiers",
                "return_button" => "Retour",
                "table_head" => ["job" => "Métier", "skill" => "Compétence", "vendors" => "Nombre de prestataires"],
                "table_row_empty" => "Cette entreprise ne référence pas de compétences.",
                "title" => "Répartition par compétences"
            ],
            "invitation" => [
                "accept" => "Accepter",
                "accept_invitation" => "Accepter l'invitation en cliquant sur le bouton ci-dessous,",
                "access_from_account" => "accessible depuis votre compte AddWorking",
                "and_its_done" => "Et c'est déjà fini !",
                "company_information" => "Merci de renseigner les informations de votre entreprise",
                "copy_paste_url" => "",
                "create" => [
                    "dashboard" => "Tableau de bord",
                    "invite" => "Inviter",
                    "invite_several_providers_once" => "Afin d'inviter plusieurs prestataires en une fois, vous devez placer un mail, un nom/prénom du destinataire et un nom d'entreprise par ligne comme ci-dessous",
                    "my_invitations" => "Mes Invitations",
                    "provider1" => "prestataire1@exemple.com, pierre dupont, entreprise-a",
                    "provider2" => "prestataire2@exemple.com, marie dupond, entreprise-b",
                    "provider3" => "prestataire3@exemple.com, michel lacroix , entreprise-b",
                    "provider4" => "prestataire4@exemple.com, clémence destours",
                    "provider5" => "prestataire5@exemple.com",
                    "provider_invitation" => "Invitation de prestataire",
                    "return" => "Retour",
                    "service_provider_information" => "Informations relatives à l'invitation de prestataire",
                    "user_invite" => "Utilisateur(s) à inviter"
                ],
                "greeting" => "Bonjour,",
                "i_accept_invitation" => "J'accepte l'invitation",
                "instant_messaging" => "Messagerie instantanée",
                "legal_documents" => "Documents légaux",
                "notification" => [
                    "accept" => "Accepter",
                    "accept_invitation" => "Acceptez l'invitation en cliquant sur le bouton ci-dessous,",
                    "access_from_account" => "accessible depuis votre compte AddWorking",
                    "and_its_done" => "Et c'est déjà fini !",
                    "company_information" => "Renseignez les informations de votre entreprise,",
                    "copy_paste_url" => "Vous pouvez également copier-coller une des URLs suivantes dans la barre d'adresse de votre navigateur pour",
                    "email" => "Email",
                    "greeting" => "Bonjour,",
                    "have_questions" => "Vous avez des questions ? Notre équipe Support vous répond",
                    "i_accept_invitation" => "J'accepte l'invitation",
                    "instant_messaging" => "Messagerie instantanée",
                    "legal_documents" => "Déposez les documents légaux demandés par votre client,",
                    "our_app" => "Notre App, accessible sur tous supports, vous accompagne afin de simplifier tous vos échanges avec votre client, tout en assurant votre conformité.",
                    "phone" => "Téléphone",
                    "refuse" => "Refuser",
                    "register_free" => "Pour vous enregistrer, c'est très simple (et gratuit !)",
                    "team_addworking" => "L'équipe AddWorking",
                    "title" => "Votre client ':client_name' souhaite vous référencer sur l’App AddWorking",
                    "welcome" => "Bienvenue chez AddWorking !",
                    "wish_to_reference" => "souhaite vous référencer sur AddWorking. Félicitations !"
                ],
                "our_app" => "",
                "questions" => "Vous avez des questions ? Notre équipe Support vous répond",
                "refuse" => "",
                "register_free" => "",
                "review" => [
                    "become_provider" => "Devenir prestataire de",
                    "choose_company" => "Choisissez une entreprise",
                    "create_account" => "Créer mon compte"
                ],
                "team_addworking" => "L'équipe AddWorking",
                "telephone" => "",
                "welcome" => "",
                "wish_to_reference" => ""
            ],
            "invitation_create" => [
                "dashboard" => "Tableau de bord",
                "invite_provider" => "Inviter un prestataire",
                "invite_provider_join_client" => "Inviter un prestataire à rejoindre le client",
                "my_invitations" => "Mes Invitations"
            ],
            "noncompliance" => [
                "addworking_supports_guarantee" => "AddWorking vous accompagne afin de garantir votre conformité auprès de vos clients.",
                "compliance_service" => "",
                "consult_documents" => "Je consulte les documents",
                "cordially" => "Cordialement,",
                "greeting" => "Bonjour,",
                "nonconformity" => "présente une non-conformité.",
                "not_confirm" => "",
                "we_inform" => "Nous vous informons que le document légal suivant "
            ],
            "partnership" => [
                "edit" => [
                    "activity_ends_at" => "Date de fin d'activité",
                    "activity_starts_at" => "Date de début d'activité",
                    "custom_management_fees_tag" => "Option de frais de gestion personnalisé",
                    "dashboard" => "Tableau de bord",
                    "my_providers" => "Mes Prestataires",
                    "partnership" => "Activité courante",
                    "record" => "Enregistrer",
                    "return" => "Retour",
                    "updated_at" => "Date de dernière modification",
                    "updated_by" => "Dernière modification faite par",
                    "vendor_external_id" => "Identifiant prestataire"
                ]
            ]
        ]
    ],
    "mission" => [
        "mission" => [
            "_actions" => [
                "complete_mission" => "Terminer la mission",
                "confirm_deletion" => "Confirmer la suppression ?",
                "confirm_generate_purchase_order" => "Etes-vous sûr de vos informations avant de générer le bon de commande ? Une fois généré, celui-ci n'est plus modifiable.",
                "consult" => "Consulter",
                "define_tracking_mode" => "Définir le mode de suivi",
                "delete_purchase_order" => "Supprimer bon de commande",
                "edit" => "Modifier",
                "generate_order_form" => "Générer bon de commande",
                "mission_followup" => "Créer un suivi de mission",
                "mission_monitoring" => "Suivi de mission",
                "order_form" => "Voir bon de commande",
                "remove" => "Supprimer"
            ],
            "_breadcrumb" => ["create" => "Créer", "edit" => "Modifier", "index" => "Missions"],
            "_departments" => ["departments" => "Départements"],
            "_form" => [
                "assignment_purpose" => "Objet de la mission",
                "describe_mission_help" => "Décrivez ici la mission dans les moindres détails.",
                "identifier_help" => "Si nécessaire, mettre un identifiant supplémentaire.",
                "location" => "Lieu",
                "project_development_help" => "Exemple: développement de projet",
                "tracking_mode" => "Mode de suivi"
            ],
            "_html" => [
                "add_note" => "Ajouter une note",
                "amount" => "Montant",
                "end" => "Fin",
                "location" => "Lieu",
                "number" => "Numéro",
                "permalink" => "Permalien",
                "rate_mission" => "Noter la mission",
                "service_provider" => "Prestataire",
                "start" => "Début",
                "status" => "Statut",
                "unit" => "Unité",
                "user_id" => "Identifiant"
            ],
            "create" => [
                "affected_companies" => "Entreprises concernées",
                "create" => "Créer",
                "create_mission" => "Créer une mission",
                "create_the_mission" => "Créer la mission",
                "dashboard" => "Tableau de bord",
                "general_information" => "Informations Générales",
                "mission" => "Mission",
                "return" => "Retour"
            ],
            "create_milestone_type" => [
                "create" => "Créer",
                "dashboard" => "Tableau de bord",
                "define_tracking_mode" => "Définir le mode de suivi",
                "mission" => "Mission",
                "mission_information" => "Informations sur la mission",
                "return" => "Retour",
                "tracking_mode" => "Mode de suivi"
            ],
            "edit" => [
                "assignment_purpose" => "Objet de la mission",
                "dashboard" => "Tableau de bord",
                "describe_mission_help" => "Décrivez ici la mission dans les moindres détails.",
                "edit" => "Modifier",
                "edit_mission" => "Modifier la mission",
                "identifier_help" => "Si nécessaire, mettre un identifiant supplémentaire.",
                "location" => "Lieu",
                "mission" => "Missions",
                "mission_information" => "Informations sur la mission",
                "project_development_help" => "Exemple : développement de projet",
                "return" => "Retour"
            ],
            "index" => [
                "actions" => "Actions",
                "add" => "Ajouter",
                "amount" => "Montant",
                "customer" => "Client",
                "dashboard" => "Tableau de bord",
                "finish" => "Terminée",
                "label" => "Label",
                "mission" => "Missions",
                "mission_closed_by" => "Mission fermée par",
                "new" => "Nouveau",
                "no" => "Non",
                "number" => "Numéro",
                "return" => "Retour",
                "service_provider" => "Prestataire",
                "start_date" => "Date de début",
                "status" => "Statut"
            ],
            "show" => [
                "abondend_by" => "Abandonnée par",
                "abondend_date" => "Date d'abandon",
                "amount" => "Quantité",
                "assigned_provider" => "Prestataire assigné",
                "billing" => "Facturation",
                "change_status" => "Changer le statut",
                "closed_by" => "Fermée par",
                "closing_date" => "Date de fermeture",
                "consult_proposal" => "Consulter la proposition",
                "contractualize" => "Contractualiser la mission",
                "create_contract" => "Créer un nouveau contrat",
                "created_by" => "Créée par",
                "creation_date" => "Date de création",
                "customer" => "Client",
                "dashboard" => "Tableau de bord",
                "description" => "Description",
                "determine" => "Déterminer",
                "end_date" => "Date de fin",
                "further_information" => "Informations complémentaires",
                "general_information" => "Informations générales",
                "id" => "Identifiant",
                "incoming_invoice" => "Facture entrante Associée",
                "last_update" => "Dernière mise à jour",
                "link_contract" => "Lier un contrat existant",
                "location" => "Lieu",
                "mission_proposal" => "Proposition de mission",
                "number" => "Numéro",
                "price" => "Prix",
                "start_date" => "Date de début",
                "status" => "Statut",
                "tracking_mode" => "Mode de suivi"
            ]
        ],
        "mission_tracking" => [
            "_actions" => [
                "actions" => "Actions",
                "consult" => "Consulter",
                "edit" => "Modifier",
                "remove" => "Supprimer"
            ],
            "_breadcrumb" => ["create" => "Créer", "edit" => "Modifier", "index" => "Suivis"],
            "_status" => [
                "refuse" => "Refusé",
                "search_for_agreement" => "Recherche d'accord",
                "valid" => "Validé",
                "waiting" => "En attente"
            ],
            "create" => [
                "addtional_files" => "Fichiers complémentaires",
                "amount" => "Quantité",
                "create" => "Créer",
                "dashboard" => "Tableau de bord",
                "general_information" => "Informations générales",
                "mission_followup" => "Nouveau suivi de mission",
                "mission_followup_ref" => "Référence du suivi de mission",
                "mission_monitoring" => "Suivi de mission",
                "notify_customer" => "Notifier le client",
                "notify_provider" => "Notifier le prestataire",
                "order_attached_help" => "Ex: n° de commande, pièce jointe, etc.",
                "period_concerned" => "Période concernée",
                "record" => "Enregistrer",
                "return" => "Retour",
                "unit" => "Unité",
                "unit_price" => "Prix unitaire"
            ],
            "created" => [
                "access_mission_tracking" => "Suivi de mission",
                "copy_paste_url" => "Vous pouvez également copier-coller l'URL suivante dans la barre d'adresse de votre navigateur",
                "cordially" => "Cordialement,",
                "greeting" => "Bonjour,",
                "new_vision_tracking" => "",
                "team_addworking" => "L'équipe AddWorking",
                "validate" => "Valider"
            ],
            "edit" => [
                "addtional_files" => "Fichiers complémentaires",
                "dashboard" => "Tableau de bord",
                "edit" => "Modifier",
                "edit_mission_tracking" => "Modifier le suivi de mission",
                "external_identifier" => "Identifiant externe",
                "general_information" => "Informations générales",
                "mission_followup" => "Suivis de missions",
                "mission_monitoring" => "Suivi de mission",
                "order_attached_help" => "Ex: n° de commande, pièce jointe, etc.",
                "period_concerned" => "Période concernée",
                "record" => "Enregistrer",
                "return" => "Retour"
            ],
            "index" => [
                "actions" => "Actions",
                "client" => "Client",
                "dashboard" => "Tableau de bord",
                "edit_mission_tracking" => "Modifier le suivi de mission",
                "end_date" => "Date de fin",
                "mission" => "Mission",
                "mission_monitoring" => "Suivi de mission",
                "mission_number" => "N° mission",
                "return" => "Retour",
                "service_provider" => "Prestataire",
                "start_date" => "Date de début",
                "status" => "Statut"
            ],
            "show" => [
                "accounting_expense" => "Poste de dépense",
                "actions" => "Actions",
                "add_row" => "Ajouter une ligne",
                "amount" => "Quantité",
                "amount_before_taxes" => "Total HT",
                "attachement" => "Pièces jointes",
                "commenting_text" => "Un système de commentaire vous permet d’échanger en vue d’un accord mutuel.",
                "comments" => "Commentaires",
                "customer_status" => "Statut client",
                "dashboard" => "Tableau de bord",
                "description" => "Description",
                "express_agreement" => "Vous avez déjà exprimé votre accord (ou non)",
                "external_identifier" => "Identifiant externe",
                "general_information" => "Informations générales",
                "information_note" => "Note d’information",
                "label" => "Libellé",
                "mission_followup" => "Suivis de la mission",
                "mission_followup_text" => "Vous pouvez créer autant de lignes de suivi de mission que nécessaire (exemple : étapes de la mission, coûts supplémentaires liés à un/des événement(s) inattendu(s), etc.).",
                "mission_monitoring" => "Suivi de mission",
                "mission_monitoring_statement" => "Une ligne de suivi de mission permet aux parties prenantes (client et sous-traitant) de valider la conformité de la prestation réalisée versus la mission confiée en vue d’une juste facturation.",
                "no_more_edit" => "Vous ne pouvez plus modifier cette ligne",
                "period_concerned" => "Période concernée",
                "provider_status" => "Statut prestataire",
                "reason_for_rejection" => "Raison du refus",
                "refusal_reason" => "Motif de refus",
                "return" => "Retour",
                "tracking_lines" => "Lignes de suivi",
                "unit_price" => "Prix / unité"
            ]
        ],
        "mission_tracking_line" => [
            "_actions" => [
                "accept_mission" => "Accepter la ligne de suivi de mission?",
                "customer_refusal" => "Refus Client",
                "customer_validation" => "Validation Client",
                "edit" => "Modifier",
                "mission_tracking_deletion_confirm" => "Confirmer la suppression de la ligne de suivi de mission?",
                "provider_validation" => "Validation Prestataire",
                "remove" => "Supprimer",
                "service_provider_refusal" => "Refus Prestataire"
            ],
            "_breadcrumb" => ["create" => "Créer", "edit" => "Modifier", "index" => "Lignes"],
            "_html" => [
                "accounting_expense" => "Poste de dépense",
                "amout" => "Montant",
                "label" => "Libellé",
                "reason_for_rejection" => "Raison de rejet",
                "validation" => "Validation",
                "validation_customer" => "validation client",
                "validation_vendro" => "validation prestataire"
            ],
            "_reject" => [
                "client" => "Client",
                "decline_tracking" => "Refuser la ligne de suivi",
                "refusal_reason" => "Motif de refus",
                "service_provider" => "Prestataire"
            ],
            "_table_row_empty" => [
                "add_line" => "Ajouter une ligne",
                "doesnt_have_lines" => "n'a aucune ligne",
                "the_tracking" => "Le suivi de mission"
            ],
            "create" => [
                "accounting_expense" => "Poste de dépense",
                "amount" => "Quantité",
                "create_row" => "Créer une ligne",
                "dashboard" => "Tableau de bord",
                "general_information" => "Informations générales",
                "line_label" => "Libellé de la ligne",
                "mission" => "Missions",
                "mission_monitoring" => "Suivi de mission",
                "mission_monitoring_new" => "Nouvelle ligne de suivi de mission",
                "record" => "Enregistrer",
                "return" => "Retour",
                "unit" => "Unité",
                "unit_price" => "Prix unitaire"
            ],
            "edit" => [
                "amount" => "Quantité",
                "dashboard" => "Tableau de bord",
                "edit" => "Modifier",
                "general_information" => "Informations générales",
                "line_label" => "Libellé de la ligne",
                "lines" => "Lignes",
                "mission" => "Missions",
                "mission_monitoring" => "Suivis de missions",
                "modify_mission_tracking" => "Modifier ligne de suivi de mission",
                "modify_row" => "Modifier la ligne",
                "return" => "Retour",
                "unit" => "Unité",
                "unit_price" => "Prix unitaire"
            ],
            "index" => [
                "amount" => "Montant",
                "label" => "Lignes de suivis",
                "title" => "Lignes de suvis",
                "validation" => "Validation"
            ]
        ],
        "offer" => [
            "_actions" => [
                "change_status" => "Changer le statut",
                "change_status_offer" => "Changer le statut de l'offre",
                "choose_recp_offer" => "Choisir les destinataires de l'offre",
                "close_offer" => "Clôturer l'offre",
                "closing_request" => "Demande de clôture",
                "consult" => "Consulter",
                "edit" => "Modifier",
                "relaunch_mission_proposal" => "Relancer les propositions de mission",
                "remove" => "Supprimer",
                "responses" => "Réponses",
                "see_missions" => "Voir les missions associées",
                "status" => "Statut",
                "summary" => "Récapitulatif"
            ],
            "_form" => [
                "desc_mission_details" => "Décrivez ici tous les détails de la mission",
                "referent" => "Référent"
            ],
            "_proposal_actions" => [
                "consult_passwork" => "Consulter le passwork",
                "consult_proposal" => "Consulter la proposition",
                "view_responses" => "Consulter les réponses"
            ],
            "_status" => [
                "abondend" => "Abandonnée",
                "broadcast" => "Diffusée",
                "closed" => "Fermée",
                "diffuse" => "À diffuser",
                "rough_draft" => "Brouillon"
            ],
            "accept_offer" => [
                "congratulations" => "Félicitations !",
                "cordially" => "Cordialement,",
                "greeting" => "Bonjour,",
                "i_consult" => "Consulter",
                "legal_statement" => "",
                "response_to_mission_proposal" => "Votre réponse à la proposition de mission",
                "team_addworking" => "L'équipe AddWorking",
                "validate" => "Valider"
            ],
            "assign" => [
                "assign" => "Assigner",
                "assign_offer_service_provider" => "Assigner l'offre à un Prestataire",
                "dashboard" => "Tableau de bord",
                "mission_offer" => "Offre de mission",
                "return" => "Retour",
                "service_provider" => "Prestataire"
            ],
            "assign_modal" => [
                "close" => "Fermer",
                "close_offer" => "Clôturer l'offre ?",
                "register" => "Enregistrer",
                "title" => "Assigner"
            ],
            "create" => [
                "additional_file" => "Documents complémentaires",
                "assignment_desired_skills" => "Compétence(s) souhaitée(s) pour cette mission",
                "assignment_offer_info" => "Informations sur l'offre de mission",
                "assignment_purpose" => "Objet de la mission",
                "create" => "Créer",
                "dashboard" => "Tableau de bord",
                "mission_offer" => "Offre de mission",
                "new_mission_offer" => "Nouvelle offre de mission",
                "project_development_help" => "Exemple: développement de projet",
                "return" => "Retour",
                "select_multiple_departments_help" => "Vous pouvez choisir plusieurs départements en maintenant la touche [Ctrl] de votre clavier.",
                "success_creation" => "Offre de mission enregistrée avec succès"
            ],
            "edit" => [
                "additional_file" => "Documents complémentaires",
                "assignment_offer_info" => "Informations sur l'offre de mission",
                "assignment_purpose" => "Objet de la mission",
                "dashboard" => "Tableau de bord",
                "department_help" => "Vous pouvez choisir plusieurs départements en maintenant la touche [Ctrl] de votre clavier.",
                "edit" => "Modifier",
                "location" => "Lieu",
                "mission_offer" => "Offre de mission",
                "modify_assignment_offer" => "Modifier une offre de mission",
                "project_development_help" => "Exemple: développement de projet",
                "return" => "Retour"
            ],
            "index" => [
                "actions" => "Actions",
                "create_assignment_offer" => "Créer une offre de mission",
                "create_offer_for_construction" => "Créer une offre de mission BTP",
                "created_on" => "Créée le",
                "customer" => "Client",
                "dashboard" => "Tableau de bord",
                "mission_offer" => "Offres de missions",
                "referent" => "Référent",
                "status" => "Statut"
            ],
            "pending_offer" => [
                "greeting" => "Bonjour,",
                "no_longer_respond" => "Vous ne pouvez plus répondre à cette offre.",
                "offer_closed" => "",
                "see_you_soon" => "A bientôt !"
            ],
            "refuse_offer" => [
                "greeting" => "Bonjour,",
                "has_refused_by" => "a été refusé par",
                "i_consult" => "Je consulte",
                "see_you_soon" => "A bientôt !",
                "your_response" => ""
            ],
            "request_close_offer" => [
                "confirm_choice" => "Clôturer l'offre de mission ?",
                "cordially" => "Cordialement,",
                "greeting" => "Bonjour,",
                "legal_statement" => "",
                "mission_offer_close" => "Clôturer l'offre",
                "retained_respondent" => "Prestataire assigné",
                "team_addworking" => "L'équipe AddWorking"
            ],
            "send_request_close" => [
                "dashboard" => "Tableau de bord",
                "mission_offer" => "Offre de mission",
                "offer_close_req" => "Demande de clôture de l'offre de mission",
                "return" => "Retour",
                "send_request" => "Envoyer la demande",
                "solicit_responsible" => "Responsable à solliciter",
                "you_selected" => "Vous avez sélectionné",
                "you_selected_text" => "réponse(s) en validation finale pour cette offre. Il est maintenant nécessaire de clore l'offre. Merci de choisir une personne habilitée à le faire dans la liste ci-dessous."
            ],
            "show" => [
                "action" => "Actions",
                "additional_document" => "Documents complémentaires",
                "analytical_code" => "Code analytique",
                "assignment_desired_skills" => "Compétence(s) souhaitée(s) pour cette mission",
                "assignment_purpose" => "Objet de la mission",
                "assing_mission_directly" => "Assigner directement la mission",
                "choose_recp_offer" => "Choisir les destinataires de l'offre",
                "client_id" => "Identifiant Client",
                "close_offer" => "Clôturer l'offre",
                "closing_request" => "Demande de clôture",
                "confirm_close_assignment" => "réponse(s) en validation finale, êtes-vous sûr de vouloir clore cette offre de mission ?",
                "dashboard" => "Tableau de bord",
                "end_date" => "Date de fin",
                "general_information" => "Informations générales",
                "location" => "Lieu",
                "mission_offer" => "Offres de missions",
                "mission_proposal" => "Destinataires",
                "no_document" => "Aucun document",
                "no_proposal" => "Aucune proposition",
                "provider_company" => "Entreprise prestataire",
                "referent" => "Référent",
                "response_number" => "Nombre de réponses",
                "start_date" => "Date de début",
                "status" => "Statut",
                "you_have" => "Vous avez"
            ],
            "summary" => [
                "create" => "Créer",
                "dashboard" => "Tableau de bord",
                "enterprise" => "Entreprise",
                "mission" => "Mission",
                "mission_offer" => "Offre de mission",
                "reply_date" => "Date de réponse",
                "response_not_in_final_validation" => "Cette réponse n'est pas au statut \"validation finale\"",
                "responses_summary" => "Récapitulatif des réponses de l'offre de mission",
                "see_mission" => "Voir cette mission",
                "status" => "Statut",
                "summary" => "Récapitulatif"
            ]
        ],
        "profile" => [
            "create" => [
                "dashboard" => "Tableau de bord",
                "disseminate_offer" => "Diffuser l’offre de mission auprès de",
                "enterprise" => "Entreprises",
                "mission_offer" => "Offre de mission",
                "provider_selection" => "Sélection des prestataires",
                "return" => "Retour",
                "selected_company" => "Entreprise(s) sélectionnée(s)",
                "service_provider_selection" => "Sélection des prestataires pour l'offre de mission",
                "trades_skill" => "Métiers & Compétences"
            ]
        ],
        "proposal" => [
            "_actions" => [
                "assign_proposal_confirm" => "Voulez-vous vraiment assigner la mission ?",
                "assing_mission" => "Assigner la mission",
                "confirmation" => "Confirmation",
                "consult" => "Consulter",
                "delete_proposal_confirm" => "Voulez-vous vraiment supprimer la proposition de mission ?",
                "edit" => "Modifier",
                "remove" => "Supprimer",
                "responses" => "Réponses"
            ],
            "create" => ["broadcast" => "Diffuser", "close" => "Fermer"],
            "edit" => [
                "dashboard" => "Tableau de bord",
                "edit" => "Modifier",
                "mission_offer" => "Offre de mission",
                "mission_proposal" => "Proposition de mission",
                "mission_proposal_info" => "Informations sur la proposition de mission",
                "modify_proposal" => "Modifier la proposition de mission",
                "return" => "Retour",
                "service_provider" => "Prestataire"
            ],
            "index" => [
                "dashboard" => "Tableau de bord",
                "desired_start_date" => "Date de début souhaitée",
                "mission_offer" => "Offre de mission",
                "mission_proposal" => "Propositions de missions",
                "referent" => "Référent",
                "service_provider" => "Prestataire",
                "status" => "Statut"
            ],
            "show" => [
                "additional_document" => "Documents complémentaires",
                "amount" => "Quantité",
                "client_id" => "Identifiant client",
                "comments" => "Commentaires",
                "customer" => "Client",
                "dashboard" => "Tableau de bord",
                "desired_start_date" => "Date de début souhaitée",
                "details_assignment_offer" => "Détails de l'offre de mission",
                "download" => "Télécharger",
                "files_title" => "Documents complémentaires",
                "further_information" => "Informations complémentaires",
                "information_req" => "Demander le BPU",
                "mission_end" => "Fin de la mission",
                "mission_location" => "Lieu de la mission",
                "mission_proposal" => "Proposition de mission",
                "mission_proposal_response" => "Réponses à la proposition de mission",
                "no_file_sentence" => "Aucun fichier joint",
                "no_response_sentence" => "Aucune réponse",
                "offer_closed" => "L'offre est désormais close, vous ne pouvez plus y répondre",
                "offer_description" => "Description de l'offre de mission",
                "offer_label" => "Objet de l'offre de mission",
                "offer_status" => "Statut de l'offre",
                "proposal_start_date" => "Date de début de la proposition",
                "proposal_status" => "Statut de la proposition",
                "quote_required" => "Devis requis",
                "read_more" => "Voir plus",
                "replace" => "Remplacer",
                "req_sent" => "Votre demande d'information est bien envoyée, un opérationnel Sogetrel va vous répondre",
                "respond_deadline" => "Date limite de réponse",
                "respond_tenders" => "Répondre à l'appel d'offres",
                "response" => "Voir la réponse du ",
                "response_title" => "Réponses",
                "send_bpu" => "Envoyer un BPU",
                "service_provider" => "Prestataire",
                "show_bpu" => "Voir le BPU",
                "to_respond_update" => "Pour répondre à cet appel d’offre, vous devez mettre à jour vos documents",
                "total_amount" => "Montant total",
                "unit" => "Unité",
                "unit_price" => "Prix unitaire"
            ],
            "status" => [
                "_interested" => [
                    "audience_text" => "Public : visible par tout le monde. Protégé : visible par les membres de mon entreprise. Privé : visible seulement par moi.",
                    "information_req" => "Demande d'information",
                    "information_requested" => "Informations demandées",
                    "visibility" => "Visibilité"
                ]
            ]
        ],
        "proposal_response" => [
            "_actions" => ["edit" => "Modifier"],
            "_status" => [
                "exchange_positive" => "Échange positif",
                "exchange_req" => "Échange demandé",
                "final_validation" => "Validation finale",
                "refuse" => "Refuser",
                "validate_price" => "Valider prix",
                "waiting" => "En attente"
            ],
            "create" => [
                "additional_file" => "Fichiers complémentaires",
                "amount" => "Quantité",
                "availability_end_date" => "Date de fin de disponibilité",
                "create_response" => "Créer une réponse",
                "create_response1" => "Créer la réponse",
                "dashboard" => "Tableau de bord",
                "general_information" => "Informations générales",
                "mission_proposal" => "Proposition de mission",
                "possible_start_date" => "Date de démarrage possible",
                "price" => "Prix",
                "respond_offer" => "Répondre à l'offre",
                "return" => "Retour",
                "unit" => "Unité"
            ],
            "edit" => [
                "additional_file" => "Fichiers complémentaires",
                "amount" => "Quantité",
                "availability_end_date" => "Date de fin de disponibilité",
                "dashboard" => "Tableau de bord",
                "edit_response" => "Modifier la réponse",
                "edit_response1" => "Modifier une réponse",
                "general_information" => "Informations générales",
                "mission_proposal" => "Proposition de mission",
                "possible_start_date" => "Date de démarrage possible",
                "price" => "Prix",
                "return" => "Retour",
                "unit" => "Unité"
            ],
            "index" => [
                "action" => "Actions",
                "client_company" => "Entreprise cliente",
                "close_assignment_confirm" => "réponse(s) en validation finale, êtes-vous sûr de vouloir clore cette offre de mission ?",
                "close_offer" => "Clôturer l'offre",
                "closing_request" => "Demande de clôture",
                "created" => "Créé le",
                "dashboard" => "Tableau de bord",
                "mission_offer" => "Offres de missions",
                "mission_proposal" => "Propositions de missions",
                "new_response" => "Nouvelles réponses",
                "offer_answer" => "Réponses à l'offre",
                "provider_company" => "Entreprise prestataire",
                "response" => "Réponses",
                "status" => "Statut"
            ],
            "show" => [
                "accept_it" => "Accepté le",
                "accepted_by" => "Accepté par",
                "additional_document" => "Documents complémentaires",
                "amount" => "Quantité",
                "change_status" => "Changer le statut",
                "client" => "Client",
                "close_assignment_confirm" => "réponse(s) en validation finale, êtes-vous sûr de vouloir clore cette offre de mission ?",
                "close_offer" => "Clôturer l'offre",
                "closing_request" => "Demande de clôture",
                "comment" => "Commentaires",
                "dashboard" => "Tableau de bord",
                "description" => "Description",
                "general_information" => "Informations générales",
                "mission_offer" => "Offre de mission",
                "mission_proposal" => "Proposition de mission",
                "no_document" => "Aucun document",
                "offer_answer" => "Réponse à l'offre",
                "possible_end_date" => "Date de fin possible",
                "possible_start_date" => "Date de début possible",
                "price" => "Prix",
                "refusal_reason" => "Motif de refus",
                "refused_by" => "Refusé par",
                "refused_on" => "Refusé le",
                "response" => "Réponses",
                "service_provider" => "Prestataire",
                "status" => "Statut"
            ],
            "status" => [
                "_final_validation" => [
                    "audience_text" => "Public: visible par tout le monde. Protégé: visible par les membres de mon entreprise. Privé: visible seulement par moi.",
                    "change_resp_status" => "Passage de la réponse au statut",
                    "close_assignment" => "Clôturer l'offre de mission ?",
                    "comment" => "Commentaire",
                    "visibility" => "Visibilité"
                ],
                "_interview_positive" => [
                    "audience_text" => "Public: visible par tout le monde. Protégé: visible par les membres de mon entreprise. Privé: visible seulement par moi.",
                    "change_resp_status" => "Passage de la réponse au statut",
                    "comment" => "Commentaire ",
                    "visibility" => "Visibilité"
                ],
                "_interview_requested" => [
                    "audience_text" => "Public: visible par tout le monde. Protégé: visible par les membres de mon entreprise. Privé: visible seulement par moi.",
                    "change_resp_status" => "Passage de la réponse au statut",
                    "comment" => "Commentaire ",
                    "visibility" => "Visibilité"
                ],
                "_ok_to_meet" => [
                    "audience_text" => "Public: visible par tout le monde. Protégé: visible par les membres de mon entreprise. Privé: visible seulement par moi.",
                    "change_resp_status" => "Passage de la réponse au statut",
                    "comment" => "Commentaire",
                    "visibility" => "Visibilité"
                ],
                "_pending" => [
                    "audience_text" => "Public : visible par tout le monde. Protégé : visible par les membres de mon entreprise. Privé : visible seulement par moi.",
                    "change_resp_status" => "Passage de la réponse au statut",
                    "comment" => "Commentaire",
                    "visibility" => "Visibilité"
                ],
                "_reject" => [
                    "audience_text" => "Public : visible par tout le monde. Protégé : visible par les membres de mon entreprise. Privé : visible seulement par moi.",
                    "comment" => "Commentaire",
                    "refuse_assign_offer" => "Refuser la réponse à l'offre de mission",
                    "visibility" => "Visibilité"
                ]
            ]
        ],
        "purchase_order" => [
            "document" => [
                "_details" => [
                    "amount" => "Quantité",
                    "assignment_purpose" => "Objet de la mission",
                    "uht_amount" => "Montant H.T.",
                    "uht_price" => "Prix U.H.T.",
                    "unit" => "Unité"
                ],
                "_enterprises" => [
                    "address" => "17 rue du Lac Saint André<br/>Savoie Technolac - BP 350<br/>73370 Le Bourget du Lac - France",
                    "address1" => "Adresse",
                    "addworking" => "ADDWORKING",
                    "billing_address" => "Adresse de facturation",
                    "buyer" => "Acheteur",
                    "last_name" => "Nom",
                    "legal_entity" => "ENTITÉ JURIDIQUE",
                    "mail" => "Email",
                    "net_transfer" => "Virement 30 jours net",
                    "payment_condition" => "Condition de paiement",
                    "phone" => "Tel",
                    "provider" => "Fournisseur"
                ],
                "_header" => [
                    "created" => "Créé le",
                    "purchase_order" => "BON DE COMMANDE",
                    "reference_mission" => "RÉFÉRENCE MISSION",
                    "remind_correspondence" => "(à rappeler <u>obligatoirement</u> sur toutes vos correspondances, <strong>bons de livraison</strong> et <strong>factures</strong> )"
                ],
                "_shipping_informations" => [
                    "by_receiving_supplier_undertakes" => "En recevant ce bon de commande, le fournisseur s'engage à",
                    "delivery_information" => "Informations de livraison",
                    "description" => "Description",
                    "destination_site" => "Site de destination",
                    "expected_start_date" => "Date de début prévue",
                    "referent" => "Référent",
                    "shipping_site" => "Site d'expédition",
                    "supplier_undertake_1" => "1. Traiter cette commande conformément aux tarifs, conditions, instructions de livraison et spécifications répertoriés ci-dessus.",
                    "supplier_undertake_2" => "2. Déposer votre facture sur la plateforme AddWorking.",
                    "supplier_undertake_3" => "3. Informer immédiatement l'acheteur s'il n'est pas en mesure d'expédier la commande telle que spécifiée."
                ],
                "_terms" => ["spf_purchase_condition" => "SPF Conditions générales d'achat"],
                "_total" => [
                    "total_net_excl_tax" => "Total net HT en €",
                    "total_price" => "Total TTC",
                    "vat" => "TVA"
                ],
                "page" => "Page"
            ],
            "index" => [
                "action" => "Actions",
                "assignment_purpose" => "Objet de la mission",
                "creation_date" => "Date de création",
                "dashboard" => "Tableau de bord",
                "enterprise" => "Entreprises",
                "ht_price" => "Prix HT",
                "mission_reference" => "Référence de la mission",
                "order_form" => "Bons de commande pour",
                "purchase_order" => "Bons de commande",
                "status" => "Statut"
            ],
            "show" => [
                "dashboard" => "Tableau de bord",
                "details" => "Détails",
                "enterprise" => "Entreprise",
                "mission" => "Mission",
                "order_form" => "Bon de commande pour",
                "order_form_help_text" => "Ce bon de commande a été généré depuis la mission correspondante. Vous pouvez modifier la mission (et regénérer le bon de commande) tant que le bon de commande n’a pas été envoyé au prestataire",
                "purchase_order" => "Bon de commande",
                "return" => "Retour",
                "send_order_form" => "Confirmer l'envoi du bon de commande ?",
                "send_to_service_provider_and_referrer" => "Envoyer au prestataire et au référent"
            ]
        ]
    ],
    "mssion" => [
        "mission_tracking_line" => [
            "_html" => [
                "amout" => "",
                "label" => "",
                "reason_for_rejection" => "",
                "validation" => "",
                "validation_customer" => "",
                "validation_vendro" => ""
            ]
        ]
    ],
    "navbar" => ["need_help" => "Besoin d'aide ?"],
    "user" => [
        "auth" => [
            "login" => [
                "email_address" => "Adresse email",
                "forgot_password" => "Mot de passe oublié ?",
                "log_in" => "Se Connecter",
                "login" => "Connexion",
                "password" => "Mot de passe"
            ],
            "passwords" => [
                "email" => [
                    "email_address" => "Adresse email",
                    "reset_password" => "Réinitialisation du mot de passe",
                    "send" => "Envoyer"
                ],
                "reset" => [
                    "confirm_password" => "Confirmer le mot de passe",
                    "email_address" => "Adresse email",
                    "password" => "Mot de passe",
                    "record" => "Enregistrer",
                    "reset_password" => "Réinitialisation de votre mot de passe"
                ]
            ],
            "register" => [
                "reCaptcha_failed" => "La vérification reCaptcha a échoué",
                "registration" => "Inscription"
            ]
        ],
        "chat" => [
            "index" => [
                "converse" => "Vous conversez avec",
                "refresh" => "Rafraîchir",
                "sent" => "Envoyé",
                "to_send" => "Envoyer",
                "view_document" => "Voir le document"
            ],
            "rooms" => [
                "access_your_conversation" => "Accéder à vos conversations",
                "chatroom_list" => "Listes des chats rooms",
                "chatroom_list_participate" => "Listes des chats rooms auxquelles vous participez",
                "conversation_with" => "Conversation avec",
                "see_conversation" => "Voir la conversation"
            ]
        ],
        "dashboard" => [
            "_customer" => [
                "active_contract" => "Contrats actifs",
                "contract" => "Contrats",
                "invoices" => "Factures",
                "mission" => "Missions",
                "missions_this_month" => "Missions ce mois",
                "new_response" => "Nouvelles réponses",
                "pending_contract" => "",
                "performance" => "Performance",
                "providers" => "Prestataires",
                "validate_offer" => "Offres à valider"
            ],
            "_onboarding" => [
                "boarding" => "Embarquement",
                "step" => [
                    "confirm_email" => [
                        "call_to_action" => "Renvoyer l'email de confirmation",
                        "description" => "Confirmez votre email",
                        "message" => "Une adresse email valide est obligatoire pour que nous puissions vous envoyer des notifications. Un email vous a été automatiquement envoyé lors de la création de votre compte. Il contient un lien de validation qui vous permettra de confirmer votre compte."
                    ],
                    "create_enterprise" => [
                        "call_to_action" => "Mettre à jour mon entreprise",
                        "description" => "Renseignez votre entreprise",
                        "message" => "Vous n'avez pas encore renseigné votre entreprise"
                    ],
                    "create_enterprise_activity" => [
                        "call_to_action" => "Renseigner l'activité",
                        "description" => "Renseignez l'activité de votre entreprise",
                        "message" => "Vous n'avez pas encore renseigné l'activité de votre entreprise"
                    ],
                    "create_passwork" => [
                        "call_to_action" => "Je créé mon passwork",
                        "description" => "Renseignez votre passwork",
                        "message" => "Vous n'avez pas encore créé votre passwork"
                    ],
                    "on" => "sur",
                    "step" => "Étape",
                    "steps" => "Étapes",
                    "upload_legal_document" => [
                        "call_to_action" => "Télécharger vos documents légaux",
                        "description" => "Télécharger vos documents légaux",
                        "message" => "Veuillez télécharger vos documents légaux."
                    ],
                    "validation_passwork" => [
                        "call_to_action" => "Voir mon passwork",
                        "description" => "Votre passwork est en attente de validation",
                        "message" => "Votre passwork est en cours de validation"
                    ]
                ]
            ],
            "_vendor" => [
                "active_contract" => "Contrats actifs",
                "alert_expired_document" => "Vous avez des documents à actualiser",
                "alert_expired_document_button" => "J'actualise mes documents",
                "client" => "Clients",
                "contract" => "Contrats",
                "mission_proposal" => "Propositions de missions",
                "missions_this_month" => "Missions ce mois",
                "pending_contract" => ""
            ]
        ],
        "log" => [
            "index" => [
                "dashboard" => "Tableau de bord",
                "date" => "Date",
                "email" => "Email",
                "export_sogetrel_user_activities" => "Export activités utilisateurs Sogetrel",
                "http_method" => "Méthode HTTP",
                "impersonating" => "Ce n'est pas vous ?",
                "ip" => "IP",
                "rout" => "Route",
                "url" => "URL",
                "user_logs" => "Logs utilisateurs"
            ]
        ],
        "notification_process" => [
            "edit" => [
                "iban_change_confirmation" => "Recevoir les confirmations de changement d'IBAN",
                "notification_setting" => "Paramètres de notification",
                "notify_service_provider_paid" => "Être notifié quand un de mes Prestataires a été payé",
                "receive_emails" => "Recevoir des emails",
                "receive_mission_followup_email" => "Recevoir les emails de création de suivis de missions"
            ]
        ],
        "onboarding_process" => [
            "_actions" => [
                "add_context_tag" => "Ajouter le tag So’connext",
                "confirm_activation" => "Confirmer l'activation ?",
                "confirm_deactivation" => "Confirmer la désactivation ?",
                "remove_context_tag" => "Enlever le tag So’connext",
                "to_log_in" => "Se connecter"
            ],
            "_form" => [
                "concern_domain" => "Domaine concerné",
                "onboarding_completed" => "Onboarding terminé",
                "user" => "Utilisateur"
            ],
            "_html" => [
                "completion_date" => "Date de complétion",
                "creation_date" => "Date de création",
                "enterprise" => "Entreprise",
                "field" => "Domaine",
                "onboarding_completed" => "Onboarding terminé",
                "step_in_process" => "Étape en cours",
                "user" => "Utilisateur"
            ],
            "create" => [
                "concerned_domain" => "Domaine concerné",
                "create" => "Créer",
                "create_new_onboaring_process" => "Créer un nouveau processus onboarding",
                "dashboard" => "Tableau de bord",
                "general_information" => "Informations générales",
                "onboarding_completed" => "Onboarding terminé",
                "onboarding_process" => "Processus Onboarding",
                "record" => "Enregistrer",
                "return" => "Retour",
                "user" => "Utilisateur"
            ],
            "edit" => [
                "dashboard" => "Tableau de bord",
                "edit" => "Modifier",
                "edit_onboarding_process" => "Edition du processus d'onboarding",
                "general_information" => "Informations générales",
                "onboarding_completed" => "Onboarding terminé",
                "onboarding_process" => "Processus Onboarding",
                "record" => "Enregistrer",
                "return" => "Retour",
                "step_in_process" => "Étape en cours"
            ],
            "index" => [
                "action" => "Action",
                "add" => "Ajouter",
                "client" => "Client",
                "concerned_domain" => "Domaine concerné",
                "created" => "Créé le",
                "dashboard" => "Tableau de bord",
                "entreprise" => "Entreprise",
                "export" => "Exporter",
                "finish" => "Terminé",
                "in_progress" => "En cours",
                "onboarding_process" => "Processus Onboarding",
                "return" => "Retour",
                "status" => "Statut",
                "step_in_process" => "Étape en cours",
                "user" => "Utilisateur"
            ],
            "show" => [
                "dashboard" => "Tableau de bord",
                "general_information" => "Informations générales",
                "onboarding" => "Onboarding",
                "onboarding_process" => "Processus d'onboarding",
                "return" => "Retour"
            ]
        ],
        "profile" => [
            "customers" => [
                "dashboard" => "Tableau de bord",
                "entreprise" => "Entreprise",
                "my_clients" => "Mes Clients",
                "return" => "Retour"
            ],
            "edit" => [
                "change_password" => "Modifier le mot de passe",
                "dashboard" => "Tableau de bord",
                "edit" => "Modifier",
                "edit_email" => "Modifier l'email",
                "edit_profile" => "Modifier le profil de",
                "profile" => "Profil",
                "profile_information" => "Informations du profil",
                "record" => "Enregistrer",
                "return" => "Retour"
            ],
            "edit_password" => [
                "change_password" => "Modifier votre mot de passe",
                "current_password" => "Mot de passe actuel",
                "dashboard" => "Tableau de bord",
                "new_password" => "Nouveau mot de passe",
                "profile" => "Profil",
                "record" => "Enregistrer",
                "repeat_new_password" => "Répéter le nouveau mot de passe"
            ],
            "index" => [
                "additional_address" => "Adresse additionnelle",
                "address" => "Adresse(s)",
                "change_password" => "Modifier le mot de passe",
                "dashboard" => "Tableau de bord",
                "edit_email" => "Modifier email",
                "edit_profile" => "Modifier mon profil",
                "enterprise" => "Entreprise",
                "first_name" => "Prénom",
                "function" => "Fonction",
                "last_name" => "Nom de famille",
                "notification" => "Notifications",
                "phone_number" => "Numéro de tél.",
                "phone_numbers" => "Numéro(s) de téléphone",
                "postal_code" => "Code postal",
                "profile_of" => "Profil de",
                "profile_picture" => "Photo de profil",
                "user_identity" => "Identité de l'utilisateur"
            ]
        ],
        "terms_of_use" => [
            "show" => [
                "accept_general_condition" => "Acceptation des Conditions Générales d'Utilisation",
                "general_information" => "Informations générales",
                "validate" => "Valider"
            ]
        ],
        "user" => [
            "_badges" => ["client" => "Client", "service_provider" => "Prestataire", "support" => "Support"],
            "_form" => ["first_name" => "Prénom", "last_name" => "Nom"],
            "_html" => [
                "activation" => "Activation",
                "active" => "Actif",
                "email" => "Email",
                "enterprises" => "Entreprise(s)",
                "identity" => "Identité",
                "inactive" => "Inactif",
                "last_activity" => "Dernière activité",
                "last_authentication" => "Dernière authentification",
                "number" => "Numéro",
                "phone_number" => "Téléphone",
                "registration_date" => "Date Inscription",
                "tags" => "Tags",
                "username" => "Identifiant"
            ],
            "_index_form" => [
                "all" => "Tous",
                "clients" => "Clients",
                "providers" => "Prestataires",
                "support" => "Support"
            ],
            "_tags" => ["na" => "n/a"],
            "create" => [
                "create" => "Créer",
                "create_new_user" => "Créer un nouvel utilisateur",
                "create_user" => "Créer l'utilisateur",
                "dashboard" => "Tableau de bord",
                "general_information" => "Informations générales",
                "return" => "Retour",
                "users" => "Utilisateurs"
            ],
            "edit" => [
                "dashboard" => "Tableau de bord",
                "edit" => "Modifier",
                "edit_user" => "Modifier l'utilisateur",
                "general_information" => "Informations générales",
                "modify_user" => "Modifier l'utilisateur",
                "return" => "Retour",
                "users" => "Utilisateurs"
            ],
            "index" => [
                "action" => "Action",
                "add" => "Ajouter",
                "created_at" => "Créé le",
                "dashboard" => "Tableau de bord",
                "email" => "Email",
                "enterprise" => "Entreprise",
                "name" => "Nom",
                "title" => "Utilisateurs",
                "type" => "Type",
                "users" => "Utilisateurs"
            ],
            "show" => [
                "comments" => "Commentaires",
                "connect" => "Se connecter",
                "contact" => "Contacter",
                "dashboard" => "Tableau de bord",
                "files" => "Fichiers",
                "general_information" => "Informations générales",
                "users" => "Utilisateurs"
            ]
        ]
    ]
];
