#language: fr

Fonctionnalité: Create received payment
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

    Et que les ibans suivants existent
      | status   | siret          |
      | approved | 01000000000000 |

    Et que l'echeance de paiement suivante existe
      | name    | display_name | value |
      | 0_days  | A reception  | 0     |

    Et que la facture outbound suivante existe
      | siret          | number | month   | deadline_name | status  |
      | 02000000000000 | 1      | 01/2020 | 0_days        | pending |

@creerUneNotificationDeFondsRecus
  Scénario: Créer une notification de fonds reçus
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de créer une notification de fonds reçus pour l'entreprise avec siret "02000000000000" avec la facture outbound numero "1"
    Alors la notification de fonds reçus est créée

  Scénario: Impossibilité de créer une notification de fonds reçus si l'utilisateur connecté n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@cliprestadeux.com"
    Quand j'essaie de créer une notification de fonds reçus pour l'entreprise avec siret "02000000000000" avec la facture outbound numero "1"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support
