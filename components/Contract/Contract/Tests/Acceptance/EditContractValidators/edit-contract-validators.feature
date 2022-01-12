#language: fr
Fonctionnalité: edit contract validator
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor |
      | 01000000000000 | Addworking1 | 0           | 0         |
      | 02000000000000 | Client1     | 1           | 0         |
      | 03000000000000 | Client2     | 1           | 0         |
      | 04000000000000 | vendor      | 0           | 1         |

    Et que les utilisateurs suivants existent
      | number | email                      | firstname | lastname | is_system_admin | siret          |
      |   1    | antoine.pierre@addwun.com  | Antoine   | PIERRE   | 1               | 01000000000000 |
      |   2    | jean.paul@clideux.com      | Jean      | PAUL     | 0               | 02000000000000 |
      |   3    | bruce.wayne@client3.com    | Bruce     | Wayne    | 0               | 03000000000000 |
      |   4    | natasha.roumaf@vendor1.com | Natasha   | ROUMANOU | 0               | 02000000000000 |
      |   5    | victor.hugo@miserables.com | Victor    | Hugo     | 0               | 04000000000000 |

    Et que les modèles de contrat suivant existe
      | number | siret          | display_name   | published_at | name      |
      | 1      | 02000000000000 | contract model | 01-11-2020   | model_one |
      | 2      | 03000000000000 | contract model | 01-11-2020   | model_two |

    Et que les parties prenantes du modèle suivantes existent
      | contract_model_number | number | denomination   | order |
      | 1                     | 1      | le client      | 1     |
      | 1                     | 2      | le prestataire | 2     |
      | 2                     | 3      | le client      | 1     |
      | 2                     | 4      | le prestataire | 2     |

    Et que les pièces du modèle suivantes existent
      | contract_model_number | number | display_name | order | name  | should_compile |
      | 1                     | 1      | part_one     | 1     | part1 | 1              |
      | 1                     | 2      | part_two     | 2     | part2 | 0              |
      | 1                     | 3      | part_three   | 3     | part3 | 0              |
      | 2                     | 4      | part_one     | 1     | part2 | 1              |

    Et que les chantiers suivants existent
      | number | name        | description | estimated_budget | started_at | ended_at   | owner_siret    | created_by              |
      | 1      | Chantier n1 | blablablaba | 123456789.98     | 2021-02-20 | 2021-12-22 | 02000000000000 | jean.paul@clideux.com   |
      | 2      | Chantier n2 | desbabption | 123456709.98     | 2022-02-20 | 2022-12-22 | 03000000000000 | bruce.wayne@client3.com |

    Et que les intervenants suivants existent
      | number | work_field_number | contributor_email       | enterprise_siret | is_admin | is_contract_validator | contract_validation_order |
      | 1      | 1                 | jean.paul@clideux.com   | 02000000000000   | 1        | 1                     | 1                         |
      | 2      | 1                 | bruce.wayne@client3.com | 03000000000000   | 0        | 1                     | 2                         |
      | 3      | 2                 | jean.paul@clideux.com   | 02000000000000   | 0        | 1                     | 1                         |
      | 4      | 2                 | bruce.wayne@client3.com | 02000000000000   | 0        | 1                     | 1                         |

    Et que les missions suivantes existent
      | number   | name       | referent_number | enterprise_siret | label   | starts_at    |  ends_at     | description | external_id  | analytic_code | status         | workfield_number | vendor_siret   |
      |    1     | mission_1  | 4               | 02000000000000   | lable_1 | 2021-04-15   |  2022-04-30  |  mission_1  |   id_1       |  D1120        | ready_to_start | 1                | 04000000000000 |
      |    2     | mission_2  | 5               | 03000000000000   | lable_2 | 2021-04-15   |  2022-04-30  |  mission_2  |   id_2       |  D1130        | ready_to_start | 2                | 04000000000000 |

    Et que les contrats suivants existent
      | number | state          | enterprise_siret | name       | valid_from | valid_until | external_identifier | mission_number    | created_by              |
      | 1      | draft          | 02000000000000   | Contract 1 | 01-11-2020 | 2020-12-30  | random_ext_id_1     | 1                 | jean.paul@clideux.com   |
      | 2      | in_preparation | 03000000000000   | Contract 2 | 01-11-2020 | 2020-12-30  | random_ext_id_2     | 2                 | bruce.wayne@client3.com |
      | 3      | signed         | 02000000000000   | Contract 3 | 01-11-2020 | 2020-12-30  | random_ext_id_3     | 2                 | jean.paul@clideux.com   |

    Et que les parties prenantes suivantes existent
      | number | denomination   | order | siret          | contract_number | email                      | signed_at  | contract_model_party_number |
      | 1      | le prestataire | 1     | 04000000000000 | 3               | victor.hugo@miserables.com | 2021-01-01 | 1                           |
      | 2      | le client      | 2     | 02000000000000 | 3               | jean.paul@clideux.com      | 2021-01-01 | 1                           |
      | 3      | le prestataire | 1     | 04000000000000 | 2               | victor.hugo@miserables.com | null       | 2                           |
      | 4      | le client      | 2     | 03000000000000 | 2               | bruce.wayne@client3.com    | null       | 2                           |

  @scenario1
  Scénario: Modifier les validateurs d'un contrat en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de modifier les validateurs du contrat numéro "1"
    Alors les validateurs du contrat numéro "1" sont modifiés

  @scenario2
  Scénario: Modifier les validateurs d'un contrat en tant que créateur du contrat
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de modifier les validateurs du contrat numéro "2"
    Alors les validateurs du contrat numéro "2" sont modifiés

  @scenario3
  Scénario: Impossibilité de modifier les validateurs d'un contrat si l'utilisateur n'est pas support ou créateur du contrat
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "natasha.roumaf@vendor1.com"
    Quand j'essaie de modifier les validateurs du contrat numéro "2"
    Alors une erreur est levée car l'utilisateur n'est pas support ou créateur du contrat

  @scenario4
  Scénario: Impossibilité de modifier les validateurs d'un contrat si l'état du contrat est différent de Brouillon/En préparation/Doc à fournir/Bon pour signature
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de modifier les validateurs du contrat numéro "3"
    Alors une erreur est levée car l'état du contrat est différent de Brouillon/En préparation/Doc à fournir/Bon pour signature
