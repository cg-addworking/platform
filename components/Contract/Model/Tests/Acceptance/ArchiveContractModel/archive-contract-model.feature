#language: fr
Fonctionnalité: archive contract model
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor |
      | 01000000000000 | Addworking1 | 0           | 0         |
      | 02000000000000 | Client2     | 1           | 0         |

    Et que les utilisateurs suivants existent
      | email                      | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com  | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@client.com       | Jean      | PAUL     | 0               | 02000000000000 |

    Et que les modèles de contrat suivants existent
      | number | siret          | display_name             | published_at |
      | 1      | 02000000000000 | contract model draft     | null         |
      | 2      | 02000000000000 | contract model published | 2020-10-01   |

  @scenario1
  Scénario: archiver un modèle de contrat en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie d'archiver le modèle de contrat numéro "2"
    Alors le modèle de contrat numéro "2" est archivé

  @scenario2
  Scénario: Impossibilité d'archiver un modèle de contrat si l'utilisateur connecté n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@client.com"
    Quand j'essaie d'archiver le modèle de contrat numéro "2"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support

  @scenario3
  Scénario: Impossibilité d'archiver un modèle de contrat s'il est en brouillon
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie d'archiver le modèle de contrat numéro "1"
    Alors une erreur est levée car le modèle de contrat est en brouillon

  @scenario4
  Scénario: Impossibilité d'archiver un modèle de contrat s'il n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie d'archiver le modèle de contrat numéro "4"
    Alors une erreur est levée car le modèle de contrat n'existe pas
