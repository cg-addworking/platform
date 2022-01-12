#language: fr
Fonctionnalité: list enterprises as support
  Contexte:
    Etant donné que les pays suivant existent
      | code | short_id |
      | fr   | 0        |

    Etant donné que les companies suivantes existent
      | identification_number | name        | short_id |
      | 01000000000000        | Addworking1 | 0        |
      | 02000000000000        | Client2     | 1        |
      | 03000000000000        | Client3     | 2        |
      | 04000000000000        | Presta4     | 3        |
      | 05000000000000        | Presta5     | 4        |
      | 06000000000000        | Hybrid6     | 5        |
      | 07000000000000        | Hybrid7     | 6        |

    Et que les utilisateurs suivants existent
      | email                      | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com  | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@clideux.com      | Jean      | PAUL     | 0               | 02000000000000 |

  @scenario1
  Scénario: Lister les companies
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de lister toutes les companies
    Alors toutes les companies sont listées

  @scenario2
  Scénario: Impossibilité de lister les companies si l'utilisateur n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de lister toutes les companies
    Alors une erreur est levée car l'utilisateur connecté n'est pas support