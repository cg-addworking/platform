#language: fr
Fonctionnalité: list annex as support
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name       | is_customer | is_vendor |
      | 01000000000000 | Addworking | 0           | 0         |
      | 02000000000000 | client 1   | 1           | 0         |
      | 03000000000000 | client 2   | 1           | 0         |

    Et que les utilisateurs suivants existent
      | email                        | firstname | lastname | is_system_admin | enterprise_siret | number |
      | peter.parker@addworking.com  | Peter     | PARKER   | 1               | 01000000000000   | 1      |
      | tony.stark@warlock.com       | Tony      | STARK    | 0               | 02000000000000   | 2      |
      | clark.kent@client2.com       | Clark     | KENT     | 0               | 03000000000000   | 3      |

    Et que les annexes suivantes existent
      | number | name    | enterprise_siret  | description     |
      | 1      | annex_1 | 02000000000000    | description_one |
      | 2      | annex_2 | 02000000000000    | description_one |
      | 3      | annex_3 | 03000000000000    | description     |

  @scenario1
  Scénario: Lister les annexes en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "peter.parker@addworking.com"
    Quand j'essaie de lister toutes les annexes de la plateforme
    Alors toutes les annexes de la plateforme sont listés

  @scenario2
  Scénario: Impossibilité de lister les annexes si l'utilisateur n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "tony.stark@warlock.com"
    Quand j'essaie de lister toutes les annexes de la plateforme
    Alors une erreur est levée car l'utilisateur n'est pas support