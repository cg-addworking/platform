#language: fr

 Fonctionnalité: Create Outbound Invoice

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

 @creerUneFactureOutbound
  Scénario: Créer une facture outbound pour une entreprise customer
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de créer une facture outbound pour l'entreprise avec siret "03000000000000"
    Alors la facture outbound pour l'entreprise avec siret "03000000000000" est créée

  Scénario: Créer une facture outbound pour une entreprise customer et vendor
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de créer une facture outbound pour l'entreprise avec siret "04000000000000"
    Alors la facture outbound pour l'entreprise avec siret "04000000000000" est créée

   Scénario: Impossibilité de créer une facture outbound si l'entreprise cliente n'a pas accès au module facturation
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de créer une facture outbound pour l'entreprise avec siret "02000000000000"
    Alors une erreur est levée car l'entreprise n'a pas accès au module facturation

   Scénario: Impossibilité de créer une facture outbound si l'utilisateur connecté n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clitrois.com"
    Quand j'essaie de créer une facture outbound pour l'entreprise avec siret "03000000000000"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support
