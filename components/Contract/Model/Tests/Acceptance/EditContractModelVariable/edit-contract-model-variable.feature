#language: fr
Fonctionnalité: list contract model variables
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | access_to_contract |
      | 01000000000000 | Addworking1 | 0           | 0         | 1                  |
      | 02000000000000 | Client2     | 1           | 0         | 1                  |

    Et que les utilisateurs suivants existent
      | email                      | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com  | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@clideux.com      | Jean      | PAUL     | 0               | 02000000000000 |

    Et que les modèles de contrat suivants existent
      | number | siret          | display_name                   | published_at | archived_at |
      | 1      | 02000000000000 | draft with 3 parties & 3 part  | null         | null        |
      | 2      | 02000000000000 | draft with 2 parties & 2 parts | null         | null        |


    Et que les parties prenantes suivantes existent
      | contract_model_number | number | denomination | order |
      | 1                     | 1      | party 1      | 1     |
      | 1                     | 2      | party 2      | 2     |
      | 1                     | 3      | party 3      | 3     |
      | 2                     | 4      | party 1      | 1     |
      | 2                     | 5      | party 2      | 2     |

    Et que les pièces suivantes existent
      | contract_model_number | number | display_name  | order | is_initialled | is_signed | should_compile |
      | 1                     | 1      | part 1        | 1     | 0             | 0         | 1              |
      | 1                     | 2      | part 2        | 1     | 1             | 1         | 1              |
      | 1                     | 3      | part 3        | 1     | 1             | 1         | 1              |
      | 2                     | 4      | part 1        | 1     | 1             | 0         | 1              |
      | 2                     | 5      | part 2        | 2     | 0             | 1         | 1              |

    Et que les variables suivantes existent
      | contract_model_number | contract_model_party_number | contract_model_part_number | number | name               |
      | 1                     | 1                           | 1                          | 1      | party_1_variable_1 |
      | 1                     | 1                           | 1                          | 2      | party_1_variable_2 |
      | 1                     | 1                           | 1                          | 3      | party_1_variable_3 |
      | 1                     | 1                           | 1                          | 4      | party_1_variable_4 |
      | 1                     | 2                           | 2                          | 5      | party_2_variable_1 |
      | 1                     | 2                           | 2                          | 6      | party_2_variable_2 |
      | 1                     | 3                           | 3                          | 7      | party_3_variable_1 |
      | 2                     | 4                           | 4                          | 8      | party_1_variable_1 |
      | 2                     | 4                           | 4                          | 9      | party_1_variable_2 |
      | 2                     | 4                           | 4                          | 10     | party_1_variable_3 |
      | 2                     | 4                           | 4                          | 11     | party_1_variable_4 |
      | 2                     | 4                           | 4                          | 12     | party_1_variable_5 |
      | 2                     | 5                           | 5                          | 13     | party_2_variable_1 |
      | 2                     | 5                           | 5                          | 14     | party_2_variable_2 |
      | 2                     | 5                           | 5                          | 15     | party_2_variable_3 |

  @scenario1
  Scénario: Editer les variables du modèle de contrat en tant que support
    Étant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de modifier la variable numéro "1"
    Alors la variable est modifiée

  @scenario2
  Scénario: Impossibilité d'editer les variables du modèle de contrat si l'utilisateur n'est pas support
    Étant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de modifier la variable numéro "1"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support
