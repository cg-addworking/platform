#language: fr
Fonctionnalité: list enterprises as support
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor |
      | 01000000000000 | Addworking1 | 0           | 0         |
      | 02000000000000 | Client2     | 1           | 0         |
      | 03000000000000 | Client3     | 1           | 0         |
      | 04000000000000 | Presta4     | 0           | 1         |
      | 05000000000000 | Presta5     | 0           | 1         |
      | 06000000000000 | Hybrid6     | 1           | 1         |
      | 07000000000000 | Hybrid7     | 1           | 1         |


    Et que les utilisateurs suivants existent
      | email                      | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com  | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@clideux.com      | Jean      | PAUL     | 0               | 02000000000000 |

  @scenario1
  Scénario: Lister les entreprises
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de lister toutes les entreprises
    Alors toutes les entreprises sont listées

  @scenario2
  Scénario: Impossibilité de lister les entreprises si l'utilisateur n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de lister toutes les entreprises
    Alors une erreur est levée car l'utilisateur connecté n'est pas support