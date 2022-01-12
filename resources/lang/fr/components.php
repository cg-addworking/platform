<?php
return [
    "alterable" => ["save" => "Sauvegarder"],
    "contract" => [
        "contract" => [
            "application" => [
                "requests" => [
                    "store_contract_request" => [
                        "messages" => [
                            "before_or_equal" => "Le champ contract.mission.starts at doit être une date antérieure ou égale à la date du jour"
                        ]
                    ]
                ],
                "tracking" => [
                    "addworking" => "AddWorking",
                    "contract_archived" => "a archivé ce contrat",
                    "contract_callback" => "a rappelé le contrat le :date",
                    "contract_expires" => "Le contrat est arrivé à échéance",
                    "contract_is_active" => "a passé le contrat à actif",
                    "contract_pre_expire_notification" => "a notifié que le contrat arrivait à echéance dans 30 jours",
                    "contract_unarchived" => "a retiré ce contrat des archives",
                    "contract_variable_value_was_requested" => "a été invité à completer des valeurs de variable par Addworking",
                    "create_amendment" => "a créé l'avenant :amendment_name",
                    "create_contract" => "a créé le contrat",
                    "party_refuses_to_sign_contract" => "a refusé le contrat",
                    "party_signs_contract" => "a signé le contrat",
                    "party_validates_contract" => "a validé le contrat",
                    "request_send_contract_to_signature" => "a envoyé le contrat en validation à :user pour sa mise en signature.",
                    "scan_urssaf_certificate_document_rejection" => "La lecture automatique n'a pas validé le document",
                    "scan_urssaf_certificate_document_validation" => "La lecture automatique a pré-check le document",
                    "send_contract_to_signature" => "a mis le contrat en signature",
                    "send_contract_to_validation" => "a envoyé le contrat en validation à :user pour sa mise en signature.",
                    "tracking" => "Suivi",
                    "tracking_document" => "Suivi des relances"
                ],
                "views" => [
                    "amendment" => [
                        "_form_without_model" => [
                            "actions" => "Actions",
                            "contract_body" => "Corps du contrat",
                            "contract_informations" => "Informations sur le contrat",
                            "designation" => "Dénomination de la partie prenante",
                            "display_name" => "Nom de la pièce de contrat",
                            "enterprise" => "Partie prenante",
                            "external_identifier" => "Identifiant externe",
                            "file" => "Fichier à sélectionner",
                            "name" => "Nom du contrat",
                            "number" => "Numéro",
                            "owner" => "Entreprise propriétaire",
                            "part_informations" => "Informations sur la pièce de contrat",
                            "parties_informations" => "Informations sur les parties prenantes et signataires",
                            "select_file" => "Choisir un fichier",
                            "signatory" => "Signataire",
                            "signed_at" => "Date de signature",
                            "valid_from" => "Date de début",
                            "valid_until" => "Date de fin"
                        ],
                        "_form_without_model_to_sign" => [
                            "amendment_part_label" => "Nom de la pièce de contrat",
                            "contract_informations" => "Informations sur le contrat",
                            "display_name" => "Nom de la pièce de contrat",
                            "external_identifier" => "Identifiant externe",
                            "file" => "Fichier à sélectionner",
                            "name" => "Nom de l'avenant",
                            "part_informations" => "Informations sur la pièce de contrat",
                            "select_file" => "Choisir un fichier",
                            "valid_from" => "Date de début",
                            "valid_until" => "Date de fin"
                        ],
                        "create_without_model" => [
                            "return" => "Retour",
                            "submit" => "Enregister",
                            "title" => "Déposer un avenant signé"
                        ],
                        "create_without_model_to_sign" => [
                            "return" => "Retour",
                            "submit" => "Enregister",
                            "title" => "Déposer un avenant à signer"
                        ]
                    ],
                    "annex" => [
                        "_actions" => ["delete" => "Supprimer", "show" => "Consulter"],
                        "_breadcrumb" => [
                            "create" => "Créer une annexe",
                            "dashboard" => "Tableau de bord",
                            "index" => "Annexes"
                        ],
                        "_filters" => ["enterprise" => "Entreprises"],
                        "_form" => [
                            "description" => "Description",
                            "enterprise" => "Entreprise",
                            "file" => "Fichier",
                            "name" => "Nom"
                        ],
                        "_html" => [
                            "created_date" => "Date de création",
                            "description" => "Description",
                            "display_name" => " Nom de l'annexe",
                            "file" => "Fichier",
                            "informations" => "Informations générales",
                            "last_modified_date" => "Date de dernière modification",
                            "more_informations" => "Informations complémentaires",
                            "owner" => "Propriétaire de l'annexe"
                        ],
                        "_table_head" => [
                            "actions" => "Actions",
                            "created_at" => "Date de création",
                            "description" => "Description",
                            "file" => "Accès au fichier",
                            "name" => "Nom",
                            "number" => "Numéro"
                        ],
                        "create" => [
                            "return" => "Retour",
                            "submit" => "Enregister",
                            "title" => "Création de modèle de contrat"
                        ],
                        "index" => ["create" => "Créer une annexe", "show" => "N° :number", "title" => "Les annexes"],
                        "show" => ["return" => "Retour"]
                    ],
                    "contract" => [
                        "_actions" => [
                            "add_part" => "",
                            "archive" => "Archiver",
                            "back" => "Retour",
                            "call_back" => "Rappeler le contrat",
                            "cancel" => "Annuler",
                            "create_amendment" => "",
                            "deactivate" => "Désactiver",
                            "delete" => "Supprimer",
                            "download" => "Télécharger le contrat",
                            "download_documents" => "Télécharger les documents liés",
                            "download_proof_of_signature" => "Télécharger le certificat de signature",
                            "edit" => "Modifier",
                            "edit_contract_party" => "Changer les parties prenantes",
                            "edit_validators" => "Circuit de Validation",
                            "link_mission" => "Lier une mission existante",
                            "nba_generate" => "Générer le contrat",
                            "nba_parties" => "Renseigner les parties prenantes",
                            "nba_send" => "Notifier les parties prenantes",
                            "regenerate_contract" => "Re-générer le contrat",
                            "show" => "Consulter",
                            "sign" => "Signer",
                            "unarchive" => "Désarchiver",
                            "update_contract_from_yousign_data" => "Mettre à jour le contract depuis yousign",
                            "upload_signed_contract" => "Mettre à jour le contrat signé",
                            "variable_list" => "Variables"
                        ],
                        "_breadcrumb" => [
                            "create" => "Créer",
                            "create_amendment" => "Créer un avenant",
                            "create_part" => "Ajouter une annexe spécifique",
                            "dashboard" => "Tableau de bord",
                            "edit" => "Modifier",
                            "index" => "Contrats",
                            "show" => "N° :number",
                            "sign" => "Signer",
                            "upload_signed_contract" => "Mettre à jour le contrat signé"
                        ],
                        "_filters" => [
                            "active" => "Actif",
                            "archived_contract" => "Afficher les contrats archivés ",
                            "being_signed" => "En cours de signature",
                            "cancelled" => "Annulé",
                            "created_by" => "Créateur du contrat",
                            "declined" => "Décliné",
                            "draft" => "Brouillon",
                            "enterprise" => "Entreprise propriétaire",
                            "error" => "Erreur",
                            "expired" => "Expiré",
                            "filter" => "",
                            "generated" => "Généré",
                            "generating" => "En cours de génération",
                            "inactive" => "Inactif",
                            "locked" => "Verouillé",
                            "model" => "Modèle",
                            "party" => "Partie prenante",
                            "published" => "Publié",
                            "ready_to_generate" => "Prêt pour génération",
                            "ready_to_sign" => "Prêt à signer",
                            "reset" => "",
                            "signed" => "Signé",
                            "state" => "État",
                            "status" => "Statut",
                            "unknown" => "Dans un état inconnu",
                            "uploaded" => "Téléchargé",
                            "uploading" => "En cours de téléchargement",
                            "work_field" => "Chantier"
                        ],
                        "_form" => [
                            "amendment_name_preset" => "Avenant :count du contrat :contract_parent_name",
                            "amendment_without_contract_model" => "",
                            "contract_model" => "Modèle de contrat",
                            "contract_model_required" => "Le champ \"modèle de contrat\" est obligatoire.",
                            "enterprise" => "Entreprise propriétaire du modèle",
                            "enterprise_owner" => "Entreprise propriétaire du contrat",
                            "external_identifier" => "Numéro du contrat",
                            "general_information" => "Informations générales",
                            "mission" => "Mission",
                            "mission_create" => "Créer une nouvelle mission",
                            "mission_none" => "Aucune mission liée à ce contrat",
                            "mission_select" => "Sélectionner une mission",
                            "name" => "Nom du contrat",
                            "no_selection" => "Aucune sélection",
                            "valid_from" => "Date de début",
                            "valid_until" => "Date d'échéance"
                        ],
                        "_form_without_model" => [
                            "contract_body" => "Corps du contrat",
                            "contract_informations" => "Informations sur le contrat",
                            "designation" => "Dénomination de la partie prenante",
                            "display_name" => "Nom de la pièce de contrat",
                            "enterprise" => "Partie prenante",
                            "external_identifier" => "Identifiant externe",
                            "file" => "Fichier à sélectionner",
                            "name" => "Nom du contrat",
                            "owner" => "Entreprise propriétaire",
                            "part_informations" => "Informations sur la pièce de contrat",
                            "parties_informations" => "Informations sur les parties prenantes et signataires",
                            "party_1_designation" => "Le client",
                            "party_2_designation" => "Le prestataire",
                            "select_file" => "Choisir un fichier",
                            "signatory" => "Signataire",
                            "signed_at" => "Date de signature",
                            "valid_from" => "Date de début",
                            "valid_until" => "Date de fin"
                        ],
                        "_form_without_model_to_sign" => [
                            "contract_informations" => "Informations sur le contrat",
                            "contract_label" => "Nom du contrat",
                            "designation" => "Dénomination de la partie prenante",
                            "display_name" => "Nom de la pièce de contrat",
                            "enterprise" => "Partie prenante",
                            "external_identifier" => "Identifiant externe",
                            "file" => "Fichier à sélectionner",
                            "name" => "Nom du contrat",
                            "owner" => "Entreprise propriétaire",
                            "part_informations" => "Informations sur la pièce de contrat",
                            "parties_informations" => "Informations sur les parties prenantes et signataires",
                            "party_1_designation" => "Le client",
                            "party_2_designation" => "Le prestataire",
                            "select_file" => "Choisir un fichier",
                            "signatory" => "Signataire",
                            "valid_from" => "Date de début",
                            "valid_until" => "Date de fin"
                        ],
                        "_html" => [
                            "amendment_contracts" => "Avenants",
                            "compliance_documents" => "Documents de conformité",
                            "contract_dates" => "Dates du contrat",
                            "contract_model" => "Modèle de contrat",
                            "contract_parts_empty" => "Aucune pièce du contrat à afficher pour le moment.",
                            "created_at" => "Date de création",
                            "documents" => "Document(s) à fournir",
                            "download" => "Télécharger",
                            "external_identifier" => "Identifiant externe",
                            "from" => "Du",
                            "generating_refresh" => "Rafraîchir la page",
                            "informations" => "",
                            "mission" => "Mission",
                            "more_informations" => "",
                            "non_body_contract_parts" => "Documents Joints",
                            "non_body_contract_parts_empty" => "Aucun documents joints du contrat à afficher pour le moment.",
                            "owner" => "Propriétaire du contrat",
                            "parent_contract" => "Contrat parent",
                            "parties" => "Signataires et parties prenantes",
                            "parts" => "Pièce(s) du contrat",
                            "party_signed_at" => "Date de signature de :party_name",
                            "request_documents" => "Notifier le :party_denomination",
                            "signed_at" => "Signé le",
                            "state" => "État",
                            "status" => "Statut",
                            "to" => "Au",
                            "updated_at" => "Date de modification",
                            "valid_from" => "Date de début du contrat",
                            "valid_until" => "Date de fin du contrat",
                            "valid_until_date" => "Date d'échéance initiale : ",
                            "validated_at" => "validé le",
                            "validator_parties" => "Validateurs",
                            "workfield" => "Chantier"
                        ],
                        "_state" => [
                            "active" => "Actif",
                            "archived" => "Archivé",
                            "canceled" => "Annulé",
                            "declined" => "Décliné",
                            "draft" => "Brouillon",
                            "due" => "Échu",
                            "generated" => "Bon pour mise en signature",
                            "generating" => "En cours de génération",
                            "in_preparation" => "En préparation",
                            "in_writing" => "En rédaction",
                            "inactive" => "Inactif",
                            "internal_validation" => "En validation interne",
                            "is_ready_to_generate" => "A générer",
                            "missing_documents" => "Documents à fournir",
                            "signed" => "Signé",
                            "to_be_distributed_for_further_information" => "À diffuser pour complément",
                            "to_complete" => "À Compléter",
                            "to_countersign" => "À contresigner",
                            "to_sign" => "À signer",
                            "to_sign_waiting_for_signature" => "À signer/ En attente de signature",
                            "to_validate" => "À valider",
                            "under_validation" => "En cours de validation",
                            "unknown" => "Inconnu",
                            "waiting_for_signature" => "En attente de signature"
                        ],
                        "_status" => [
                            "active" => "Actif",
                            "being_signed" => "En cours de signature",
                            "cancelled" => "Annulé",
                            "declined" => "Décliné",
                            "draft" => "Brouillon",
                            "error" => "Erreur",
                            "expired" => "Expiré",
                            "generated" => "Généré",
                            "generating" => "En cours de génération",
                            "inactive" => "Inactif",
                            "locked" => "Verouillé",
                            "published" => "Publié",
                            "ready_to_generate" => "Prêt pour génération",
                            "ready_to_sign" => "Prêt à signer",
                            "signed" => "Signé",
                            "unknown" => "Dans un état inconnu",
                            "uploaded" => "Téléchargé",
                            "uploading" => "En cours de téléchargement"
                        ],
                        "_table_head" => [
                            "actions" => "Actions",
                            "amount" => "Montant",
                            "contract_external_identifier" => "Code du contrat",
                            "contract_number" => "Numéro du contrat",
                            "contract_party_enterprise_name" => "Partie prenante",
                            "created_by" => "Créateur du contrat",
                            "enterprise" => "Entreprise propriétaire",
                            "external_identifier" => "Identifiant externe",
                            "model" => "Modèle de contrat",
                            "name" => "Nom du contrat",
                            "number" => "Numéro",
                            "parties" => "Parties prenantes",
                            "state" => "État",
                            "status" => "Statut",
                            "valid_from" => "Date de début",
                            "valid_until" => "Date de fin",
                            "workfield_external_identifier" => "Code du chantier"
                        ],
                        "accounting_monitoring" => [
                            "_breadcrumb" => [
                                "contracts" => "Contrats",
                                "dashboard" => "Tableau de bord",
                                "index" => "Suivi de facturation des contrats"
                            ],
                            "_table_head" => [
                                "actions" => "Actions",
                                "amount_before_taxes" => "Montant HT du contrat",
                                "amount_before_taxes_invoiced" => "Montant HT facturé",
                                "amount_of_remains_to_be_billed" => "Reste à facturer HT",
                                "amount_of_taxes_invoiced" => "Montant TVA",
                                "contract_number" => "Numéro de contrat",
                                "dc4" => "DC4",
                                "good_end" => "BF",
                                "good_end_deposit" => "N° caution BF",
                                "good_end_value" => "Montant BF retenu",
                                "guaranteed_holdback" => "RG",
                                "guaranteed_holdback_deposit" => "N° caution RG",
                                "guaranteed_holdback_value" => "Montant RG retenu",
                                "payment" => "Paiement",
                                "signature" => "Date de signature",
                                "vendor" => "Prestataire",
                                "workfield" => "Nom du chantier"
                            ],
                            "index" => [
                                "create_capture_invoice" => "Imputer une facture",
                                "filters" => [
                                    "enterprise" => "Entreprise propriétaire",
                                    "filter" => "Filtrer",
                                    "reset" => "Réinitialiser",
                                    "work_field" => "Chantier"
                                ],
                                "return" => "Retour",
                                "title" => "Suivi de facturation des contrats"
                            ]
                        ],
                        "capture_invoice" => [
                            "_breadcrumb" => [
                                "contracts" => "Contrats",
                                "create" => "Imputer une facture",
                                "dashboard" => "Tableau de bord",
                                "index" => "Factures imputées",
                                "index_accounting_monitoring" => "Suivi de facturation des contrats"
                            ],
                            "_form" => [
                                "amount_good_end" => "Montant BF pour ce contrat",
                                "amount_guaranteed_holdback" => "Montant RG pour ce contrat ( :number du montant HT de la facture imputée)",
                                "contract" => "Contrat",
                                "contract_number" => "N° de contrat",
                                "create" => "Imputer la facture",
                                "dc4_date" => "Date de validation DC4",
                                "dc4_file" => "Fichier DC4",
                                "dc4_percent" => "Agréé à X %",
                                "dc4_text" => "DC4: Agréé à :percent %",
                                "deposit_good_end_number" => "N° caution BF pour ce contrat",
                                "deposit_guaranteed_holdback_number" => "N° caution RG pour ce contrat",
                                "invoice_amount_before_taxes" => "Montant HT pour ce contrat",
                                "invoice_amount_of_taxes" => "Montant TVA pour ce contrat",
                                "invoice_number" => "Numéro de facture prestataire",
                                "invoiced_at" => "Date de facture",
                                "vendor" => "Prestataire"
                            ],
                            "_table_head" => [
                                "actions" => "Actions",
                                "amount_good_end" => "Montant BF",
                                "amount_guaranteed_holdback" => "Montant RG",
                                "deposit_good_end_number" => "N° caution BF",
                                "deposit_guaranteed_holdback_number" => "N° caution RG",
                                "invoice_amount_before_taxes" => "Montant HT",
                                "invoice_amount_of_taxes" => "Montant TVA",
                                "invoiced_at" => "Date de facturation",
                                "number" => "Numéro"
                            ],
                            "create" => ["return" => "Retour", "title" => "Imputer une facture pour ce contrat"],
                            "edit" => ["return" => "Retour", "title" => "Modifier la facture imputée"],
                            "index" => [
                                "create" => "Imputer une facture",
                                "return" => "Retour",
                                "title" => "Factures imputées au contrat :contract"
                            ]
                        ],
                        "create" => ["create" => "Enregistrer", "return" => "Retour", "title" => "Création du contrat"],
                        "create_amendment" => ["title" => "Création de l'avenant"],
                        "create_without_model" => ["return" => "Retour", "submit" => "Enregister", "title" => "Déposer un contrat"],
                        "create_without_model_to_sign" => [
                            "return" => "Retour",
                            "submit" => "Enregister",
                            "title" => "Déposer un contrat à signer"
                        ],
                        "edit" => ["edit" => "Modifier", "title" => "Modifier le contract N° :number"],
                        "edit_validators" => [
                            "edit" => "Modifier",
                            "title" => "Modifier le circuit de validation du contract N° :number"
                        ],
                        "export" => [
                            "success" => "Votre export est en cours de génération, vous recevrez un lien par mail pour le télécharger."
                        ],
                        "index" => [
                            "accounting_monitoring" => "Suivi de facturation",
                            "annex" => "Bibliothèques d'annexes",
                            "contract_model" => "Modèles de contrat",
                            "create" => "Créer un contrat",
                            "createContractWithoutModel" => "",
                            "create_contract_without_model" => "Déjà signé",
                            "create_contract_without_model_to_sign" => "A signer",
                            "create_dropdown" => "Déposer un contrat",
                            "export" => "Exporter",
                            "return" => "Retour",
                            "title" => "Contrats"
                        ],
                        "mail" => [
                            "addworking_team" => "",
                            "consult_button" => "",
                            "contract_needs_documents" => [
                                "addworking_team" => "L'équipe AddWorking",
                                "consult_button" => "",
                                "consult_contract" => "Voir le contrat",
                                "consult_doc" => "Déposer les documents",
                                "followup" => "Rappel : ",
                                "greetings" => "Bonjour,",
                                "sentence_one" => "Votre contrat :contract_name avec :enterprise_name nécessite quelques éléments de votre part avant sa mise en signature.",
                                "sentence_two" => "",
                                "subject" => ":enterprise_name vous propose un nouveau contrat",
                                "thanks_you" => "Cordialement,"
                            ],
                            "contract_needs_variables_values" => [
                                "addworking_team" => "L'équipe AddWorking",
                                "consult_contract" => "Voir le contrat",
                                "greetings" => "Bonjour,",
                                "sentence_one" => "Le contrat :contract_name nécessite des éléments de votre part.",
                                "sentence_two" => "Merci de compléter les variables.",
                                "subject" => "Des valeurs de variable vous sont demandées",
                                "thanks_you" => "Cordialement,"
                            ],
                            "contract_request_variable_value" => [
                                "addworking_team" => "L'équipe AddWorking",
                                "consult_contract" => "Voir le contrat",
                                "consult_variables" => "Voir les variables",
                                "greetings" => "Bonjour,",
                                "sentence_one" => "Le contrat :contract_name entre :pp_1 et :pp_2 nécessite des éléments de votre part.",
                                "sentence_two" => "Merci de compléter les variables demandées.",
                                "subject" => "Des valeurs de variable vous sont demandées",
                                "subject_oracle" => " N° oracle : :oracle_id",
                                "thanks_you" => "Cordialement,"
                            ],
                            "contract_to_complete" => [
                                "addworking_team" => "L'équipe AddWorking",
                                "consult_button" => "Je consulte le contrat",
                                "greetings" => "Bonjour,",
                                "sentence_one" => "Votre contrat :type avec votre client :owner est en préparation.",
                                "sentence_two" => "Merci de renseigner les informations nécessaires à son élaboration.",
                                "subject" => "Nouveau contrat",
                                "thanks_you" => "Cordialement,"
                            ],
                            "contract_to_send_to_signature" => [
                                "addworking_team" => "L'équipe AddWorking",
                                "consult_button" => "Je consulte le contrat",
                                "greetings" => "Bonjour,",
                                "sentence_one" => "Le contrat :contract_name est prêt pour être mis en signature.",
                                "sentence_three" => "Vous pouvez y accéder en cliquant sur le bouton ci-dessous.",
                                "sentence_two" => "Envoyez votre contrat en validation ou mettez le en signature directement.",
                                "subject" => "Le contrat :contract_name est prêt pour être mis en signature",
                                "thanks_you" => "Cordialement,"
                            ],
                            "contract_to_sign" => [
                                "addworking_team" => "L'équipe AddWorking",
                                "consult_button" => "Je consulte le contrat",
                                "followup" => "Rappel : ",
                                "greetings" => "Bonjour,",
                                "sentence_one" => "L'entreprise :owner vous invite à signer le contrat :contract_name.",
                                "sentence_two" => "Vous pouvez consulter puis signer ce contrat en cliquant sur le bouton ci-dessous.",
                                "subject" => "Nouveau contrat à signer",
                                "thanks_you" => "Cordialement,"
                            ],
                            "contract_to_validate_on_yousign" => [
                                "addworking_team" => "L'équipe AddWorking",
                                "consult_button" => "Je consulte le contrat",
                                "followup" => "Rappel : ",
                                "greetings" => "Bonjour,",
                                "sentence_one" => "L'entreprise :owner vous invite à valider le contrat :contract_name avant sa mise en signature.",
                                "sentence_two" => "Vous pouvez consulter puis valider ce contrat en cliquant sur le bouton ci-dessous.",
                                "subject" => "Un nouveau contrat demande votre validation",
                                "thanks_you" => "Cordialement,"
                            ],
                            "expiring_contract_customer" => [
                                "addworking_team" => "L'équipe AddWorking",
                                "greetings" => "Bonjour,",
                                "sentence_one" => "Un ou plusieurs contrat(s) de :enterprise_name arrivent à échéance dans moins de 30 jours.",
                                "sentence_three" => "Un ou plusieurs contrat(s) de :enterprise_name seront échus le ",
                                "sentence_two" => "Nous vous invitons à prendre les dispositions nécessaires pour le(s) renouveler si nécessaire.",
                                "subject_one" => "Vous avez des contrats qui arrivent à échéance",
                                "subject_two" => "Vous avez des contrats bientôt échus",
                                "thank_you" => "Cordialement,",
                                "url" => "Je consulte les contrats concernés"
                            ],
                            "expiring_contract_vendor" => [
                                "addworking_team" => "L'équipe AddWorking",
                                "greetings" => "Bonjour,",
                                "sentence_one" => "Votre contrat :contract_name avec :enterprise_name arrive à échéance au ",
                                "subject_one" => "Vous avez un contrat qui arrive à échéance",
                                "thank_you" => "Cordialement,",
                                "url" => "Je consulte le contrat"
                            ],
                            "export" => [
                                "addworking_team" => "L'équipe AddWorking",
                                "consult_button" => "Télécharger",
                                "greetings" => "Bonjour,",
                                "sentence_one" => "Votre export est prêt !",
                                "sentence_two" => "Cliquez sur le lien ci-dessous pour le télécharger :",
                                "subject" => "Export des contrats pour :enterprise_name",
                                "thanks_you" => "Cordialement,"
                            ],
                            "greetings" => "",
                            "notify_for_new_comment" => [
                                "addworking_team" => "L'équipe AddWorking",
                                "comment_author" => "Par :author_name",
                                "consult_button" => "Je consulte le contrat",
                                "greetings" => "Bonjour :user_name,",
                                "sentence_one" => "AddWorking vous informe qu'un nouveau commentaire a été posté pour le contrat :contract_name : ",
                                "subject" => ":contract_name - Un nouveau commentaire est posté.",
                                "thanks_you" => "Cordialement,"
                            ],
                            "refused_contract" => [
                                "addworking_team" => "L'équipe AddWorking",
                                "consult_button" => "Je consulte le contrat",
                                "greetings" => "Bonjour :name,",
                                "sentence_one" => "AddWorking vous informe que le contrat :contract_name a été refusé.",
                                "subject" => ":name - Votre document a été refusé sur AddWorking.",
                                "thanks_you" => "Cordialement,"
                            ],
                            "request_validation" => [
                                "access_contract" => "Accéder au contrat",
                                "addworking_team" => "L'équipe AddWorking",
                                "greetings" => "Bonjour,",
                                "sentence_one" => "Vous avez un nouveau contrat qui nécessite votre validation pour être mis en signature :",
                                "sentence_two" => "Vous pouvez consulter l'intégralité du contrat en cliquant sur le bouton ci-dessous.",
                                "thanks_you" => "Cordialement,"
                            ],
                            "sentence_one" => "",
                            "sentence_two" => "",
                            "signed_contract" => [
                                "addworking_team" => "L'équipe AddWorking",
                                "consult_button" => "Je consulte le contrat",
                                "greetings" => "Bonjour :name,",
                                "sentence_one" => "AddWorking vous informe que le contrat :contract_name a bien été signé.",
                                "subject" => ":name - La signature de votre document est terminée sur AddWorking.",
                                "thanks_you" => "Cordialement,"
                            ],
                            "thanks_you" => ""
                        ],
                        "request_validation" => [
                            "general_information" => "Informations générales",
                            "send" => "Envoyer la demande de mise en signature",
                            "success" => "Ce contrat vient d'être envoyé pour validation avant mise en signature. Si vous souhaitez relancer le validant, il suffit de reproduire l'opération.",
                            "title" => "Envoyer une demande de mise en signature",
                            "user" => "Utilisateur"
                        ],
                        "show" => [
                            "add_dropdown" => "Ajouter...",
                            "add_part" => "Une annexe spécifique",
                            "add_part_to_signed_contract" => "Un document joint",
                            "create_amendment" => "Un avenant",
                            "create_amendment_without_model" => "Un avenant signé",
                            "create_amendment_without_model_to_sign" => "Un avenant à signer",
                            "edit_variable" => "Compléter les variables",
                            "generate_contract" => "",
                            "request_signature" => "Relancer le :designation_pp pour signer",
                            "request_validation" => "Envoyer pour validation",
                            "return" => "Retour",
                            "send_to_manager" => "Envoyer à un responsable",
                            "send_to_sign" => "Mettre le contrat en signature",
                            "sign" => "Signer",
                            "upload_documents" => "Documents à fournir",
                            "validate" => "Valider le contrat"
                        ],
                        "tracking" => [
                            "request_documents" => "Notification pour collecte des documents nécessaire(s) au contrat le :date à :pp par :user"
                        ],
                        "upload_signed_contract" => [
                            "display_name" => "Nom de la pièce du contrat",
                            "file" => "Fichier à sélectionner",
                            "party_signed_at" => "Date de signature de :party_name",
                            "return" => "Retour",
                            "select_file" => "Choisir un fichier",
                            "signed_on_the_at" => "Signé par {firstname} {lastname} le {date.fr}",
                            "submit" => "Ajouter",
                            "title" => "Mettre à jour le contrat signé"
                        ]
                    ],
                    "contract_mission" => [
                        "_breadcrumb" => [
                            "contract" => "Contrat N° :number",
                            "create_amendment" => "Créer un avenant",
                            "dashboard" => "Tableau de bord",
                            "link_contract" => "Lier un contrat",
                            "link_mission" => "Lier une mission",
                            "mission" => "Mission N° :number"
                        ],
                        "create" => [
                            "contract" => "Contrat",
                            "contract_title" => "Lier le contrat N° :number à une mission",
                            "mission" => "Mission",
                            "mission_title" => "Lier la mission N° :number à un contrat",
                            "return" => "Retour",
                            "submit" => "Enregistrer"
                        ]
                    ],
                    "contract_part" => [
                        "_actions" => ["delete" => "Supprimer"],
                        "_form" => [
                            "annex" => "Sélectionner une annexe",
                            "display_name" => "Nom de la pièce",
                            "file" => "Pièce à ajouter",
                            "is_from_annexes" => "Depuis la bibliothèque d'annexes disponibles",
                            "is_from_annexes_options" => "Sélectionner une annexe à ajouter",
                            "is_signed" => "Pièce signable?",
                            "no" => "Non",
                            "select_file" => "Choisir un fichier",
                            "sign_on_last_page" => "Dernière page",
                            "signature_mention" => "Mention de la signature",
                            "signature_page" => "Numéro de page de la signature ",
                            "upload_file" => "Depuis votre poste",
                            "yes" => "Oui"
                        ],
                        "create" => [
                            "return" => "Retour",
                            "submit" => "Enregistrer",
                            "title" => "Ajouter une annexe spécifique"
                        ],
                        "signed_contract" => [
                            "create" => [
                                "return" => "Retour",
                                "submit" => "Enregistrer",
                                "title" => "Ajouter une annexe spécifique"
                            ]
                        ]
                    ],
                    "contract_party" => [
                        "_breadcrumb" => [
                            "create" => "Créer",
                            "dashboard" => "Tableau de bord",
                            "index" => "Parties prenantes",
                            "index_contract" => "Contrats",
                            "show_contract" => "Contrat N° :number"
                        ],
                        "_form" => [
                            "add_validator" => "Ajouter un validateur",
                            "confirm_edit" => "Modifier les informations des partie prenante aura pour effet de supprimer les fichiers du contract à tout jamais. Êtes vous sûre?",
                            "denomination" => "Dénomination",
                            "enterprise" => "Entreprise",
                            "general_information" => "Informations générales",
                            "order" => "Ordre",
                            "party" => "Partie prenante",
                            "remove_validator" => "Retirer",
                            "signatory" => "Signataire",
                            "signed_at" => "Date de signature",
                            "validator" => "Validator",
                            "validator_info" => "Ces membres seront sollicités pour validation du contrat avant envoi pour mise en signataire",
                            "validators" => "Validateurs"
                        ],
                        "create" => [
                            "create" => "Enregistrer",
                            "return" => "Retour",
                            "title" => "Identification des parties prenantes du contrat N° :number"
                        ],
                        "store" => [
                            "success" => "Vos variables pré-remplies sont en cours de génération. Cela peut prendre quelques minutes, vous pouvez d’ores et déjà compléter le reste des variables."
                        ]
                    ],
                    "contract_party_document" => [
                        "_breadcrumb" => [
                            "dashboard" => "Tableau de bord",
                            "index" => "Documents demandés pour :enterprise_name",
                            "index_contract" => "Contrats",
                            "show_contract" => "Contrat N° :number"
                        ],
                        "index" => [
                            "return" => "Retour",
                            "title" => "Document(s) de :enterprise pour le contrat :name"
                        ]
                    ],
                    "contract_variable" => [
                        "_breadcrumb" => [
                            "dashboard" => "Tableau de bord",
                            "define_value" => "Définir les valeurs de variables",
                            "edit" => "Définir la valeur des variables de contrat",
                            "index" => "Variables de contrat",
                            "index_contract" => "Contrats",
                            "show_contract" => "Contrat N° :number"
                        ],
                        "_filters" => [
                            "filter" => "Filtrer",
                            "model_variable_display_name" => "Libellé de la variable",
                            "model_variable_input_type" => "Type",
                            "model_variable_model_part_display_name" => "Pièce de contrat",
                            "model_variable_required" => "Requis",
                            "reset" => "Réinitialiser",
                            "value" => "Valeur"
                        ],
                        "_form" => [
                            "denomination_party" => "Dénomination partie prenante",
                            "description" => "Description",
                            "display_name" => "Nom de la variable",
                            "edit_variable_value" => "Modification des valeurs de variables de contract",
                            "value" => "Valeur (utilisé dans la pièce : :part)"
                        ],
                        "_table_head" => [
                            "contract_model_display_name" => "Libellé de la variable",
                            "contract_model_input_type" => "Type",
                            "contract_model_part_name" => "Pièce de contrat",
                            "contract_party_enterprise_name" => "Partie prenante",
                            "description" => "Description",
                            "required" => "Obligatoire",
                            "value" => "Valeur"
                        ],
                        "define_value" => [
                            "create" => "Enregistrer",
                            "edit" => "Définir la valeur des variables de contrat",
                            "request_contract_variable_value_user_to_request" => "Sélectionner un utilisateur à notifier",
                            "request_value_button" => "Assigner des variables",
                            "return" => "Retour",
                            "send_request_contract_variable_value" => "Envoyer la demande",
                            "success_send_request_contract_variable_value" => "Une requette a été envoyé.",
                            "title" => "Définir les valeurs de variables",
                            "url_is_too_long" => "Vous ne pouvez pas selectioner plus de variables."
                        ],
                        "error" => ["no_variable_to_edit" => "Aucune variable a définir"],
                        "index" => [
                            "define_value" => "Définir les valeurs",
                            "refresh" => "Actualiser les variables",
                            "refresh_warning" => "Les valeurs des variables du formulaire qui ne sont pas enregistrées, seront perdues.",
                            "regenerate" => "Régénérer les pièces de contrat",
                            "return" => "Retour",
                            "table_row_empty" => "Aucune variable de contrat trouvé",
                            "title" => "Liste de variable de contrat"
                        ]
                    ]
                ]
            ]
        ],
        "model" => [
            "application" => [
                "models" => [
                    "contract_model_variable" => [
                        "input_type" => [
                            "contract_enterprise_owner" => "Entreprise Propriétaire",
                            "contract_external_identifier" => "Identifiant externe",
                            "contract_title" => "Contrat",
                            "contract_valid_from" => "Date de début",
                            "contract_valid_until" => "Date d'échéance",
                            "date" => "Date",
                            "enterprise_address" => "Adresse d'entreprise",
                            "enterprise_employees_number" => "Nombre d'employés ",
                            "enterprise_identification_number" => "Numéro d'identification (SIRET)",
                            "enterprise_legal_form" => "Forme légale",
                            "enterprise_name" => "Nom d'entreprise",
                            "enterprise_registration_date" => "Date d'immatriculation",
                            "enterprise_siren_number" => "SIREN",
                            "enterprise_title" => "Entreprise",
                            "enterprise_town" => "Ville d'entreprise",
                            "long_text" => "Texte long",
                            "mission_amount" => "Montant",
                            "mission_ended_at" => "Date de fin",
                            "mission_started_at" => "Date de début",
                            "mission_title" => "Mission",
                            "options" => "Options",
                            "party_title" => "Partie prenante",
                            "registration_town" => "Ville d'enregistrement",
                            "signatory_function" => "Fonction du signataire",
                            "signatory_mail" => "Email du signataire",
                            "signatory_name" => "Nom du signataire",
                            "signatory_title" => "Signataire",
                            "text" => "Texte",
                            "text_title" => "Input",
                            "work_field_address" => "Adresse",
                            "work_field_description" => "Descriptif des travaux confiés",
                            "work_field_display_name" => "Nom",
                            "work_field_ended_at" => "Date de fin",
                            "work_field_external_id" => "Code chantier",
                            "work_field_project_manager" => "Maître d'ouvrage",
                            "work_field_project_owner" => "Maître d'oeuvre",
                            "work_field_sps_coordinator" => "Coordonnateur SPS",
                            "work_field_started_at" => "Date de début",
                            "work_field_title" => "Chantier"
                        ]
                    ]
                ],
                "views" => [
                    "contract_model" => [
                        "_actions" => [
                            "add_part" => "Ajouter une pièce",
                            "archive" => "Archiver",
                            "consult" => "Consulter",
                            "delete" => "Supprimer",
                            "duplicate" => "Dupliquer",
                            "edit" => "Modifier",
                            "index_part" => "Pièces (:count)",
                            "index_variable" => "",
                            "index_variables" => "Variables",
                            "preview" => "Preview",
                            "versionate" => "Nouvelle version"
                        ],
                        "_breadcrumb" => [
                            "create" => "Créer un modèle de contrat",
                            "dashboard" => "Tableau de bord",
                            "edit" => "Modifier",
                            "index" => "Modèles de contrat",
                            "show" => "N° :number"
                        ],
                        "_filters" => [
                            "archived_contract_model" => "Afficher les modèles archivés",
                            "enterprise" => "Entreprise propriétaire",
                            "status" => "État"
                        ],
                        "_form" => [
                            "display_name" => "Nom du modèle",
                            "enterprise" => "Entreprise propriètaire",
                            "general_information" => "Informations générales",
                            "should_vendors_fill_their_variables" => "Les sous-traitants devront remplir leurs propres variables."
                        ],
                        "_html" => [
                            "archived_date" => "Date d'archivage",
                            "created_date" => "Date de création",
                            "delete" => "Supprimer",
                            "display_name" => "Nom du modèle",
                            "document_types" => "Documents associés",
                            "enterprise" => "Entreprise propriètaire",
                            "id" => "Identifiant",
                            "informations" => "Informations générales",
                            "last_modified_date" => "Date de dernière modification",
                            "more_informations" => "Informations complémentaires",
                            "no" => "Non",
                            "parties" => "Parties prenantes",
                            "parts" => "Pièce(s) du modèle de contrat",
                            "published_date" => "Date de publication",
                            "should_vendors_fill_their_variables" => "Les variables seront remplies par les sous traitants",
                            "status" => "Statut",
                            "version" => "(version : :version_number)",
                            "yes" => "Oui"
                        ],
                        "_state" => ["Archived" => "Archivé", "Draft" => "Brouillon", "Published" => "Publié"],
                        "_table_head" => [
                            "actions" => "Actions",
                            "archived_at" => "",
                            "created_at" => "",
                            "display_name" => "Nom du modèle",
                            "enterprise" => "Entreprise propriètaire",
                            "number" => "Numéro",
                            "published_at" => "",
                            "status" => "Statut"
                        ],
                        "create" => [
                            "create" => "Enregistrer",
                            "parties" => "Parties prenantes",
                            "party" => "Dénomination de la partie prenante :number",
                            "return" => "Retour",
                            "title" => "Création de modèle de contrat"
                        ],
                        "edit" => [
                            "edit" => "Modifier",
                            "party" => "Dénomination de la partie prenante :number",
                            "title" => "Modifier le modèle de contrat N° :number"
                        ],
                        "index" => [
                            "button_create" => "Créer un modèle de contrat",
                            "part" => "Pièces du modèle",
                            "publish_button" => "Publier",
                            "return" => "Retour",
                            "table_row_empty" => "Aucun modèle de contrat trouvé",
                            "title" => "Liste des modèles de contrat"
                        ],
                        "show" => [
                            "back" => "Retour",
                            "part" => "Ajouter une pièce de contrat",
                            "publish_button" => "Publier",
                            "return" => "Retour",
                            "unpublished_button" => "Dépublier",
                            "variable" => "Completer les variables"
                        ]
                    ],
                    "contract_model_document_type" => [
                        "_actions" => ["delete" => "Supprimer"],
                        "_breadcrumb" => [
                            "create" => "Ajouter",
                            "dashboard" => "Tableau de bord",
                            "document_type" => "Document type",
                            "index" => "Modèles de contrat",
                            "party" => "Partie prenante N° :number",
                            "show" => "N° :number"
                        ],
                        "_form" => [
                            "add" => "Sélectionner ?",
                            "document_type" => "Type du document",
                            "no" => "Non",
                            "validation_required" => "Demande de validation",
                            "yes" => "Oui"
                        ],
                        "_table_head" => [
                            "actions" => "Actions",
                            "created_at" => "Date de création",
                            "document_type" => "Type du document",
                            "validation_by" => "Validation par",
                            "validation_required" => "Demande de validation"
                        ],
                        "create" => [
                            "create" => "Enregistrer",
                            "return" => "Retour",
                            "title" => "Définir les types de documents pour la partie prenante N° :number : :denomination"
                        ],
                        "create_specific_document" => [
                            "create" => "Ajouter",
                            "description" => "Description",
                            "display_name" => "Nom du modèle de document",
                            "general_information" => "Informations générales",
                            "return" => "Retour",
                            "title" => "Ajouter un document spécifique pour la partie prenante N° :number : :denomination",
                            "validation_required" => "Demande de validation?"
                        ],
                        "index" => [
                            "button_create" => "Associer un document ",
                            "button_create_specific_document" => "Ajouter un document spécifique",
                            "return" => "Retour",
                            "table_row_empty" => "Aucun document type n'est associé à cette partie prenante",
                            "title" => "Liste des documents associés à la partie prenante N° :number : :denomination"
                        ]
                    ],
                    "contract_model_part" => [
                        "_actions" => ["delete" => "Supprimer", "preview" => "Aperçu"],
                        "_breadcrumb" => [
                            "create" => "Créer une pièce de modèle de contrat",
                            "dashboard" => "Tableau de bord",
                            "edit" => "Modifier",
                            "index" => "Pièces de modèle de contrat",
                            "parts" => "Pièces",
                            "show" => "N° :number"
                        ],
                        "_form" => [
                            "display_name" => "Nom de la pièce",
                            "empty_textarea" => "Le champ text est vide.",
                            "file" => "Fichier",
                            "general_information" => "Informations générales",
                            "information" => [
                                "call_to_action" => "Plus d'informations ici.",
                                "modal" => [
                                    "main_title" => "Comment utiliser les variables",
                                    "paragraph_1_1" => "Pour que le systeme puisse utiliser vos variables, ses dernières devront respecter un format particulier",
                                    "paragraph_1_10" => "{{1.siret}}",
                                    "paragraph_1_11" => "{{2.raison_sociale}}",
                                    "paragraph_1_12" => "{{1.variable_partie_prenante_1}}",
                                    "paragraph_1_13" => "{{2.variable_partie_prenante_2}}",
                                    "paragraph_1_14" => "{{1.nom_de_famille}}",
                                    "paragraph_1_15" => "{{2.nom_de_famille}}",
                                    "paragraph_1_2" => "Dans un premier temps, encadrez vos variables de deux accolades ouvrante puis fermante.",
                                    "paragraph_1_3" => "Enfin, vous y définirez deux informations que vous séparerez par un point.",
                                    "paragraph_1_5" => "La première partie de la variable indique l'ordre qui désigne une des parties prenante du modèle de contract.",
                                    "paragraph_1_6" => "La deuxième partie désigne le nom de la variable. Elle peut prendre n'importe quel valeur.",
                                    "paragraph_1_7" => "A noter: Toujours écrire les variables en minuscule et éviter d'utiliser des valeurs alphanumeriques.",
                                    "paragraph_1_8" => "Exemple :",
                                    "paragraph_1_9" => "{{1.nom_de_la_variable}}",
                                    "paragraph_2_1" => "Votre variable peut étre placé n'importe où dans la zone de text. Elle sera automatiquement detecté par le systeme.",
                                    "title_1" => "Format de variable",
                                    "title_2" => "Utilisation des variables"
                                ],
                                "paragraph_1" => "Utilisez des variables qui vous aideront à dynamiser vos contrats. Exemple :",
                                "paragraph_2" => "{{1.nom_de_la_variable}}",
                                "paragraph_3" => "{{1.siret}}",
                                "paragraph_4" => "{{2.raison_sociale}}",
                                "paragraph_5" => "{{1.variable_partie_prenante_1}}",
                                "paragraph_6" => "{{2.variable_partie_prenante_2}}",
                                "paragraph_7" => "{{1.nom_de_famille}}",
                                "paragraph_8" => "{{2.nom_de_famille}}"
                            ],
                            "is_initialled" => "Paraphable",
                            "is_signed" => "Signable",
                            "no" => "Non",
                            "order" => "Ordre",
                            "part_type" => "Type de la pièce",
                            "sign_on_last_page" => "Dernière page",
                            "signature_mention" => "Mention de la signature",
                            "signature_page" => "Numéro de page de la signature",
                            "signature_position" => "Position de la signature (a,b,c,d)",
                            "textarea" => "Zone de texte",
                            "yes" => "Oui"
                        ],
                        "_table_head" => [
                            "actions" => "Actions",
                            "display_name" => "Nom de la pièce",
                            "id" => "UUID",
                            "is_initialled" => "Paraphable",
                            "is_signed" => "Signable",
                            "order" => "Ordre"
                        ],
                        "contract_model_variable" => [
                            "_breadcrumb" => ["dashboard" => "", "index" => "", "show" => "", "variables" => ""],
                            "_table_head" => [
                                "actions" => "",
                                "default_value" => "",
                                "description" => "",
                                "display_name" => "",
                                "id" => "",
                                "input_type" => "",
                                "part_name" => "",
                                "party_denomination" => "",
                                "required" => ""
                            ],
                            "index" => ["return" => "", "table_row_empty" => "", "title" => ""]
                        ],
                        "create" => [
                            "create" => "Enregistrer",
                            "parties" => "Parties prenantes",
                            "party" => "Dénomination de la partie prenante :number",
                            "return" => "Retour",
                            "title" => "Création d'une pièce"
                        ],
                        "edit" => [
                            "_actions" => ["delete" => "Supprimer", "preview" => "Aperçu"],
                            "_breadcrumb" => [
                                "create" => "Créer",
                                "dashboard" => "Tableau de bord",
                                "edit" => "Modifier",
                                "index" => "Pièces du modèle",
                                "show" => "N° :number"
                            ],
                            "edit" => "Modifier",
                            "party" => "Dénomination de la partie prenante :number",
                            "title" => "Modifier la pièce N° :number"
                        ],
                        "index" => [
                            "button_create" => "Ajouter une pièce",
                            "create" => "Enregistrer",
                            "return" => "Retour",
                            "table_row_empty" => "Aucune pièce de modèle de contrat trouvé",
                            "title" => "Liste de pièces du modèle de contrat"
                        ]
                    ],
                    "contract_model_variable" => [
                        "_breadcrumb" => [
                            "dashboard" => "Tableau de bord",
                            "edit" => "Modifier",
                            "index" => "Modèles de contrat",
                            "show" => "N° :number",
                            "variables" => "Variables"
                        ],
                        "_filters" => [
                            "active" => "",
                            "being_signed" => "",
                            "cancelled" => "",
                            "declined" => "",
                            "draft" => "",
                            "enterprise" => "",
                            "error" => "",
                            "expired" => "",
                            "generated" => "",
                            "generating" => "",
                            "inactive" => "",
                            "locked" => "",
                            "party" => "",
                            "published" => "",
                            "ready_to_generate" => "",
                            "ready_to_sign" => "",
                            "signed" => "",
                            "status" => "",
                            "unknown" => "",
                            "uploaded" => "",
                            "uploading" => ""
                        ],
                        "_form" => [
                            "amendment_name_preset" => "",
                            "amendment_without_contract_model" => "",
                            "contract_model" => "Modèle de contrat",
                            "default_value" => "Valeur par défaut",
                            "description" => "Description",
                            "display_name" => "Nom de la variable",
                            "enterprise" => "Entreprise propriétaire du modèle",
                            "enterprise_owner" => "Entreprise propriétaire du contrat",
                            "external_identifier" => "Identifiant externe",
                            "general_information" => "Informations générales",
                            "input_type" => "Type",
                            "is_exportable" => "Exportable",
                            "model" => "Nom de la pièce",
                            "name" => "Nom du contrat",
                            "options" => "Options",
                            "required" => "Requis",
                            "valid_from" => "Date de début",
                            "valid_until" => "Date d'échéance",
                            "variable" => "Variable"
                        ],
                        "_form_without_model" => [
                            "actions" => "Actions",
                            "contract_informations" => "Informations sur le contrat",
                            "designation" => "Dénomination de la partie prenante",
                            "display_name" => "Nom de la pièce de contrat",
                            "enterprise" => "Partie prenante",
                            "external_identifier" => "Identifiant externe",
                            "file" => "Fichier à sélectionner",
                            "name" => "Nom du contrat",
                            "number" => "Numéro",
                            "owner" => "Entreprise propriétaire",
                            "part_informations" => "Informations sur la pièce de contrat",
                            "parties_informations" => "Informations sur les parties prenantes et signataires",
                            "select_file" => "Choisir un fichier",
                            "signatory" => "Signataire",
                            "valid_from" => "Date de début",
                            "valid_until" => "Date de fin"
                        ],
                        "_status" => [
                            "active" => "",
                            "being_signed" => "",
                            "cancelled" => "",
                            "declined" => "",
                            "draft" => "",
                            "error" => "",
                            "expired" => "",
                            "generated" => "",
                            "generating" => "",
                            "inactive" => "",
                            "locked" => "",
                            "published" => "",
                            "ready_to_generate" => "",
                            "ready_to_sign" => "",
                            "signed" => "",
                            "unknown" => "",
                            "uploaded" => "",
                            "uploading" => ""
                        ],
                        "_table_head" => [
                            "actions" => "Actions",
                            "default_value" => "Valeur par défaut",
                            "description" => "Description",
                            "display_name" => "Nom affiché",
                            "enterprise" => "Entreprise propriétaire",
                            "input_type" => "Type",
                            "model" => "Modèle de contrat",
                            "name" => "Nom du contrat",
                            "part_name" => "Nom de la Pièce",
                            "parties" => "Parties prenantes",
                            "party_denomination" => "Partie Prenante",
                            "required" => "Requis",
                            "status" => "Statut",
                            "valid_from" => "Date de début",
                            "valid_until" => "Date de fin"
                        ],
                        "create_without_model" => ["return" => "Retour", "submit" => "Enregister", "title" => "Déposer un contrat"],
                        "edit" => [
                            "create_amendment" => "Créer un avenant",
                            "create_part" => "Ajouter une annexe spécifique",
                            "edit" => "Modifier",
                            "return" => "Retour",
                            "title" => "",
                            "upload_signed_contract" => "Mettre à jour le contrat signé"
                        ],
                        "index" => [
                            "create" => "Créer un contrat",
                            "createContractWithoutModel" => "Déposer un contrat",
                            "edit" => "Mettre à jour les variables",
                            "return" => "Retour",
                            "table_row_empty" => "Aucune variable de modèle de contrat trouvée",
                            "title" => "Liste des variables du modèle de contrat"
                        ],
                        "show" => [
                            "return" => "Retour",
                            "title" => "Modification des variables du contrat N° :number"
                        ],
                        "upload_signed_contract" => [
                            "display_name" => "Nom de la pièce du contrat",
                            "file" => "Fichier à sélectionner",
                            "party_signed_at" => "Date de signature de :party_name",
                            "return" => "Retour",
                            "select_file" => "Choisir un fichier",
                            "submit" => "Ajouter",
                            "title" => "Mettre à jour le contrat signé"
                        ]
                    ]
                ]
            ]
        ]
    ],
    "enterprise" => [
        "activity_report" => [
            "application" => [
                "views" => [
                    "activity_report" => [
                        "_form" => ["note" => "Note"],
                        "months" => [
                            "april" => "avril",
                            "august" => "août",
                            "december" => "décembre",
                            "february" => "février",
                            "january" => "janvier",
                            "july" => "juillet",
                            "june" => "juin",
                            "march" => "mars",
                            "may" => "mai",
                            "november" => "novembre",
                            "october" => "octobre",
                            "september" => "septembre"
                        ]
                    ]
                ]
            ]
        ],
        "filters" => [
            "identification_number" => "SIRET ou SIREN",
            "name" => "Nom d'entreprise",
            "phone" => "Téléphone",
            "zipcode" => "Code Postal ou Département"
        ]
    ],
    "enterprise_finder" => [
        "companies_found" => "Entreprises trouvées",
        "enterprise" => "Entreprise",
        "error_occurred" => "Une erreur est survenue ! Si le problème persiste, contactez le"
    ],
    "form" => [
        "checkbox_list" => ["select_all" => "Sélectionner tout"],
        "group" => ["required_field" => "Champ obligatoire"],
        "modal" => ["register" => "Enregistrer"],
        "qualification_list" => [
            "being_obtained" => "En cours d'obtention",
            "no" => "No",
            "yes" => "Oui",
            "yes_probative" => "Oui, possible"
        ]
    ],
    "modal" => [
        "confirm" => ["no" => "Non", "yes" => "Oui"],
        "post_confirm" => ["no" => "Non", "yes" => "Oui"]
    ],
    "modal2" => ["to_close" => "Fermer"],
    "sogetrel" => [
        "mission" => [
            "application" => [
                "policies" => [
                    "create" => [
                        "denied_must_be_support_user" => "Vous devez être membre support pour pouvoir créer un attachment"
                    ],
                    "create_support" => [
                        "denied_must_be_support_user" => "Vous devez être membre du Support AddWorking pour afficher cette page"
                    ],
                    "index" => [
                        "denied_must_be_support_user" => "Vous devez être membre support pour pouvoir lister les attachments"
                    ],
                    "index_support" => [
                        "denied_must_be_support_user" => "Vous devez être membre du Support AddWorking pour afficher cette page"
                    ],
                    "update" => [
                        "denied_must_be_support_user" => "Vous devez être membre support pour pouvoir modifier un attachment"
                    ],
                    "view" => [
                        "denied_must_be_support_user" => "Vous devez être membre support pour pouvoir consulter un attachment"
                    ]
                ],
                "views" => [
                    "mission_tracking_line_attachment" => [
                        "_breadcrumb" => ["create" => "Créer", "edit" => "Modifier", "index" => "Pièces jointes"],
                        "_form" => ["period" => "Période", "title" => "Informations de la pièce jointe"],
                        "_html" => [
                            "amount" => "Montant HT",
                            "created_at" => "Créé le",
                            "direct_billing" => "Facturation directe",
                            "id" => "Identifiant",
                            "label" => "Libellé",
                            "num_attachment" => "Numéro attachment",
                            "num_order" => "Numéro commande",
                            "num_site" => "Numéro chantier",
                            "reverse_charges" => "Autoliquidation",
                            "signed_at" => "Signé le",
                            "submitted_at" => "Date de soumission dans DocuSign",
                            "updated_at" => "Mis à jour le"
                        ],
                        "_period_selector" => [
                            "customer" => "Client",
                            "milestone" => "Période",
                            "mission" => "Mission",
                            "vendor" => "Prestataire"
                        ],
                        "_table_head" => [
                            "customer" => "Client",
                            "num_attachment" => "Numéro d'attachement",
                            "num_order" => "Numéro de commande",
                            "vendor" => "Prestataire"
                        ],
                        "create" => [
                            "amount" => "Montant",
                            "direct_billing" => "Facturation directe",
                            "file" => "Fichier",
                            "num_attachment" => "Numéro attachment",
                            "num_order" => "Numéro commande",
                            "num_site" => "Numéro site",
                            "return" => "Retour",
                            "reverse_charges" => "Autoliquidation",
                            "save" => "Enregistrer",
                            "signed_at" => "Signé le",
                            "submitted_at" => "Date de soumission dans DocuSign",
                            "title" => "Créer une pièce jointe"
                        ],
                        "create_support" => [
                            "amount" => "Montant HT",
                            "customer" => "Client",
                            "direct_billing" => "Facturation directe",
                            "file" => "Fichier PDF",
                            "milestone" => "Période",
                            "mission" => "Mission",
                            "num_attachment" => "Numéro attachement",
                            "num_order" => "Numéro commande",
                            "num_site" => "Numéro chantier",
                            "reverse_charges" => "Auto-liquidation",
                            "save" => "Enregistrer",
                            "signed_at" => "Date signature",
                            "title" => "Créer une pièce jointe à la ligne de suivi Sogetrel",
                            "vendor" => "Prestataire"
                        ],
                        "edit" => ["return" => "Retour", "save" => "Enregistrer", "title" => "Modifier"],
                        "index" => [
                            "add" => "Ajouter",
                            "amount" => "Montant",
                            "created_from_airtable" => "Création Airtable",
                            "customer" => "Client",
                            "direct_billing" => "Facturation directe",
                            "doesnt_have_inbound_invoice" => "N'a pas de facture entrante",
                            "doesnt_have_outbound_invoice" => "N'a pas de facture sortante",
                            "empty" => "Vide",
                            "filter_inbound_invoice" => "Factures entrantes",
                            "filter_outbound_invoice" => "Factures sortantes",
                            "has_inbound_invoice" => "A des factures entantes",
                            "has_outbound_invoice" => "A des factures sortantes",
                            "inbound_invoice" => "Facture entrante",
                            "milestone" => "Période",
                            "mission" => "Mission",
                            "num_attachment" => "Numéro attachment",
                            "num_order" => "Numéro commande",
                            "outbound_invoice" => "Facture sortante",
                            "signed_at" => "Signé le",
                            "title" => "Attachements Sogetrel",
                            "vendor" => "Prestataire"
                        ],
                        "show" => [
                            "return" => "Retour",
                            "tab_file" => "Fichier",
                            "tab_summary" => "Propriétés",
                            "title" => "Pièce jointe"
                        ]
                    ],
                    "support_mission_tracking_line_attachment" => [
                        "index" => [
                            "add" => "Ajouter",
                            "amount" => "Montant HT",
                            "customer" => "Client",
                            "direct_billing" => "Facturation directe",
                            "doesnt_have_inbound_invoice" => "Sans facture",
                            "doesnt_have_outbound_invoice" => "Sans facture",
                            "filter_inbound_invoice" => "Factures entrantes",
                            "filter_outbound_invoice" => "Factures sortantes",
                            "has_inbound_invoice" => "Avec factures",
                            "has_outbound_invoice" => "Avec factures",
                            "inbound_invoice" => "Facture entrante",
                            "milestone" => "Période",
                            "mission" => "Mission",
                            "num_attachment" => "Attachement",
                            "num_order" => "Commande",
                            "outbound_invoice" => "Facture sortante",
                            "signed_at" => "Signé le",
                            "title" => "Attachements Sogetrel",
                            "vendor" => "Prestataire"
                        ]
                    ]
                ]
            ]
        ]
    ],
    "infrastructure" => [
        "electronic_signature" => [
            "application" => [
                "views" => [
                    "mail" => [
                        "finished_procedure" => [
                            "sentence_one"   => "Bonjour",
                            "sentence_two"   => "AddWorking vous informe que votre document a bien été signé.",
                            "sentence_three" => "Accéder au document",
                            "sentence_four"  => "Cordialement,",
                            "sentence_five"  => "L’équipe AddWorking",
                        ],
                        "refused_procedure" => [
                            "sentence_one"   => "Bonjour",
                            "sentence_two"   => "AddWorking vous informe que l'une des parties a refusé de signer le document.",
                            "sentence_three" => "Accéder au document",
                            "sentence_four"  => "Cordialement,",
                            "sentence_five"  => "L’équipe AddWorking",
                        ]
                    ]
                ]
            ]
        ]
    ]
];
