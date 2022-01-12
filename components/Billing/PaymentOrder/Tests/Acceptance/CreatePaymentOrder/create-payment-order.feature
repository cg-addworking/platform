#language: fr
Fonctionnalité: Generate payment order
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

  @genererLOrdreDePaiementDeLaFacture
  Scénario: Creer l'ordre de paiement
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de creer un ordre de paiement pour l'entreprise avec le siret "02000000000000"
    Alors l'ordre de paiement est creé

  Scénario: Impossibilité de creer un ordre de paiement pour la facture outbound si l'utilisateur connecté n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de creer un ordre de paiement pour l'entreprise avec le siret "02000000000000"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support

  Scénario: Impossibilité de creer un ordre de paiement pour la facture outbound si l'entreprise cliente n'a pas accès au module "Facturation"
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de creer un ordre de paiement pour l'entreprise avec le siret "04000000000000"
    Alors une erreur est levée car l'entreprise n'a pas accès au module facturation