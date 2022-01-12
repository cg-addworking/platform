#language: fr

  Fonctionnalité: List Outbound Invoice

    Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | access_to_billing |
      | 01000000000000 | Addworking1 | 0           | 0         | 1                 |
      | 02000000000000 | Client2     | 1           | 0         | 1                 |
      | 03000000000000 | Clipresta3  | 1           | 1         | 1                 |
      | 04000000000000 | Client4     | 1           | 0         | 0                 |

    Et que les utilisateurs suivants existent
      | email                      | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com  | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@clitrois.com     | Jean      | PAUL     | 0               | 03000000000000 |
      | louis.jacquesl@cliqua.com  | Louis     | JACQUES  | 0               | 04000000000000 |

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

  @listerLesFacturesOutbound
  Scénario: Lister les factures outbound d'une entreprise en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de lister les factures outbound de l'entreprise avec le siret "02000000000000"
    Alors les factures outbound de l'entreprise avec le siret "02000000000000" sont listées

  Scénario: Lister les factures outbound d'une entreprise en tant que membre de cette entreprise
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clitrois.com"
    Quand j'essaie de lister les factures outbound de l'entreprise avec le siret "03000000000000"
    Alors les factures outbound de l'entreprise avec le siret "03000000000000" sont listées

  Scénario: Impossibilité de lister les factures outbound si l'entreprise n'a pas accès au module facturation
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "louis.jacquesl@cliqua.com"
    Quand j'essaie de lister les factures outbound de l'entreprise avec le siret "04000000000000"
    Alors une erreur est levée car l'entreprise avec le siret "04000000000000" n'a pas accès au module facturation

  Scénario: Impossibilité de lister les factures outbound d'une entreprise si l'utilisateur connecté n'est pas de cette entreprise
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clitrois.com"
    Quand j'essaie de lister les factures outbound de l'entreprise avec le siret "02000000000000"
    Alors une erreur est levée car l'utilisateur connecté n'est pas de l'entreprise avec le siret "02000000000000"
    