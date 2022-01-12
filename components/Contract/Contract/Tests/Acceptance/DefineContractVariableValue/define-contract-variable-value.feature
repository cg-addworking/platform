#language: fr
Fonctionnalité: Define contract variable value
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | parent_siret   | name         | is_customer | is_vendor | access_to_contract |
      | 01000000000000 | null           | Addworking1  | 0           | 0         | 1                  |
      | 02000000000000 | null           | head quarter | 1           | 0         | 1                  |
      | 03000000000000 | null           | subsidiary   | 1           | 0         | 1                  |
      | 04000000000000 | 02000000000000 | not related  | 1           | 0         | 1                  |

    Et que les utilisateurs suivants existent
      | email                        | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com    | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@head-quarter.com   | Jean      | PAUL     | 0               | 02000000000000 |
      | pierre.dupont@subsidiary.com | Pierre    | DUPONT   | 0               | 03000000000000 |
      | jean.michel@not-related.com  | Jean      | Michel   | 0               | 04000000000000 |

    Et que les modèles de contrat suivants existent
      | number | siret          | display_name             | published_at | archived_at |
      | 1      | 01000000000000 | published contract model | 2020-11-13   | null        |
      | 2      | 02000000000000 | published contract model | 2020-11-13   | null        |

    Et que les parties prenantes de modéle de contract suivantes existent
      | number | contract_model_number | denomination | order |
      | 1      | 1                     | party 1      | 1     |
      | 2      | 1                     | party 2      | 2     |
      | 3      | 2                     | party 1      | 1     |
      | 4      | 2                     | party 2      | 2     |

    Et que les pièces suivantes existent
      | number | contract_model_number | display_name  | order | is_initialled | is_signed | should_compile |
      | 1      | 1                     | part 1        | 1     | 0             | 0         | 1              |
      | 2      | 1                     | part 2        | 2     | 1             | 1         | 1              |
      | 3      | 1                     | part 3        | 3     | 1             | 1         | 1              |
      | 4      | 2                     | part 4        | 4     | 1             | 0         | 1              |
      | 5      | 2                     | part 5        | 5     | 0             | 1         | 1              |

    Et que les modeles de variables suivantes existent
      | number | contract_model_number | contract_model_party_number | contract_model_part_number | name               |
      | 1      | 1                     | 1                           | 1                          | party_1_variable_1 |
      | 2      | 1                     | 1                           | 1                          | party_1_variable_2 |
      | 3      | 1                     | 1                           | 1                          | party_1_variable_3 |
      | 4      | 1                     | 1                           | 1                          | party_1_variable_4 |
      | 5      | 1                     | 2                           | 2                          | party_2_variable_5 |
      | 6      | 1                     | 2                           | 2                          | party_2_variable_6 |
      | 7      | 1                     | 2                           | 2                          | party_2_variable_7 |
      | 8      | 1                     | 2                           | 2                          | party_2_variable_8 |
      | 9      | 1                     | 1                           | 3                          | party_2_variable_9 |
      | 10     | 2                     | 3                           | 4                          | party_1_variable_1 |
      | 11     | 2                     | 4                           | 4                          | party_1_variable_2 |
      | 12     | 2                     | 4                           | 4                          | party_1_variable_3 |
      | 13     | 2                     | 4                           | 4                          | party_1_variable_4 |

    Et que les contrats suivants existent
      | number | siret          | name       | model_number | valid_from | valid_until |
      | 1      | 01000000000000 | contract 1 | 1            | 2020-11-25 | 2021-11-28  |
      | 2      | 02000000000000 | contract 2 | 1            | 2020-11-25 | 2021-11-28  |
      | 3      | 02000000000000 | contract 3 | 2            | 2020-11-25 | 2021-11-28  |

    Et que les parties prenantes de contract suivantes existent
      | number | siret          | contract_number | contract_model_party_number | denomination     | order | signed | declined |
      | 1      | 01000000000000 | 1               | 1                           | contract party 1 | 1     | 0      | 0        |
      | 2      | 02000000000000 | 1               | 2                           | contract party 1 | 1     | 0      | 0        |
      | 3      | 01000000000000 | 2               | 1                           | contract party 1 | 1     | 0      | 0        |
      | 4      | 02000000000000 | 2               | 2                           | contract party 1 | 1     | 0      | 0        |
      | 5      | 01000000000000 | 3               | 3                           | contract party 1 | 1     | 0      | 0        |
      | 6      | 03000000000000 | 3               | 4                           | contract party 1 | 1     | 0      | 0        |

    Et que les variables suivantes existent
      | number | variable_model_number | name        | contract_number | party_number |
      | 1      | 1                     | variable_1  | 1               | 1            |
      | 2      | 2                     | variable_2  | 1               | 1            |
      | 3      | 3                     | variable_3  | 1               | 1            |
      | 4      | 4                     | variable_4  | 1               | 1            |
      | 5      | 5                     | variable_5  | 1               | 2            |
      | 6      | 6                     | variable_6  | 1               | 2            |
      | 7      | 7                     | variable_7  | 1               | 2            |
      | 8      | 8                     | variable_8  | 1               | 2            |
      | 9      | 9                     | variable_9  | 1               | 1            |
      | 10     | 1                     | variable_10 | 2               | 1            |
      | 12     | 2                     | variable_12 | 2               | 1            |
      | 13     | 3                     | variable_13 | 2               | 1            |
      | 14     | 4                     | variable_14 | 2               | 1            |
      | 15     | 5                     | variable_15 | 2               | 2            |
      | 16     | 6                     | variable_16 | 2               | 2            |
      | 17     | 7                     | variable_17 | 2               | 2            |
      | 18     | 8                     | variable_18 | 2               | 2            |
      | 19     | 9                     | variable_19 | 2               | 1            |
      | 20     | 10                    | variable_20 | 3               | 5            |
      | 21     | 11                    | variable_21 | 3               | 6            |
      | 22     | 12                    | variable_22 | 3               | 6            |
      | 23     | 13                    | variable_23 | 3               | 6            |

  @scenario1
  Scénario: Modifier les variables d'un contract quand je suis support
    Etant donné que je suis authentifié en tant que utilisateur avec l'émail "antoine.pierre@addwun.com"
    Quand j'essaie de définir la valeur des variables du contract numéro "1"
    Alors les valeurs des variables du contract numéro "1" sont définie
    Alors Au total "9" variables ont été modifié

  @scenario2
  Scénario: Modifier les variables d'un contract quand je suis propriétaire du contract
    Etant donné que je suis authentifié en tant que utilisateur avec l'émail "jean.paul@head-quarter.com"
    Quand j'essaie de définir la valeur des variables du contract numéro "2"
    Alors les valeurs des variables du contract numéro "2" sont définie
    Alors Au total "9" variables ont été modifié

  @scenario3
  Scénario: Modifier les variables d'un contract quand je suis partie prenante
    Etant donné que je suis authentifié en tant que utilisateur avec l'émail "pierre.dupont@subsidiary.com"
    Quand j'essaie de définir la valeur des variables du contract numéro "3"
    Alors une erreur est levée car l'utilisateur connecté n'est ni support ni partie prenante
