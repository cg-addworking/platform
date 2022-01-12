#language: fr
Fonctionnalité: Add a mission to a contract or create a mission for a contract
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | parent_siret   | client_siret   | name         | is_customer | is_vendor | access_to_contract |
      | 01000000000000 | null           | null           | Addworking1  | 0           | 0         | 1                  |
      | 02000000000000 | null           | null           | head quarter | 1           | 0         | 1                  |
      | 03000000000000 | 02000000000000 | null           | subsidiary   | 1           | 0         | 1                  |
      | 04000000000000 | null           | null           | not related  | 1           | 0         | 1                  |
      | 05000000000000 | null           | 03000000000000 | vendor 1     | 0           | 1         | 1                  |

    Et que les utilisateurs suivants existent
      | email                        | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com    | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@head-quarter.com   | Jean      | PAUL     | 0               | 02000000000000 |
      | pierre.dupont@subsidiary.com | Pierre    | DUPONT   | 0               | 03000000000000 |
      | jean.michel@not-related.com  | Jean      | Michel   | 0               | 04000000000000 |
      | gandalf.leblanc@lotr.com     | Gandalf   | Leblanc  | 0               | 05000000000000 |

    Et que les modèles de contrat suivants existent
      | number | siret          | display_name             | published_at | archived_at |
      | 1      | 03000000000000 | published contract model | 2020-11-13   | null        |
      | 2      | 03000000000000 | drafted contract model   | null         | null        |
      | 3      | 02000000000000 | published contract model | 2020-11-20   | null        |
      | 4      | 04000000000000 | published contract model | 2020-11-20   | null        |

    Et que les parties prenantes suivantes existent
      | contract_model_number | number | denomination | order |
      | 1                     | 1      | party 1      | 1     |
      | 1                     | 2      | party 2      | 2     |
      | 1                     | 3      | party 3      | 3     |
      | 2                     | 4      | party 1      | 1     |
      | 2                     | 5      | party 2      | 2     |
      | 3                     | 6      | party 1      | 1     |
      | 3                     | 7      | party 2      | 2     |
      | 3                     | 8      | party 3      | 3     |
      | 3                     | 9      | party 4      | 4     |
      | 4                     | 10     | party 1      | 1     |
      | 4                     | 11     | party 2      | 2     |

    Et que les pièces suivantes existent
      | contract_model_number | number | display_name  | order | is_initialled | is_signed | should_compile |
      | 1                     | 1      | part 1        | 1     | 0             | 0         | 1              |
      | 1                     | 2      | part 2        | 1     | 1             | 1         | 1              |
      | 1                     | 3      | part 3        | 1     | 1             | 1         | 1              |
      | 2                     | 4      | part 1        | 1     | 1             | 0         | 1              |
      | 2                     | 5      | part 2        | 2     | 0             | 1         | 1              |
      | 3                     | 6      | part 1        | 1     | 1             | 1         | 1              |
      | 4                     | 7      | part 1        | 1     | 1             | 0         | 1              |

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
      | 3                     | 6                           | 6                          | 12     | party_1_variable_1 |
      | 3                     | 6                           | 6                          | 13     | party_1_variable_2 |
      | 3                     | 7                           | 6                          | 14     | party_2_variable_1 |
      | 3                     | 8                           | 6                          | 15     | party_3_variable_1 |
      | 3                     | 9                           | 6                          | 16     | party_4_variable_1 |
      | 3                     | 9                           | 6                          | 17     | party_4_variable_2 |
      | 4                     | 10                          | 7                          | 18     | party_1_variable_1 |

    Et que les contracts suivants existent
      | contract_model_number | number | status    | siret          | name  | valid_from | valid_until |
      | 1                     | 10     | published | 03000000000000 | Lorem | 2021-01-01 | 2021-05-31  |

    Et que les parties prenantes de contract suivantes existent
      | contract_number | contract_model_party_number | number | siret          | signatory_number | order | denomination   | signed | declined |
      | 10              | 1                           | 1      | 03000000000000 | 1                | 1     | denomination_1 | 0      | 0        |
      | 10              | 2                           | 2      | 05000000000000 | 2                | 2     | denomination_2 | 0      | 0        |

    Et que les missions suivantes existent
      | number | label                    | client_siret   | vendor_siret   | contract_number | status | starts_at  |
      | 1      | mission without contract | 03000000000000 | 05000000000000 | null            | draft  | 2021-01-01 |
      | 2      | mission with contract    | 03000000000000 | 05000000000000 | 10              | draft  | 2021-01-01 |

  @scenario1
  Scénario: Add a mission to a contract
    Etant donné que je suis authentifié en tant que utilisateur avec l'émail "antoine.pierre@addwun.com"
    Quand j'essaie d'assigner la mission "1" au contrat "10"
    Alors la mission est ajouté au contract "10"

  @scenario2
  Scénario: Create a mission and add it to a contract
    Etant donné que je suis authentifié en tant que utilisateur avec l'émail "jean.paul@head-quarter.com"
    Quand j'essaie de créer une mission et de l'ajouter au contrat "10"
    Alors la mission est ajouté au contract "10"
