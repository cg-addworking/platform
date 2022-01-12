#language: fr
Fonctionnalité: list party documents for a contract
  Contexte:
    Étant donné que les entreprises suivantes existent
      | siret          | parent_siret   | client_siret   | name       | is_customer | is_vendor | access_to_contract |
      | 01000000000000 | null           | null           | Addworking | 0           | 0         | 1                  |
      | 02000000000000 | null           | null           | client 1   | 1           | 0         | 1                  |
      | 03000000000000 | 02000000000000 | null           | client 2   | 1           | 0         | 1                  |
      | 04000000000000 | null           | null           | client 3   | 1           | 0         | 1                  |
      | 05000000000000 | null           | 03000000000000 | vendor 1   | 0           | 1         | 1                  |
      | 06000000000000 | null           | 04000000000000 | vendor 2   | 0           | 1         | 1                  |
      | 07000000000000 | null           | 04000000000000 | vendor 3   | 0           | 1         | 1                  |

    Et que les utilisateurs suivants existent
      | email                        | firstname | lastname | is_system_admin | siret          | is_signatory | number |
      | peter.parker@addworking.com  | Peter     | PARKER   | 1               | 01000000000000 | 1            | 1      |
      | tony.stark@client1.com       | Tony      | STARK    | 0               | 02000000000000 | 1            | 2      |
      | clark.kent@client2.com       | Clark     | KENT     | 0               | 03000000000000 | 1            | 3      |
      | bruce.wayne@client3.com      | Bruce     | WAYNE    | 0               | 04000000000000 | 1            | 4      |
      | steve.rogers@vendor1.com     | Steve     | ROGERS   | 0               | 05000000000000 | 1            | 5      |
      | bruce.banner@vendor1.com     | Bruce     | BANNERS  | 0               | 05000000000000 | 0            | 6      |
      | natasha.romanova@vendor2.com | Natasha   | ROMANOVA | 0               | 06000000000000 | 1            | 7      |
      | barry.allen@vendor3.com      | Barry     | ALLEN    | 0               | 06000000000000 | 1            | 8      |

    Et que les documents types suivants existent
      | siret          | display_name    | description          | validity_period | code | type        |
      | 02000000000000 | document type 1 | Document legal       | 365             | ABCD | legal       |
      | 02000000000000 | document type 2 | Document Business    | 365             | EFGH | business    |
      | 02000000000000 | document type 3 | Document contractual | 365             | IJKL | contractual |
      | 02000000000000 | document type 4 | Document legal       | 365             | MNOP | legal       |
      | 02000000000000 | document type 5 | Document legal       | 365             | QRST | legal       |
      | 02000000000000 | document type 6 | Document legal       | 365             | UVWX | legal       |

    Et que les modèles de contrat suivants existent
      | number | siret          | display_name             | published_at | archived_at |
      | 1      | 03000000000000 | published contract model | 2020-11-13   | null        |
      | 2      | 04000000000000 | published contract model | 2020-11-23   | null        |

    Et que les parties prenantes suivantes (modèle de contrat) existent
      | contract_model_number | number | denomination | order |
      | 1                     | 1      | party 1      | 1     |
      | 1                     | 2      | party 2      | 2     |
      | 2                     | 3      | party 1      | 1     |
      | 2                     | 4      | party 2      | 2     |

    Et que les types de documents suivants sont définis pour les parties prenantes du modèle de contrat
      | contract_model_party_number | document_type_display_name | number | validation_required |
      | 1                           | document type 1            | 1      | 1                   |
      | 1                           | document type 2            | 2      | 1                   |
      | 1                           | document type 3            | 3      | 1                   |
      | 1                           | document type 4            | 4      | 1                   |
      | 1                           | document type 5            | 5      | 1                   |

    Et que les contracts suivants existent
      | contract_model_number | number | status    | siret          | name  | valid_from | valid_until |
      | 1                     | 1      | draft     | 03000000000000 | Lorem | 2021-01-01 | 2021-05-31  |
      | 1                     | 2      | published | 03000000000000 | Ipsum | 2021-01-01 | 2021-05-31  |
      | 2                     | 3      | published | 04000000000000 | Ipsum | 2021-01-01 | 2021-05-31  |

    Et que les parties prenantes suivantes (contrat) existent
      | contract_number | contract_model_party_number | number | siret          | signatory_number | order |
      | 1               | 1                           | 1      | 02000000000000 | 2                | 1     |
      | 1               | 2                           | 2      | 05000000000000 | 5                | 2     |
      | 2               | 1                           | 3      | 03000000000000 | 3                | 1     |
      | 2               | 2                           | 4      | 05000000000000 | 5                | 2     |
      | 3               | 3                           | 5      | 03000000000000 | 3                | 1     |
      | 3               | 4                           | 6      | 05000000000000 | 5                | 2     |

  @scenario1
  Scénario: Lister les documents d'une partie prenante en tant que support
    Étant donné que je suis authentifié en tant que utilisateur avec l'émail "peter.parker@addworking.com"
    Quand j'essaie de lister tous les documents de la partie prenante numéro "1"
    Alors les documents de la partie prenante sont listés

  @scenario2
  Scénario: Lister les documents d'une partie prenante par un membre de l'entreprise partie prenante
    Étant donné que je suis authentifié en tant que utilisateur avec l'émail "tony.stark@client1.com"
    Quand j'essaie de lister tous les documents de la partie prenante numéro "1"
    Alors les documents de la partie prenante sont listés

  @scenario3
  Scénario: Impossibilité de lister les documents d'une partie prenante si l'utilisateur n'est pas membre de l'entreprise partie prenante
    Étant donné que je suis authentifié en tant que utilisateur avec l'émail "clark.kent@client2.com"
    Quand j'essaie de lister tous les documents de la partie prenante numéro "1"
    Alors une erreur est levée car l'utilisateur connecté n'est pas membre de l'entreprise partie prenante
