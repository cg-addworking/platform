#language: fr
Fonctionnalité: archive contract
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name       | is_customer | is_vendor |
      | 01000000000000 | Addworking | 0           | 0         |
      | 02000000000000 | client 1   | 1           | 0         |
      | 03000000000000 | client 2   | 1           | 0         |
      | 04000000000000 | client 3   | 1           | 0         |
      | 05000000000000 | vendor 1   | 0           | 1         |

    Et que les utilisateurs suivants existent
      | email                        | firstname | lastname | is_system_admin | siret          | number |is_contract_creator |
      | peter.parker@addworking.com  | Peter     | PARKER   | 1               | 01000000000000 | 1      |1                   |
      | tony.stark@client1.com       | Tony      | STARK    | 0               | 02000000000000 | 2      |1                   |
      | clark.kent@client2.com       | Clark     | KENT     | 0               | 03000000000000 | 3      |1                   |
      | bruce.wayne@client3.com      | Bruce     | WAYNE    | 0               | 04000000000000 | 4      |1                   |
      | steve.rogers@vendor1.com     | Steve     | ROGERS   | 0               | 05000000000000 | 5      |1                   |
      | bruce.banner@vendor1.com     | Bruce     | BANNERS  | 0               | 05000000000000 | 6      |0                   |

    Et que les modèles de contrat suivants existent
      | number | siret          | display_name             | published_at | archived_at |
      | 1      | 03000000000000 | published contract model | 2021-06-07   | null        |
      | 2      | 04000000000000 | published contract model | 2021-06-08   | null        |

    Et que les parties prenantes du modèle suivantes existent
      | contract_model_number | number | denomination | order |
      | 1                     | 1      | party 1      | 1     |
      | 1                     | 2      | party 2      | 2     |
      | 2                     | 3      | party 1      | 1     |
      | 2                     | 4      | party 2      | 2     |

    Et que les contracts suivants existent
      | contract_model_number | number | state       | siret          | name       | valid_from | valid_until | created_by                  | archived_at |
      | 1                     | 1      | to_validate | 03000000000000 | contract_1 | 2021-06-07 | 2021-08-31  | peter.parker@addworking.com | null        |
      | 1                     | 2      | to_sign     | 03000000000000 | contract_2 | 2021-06-07 | 2021-08-31  | peter.parker@addworking.com | null        |
      | 2                     | 3      | draft       | 04000000000000 | contract_3 | 2021-06-07 | 2021-08-31  | bruce.wayne@client3.com     | null        |
      | 2                     | 4      | archived    | 04000000000000 | contract_4 | 2021-06-07 | 2021-08-31  | bruce.wayne@client3.com     | 2021-06-08  |

    Et que les parties prenantes suivantes existent
      | contract_number | contract_model_party_number | number | siret          | signatory_number | order |
      | 1               | 1                           | 1      | 02000000000000 | 2                | 1     |
      | 1               | 2                           | 2      | 05000000000000 | 5                | 2     |
      | 2               | 1                           | 3      | 03000000000000 | 3                | 1     |
      | 2               | 2                           | 4      | 05000000000000 | 5                | 2     |
      | 3               | 3                           | 5      | 03000000000000 | 3                | 1     |
      | 3               | 4                           | 6      | 05000000000000 | 5                | 2     |
      | 4               | 3                           | 6      | 05000000000000 | 5                | 2     |

  @scenario1
  Scénario: archiver un contrat en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "peter.parker@addworking.com"
    Quand j'essaie d'archiver le contrat numéro "1"
    Alors le contrat numéro "1" est archivé

  @scenario2
  Scénario: archiver un contrat en tant que membre de l'entreprise propriétaire du contrat
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "clark.kent@client2.com"
    Quand j'essaie d'archiver le contrat numéro "2"
    Alors le contrat numéro "2" est archivé

  @scenario3
  Scénario: Impossibilité d'archiver un contrat si l'utilisateur connecté n'est pas membre de l'entreprise propriétaire du contrat
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "steve.rogers@vendor1.com"
    Quand j'essaie d'archiver le contrat numéro "3"
    Alors une erreur est levée car l'utilisateur connecté n'est pas membre de l'entreprise propriétaire du contrat

  @scenario4
  Scénario: Impossibilité d'archiver un contrat s'il est déjà archivé
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "bruce.wayne@client3.com"
    Quand j'essaie d'archiver le contrat numéro "4"
    Alors une erreur est levée car le contract est déjà archivé

