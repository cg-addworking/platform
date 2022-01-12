#language: fr
Fonctionnalité: calculer l'état des contrats
  Contexte:
    Etant donné que les formes légales suivantes existent
      | legal_form_name | display_name       | country |
      | sas             | SAS                | fr      |
      | sasu            | SASU               | fr      |
      | sarl            | SARL               | fr      |

    Et que les entreprises suivantes existent
      | siret          | parent_siret   | client_siret   | name       | is_customer | is_vendor | access_to_contract | legal_form_name |
      | 01000000000000 | null           | null           | Addworking | 0           | 0         | 1                  | sas             |
      | 02000000000000 | null           | null           | client 1   | 1           | 0         | 1                  | sasu            |
      | 03000000000000 | 02000000000000 | null           | client 2   | 1           | 0         | 1                  | sarl            |
      | 04000000000000 | null           | null           | client 3   | 1           | 0         | 1                  | sarl            |
      | 05000000000000 | null           | 03000000000000 | vendor 1   | 0           | 1         | 1                  | sasu            |
      | 06000000000000 | null           | 04000000000000 | vendor 2   | 0           | 1         | 1                  | sasu            |
      | 07000000000000 | null           | 04000000000000 | vendor 3   | 0           | 1         | 1                  | sasu            |

    Et que les utilisateurs suivants existent
      | email                        | firstname | lastname | is_system_admin | siret          | is_signatory | number |
      | peter.parker@addworking.com  | Peter     | PARKER   | 1               | 01000000000000 | 1            | 1      |
      | tony.stark@client1.com       | Tony      | STARK    | 0               | 02000000000000 | 1            | 2      |
      | clark.kent@client2.com       | Clark     | KENT     | 0               | 03000000000000 | 1            | 3      |
      | bruce.wayne@client3.com      | Bruce     | WAYNE    | 0               | 04000000000000 | 1            | 4      |
      | steve.rogers@vendor1.com     | Steve     | ROGERS   | 0               | 05000000000000 | 1            | 5      |
      | bruce.banner@vendor1.com     | Bruce     | BANNER   | 0               | 05000000000000 | 0            | 6      |
      | natasha.romanova@vendor2.com | Natasha   | ROMANOVA | 0               | 06000000000000 | 1            | 7      |
      | barry.allen@vendor3.com      | Barry     | ALLEN    | 0               | 06000000000000 | 1            | 8      |

    Et que les documents types suivants existent
      | siret          | display_name    | description          | is_mandatory | validity_period | code | type        | legal_form_name |
      | 02000000000000 | document type 1 | Document legal       | 1            | 365             | ABCD | legal       | sasu            |
      | 02000000000000 | document type 2 | Document Business    | 1            | 365             | EFGH | business    | sasu            |
      | 02000000000000 | document type 3 | Document contractual | 1            | 365             | IJKL | contractual | sasu            |

    Et que les documents suivants existent
      | document_type_display_name | siret          | status    | valid_from |
      | document type 1            | 02000000000000 | validated | 01-01-2021 |
      | document type 2            | 02000000000000 | pending   | 01-01-2021 |
      | document type 3            | 02000000000000 | pending   | 01-01-2021 |
      | document type 1            | 03000000000000 | validated | 01-01-2021 |
      | document type 2            | 03000000000000 | validated | 01-01-2021 |
      | document type 3            | 03000000000000 | validated | 01-01-2021 |

    Et que les modèles de contrat suivants existent
      | number | siret          | display_name             | published_at |
      | 100    | 03000000000000 | published contract model | 2020-11-13   |
      | 101    | 03000000000000 | published contract model | 2020-11-13   |
      | 102    | 03000000000000 | published contract model | 2020-11-13   |
      | 103    | 03000000000000 | published contract model | 2020-11-13   |
      | 104    | 03000000000000 | published contract model | 2020-11-13   |

    Et que les parties prenantes suivantes (modèle de contrat) existent
      | number | contract_model_number | denomination | order |
      | 200    | 100                   | party 1      | 1     |
      | 201    | 100                   | party 2      | 2     |
      | 202    | 101                   | party 1      | 1     |
      | 203    | 101                   | party 2      | 2     |
      | 204    | 102                   | party 1      | 1     |
      | 205    | 102                   | party 2      | 2     |
      | 206    | 103                   | party 1      | 1     |
      | 207    | 103                   | party 2      | 2     |
      | 208    | 104                   | party 1      | 1     |
      | 209    | 104                   | party 2      | 2     |

    Et que les pièces suivantes (modèle de contrat) existent
      | number | contract_model_number | display_name  | order | is_initialled | is_signed | should_compile |
      | 301    | 100                   | part 2        | 2     | 1             | 1         | 0              |
      | 300    | 100                   | part 1        | 1     | 0             | 0         | 1              |
      | 302    | 101                   | part 1        | 1     | 0             | 0         | 1              |
      | 303    | 101                   | part 2        | 2     | 1             | 1         | 0              |
      | 305    | 102                   | part 2        | 2     | 1             | 1         | 0              |
      | 304    | 102                   | part 1        | 1     | 0             | 0         | 1              |
      | 306    | 103                   | part 1        | 1     | 0             | 0         | 1              |
      | 307    | 103                   | part 2        | 2     | 1             | 1         | 0              |
      | 308    | 104                   | part 1        | 1     | 0             | 0         | 1              |
      | 309    | 104                   | part 2        | 2     | 1             | 1         | 0              |

    Et que les variables suivantes (pièces du modèle de contrat) existent
      | number | contract_model_number | contract_model_party_number | contract_model_part_number | name  |
      | 400    | 100                   | 200                         | 300                        | var1  |
      | 401    | 100                   | 200                         | 300                        | var2  |
      | 402    | 101                   | 202                         | 302                        | var3  |
      | 403    | 101                   | 202                         | 302                        | var4  |
      | 404    | 102                   | 204                         | 304                        | var5  |
      | 405    | 102                   | 204                         | 304                        | var6  |
      | 406    | 103                   | 206                         | 306                        | var7  |
      | 407    | 103                   | 206                         | 306                        | var8  |
      | 408    | 104                   | 208                         | 308                        | var9  |
      | 409    | 104                   | 208                         | 308                        | var10 |

    Et que les documents types suivantes (parties prenantes du modèle de contrat) existent
      | number | contract_model_party_number | document_type_display_name | validation_required |
      | 500    | 200                         | document type 1            | 1                   |
      | 501    | 200                         | document type 2            | 1                   |
      | 502    | 200                         | document type 3            | 0                   |
      | 503    | 202                         | document type 1            | 1                   |
      | 504    | 202                         | document type 2            | 0                   |
      | 505    | 204                         | document type 1            | 1                   |
      | 506    | 204                         | document type 2            | 1                   |
      | 507    | 206                         | document type 1            | 1                   |
      | 508    | 206                         | document type 2            | 1                   |
      | 509    | 208                         | document type 1            | 1                   |
      | 510    | 208                         | document type 2            | 1                   |

    Et que les contrats suivants existent
      | number | contract_parent_number | contract_model_number | siret          | name  | valid_from | valid_until | canceled_at | inactive_at | yousign_procedure_id | sent_to_signature_at |
      | 600    | null                   | null                  | 03000000000000 | Lorem | 2021-01-01 | 2021-05-31  | null        | null        | null                 | null                 |
      | 601    | null                   | 100                   | 03000000000000 | Lorem | 2021-01-01 | 2021-05-31  | null        | null        | null                 | null                 |
      | 602    | null                   | 101                   | 03000000000000 | Lorem | 2021-01-01 | 2021-05-31  | null        | null        | null                 | null                 |
      | 603    | null                   | 102                   | 03000000000000 | Lorem | 2021-01-01 | 2021-05-31  | null        | null        | null                 | null                 |
      | 604    | null                   | 103                   | 03000000000000 | Lorem | 2021-01-01 | 2021-05-31  | null        | null        | null                 | null                 |
      | 605    | null                   | 104                   | 03000000000000 | Lorem | 2021-01-01 | 2021-05-31  | null        | null        | random_id            | 2021-04-01           |
      | 606    | null                   | 104                   | 03000000000000 | Lorem | 3021-01-01 | 3021-05-31  | null        | null        | random_id            | 2021-04-01           |
      | 607    | null                   | 104                   | 03000000000000 | Lorem | 2021-01-01 | 3021-05-31  | null        | null        | random_id            | 2021-04-01           |
      | 608    | null                   | 104                   | 03000000000000 | Lorem | 2021-01-01 | null        | null        | null        | random_id            | 2021-04-01           |
      | 609    | null                   | 104                   | 03000000000000 | Lorem | null       | 3021-05-31  | null        | null        | random_id            | 2021-04-01           |
      | 610    | null                   | 104                   | 03000000000000 | Lorem | null       | null        | null        | null        | random_id            | 2021-04-01           |
      | 611    | null                   | 104                   | 03000000000000 | Lorem | 2021-01-01 | 2021-01-30  | null        | null        | random_id            | 2021-04-01           |
      | 612    | 611                    | 104                   | 03000000000000 | Lorem | 2021-01-31 | 2021-02-01  | null        | null        | null                 | null                 |
      | 613    | null                   | 104                   | 03000000000000 | Lorem | 2021-01-01 | 2021-01-30  | 2021-01-24  | null        | null                 | null                 |
      | 614    | null                   | 104                   | 03000000000000 | Lorem | 2021-01-01 | 2021-01-30  | null        | 2021-01-24  | null                 | null                 |

    Et que les parties prenantes suivantes (contrat) existent
      | number | contract_number | contract_model_party_number | siret          | signatory_number | order | signed | signed_at  |
      | 700    | 601             | 200                         | 02000000000000 | 2                | 1     | 0      | null       |
      | 701    | 601             | 201                         | 05000000000000 | 6                | 2     | 0      | null       |
      | 702    | 602             | 202                         | 03000000000000 | 2                | 1     | 0      | null       |
      | 703    | 602             | 203                         | 05000000000000 | 6                | 2     | 0      | null       |
      | 704    | 603             | 204                         | 02000000000000 | 2                | 1     | 0      | null       |
      | 705    | 603             | 205                         | 05000000000000 | 6                | 2     | 0      | null       |
      | 706    | 604             | 206                         | 03000000000000 | 2                | 1     | 0      | null       |
      | 707    | 604             | 207                         | 05000000000000 | 6                | 2     | 0      | null       |
      | 708    | 605             | 208                         | 03000000000000 | 2                | 1     | 0      | null       |
      | 709    | 605             | 209                         | 05000000000000 | 6                | 2     | 0      | null       |
      | 710    | 606             | 208                         | 03000000000000 | 2                | 1     | 1      | 2021-02-02 |
      | 711    | 606             | 209                         | 05000000000000 | 6                | 2     | 1      | 2021-02-02 |
      | 712    | 607             | 208                         | 03000000000000 | 2                | 1     | 1      | 2021-02-02 |
      | 713    | 607             | 209                         | 05000000000000 | 6                | 2     | 1      | 2021-02-02 |
      | 714    | 608             | 208                         | 03000000000000 | 2                | 1     | 1      | 2021-02-02 |
      | 715    | 608             | 209                         | 05000000000000 | 6                | 2     | 1      | 2021-02-02 |
      | 716    | 609             | 208                         | 03000000000000 | 2                | 1     | 1      | 2021-02-02 |
      | 717    | 609             | 209                         | 05000000000000 | 6                | 2     | 1      | 2021-02-02 |
      | 718    | 610             | 208                         | 03000000000000 | 2                | 1     | 1      | 2021-02-02 |
      | 719    | 610             | 209                         | 05000000000000 | 6                | 2     | 1      | 2021-02-02 |
      | 720    | 611             | 208                         | 03000000000000 | 2                | 1     | 1      | 2021-02-02 |
      | 721    | 611             | 209                         | 05000000000000 | 6                | 2     | 1      | 2021-02-02 |

    Et que les pièces suivantes (contrat) existent
      | number | contract_model_part_number | contract_number | name        | is_hidden |
      | 800    | 308                        | 605             | piece_one   | 0         |
      | 801    | 308                        | 606             | piece_two   | 0         |
      | 802    | 308                        | 607             | piece_three | 0         |
      | 803    | 308                        | 608             | piece_four  | 0         |
      | 804    | 308                        | 609             | piece_five  | 0         |
      | 805    | 308                        | 610             | piece_six   | 0         |
      | 806    | 308                        | 611             | piece_seven | 0         |

    Et que les variables suivantes (contrat) existent
      | number | contract_number |  contract_model_variable_number | contract_party_number | value   |
      | 900    | 601             | 400                             | 700                   | alpha   |
      | 901    | 601             | 401                             | 700                   | bravo   |
      | 902    | 602             | 402                             | 702                   | charlie |
      | 903    | 602             | 403                             | 702                   | null    |
      | 904    | 603             | 404                             | 704                   | null    |
      | 905    | 603             | 405                             | 704                   | delta   |
      | 906    | 604             | 406                             | 706                   | echo    |
      | 907    | 604             | 407                             | 706                   | foxtrot |
      | 908    | 605             | 408                             | 708                   | golf    |
      | 909    | 605             | 409                             | 708                   | hotel   |

  @scenario1 @draft
  Scénario: Vérifier que l'état du contrat doit être égal à "brouillon"
    Étant donné que le contrat numéro "600" existe
    Et qu'il n'a pas de parties prenantes.
    Quand je calcule son état.
    Alors son état est bien "brouillon".

  @scenario2 @is_missing_documents
  Scénario: Vérifier que l'état du contrat doit être égal à "documents à fournir"
    Étant donné que le contrat numéro "601" existe
    Et qu'il a au moins deux parties prenantes.
    Et que ces variables sont tous renseignées
    Et que les documents du contrat ne sont pas tous valides
    Quand je calcule son état.
    Alors son état est bien "documents à fournir".

  @scenario3 @in_preparation
  Scénario: Vérifier que l'état du contrat doit être égal à "en préparation"
    Étant donné que le contrat numéro "602" existe
    Et qu'il a au moins deux parties prenantes.
    Et que ces variables ne sont pas tous renseignées
    Et que les documents du contrat sont valides
    Quand je calcule son état.
    Alors son état est bien "en préparation".

  @scenario4 @in_preparation
  Scénario: Vérifier que l'état du contrat doit être égal à "en préparation"
    Étant donné que le contrat numéro "603" existe
    Et qu'il a au moins deux parties prenantes.
    Et que ces variables ne sont pas tous renseignées
    Et que les documents du contrat ne sont pas tous valides
    Quand je calcule son état.
    Alors son état est bien "en préparation".

  @scenario5 @ready_to_generate
  Scénario: Vérifier que l'état du contrat doit être égal à "bon pour mise en signature"
    Étant donné que le contrat numéro "604" existe
    Et qu'il a au moins deux parties prenantes.
    Et que ces variables sont tous renseignées
    Et que les documents du contrat sont valides
    Et que le contrat n'a pas de pièce non volante
    Quand je calcule son état.
    Alors son état est bien "bon pour mise en signature".

  @scenario6 @to_sign
  Scénario: Vérifier que l'état du contrat doit être égal à "à signer"
    Étant donné que le contrat numéro "605" existe
    Et qu'il a au moins deux parties prenantes.
    Et que ces variables sont tous renseignées
    Et que les documents du contrat sont valides
    Et que le contrat a au moins une pièce non volante
    Et que le contrat est prêt à être signé sur yousign
    Quand je calcule son état.
    Alors son état est bien "à signer".

  @scenario7 @signed
  Scénario: Vérifier que l'état du contrat doit être égal à "signé"
    Étant donné que le contrat numéro "606" existe
    Et qu'il a au moins deux parties prenantes.
    Et que ces variables sont tous renseignées
    Et que les documents du contrat sont valides
    Et que le contrat a au moins une pièce non volante
    Et que les parties prenantes ont des dates de signatures renseignées.
    Et que la date de début du contrat est supérieur ou égale à la date du jour
    Quand je calcule son état.
    Alors son état est bien "signé".

  @scenario8 @active
  Scénario: Vérifier que l'état du contrat doit être égal à "actif"
    Étant donné que le contrat numéro "607" existe
    Et qu'il a au moins deux parties prenantes.
    Et que ces variables sont tous renseignées
    Et que les documents du contrat sont valides
    Et que le contrat a au moins une pièce non volante
    Et que les parties prenantes ont des dates de signatures renseignées.
    Et que la date du jour est comprise entre la date de début et la date de fin du contrat
    Quand je calcule son état.
    Alors son état est bien "actif".

  @scenario9 @active
  Scénario: Vérifier que l'état du contrat doit être égal à "actif"
    Étant donné que le contrat numéro "608" existe
    Et qu'il a au moins deux parties prenantes.
    Et que ces variables sont tous renseignées
    Et que les documents du contrat sont valides
    Et que le contrat a au moins une pièce non volante
    Et que les parties prenantes ont des dates de signatures renseignées.
    Et que la date du jour est supérieur ou égale à la date de début du contrat
    Et que la date de fin du contrat n'est pas définie
    Quand je calcule son état.
    Alors son état est bien "actif".

  @scenario10 @active
  Scénario: Vérifier que l'état du contrat doit être égal à "actif"
    Étant donné que le contrat numéro "609" existe
    Et qu'il a au moins deux parties prenantes.
    Et que ces variables sont tous renseignées
    Et que les documents du contrat sont valides
    Et que le contrat a au moins une pièce non volante
    Et que les parties prenantes ont des dates de signatures renseignées.
    Et que la date de début du contrat n'est pas définie
    Quand je calcule son état.
    Alors son état est bien "actif".

  @scenario11 @active
  Scénario: Vérifier que l'état du contrat doit être égal à "actif"
    Étant donné que le contrat numéro "610" existe
    Et qu'il a au moins deux parties prenantes.
    Et que ces variables sont tous renseignées
    Et que les documents du contrat sont valides
    Et que le contrat a au moins une pièce non volante
    Et que les parties prenantes ont des dates de signatures renseignées.
    Et que la date de début du contrat n'est pas définie
    Et que la date de fin du contrat n'est pas définie
    Quand je calcule son état.
    Alors son état est bien "actif".

  @scenario12 @due
  Scénario: Vérifier que l'état du contrat doit être égal à "échu"
    Étant donné que le contrat numéro "611" existe
    Et qu'il a au moins deux parties prenantes.
    Et que ces variables sont tous renseignées
    Et que le contrat a au moins une pièce non volante
    Et que les parties prenantes ont des dates de signatures renseignées.
    Et que la date du jour est supérieure ou égale à la date de fin du contrat
    Quand je calcule son état.
    Alors son état est bien "échu".

  @scenario13 @canceled
  Scénario: Vérifier que l'état du contrat doit être égal à "annulé"
    Étant donné que le contrat numéro "613" existe
    Et qu'il est annulé.
    Quand je calcule son état.
    Alors son état est bien "annulé".

  @scenario14 @inactive
  Scénario: Vérifier que l'état du contrat doit être égal à "inactif"
    Étant donné que le contrat numéro "614" existe
    Et qu'il est inactif.
    Quand je calcule son état.
    Alors son état est bien "inactif".
