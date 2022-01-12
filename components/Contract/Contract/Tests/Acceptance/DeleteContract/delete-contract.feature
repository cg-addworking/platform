#language: fr
Fonctionnalité: delete contract
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

    Et que les contracts suivants existent
      | contract_model_number | number | status    | siret          | name  | valid_from | valid_until | created_by                  |
      | 1                     | 1      | draft     | 03000000000000 | Lorem | 2021-01-01 | 2021-05-31  | peter.parker@addworking.com |
      | 1                     | 2      | published | 03000000000000 | Ipsum | 2021-01-01 | 2021-05-31  | peter.parker@addworking.com |
      | 2                     | 3      | draft     | 04000000000000 | Ipsum | 2021-01-01 | 2021-05-31  | bruce.wayne@client3.com     |

    Et que les parties prenantes suivantes (contrat) existent
      | contract_number | contract_model_party_number | number | siret          | signatory_number | order |
      | 1               | 1                           | 1      | 02000000000000 | 2                | 1     |
      | 1               | 2                           | 2      | 05000000000000 | 5                | 2     |
      | 2               | 1                           | 3      | 03000000000000 | 3                | 1     |
      | 2               | 2                           | 4      | 05000000000000 | 5                | 2     |
      | 3               | 3                           | 5      | 03000000000000 | 3                | 1     |
      | 3               | 4                           | 6      | 05000000000000 | 5                | 2     |

    Et que les pièces du modèle suivantes existent
      | contract_model_number | number | display_name | order | name | should_compile |
      | 1                     | 100    | bras         | 1     | arm  | 1              |
      | 1                     | 200    | corps        | 2     | body | 0              |
      | 1                     | 300    | pied         | 3     | foot | 0              |
      | 2                     | 400    | pied         | 1     | foot | 1              |

    Et que les variables du modèle suivantes existent
      | contract_model_number | contract_model_party_number | contract_model_part_number | number | name        |
      | 1                     | 1                           | 100                        | 01     | 1.variable1 |
      | 1                     | 1                           | 100                        | 02     | 1.variable2 |
      | 2                     | 2                           | 400                        | 03     | 1.variable3 |
      | 2                     | 2                           | 400                        | 04     | 1.variable4 |

    Et que les variables du contrat suivantes existent
      | number | value | contract_number | contract_model_variable_number | party_number |
      | 0001   | ABC   | 1               | 01                             | 1            |
      | 0002   | DEF   | 1               | 02                             | 1            |
      | 0003   | ABC   | 1               | 03                             | 1            |
      | 0004   | DEF   | 1               | 04                             | 1            |

  @scenario1
  Scénario: supprimer un contrat en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "peter.parker@addworking.com"
    Quand j'essaie de supprimer le contrat numéro "1"
    Alors le contrat numéro "1" est supprimé
    Et les parties prenantes du contrat numéro "1" sont supprimées
    Et les variables du contrat numéro "1" sont supprimées

  @scenario2
  Scénario: Impossibilité de supprimer le contrat si l'utilisateur connecté n'est pas membre de l'entreprise propriétaire du contrat
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "clark.kent@client2.com"
    Quand j'essaie de supprimer le contrat numéro "3"
    Alors une erreur est levée car l'utilisateur connecté n'est pas le créateur
