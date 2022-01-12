#language: fr
Fonctionnalité: edit drafted contract model
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | access_to_contract |
      | 01000000000000 | Addworking1 | 0           | 0         | 1                  |
      | 02000000000000 | Client2     | 1           | 0         | 1                  |
      | 03000000000000 | Client3     | 1           | 0         | 1                  |

    Et que les utilisateurs suivants existent
      | email                      | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com  | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@clideux.com      | Jean      | PAUL     | 0               | 02000000000000 |
      | victor.hugo@miserables.com | Victor    | HUGO     | 0               | 03000000000000 |

    Et que les modèles de contrat suivants existent
      | number | siret          | display_name             | published_at | archived_at |
      | 1      | 02000000000000 | contract model draft     | null         | null        |
      | 2      | 02000000000000 | contract model published | 2020-10-01   | null        |
      | 3      | 02000000000000 | contract model archived  | null         | 2020-10-10  |

  @scenario1
  Scénario: Modifier un modèle de contrat en mode draft
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de modifier le modèle de contrat numéro "1"
    Alors le modèle de contrat numéro "1" est modifié

  @scenario2
  Scénario: Impossibilité de modifier un modèle de contrat en mode draft si l'utilisateur n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de modifier le modèle de contrat numéro "1"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support

  @scenario3
  Scénario: Impossibilité de modifier un modèle de contrat s'il est publié
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de modifier le modèle de contrat numéro "2"
    Alors une erreur est levée car le modèle de contrat est publié

  @scenario4
  Scénario: Impossibilité de modifier un modèle de contrat s'il est archivé
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de modifier le modèle de contrat numéro "3"
    Alors une erreur est levée car le modèle de contrat est archivé
