#language: fr
Fonctionnalité: list contract as support
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | access_to_contract |
      | 01000000000000 | Addworking1 | 0           | 0         | 1                  |
      | 02000000000000 | Client2     | 1           | 0         | 0                  |
      | 03000000000000 | CliPresta3  | 1           | 1         | 1                  |
      | 04000000000000 | Presta4     | 0           | 1         | 1                  |
      | 05000000000000 | Presta5     | 0           | 1         | 1                  |
      | 06000000000000 | Presta6     | 0           | 1         | 1                  |

    Et que les partenariats suivants existent
      | siret_customer | siret_vendor   | activity_starts_at  |
      | 02000000000000 | 03000000000000 | 2017-01-01 00:00:00 |
      | 03000000000000 | 05000000000000 | 2017-01-01 00:00:00 |
      | 03000000000000 | 06000000000000 | 2017-01-01 00:00:00 |


    Et que les utilisateurs suivants existent
      | email                      | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com  | Antoine   | PIERRE   | 1               | 01000000000000 |
      | victor.hugo@miserables.com | Victor    | HUGO     | 0               | 02000000000000 |


    Et que les modèles de contrat suivants existent
      | number | siret          | display_name             | published_at | archived_at |
      | 1      | 03000000000000 | published contract model | 2020-11-13   | null        |
      | 2      | 04000000000000 | published contract model | 2020-11-25   | null        |
      | 3      | 05000000000000 | published contract model | 2020-11-20   | null        |
      | 4      | 06000000000000 | published contract model | 2020-11-20   | null        |

    Et que les parties prenantes suivantes existent
      | contract_model_number | number | denomination | order |
      | 1                     | 1      | party 1      | 1     |
      | 1                     | 2      | party 2      | 2     |
      | 2                     | 3      | party 1      | 1     |
      | 2                     | 4      | party 2      | 2     |
      | 3                     | 5      | party 1      | 1     |
      | 3                     | 6      | party 2      | 2     |
      | 4                     | 7      | party 1      | 1     |
      | 4                     | 8      | party 2      | 2     |
      | 4                     | 9      | party 3      | 3     |

    Et que les contrats suivants existent
      | number | siret          | name         | model_number | valid_from | valid_until |
      | 1      | 03000000000000 | contract a   | 1            | 2020-11-25 | 2021-11-28  |
      | 2      | 03000000000000 | contract b   | 1            | 2020-11-25 | 2021-11-28  |
      | 3      | 04000000000000 | contract c   | 2            | 2020-11-25 | 2021-11-28  |
      | 4      | 04000000000000 | contract d   | 2            | 2020-11-25 | 2021-11-28  |
      | 5      | 05000000000000 | contract e   | 3            | 2020-11-25 | 2021-11-28  |
      | 6      | 06000000000000 | contract f   | 4            | 2020-11-25 | 2021-11-28  |

  @scenario1
  Scénario: Lister les contrats en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de lister tous les contrats de la plateforme
    Alors tous les contrats de la plateforme sont listés

  @scenario2
  Scénario: Impossibilité de lister les contrats si l'utilisateur n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "victor.hugo@miserables.com"
    Quand j'essaie de lister tous les contrats de la plateforme
    Alors une erreur est levée car l'utilisateur n'est pas support