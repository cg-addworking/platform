#language: fr
  Fonctionnalité: Show Payment Order
    Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | access_to_billing |
      | 01000000000000 | Addworking1 | 0           | 0         | 1                 |
      | 02000000000000 | Clipresta2  | 1           | 1         | 1                 |

    Et l'ordre de paiement suivant existe
      | number | siret_customer |
      | 022    | 02000000000000 |

    Et que les utilisateurs suivants existent
      | email                     | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@clipresta2.com  | Jean      | PAUL     | 0               | 02000000000000 |

  @voirLeDetailDUnOrdreDePaiement
  Scénario: Voir le détail d'un ordre de paiement en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de voir le détail de l'ordre de paiement numéro "022"
    Alors le détail de l'ordre de paiement numéro "022" est affiché

  Scénario: Impossibilité de voir le détail d'un ordre de paiement si l'utilisateur connecté n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clipresta2.com"
    Quand j'essaie de voir le détail de l'ordre de paiement numéro "022"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support