#language: fr
Fonctionnalité: add an annex to a contract
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name       | is_customer | is_vendor |
      | 01000000000000 | Addworking | 0           | 0         |
      | 02000000000000 | client 1   | 1           | 0         |
      | 03000000000000 | vendor 2   | 0           | 1         |

    Et que les utilisateurs suivants existent
      |  number | email                        | firstname | lastname | is_system_admin | enterprise_siret |
      |  1      | peter.parker@addworking.com  | Peter     | PARKER   | 1               | 01000000000000   |
      |  2      | tony.stark@warlock.com       | Tony      | STARK    | 0               | 02000000000000   |
      |  3      | clark.kent@client2.com       | Clark     | KENT     | 0               | 03000000000000   |

    Et que les annexes suivantes existent
      | number | name    | enterprise_siret  | description     |
      | 1      | annex_1 | 02000000000000    | description_one |
      | 2      | annex_2 | 02000000000000    | description_two |
      | 3      | annex_3 | 03000000000000    | description     |

    Et que le modèle de contrat suivant existe
      | number | siret          | display_name   | published_at | name  |
      | 1      | 02000000000000 | contract model | 01-11-2020   | model |

    Et que les parties prenantes du modèle suivantes existent
      | number | contract_model_number | denomination  | order |
      | 1      | 1                     | le vendor     | 1     |
      | 2      | 1                     | le client     | 2     |

    Et que les pièces du modèle suivantes existent
      | number | contract_model_number | display_name | order | name | should_compile |
      | 1      | 1                     | corps        | 1     | body | 0              |

    Et que les contrats suivants existent
      | number  | name       | contract_model_number | enterprise_siret | state                |
      | 1       | contract_1 | 1                     | 02000000000000   | is_ready_to_generate |

    Et que les parties prenantes suivantes existent
      | contract_model_party_number | number | denomination   | order | siret          | contract_number | email                      | signed_at  |
      | 1                           | 1      | le client      | 1     | 02000000000000 | 1               | tony.stark@warlock.com     | null       |
      | 2                           | 2      | le vendor      | 2     | 03000000000000 | 1               | clark.kent@client2.com     | null       |

    Et que les pièces de contrat suivantes existent
      | number  | name        | model_part_number | contract_number |
      | 1       | piece_one   | 1                 | 1               |
      | 2       | piece_two   | 1                 | 1               |


  @scenario1
  Scénario: Ajouter une annexe a un contrat en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "peter.parker@addworking.com"
    Quand j'essaie d'ajouter l'annexe numéro "1" au contrat numéro "1"
    Alors l'annexe numéro "1" est ajoutée au contrat numéro "1"

  @scenario2
  Scénario: Ajouter une annexe a un contrat en tant que propriètaire
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "tony.stark@warlock.com"
    Quand j'essaie d'ajouter l'annexe numéro "2" au contrat numéro "1"
    Alors l'annexe numéro "2" est ajoutée au contrat numéro "1"

  @scenario3
  Scénario: Impossibilité d'ajouter une annexe a un contrat s'il n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "tony.stark@warlock.com"
    Quand j'essaie d'ajouter l'annexe numéro "3" au contrat numéro "15"
    Alors une erreur est levée car le contrat n'existe pas

  @scenario4
  Scénario: Impossibilité d'ajouter une annexe a un contrat si l'utilisateur n'est pas support ou propriètaire du contrat
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "clark.kent@client2.com"
    Quand j'essaie d'ajouter l'annexe numéro "2" au contrat numéro "1"
    Alors une erreur est levée car l'utilisateur n'est pas support ou propriètaire du contrat