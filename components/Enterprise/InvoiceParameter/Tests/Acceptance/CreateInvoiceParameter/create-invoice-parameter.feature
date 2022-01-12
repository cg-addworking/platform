#language: fr
Fonctionnalité: Creer un parametre de facturation

  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | access_to_billing |
      | 01000000000000 | Addworking1 | 0           | 0         | 1                 |
      | 02000000000000 | Client2     | 1           | 0         | 1                 |

    Et que les ibans suivants existent
      | status   | siret          |
      | approved | 01000000000000 |
      | approved | 02000000000000 |

    Et que les échéances de paiement suivantes existent
      | name     | display_name |
      | 30_jours | 30 jours     |

    Et que les utilisateurs suivants existent
      | email                     | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@cli.com         | Jean      | PAUL     | 0               | 02000000000000 |

  @scenario1
  Scénario: Creer un parametre de facturation d'une entreprise en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de creer un parametre de facturation de l'entreprise avec le siret "02000000000000"
    Alors les parametres de facturation sont créé

  @scenario2
  Scénario: Impossibilité de creer un parametre de facturation si l'utilisateur connecté n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@cli.com"
    Quand j'essaie de creer un parametre de facturation de l'entreprise avec le siret "02000000000000"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support
