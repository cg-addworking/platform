#language: fr

  Fonctionnalité: List Inbound Invoices As Customer

    Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | access_to_billing |
      | 01000000000000 | Addworking1 | 0           | 0         | 1                 |
      | 02000000000000 | Client2     | 1           | 0         | 1                 |
      | 03000000000000 | Clipresta3  | 1           | 1         | 1                 |
      | 04000000000000 | Presta4     | 0           | 1         | 1                 |
      | 05000000000000 | Client5     | 1           | 0         | 0                 |
      | 06000000000000 | Presta6     | 0           | 1         | 1                 |
      | 07000000000000 | Presta7     | 0           | 1         | 1                 |

    Et que les utilisateurs suivants existent
      | email                     | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@clideux.com     | Jean      | PAUL     | 0               | 02000000000000 |
      | louis.jacquesl@clipre.com | Louis     | JACQUES  | 0               | 03000000000000 |
      | louis.jacquesl@clipre.com | Louis     | JACQUES  | 0               | 05000000000000 |

    Et que les partenariats suivants existent
      | siret_customer | siret_vendor   | activity_starts_at  |
      | 05000000000000 | 03000000000000 | 2017-01-01 00:00:00 |
      | 02000000000000 | 04000000000000 | 2017-01-01 00:00:00 |
      | 02000000000000 | 06000000000000 | 2017-01-01 00:00:00 |
      | 03000000000000 | 04000000000000 | 2017-01-01 00:00:00 |
      | 03000000000000 | 06000000000000 | 2017-01-01 00:00:00 |

    Et que les echeances de paiement suivantes existent
      | name    | display_name | value |
      | 0_days  | A reception  | 0     |
      | 30_days | 30 Jours     | 30    |
      | 40_days | 40 Jours     | 40    |

    Et que les factures inbound suivantes existent
      | siret          | month   | deadline_name | customer_siret |
      | 04000000000000 | 09/2020 | 40_days       | 03000000000000 |
      | 06000000000000 | 09/2020 | 40_days       | 03000000000000 |
      | 04000000000000 | 09/2020 | 30_days       | 02000000000000 |
      | 03000000000000 | 09/2020 | 0_days        | 05000000000000 |
      | 06000000000000 | 09/2020 | 30_days       | 02000000000000 |

@listerLesFacturesInboundEnTantQueClient
  Scénario: Lister les factures inbound de mes prestataires
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "louis.jacquesl@clipre.com"
    Quand j'essaie de lister les factures inbound de mes prestataires
    Alors les factures inbound de mes prestataires sont listées