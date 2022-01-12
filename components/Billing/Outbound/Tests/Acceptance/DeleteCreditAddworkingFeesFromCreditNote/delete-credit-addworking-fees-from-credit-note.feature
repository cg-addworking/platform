#language: fr

  Fonctionnalité: Delete Credit Addworking Fees From Credit Note

  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | access_to_billing |
      | 01000000000000 | Addworking1 | 0           | 0         | 1                 |
      | 02000000000000 | Client2     | 1           | 0         | 0                 |
      | 03000000000000 | Clipresta3  | 1           | 1         | 1                 |

    Et que les utilisateurs suivants existent
      | email                        | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com    | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@cliprestatrois.com | Jean      | PAUL     | 0               | 03000000000000 |

    Et que l'echeance de paiement suivante existe
       | name    | display_name | value |
       | 0_days  | A reception  | 0     |

    Et que les factures outbound suivantes existent
      | number | siret          | month   | deadline_name | status  | parent_number |
      | 1      | 03000000000000 | 05/2020 | 0_days        | paid    | null          |
      | 3      | 03000000000000 | 05/2020 | 0_days        | pending | 1             |
      | 5      | 03000000000000 | 05/2020 | 0_days        | paid    | 1             |

    Et que le taux de tva suivant existe
      | name       | display_name | value |
      | vat_rat_20 | 20%          | 0.2   |

    Et les parameters de facturation suivants existent
      | siret          | number |
      | 03000000000000 | 1      |

    Et que les commissions de facture outbound suivantes existent
      | number | outbound_number | label | type         | amount_before_taxes | vat_rate | siret_vendor | siret_customer | parent_number |
      | 2      | 1               | AAAA  | subscription | 1000                | 0.2      | null         | 03000000000000 | null          |
      | 4      | 3               | AAAB  | subscription | -1000               | 0.2      | null         | 03000000000000 | 2             |
      | 6      | 5               | AAAC  | subscription | -1000               | 0.2      | null         | 03000000000000 | 2             |

 @supprimerUneCommissionDAvoirDUneFactureDAvoir
  Scénario: Supprimer une commission d'avoir d'une facture d'avoir
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de supprimer la commission d'avoir numéro "4" de la facture d'avoir "3"
    Alors la commission d'avoir numéro "4" est supprimée de la facture d'avoir

   Scénario: Impossibilité de supprimer une commission d'avoir si l'utilisateur connecté n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@cliprestatrois.com"
    Quand j'essaie de supprimer la commission d'avoir numéro "4" de la facture d'avoir "3"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support

   Scénario: Impossibilité de supprimer une commission d'avoir si la facture d'avoir n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de supprimer la commission d'avoir numéro "4" de la facture d'avoir "42"
    Alors une erreur est levée car la facture d'avoir n'existe pas

 Scénario: Impossibilité de supprimer une commission d'avoir si la facture d'avoir est au statut payee
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de supprimer la commission d'avoir numéro "6" de la facture d'avoir "5"
    Alors une erreur est levée car la facture d'avoir est au statut payée

   Scénario: Impossibilité de supprimer une commission d'avoir si la commission d'avoir n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de supprimer la commission d'avoir numéro "42" de la facture d'avoir "3"
    Alors une erreur est levée car la commission d'avoir n'existe pas 