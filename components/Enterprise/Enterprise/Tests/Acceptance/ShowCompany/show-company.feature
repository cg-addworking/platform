#language: fr
Fonctionnalité: show contract
  Contexte:
    Etant donné que les pays suivant existent
      | code | short_id |
      | fr   | 0        |

    Et que les utilisateurs suivants existent
      | email                      | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com  | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@clideux.com      | Jean      | PAUL     | 0               | 02000000000000 |
      | victor.hugo@miserables.com | Victor    | HUGO     | 0               | 03000000000000 |
      | emile.zola@bonheur.com     | Emile     | ZOLA     | 0               | 04000000000000 |

    Et que les companies suivant existent
      | identification_number | name        | short_id |
      | 01000000000000        | Addworking1 | 0        |
      | 02000000000000        | Client2     | 1        |
      | 03000000000000        | Client3     | 2        |
      | 04000000000000        | Presta4     | 3        |
      | 05000000000000        | Presta5     | 4        |
      | 06000000000000        | Hybrid6     | 5        |
      | 07000000000000        | Hybrid7     | 6        |

  @scenario1
  Scénario: Voir le détail d'une companie en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de voir le détail de la companie "1"
    Alors le détail de la companie "1" est affiché

  @scenario2
  Scénario: Voir le détail d'une companie en tant que non support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "victor.hugo@miserables.com"
    Quand j'essaie de voir le détail de la companie "1"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support

  @scenario3
  Scénario: Impossibilité de voir le détail d'une companie s'il n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de voir le détail de la companie "42"
    Alors une erreur est levée car le companie n'existe pas