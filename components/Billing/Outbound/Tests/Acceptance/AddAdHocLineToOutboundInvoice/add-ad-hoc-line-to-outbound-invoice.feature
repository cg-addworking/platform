#language: fr

  Fonctionnalité: Add Ad Hoc Line To Outbound Invoice

  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | access_to_billing |
      | 01000000000000 | Addworking1 | 0           | 0         | 1                 |
      | 02000000000000 | Client2     | 1           | 0         | 0                 |
      | 03000000000000 | Client3     | 1           | 0         | 1                 |
      | 04000000000000 | Clipresta4  | 1           | 1         | 1                 |

    Et que les utilisateurs suivants existent
      | email                      | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com  | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@clitrois.com     | Jean      | PAUL     | 0               | 03000000000000 |

    Et que les echeances de paiement suivantes existent
       | name    | display_name | value |
       | 0_days  | A reception  | 0     |
       | 30_days | 30 Jours     | 30    |
       | 40_days | 40 Jours     | 40    |

    Et que les factures outbound suivantes existent
      | number | siret          | month   | deadline_name | status    |
      | 041    | 04000000000000 | 2019-12 | 30_days       | pending   |
      | 032    | 03000000000000 | 2020-01 | 40_days       | pending   |
      | 033    | 03000000000000 | 2020-06 | 0_days        | validated |

    Et que les taux de tva suivants existent
      | name | display_name | value |
      | 20%  | 20%          | 20    |
      | 0%   | 0%           | 0     |

@ajouterUneLigneDeFactureAdhocAUneOutbound
  Scénario: Ajouter une ligne de facture ad-hoc à une facture outbound
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie d'ajouter une ligne de facture ad-hoc pour la facture outbound avec le numéro "041" de l'entreprise avec le siret "04000000000000"
    Alors la ligne de facture ad-hoc pour la facture outbound avec le numéro "041" est créée

   Scénario: Impossibilité d'ajouter une ligne de facture ad-hoc si l'entreprise cliente n'a pas accès au module facturation
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie d'ajouter une ligne de facture ad-hoc pour la facture outbound avec le numéro "025" de l'entreprise avec le siret "02000000000000"
    Alors une erreur est levée car l'entreprise n'a pas accès au module facturation

   Scénario: Impossibilité d'ajouter une ligne de facture ad-hoc si l'utilisateur connecté n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clitrois.com"
    Quand j'essaie d'ajouter une ligne de facture ad-hoc pour la facture outbound avec le numéro "032" de l'entreprise avec le siret "03000000000000"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support

   Scénario: Impossibilité d'ajouter une ligne de facture ad-hoc si la facture outbound n'est pas au statut en attente
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie d'ajouter une ligne de facture ad-hoc pour la facture outbound avec le numéro "033" de l'entreprise avec le siret "03000000000000"
    Alors une erreur est levée car la facture outbound n'est pas au statut en attente

   Scénario: Impossibilité d'ajouter une ligne de facture ad-hoc si la facture outbound n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie d'ajouter une ligne de facture ad-hoc pour la facture outbound avec le numéro "034" de l'entreprise avec le siret "03000000000000"
    Alors une erreur est levée car la facture outbound n'existe pas
