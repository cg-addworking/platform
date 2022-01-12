#language: fr
Fonctionnalité: delete Received Payment
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name       | is_customer | is_vendor | access_to_billing |
      | 01000000000000 | Addworking | 0           | 0         | 1                 |
      | 02000000000000 | Client_2   | 1           | 0         | 1                 |
      | 03000000000000 | Client_3   | 1           | 0         | 1                 |

    Et que les utilisateurs suivants existent
      | email                      | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com  | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@clideux.com      | Jean      | PAUL     | 0               | 02000000000000 |
      | alex.nico@cltrois.com      | Alex      | Nico     | 0               | 03000000000000 |

    Et que les ibans suivants existent
      | status   | siret          |
      | approved | 01000000000000 |

    Et que les paiements reçus suivants existent
      | number | siret_addworking_for_iban | siret          |
      | 1      | 01000000000000            | 02000000000000 |
      | 2      | 01000000000000            | 03000000000000 |

  @scenario1
  Scénario: supprimer un paiement reçu en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de supprimer le paiement reçu numéro "1"
    Alors le paiement reçu numéro "1" est supprimé

  @scenario2
  Scénario: Impossibilité de supprimer le paiement reçu si l'utilisateur connecté n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de supprimer le paiement reçu numéro "1"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support

  @scenario3
  Scénario: Impossibilité de supprimer le paiement reçu s'il n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de supprimer le paiement reçu numéro "42"
    Alors une erreur est levée car le paiement reçu n'existe pas