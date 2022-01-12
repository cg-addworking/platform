#language: fr
Fonctionnalité: list contract model as support
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | access_to_contract |
      | 01000000000000 | Addworking1 | 0           | 0         | 1                  |
      | 02000000000000 | Client2     | 1           | 0         | 1                  |
      | 03000000000000 | Client3     | 1           | 0         | 1                  |
      | 04000000000000 | Presta1     | 0           | 1         | 1                  |


    Et que les utilisateurs suivants existent
      | email                      | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com  | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@clideux.com      | Jean      | PAUL     | 0               | 02000000000000 |
      | victor.hugo@miserables.com | Victor    | HUGO     | 0               | 03000000000000 |
      | claude.b@presta.com        | Claude    | BERNAT   | 0               | 04000000000000 |

    Et que les modèles de contrat suivants existent
      | number | siret          | display_name             | published_at | archived_at |
      | 1      | 02000000000000 | contract model draft     | null         | null        |
      | 2      | 02000000000000 | contract model published | 2020-10-01   | null        |
      | 3      | 02000000000000 | contract model archived  | 2020-10-05   | 2020-10-10  |
      | 4      | 03000000000000 | contract model published | 2020-10-10   | null        |
      | 5      | 03000000000000 | contract model archived  | 2020-10-02   | 2020-10-10  |
      | 6      | 04000000000000 | contract model published | 2020-10-10   | null        |

  @scenario1
  Scénario: Lister les modeles de contrats
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de lister tout les modeles de contrat de toutes les entreprises
    Alors les modeles de contrats de toutes les entreprises sont listés

  @scenario2
  Scénario: Impossibilité de lister les modèles de contrat si l'utilisateur n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de lister tout les modeles de contrat de toutes les entreprises
    Alors une erreur est levée car l'utilisateur connecté n'est pas support
