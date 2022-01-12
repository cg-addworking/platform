#language: fr
Fonctionnalité: Edit payment order
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | access_to_billing |
      | 01000000000000 | Addworking1 | 0           | 0         | 1                 |
      | 02000000000000 | Client2     | 1           | 0         | 1                 |
      | 03000000000000 | Clipresta3  | 1           | 1         | 1                 |
      | 04000000000000 | Client4     | 1           | 0         | 0                 |

    Et que les ibans suivants existent
      | status   | siret          |
      | approved | 01000000000000 |

    Et que les paramètres de facturation suivants existent
      | siret          | parameter_analytic_code | default_management_fees_by_vendor | custom_management_fees_by_vendor | fixed_fees_by_vendor_amount | subscription_amount | number |
      | 02000000000000 | ADD-02                  | 0                                 | 0.5                              | 79                          | 3000                | 1      |
      | 03000000000000 | ADD-03                  | 0.2                               | 0                                | 42                          | 1000                | 2      |

    Et que les utilisateurs suivants existent
      | email                     | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@clideux.com     | Jean      | PAUL     | 0               | 02000000000000 |

    Et que les ordres de paiement suivants existent
      | number | siret_customer | status  |
      | 2      | 02000000000000 | created |
      | 3      | 02000000000000 | paid    |

  @genererLOrdreDePaiementDeLaFacture
  Scénario: Modifier l'ordre de paiement
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de modifier l'ordre de paiement numero "2"
    Alors l'ordre de paiement numero "2" est modifié

  Scénario: Impossibilité de modifier un ordre de paiement si l'utilisateur connecté n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de modifier l'ordre de paiement numero "2"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support

  Scénario: Impossibilité de modifier un ordre de paiement si l'ordre de paiement n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de modifier l'ordre de paiement numero "12"
    Alors une erreur est levée car la facture outbound n'existe pas
