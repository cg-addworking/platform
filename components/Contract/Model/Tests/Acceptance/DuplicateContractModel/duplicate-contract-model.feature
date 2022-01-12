#language: fr
Fonctionnalité: create contract
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name       | is_customer | is_vendor | access_to_contract |
      | 01000000000000 | Addworking | 0           | 0         | 1                  |
      | 02000000000000 | Client2    | 1           | 0         | 1                  |
      | 03000000000000 | Presta3    | 1           | 0         | 1                  |
      | 04000000000000 | CliPresta4 | 1           | 0         | 1                  |

    Et que les utilisateurs suivants existent
      | email                      | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addw.com    | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@client2.com      | Jean      | PAUL     | 0               | 02000000000000 |
      | pierre.dupont@presta3.com  | Pierre    | DUPONT   | 0               | 03000000000000 |
      | jean.michel@clipresta4.com | Jean      | Michel   | 0               | 04000000000000 |

    Et que les modèles de contrat suivants existent
      | number | siret          | display_name             | published_at | archived_at |
      | 1      | 02000000000000 | published contract model | 2020-11-13   | null        |
      | 2      | 04000000000000 | drafted contract model   | null         | null        |

    Et que les parties prenantes suivantes existent
      | contract_model_number | number | denomination | order |
      | 1                     | 1      | party 1      | 1     |
      | 1                     | 2      | party 2      | 2     |
      | 2                     | 3      | party 1      | 1     |
      | 2                     | 4      | party 2      | 2     |

    Et que les pièces suivantes existent
      | contract_model_number | number | display_name  | order | is_initialled | is_signed | should_compile |
      | 1                     | 1      | part 1        | 1     | 0             | 0         | 1              |
      | 1                     | 2      | part 2        | 2     | 1             | 1         | 0              |
      | 2                     | 3      | part 1        | 1     | 1             | 0         | 1              |
      | 2                     | 4      | part 2        | 2     | 0             | 1         | 0              |
    Et que les variables suivantes existent
      | contract_model_number | contract_model_party_number | contract_model_part_number | number | name               | order |
      | 1                     | 1                           | 1                          | 1      | party_1_variable_1 | 0     |
      | 1                     | 1                           | 1                          | 2      | party_1_variable_2 | 1     |
      | 1                     | 1                           | 1                          | 3      | party_1_variable_3 | 2     |
      | 1                     | 1                           | 1                          | 4      | party_1_variable_4 | 3     |
      | 1                     | 2                           | 2                          | 5      | party_2_variable_1 | 4     |
      | 1                     | 2                           | 2                          | 6      | party_2_variable_2 | 5     |
      | 2                     | 4                           | 4                          | 7      | party_1_variable_1 | 6     |
      | 2                     | 4                           | 4                          | 8      | party_1_variable_2 | 7     |
      | 2                     | 4                           | 4                          | 9      | party_1_variable_3 | 8     |
      | 2                     | 4                           | 4                          | 10     | party_1_variable_4 | 9     |

  @scenario1
  Scénario: Duppliquer un modèle de contrat pour une entreprise qui possède le modèle de contrat
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addw.com"
    Quand j'essaie de duppliquer un modèle de contrat à partir du modèle de contrat numéro "1"
    Alors le modèle de contrat est duppliqué

  @scenario2
  Scénario: Impossibilité de duppliquer un modèle de contrat depuis une entreprise qui ne possède pas le modèle de contrat
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "pierre.dupont@presta3.com"
    Quand j'essaie de duppliquer un modèle de contrat à partir du modèle de contrat numéro "1"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support

  @scenario3
  Scénario: Impossibilité de duppliquer un modèle de contrat pour une entreprise qui possède le modèle de contrat au statut brouillon
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addw.com"
    Quand j'essaie de duppliquer un modèle de contrat à partir du modèle de contrat numéro "2"
    Alors une erreur est levée car le modèle de contrat n'est pas publié