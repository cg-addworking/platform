#language: fr

Fonctionnalité: Calculate Addworking Fees
    Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | access_to_billing |
      | 01000000000000 | Addworking1 | 0           | 0         | 1                 |
      | 02000000000000 | Client2     | 1           | 0         | 1                 |
      | 03000000000000 | Clipresta3  | 1           | 1         | 1                 |
      | 04000000000000 | Client4     | 1           | 0         | 1                 |
      | 05000000000000 | Client5     | 1           | 0         | 0                 |
      | 06000000000000 | Presta6     | 0           | 1         | 0                 |
      | 07000000000000 | Presta7     | 0           | 1         | 0                 |

    Etant donné que les partenariats suivants existent
      | siret_customer | siret_vendor   |
      | 02000000000000 | 03000000000000 |
      | 02000000000000 | 06000000000000 |
      | 03000000000000 | 07000000000000 |
      | 04000000000000 | 07000000000000 |

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
      | siret          | number | month   | deadline_name | status          |
      | 02000000000000 | 5      | 12/2019 | 30_days       | pending         |
      | 02000000000000 | 2      | 12/2019 | 40_days       | fees_calculated |
      | 03000000000000 | 1      | 02/2020 | 30_days       | pending         |
      | 04000000000000 | 3      | 07/2019 | 0_days        | pending         |
      | 03000000000000 | 6      | 02/2020 | 30_days       | validated       |

    Et que les taux de tva suivants existent
      | name | display_name | value |
      | 20%  | 20%          | 0.2   |
      | 0%   | 0%           | 0     |

    Et que les factures inbound suivantes existent
      | siret          | number | month   | deadline_name | status     | siret_customer |
      | 03000000000000 | 132    | 12/2019 | 30_days       | validated  | 02000000000000 |
      | 07000000000000 | 173    | 02/2020 | 30_days       | validated  | 03000000000000 |
      | 07000000000000 | 174    | 07/2019 | 30_days       | validated  | 04000000000000 |

    Et que les lignes factures inbound suivantes existent
      | siret          | number | month   | label   | quantity | unit_price | vat_rate |
      | 03000000000000 | 132    | 12/2019 | AAA     | 1        | 10         | 0        |
      | 03000000000000 | 132    | 12/2019 | AAB     | 2        | 20         | 20       |
      | 07000000000000 | 173    | 02/2020 | AAC     | 3        | 30         | 20       |
      | 07000000000000 | 174    | 07/2019 | AAD     | 1        | 10         | 20       |

    Et que les lignes factures outbound suivantes existent
      | siret_vendor   | inbound_number | month   | siret_customer | outbound_number | label | quantity | unit_price | vat_rate |
      | 03000000000000 | 132            | 12/2019 | 02000000000000 | 5               | AAA   | 1        | 10         | 0        |
      | 03000000000000 | 132            | 12/2019 | 02000000000000 | 5               | AAB   | 2        | 20         | 20       |
      | 07000000000000 | 173            | 02/2020 | 03000000000000 | 1               | AAC   | 3        | 30         | 20       |
      | 07000000000000 | 174            | 07/2019 | 04000000000000 | 3               | AAD   | 1        | 10         | 20       |

    Et que les paramètres de facturation suivants existent
      | siret          | parameter_analytic_code | default_management_fees_by_vendor | custom_management_fees_by_vendor | fixed_fees_by_vendor_amount | subscription_amount | number |
      | 02000000000000 | ADD-02                  | 0                                 | 0.5                              | 79                          | 3000                | 1      |
      | 03000000000000 | ADD-03                  | 0.2                               | 0                                | 42                          | 1000                | 2      |

@calculerLesCommissionsAddworking
    Scénario: Calculer les commissions Addworking
      Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
      Quand j'essaie de calculer les commissions Addworking de la facture outbound numero "1" de l'entreprise avec le siret "03000000000000"
      Alors les commissions Addworking de la facture outbound numero "1" de l'entreprise avec le siret "03000000000000" sont calculées

    Scénario: Impossibilité de calculer les commissions Addworking si l'entreprise cliente n'a pas accès au module facturation
      Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
      Quand j'essaie de calculer les commissions Addworking de la facture outbound numero "12" de l'entreprise avec le siret "05000000000000"
      Alors une erreur est levée car l'entreprise n'a pas accès au module facturation

    Scénario: Impossibilité de calculer les commissions Addworking si l'utilisateur connecté n'est pas support
      Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
      Quand j'essaie de calculer les commissions Addworking de la facture outbound numero "5" de l'entreprise avec le siret "02000000000000"
      Alors une erreur est levée car l'utilisateur connecté n'est pas support

    Scénario: Impossibilité de calculer les commissions Addworking si la facture outbound n'existe pas
      Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
      Quand j'essaie de calculer les commissions Addworking de la facture outbound numero "42" de l'entreprise avec le siret "04000000000000"
      Alors une erreur est levée car la facture outbound n'existe pas

    Scénario: Impossibilité de calculer les commissions Addworking si la facture outbound n'est pas au statut en attente
      Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
      Quand j'essaie de calculer les commissions Addworking de la facture outbound numero "2" de l'entreprise avec le siret "02000000000000"
      Alors une erreur est levée car la facture outbound n'est pas au statut en attente

    Scénario: Impossibilité de calculer les commissions Addworking si les paramètres de facturation de l'entreprise cliente ne sont pas renseignés
      Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
      Quand j'essaie de calculer les commissions Addworking de la facture outbound numero "3" de l'entreprise avec le siret "04000000000000"
      Alors une erreur est levée car l'entreprise n'a pas de paramètres de facturation renseignés

  Scénario: Impossibilité de calculer les commissions Addworking si la facture est validée
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de calculer les commissions Addworking de la facture outbound numero "6" de l'entreprise avec le siret "03000000000000"
    Alors une erreur est levée car la facture est validée