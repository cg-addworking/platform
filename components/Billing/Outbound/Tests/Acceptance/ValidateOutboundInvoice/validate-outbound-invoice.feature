#language: fr
Fonctionnalité: validate outbound invoice
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | access_to_billing |
      | 01000000000000 | Addworking1 | 0           | 0         | 1                 |
      | 02000000000000 | Client1     | 1           | 0         | 1                 |

    Et que les utilisateurs suivants existent
      | email                     | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@clideux.com     | Jean      | PAUL     | 0               | 02000000000000 |

    Et que les échéances de paiement suivantes existent
      | name     | display_name | value | description     |
      | 30_jours | 30 jours     | 30    | description_one |
      | 40_jours | 40 jours     | 40    | description_two |

    Et que les factures outbound suivantes existent
      | siret          | number | month   | deadline_name | status          |
      | 02000000000000 | 1      | 2019-12 | 30_days       | fees_calculated |
      | 02000000000000 | 2      | 2019-12 | 40_days       | file_generated  |

  @scenario1
  Scénario: Valider une facture en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de valider la facture numéro "2"
    Alors la facture numéro "2" est validée

  @scenario2
  Scénario: Impossibilité de valider une facture si l'utilisateur connecté n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de valider la facture numéro "2"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support

  @scenario3
  Scénario: Impossibilité de valider une facture si son état est différent de file_generated
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de valider la facture numéro "1"
    Alors une erreur est levée car son état est différent de file_generated