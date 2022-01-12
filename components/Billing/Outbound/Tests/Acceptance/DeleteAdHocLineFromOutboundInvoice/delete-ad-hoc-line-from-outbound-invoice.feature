#language: fr

  Fonctionnalité: Delete Ad Hoc Line From Outbound Invoice

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

    Et que la facture outbound suivante existe
      | number | siret          | month   | deadline_name | status  |
      | 1      | 03000000000000 | 05/2020 | 0_days        | pending |
      | 3      | 03000000000000 | 05/2020 | 0_days        | paid    |

    Et que le taux de tva suivant existe
      | name       | display_name | value |
      | vat_rat_20 | 20%          | 0.2   |

    Et que la ligne ad-hoc de facture outbound suivante existe
      | siret_customer | outbound_number | label | quantity | unit_price | vat_rate | number |
      | 03000000000000 | 1               | XXX   | 1        | 10         | 0.2      | 2      |
      | 03000000000000 | 3               | YYY   | 2        | 20         | 0.2      | 4      |

@supprimerUneLigneAdHocDUneFactureAddworking
  Scénario: Supprimer une ligne ad-hoc d'une facture Addworking
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de supprimer la ligne ad-hoc numéro "2" de la facture outbound "1"
    Alors la ligne ad-hoc est supprimée de la facture outbound "1"

  Scénario: Impossibilité de supprimer une ligne ad-hoc si l'utilisateur connecté n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@cliprestatrois.com"
    Quand j'essaie de supprimer la ligne ad-hoc numéro "2" de la facture outbound "1"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support

  Scénario: Impossibilité de supprimer une ligne ad-hoc si la facture outbound n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de supprimer la ligne ad-hoc numéro "2" de la facture outbound "42"
    Alors une erreur est levée car la facture outbound n'existe pas

Scénario: Impossibilité de supprimer une ligne ad-hoc si la facture outbound est au statut payee
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de supprimer la ligne ad-hoc numéro "4" de la facture outbound "3"
    Alors une erreur est levée car la facture outbound est au statut payée

  Scénario: Impossibilité de supprimer une ligne ad-hoc si la ligne outbound n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de supprimer la ligne ad-hoc numéro "42" de la facture outbound "1"
    Alors une erreur est levée car la ligne outbound n'existe pas