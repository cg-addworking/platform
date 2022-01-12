#language: fr

  Fonctionnalité: Edit Received Payment

    Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | access_to_billing |
      | 01000000000000 | Addworking1 | 0           | 0         | 1                 |
      | 02000000000000 | Client2     | 1           | 0         | 1                 |

    Et que les utilisateurs suivants existent
      | email                      | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com  | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@clideux.com      | Jean      | PAUL     | 0               | 02000000000000 |

    Et que les ibans suivants existent
      | status   | siret          |
      | approved | 01000000000000 |

    Et que les echeances de paiement suivantes existent
      | name    | display_name | value |
      | 0_days  | A reception  | 0     |

    Et que les factures addworking suivantes existent
      | siret_customer | number | month   | deadline_name | status  |
      | 02000000000000 | 2      | 2020-06 | 0_days        | pending |

    Et que les paiements reçus suivants existent
      | number | siret_addworking_for_iban | siret          |
      | 1      | 01000000000000            | 02000000000000 |

  @modifierLesPaiementsRecus
  Scénario: Modifier les paiements reçus pour une facture addworking
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de modifier le paiement reçu numéro "1"
    Alors le paiement reçu numéro "1" est modifié

  Scénario: Impossibilité de modifier le paiement reçu si l'utilisateur connecté n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de modifier le paiement reçu numéro "1"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support

  Scénario: Impossibilité de modifier le paiement reçu si le paiement reçu n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de modifier le paiement reçu numéro "42"
    Alors une erreur est levée car le paiement reçu n'existe pas