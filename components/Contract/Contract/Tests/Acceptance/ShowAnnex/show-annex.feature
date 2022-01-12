#language: fr
Fonctionnalité: show annex
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor |
      | 01000000000000 | Addworking1 | 0           | 0         |
      | 02000000000000 | Client2     | 1           | 0         |
      | 03000000000000 | Client3     | 1           | 0         |

    Et que les utilisateurs suivants existent
      | email                      | firstname | lastname | is_system_admin | enterprise_siret |
      | antoine.pierre@addwun.com  | Antoine   | PIERRE   | 1               | 01000000000000   |
      | jean.paul@clideux.com      | Jean      | PAUL     | 0               | 02000000000000   |
      | victor.hugo@miserables.com | Victor    | HUGO     | 0               | 03000000000000   |

    Et que les annexes suivantes existent
      | number | name    | enterprise_siret  | description     |
      | 1      | annex_1 | 02000000000000    | description_one |
      | 2      | annex_2 | 02000000000000    | description_two |
      | 3      | annex_3 | 03000000000000    | description_3   |

  @scenario1
  Scénario: Voir le détail d'une annexe en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de voir le détail de l'annexe numéro "2"
    Alors le détail de l'annexe numéro "2" est affiché

  @scenario2
  Scénario: Voir le détail d'une annexe en tant que membre de l'entreprise propriétaire de l'annexe
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "victor.hugo@miserables.com"
    Quand j'essaie de voir le détail de l'annexe numéro "3"
    Alors le détail de l'annexe numéro "3" est affiché

  @scenario3
  Scénario: Impossibilité de voir le détail d'une annexe si l'utilisateur n'est pas support ou membre de l'entreprise propriétaire de l'annexe
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de voir le détail de l'annexe numéro "3"
    Alors une erreur est levée car l'utilisateur n'est pas support ou membre de l'entreprise propriétaire de l'annexe

  @scenario4
  Scénario: Impossibilité de voir le détail d'une annexe si elle n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de voir le détail de l'annexe numéro "15"
    Alors une erreur est levée car l'annexe n'existe pas