#language: fr
Fonctionnalité: list contract variables
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

    Et que les variables de model de contract suivantes existent
      | number | contract_model_number | contract_model_party_number | contract_model_part_number | name               | order |
      | 1      | 1                     | 1                           | 1                          | party_1_variable_1 | 0     |
      | 2      | 1                     | 1                           | 1                          | party_1_variable_2 | 1     |
      | 3      | 1                     | 1                           | 1                          | party_1_variable_3 | 2     |
      | 4      | 1                     | 1                           | 1                          | party_1_variable_4 | 3     |
      | 5      | 1                     | 2                           | 2                          | party_2_variable_5 | 4     |
      | 6      | 1                     | 2                           | 2                          | party_2_variable_6 | 5     |
      | 7      | 1                     | 2                           | 2                          | party_2_variable_7 | 6     |
      | 8      | 1                     | 2                           | 2                          | party_2_variable_8 | 7     |
      | 9      | 1                     | 1                           | 3                          | party_2_variable_9 | 8     |
      | 10     | 2                     | 3                           | 4                          | party_1_variable_1 | 9     |
      | 11     | 2                     | 4                           | 4                          | party_1_variable_2 | 10    |
      | 12     | 2                     | 4                           | 4                          | party_1_variable_3 | 11    |
      | 13     | 2                     | 4                           | 4                          | party_1_variable_4 | 12    |

    Et que les contrats suivants existent
      | number | siret          | name       | model_number | valid_from | valid_until |
      | 1      | 01000000000000 | contract 1 | 1            | 2020-11-25 | 2021-11-28  |
      | 2      | 02000000000000 | contract 2 | 1            | 2020-11-25 | 2021-11-28  |
      | 3      | 03000000000000 | contract 3 | 2            | 2020-11-25 | 2021-11-28  |

    Et que les parties prenantes de contract suivantes existent
      | number | siret          | contract_number | contract_model_party_number | denomination     | order | signed | declined |
      | 1      | 01000000000000 | 1               | 1                           | contract party 1 | 1     | 0      | 0        |
      | 2      | 02000000000000 | 1               | 2                           | contract party 1 | 1     | 0      | 0        |
      | 3      | 01000000000000 | 2               | 1                           | contract party 1 | 1     | 0      | 0        |
      | 4      | 02000000000000 | 2               | 2                           | contract party 1 | 1     | 0      | 0        |
      | 5      | 01000000000000 | 3               | 3                           | contract party 1 | 1     | 0      | 0        |
      | 6      | 03000000000000 | 3               | 4                           | contract party 1 | 1     | 0      | 0        |

      Et que les pièces de contrat suivantes existent
      | number | contract_model_part_number | contract_number | display_name  | order | is_signed | signature_page |
      | 1      | 1                          | 1               | part 1        | 1     | 0         | 1              |
      | 2      | 2                          | 1               | part 2        | 2     | 1         | 1              |
      | 3      | 3                          | 1               | part 3        | 3     | 1         | 1              |
      | 4      | 4                          | 2               | part 4        | 1     | 0         | 1              |
      | 5      | 5                          | 2               | part 5        | 2     | 1         | 1              |

    Et que les variables suivantes existent
      | variable_model_number | contract_number | value                 | number | order |
      | 1                     | 1               | contract_1_variable_1 | 1      | 0     |
      | 1                     | 2               | contract_2_variable_1 | 2      | 0     |
      | 2                     | 1               | contract_1_variable_2 | 3      | 1     |
      | 2                     | 2               | contract_2_variable_2 | 4      | 1     |
      | 3                     | 1               | contract_1_variable_3 | 5      | 2     |
      | 3                     | 2               | contract_2_variable_3 | 6      | 2     |
      | 4                     | 1               | contract_1_variable_4 | 7      | 3     |
      | 4                     | 2               | contract_2_variable_4 | 8      | 3     |
      | 5                     | 1               | contract_2_variable_5 | 9      | 4     |
      | 5                     | 2               | contract_2_variable_5 | 10     | 4     |
      | 6                     | 1               | contract_2_variable_6 | 11     | 5     |
      | 6                     | 2               | contract_2_variable_6 | 12     | 5     |
      | 7                     | 1               | contract_2_variable_7 | 13     | 6     |
      | 7                     | 2               | contract_2_variable_7 | 14     | 6     |
      | 8                     | 1               | contract_2_variable_8 | 15     | 7     |
      | 8                     | 2               | contract_2_variable_8 | 16     | 7     |
      | 9                     | 1               | contract_2_variable_9 | 17     | 8     |
      | 9                     | 2               | contract_2_variable_9 | 18     | 8     |

  @scenario1
  Scénario: Lister les variables du contrat
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de lister toutes les variables du contrat numéro "1"
    Alors toutes les variables du contrat numéro "1" sont listées
