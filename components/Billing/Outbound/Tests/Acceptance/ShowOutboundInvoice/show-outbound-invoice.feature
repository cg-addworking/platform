#language: fr
Fonctionnalité: Show outbound invoice
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | access_to_billing |
      | 01000000000000 | Addworking1 | 0           | 0         | 1                 |
      | 02000000000000 | Client2     | 1           | 0         | 1                 |
      | 03000000000000 | Clipresta3  | 1           | 1         | 1                 |
      | 04000000000000 | Client4     | 1           | 0         | 0                 |

    Et que les utilisateurs suivants existent
      | email                     | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@clideux.com     | Jean      | PAUL     | 0               | 02000000000000 |

    Et que les echeances de paiement suivantes existent
      | name    | display_name | value |
      | 0_days  | A reception  | 0     |
      | 30_days | 30 Jours     | 30    |
      | 40_days | 40 Jours     | 40    |

    Et que les factures outbound suivantes existent
      | siret          | number | month   | deadline_name | status          |
      | 02000000000000 | 1      | 2019-12 | 30_days       | fees_calculated |
      | 02000000000000 | 2      | 2019-12 | 40_days       | pending         |
      | 02000000000000 | 3      | 2019-12 | 0_days        | pending         |
      | 03000000000000 | 4      | 2019-12 | 40_days       | pending         |

  @visualiserLeFichierDeLaFacture
  Scénario: Visualiser les informations de la facture
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de visualiser les informations de la facture numero "1" de l'entreprise avec le siret "02000000000000"
    Alors les details de la facture outbound numero "1" sont affichés

  Scénario: Impossibilité de visualiser les informations de la facture si l'entreprise cliente n'a pas accès au module "Facturation"
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de visualiser les informations de la facture numero "1" de l'entreprise avec le siret "04000000000000"
    Alors une erreur est levée car l'entreprise n'a pas accès au module facturation

  Scénario: Impossibilité de visualiser les informations de la facture si la facture outbound n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de visualiser les informations de la facture numero "7" de l'entreprise avec le siret "03000000000000"
    Alors une erreur est levée car la facture outbound n'existe pas

  Scénario: Impossibilité de visualiser les informations de la facture d'une entreprise si l'utilisateur connecté n'est pas de cette entreprise
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de visualiser les informations de la facture numero "4" de l'entreprise avec le siret "03000000000000"
    Alors une erreur est levée car l'utilisateur connecté n'est pas membre de l'entreprise
