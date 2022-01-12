#language: fr

Fonctionnalité: Create credit note
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | access_to_billing |
      | 01000000000000 | Addworking1 | 0           | 0         | 1                 |
      | 02000000000000 | Clipresta2  | 1           | 1         | 1                 |
      | 03000000000000 | Cli3        | 1           | 1         | 0                 |

    Et que les utilisateurs suivants existent
      | email                       | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com   | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@cliprestadeux.com | Jean      | PAUL     | 0               | 02000000000000 |

    Et que l'echeance de paiement suivante existe
      | name    | display_name | value |
      | 0_days  | A reception  | 0     |

    Et que la facture outbound suivante existe
      | siret          | number | month   | deadline_name | status  |
      | 02000000000000 | 1      | 01/2020 | 0_days        | pending |

@creerUneFactureDAvoir
  Scénario: Créer une facture d'avoir
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de créer une facture d'avoir pour la facture outbound numero "1" 
    Alors la facture d'avoir pour la facture outbound numero "1" est créée

  Scénario: Impossibilité de créer une facture d'avoir si l'utilisateur connecté n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@cliprestadeux.com"
    Quand j'essaie de créer une facture d'avoir pour la facture outbound numero "1" 
    Alors une erreur est levée car l'utilisateur connecté n'est pas support

  Scénario: Impossibilité de créer une facture d'avoir si l'entreprise n'a pas accès au module facturation
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de créer une facture d'avoir pour la facture outbound numero "1" 
    Alors une erreur est levée car l'entreprise n'a pas acces au module facturation

  Scénario: Impossibilité de créer une facture d'avoir si la facture outbound n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de créer une facture d'avoir pour la facture outbound numero "42" 
    Alors une erreur est levée car la facture outbound n'existe pas
