#language: fr

Fonctionnalité: List Payment Order

  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | access_to_billing |
      | 01000000000000 | Addworking1 | 0           | 0         | 1                 |
      | 02000000000000 | Clipresta2  | 1           | 1         | 1                 |
      | 03000000000000 | Client3     | 1           | 0         | 1                 |
      | 04000000000000 | Client4     | 1           | 0         | 1                 |

    Et les ordres de paiement suivants existent
      | number | siret_customer |
      | 002    | 02000000000000 |
      | 012    | 02000000000000 |
      | 022    | 02000000000000 |
      | 222    | 02000000000000 |
      | 003    | 03000000000000 |
      | 004    | 04000000000000 |

    Et que les utilisateurs suivants existent
      | email                     | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@clipresta2.com  | Jean      | PAUL     | 0               | 02000000000000 |

  @listerLesParametresDeFacturation
  Scénario: Lister les ordres de paiement d'une entreprise en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de lister les ordres de paiement de l'entreprise avec siret "02000000000000"
    Alors les ordres de paiement sont listées

  Scénario: Impossibilité de lister les ordres de paiement si l'utilisateur connecté n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clipresta2.com"
    Quand j'essaie de lister les ordres de paiement de l'entreprise avec siret "02000000000000"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support
