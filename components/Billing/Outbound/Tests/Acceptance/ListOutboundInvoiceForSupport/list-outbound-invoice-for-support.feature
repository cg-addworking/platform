#language: fr

  Fonctionnalité: List Outbound Invoice For Support

    Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | access_to_billing |
      | 01000000000000 | Addworking1 | 0           | 0         | 1                 |
      | 02000000000000 | Client2     | 1           | 0         | 1                 |
      | 03000000000000 | Clipresta3  | 1           | 1         | 1                 |

    Et que les utilisateurs suivants existent
      | email                      | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com  | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@clideux.com      | Jean      | PAUL     | 0               | 02000000000000 |

    Et que les echeances de paiement suivantes existent
      | name    | display_name | value |
      | 0_days  | A reception  | 0     |
      | 30_days | 30 Jours     | 30    |
      | 40_days | 40 Jours     | 40    |

    Et que les factures outbound suivantes existent
      | siret          | month   | deadline_name |
      | 02000000000000 | 2019-12 | 30_days       |
      | 02000000000000 | 2019-12 | 40_days       |
      | 02000000000000 | 2020-06 | 0_days        |
      | 03000000000000 | 2019-12 | 40_days       |
      | 03000000000000 | 2020-02 | 30_days       |

  @listerLesFacturesOutboundPourLeSupport
  Scénario: Lister les factures outbound de toutes les entreprises
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de lister les factures outbound de toutes les entreprises
    Alors les factures outbound de toutes les entreprises sont listées

  Scénario: Impossibilité de lister les factures outbound de toutes les entreprises si l'utilisateur connecté n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de lister les factures outbound de toutes les entreprises
    Alors une erreur est levée car l'utilisateur connecté n'est pas support
    