#language: fr
Fonctionnalité: modifier un paramétre de facturation
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name       | is_customer | is_vendor | access_to_billing |
      | 01000000000000 | Addworking | 0           | 0         | 1                 |
      | 02000000000000 | Client     | 1           | 0         | 1                 |

    Et que les utilisateurs suivants existent
      | email                     | firstname | lastname | is_system_admin | enterprise_siret  |
      | antoine.pierre@addwun.com | Antoine   | PIERRE   | 1               | 01000000000000    |
      | jean.paul@cli.com         | Jean      | PAUL     | 0               | 02000000000000    |

    Et que les ibans suivants existent
      | status   | enterprise_siret | iban                        | bic      | label     |
      | approved | 01000000000000   | FR7630003005600002071482421 | SOGEFRPP | label_one |
      | approved | 02000000000000   | FR7630003005710002012411584 | SOGEFRPP | label_two |

    Et que les échéances de paiement suivantes existent
      | name     | display_name | value | description     |
      | 30_jours | 30 jours     | 30    | description_one |
      | 40_jours | 40 jours     | 40    | description_two |

    Et que les paraméters de facturation suivants existent
      | number | enterprise_siret | invoicing_from_inbound_invoice | vendor_creating_inbound_invoice_items | fixed_fees_by_vendor_amount | subscription_amount |
      | 1      | 02000000000000   | 0                              | 0                                     | 1                           | 215                 |
      | 2      | 02000000000000   | 1                              | 1                                     | 2                           | 315                 |

  @scenario1
  Scénario: Modifier un paramétre de facturation d'une entreprise en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de modifier le paramétre de facturation numéro "1" de l'entreprise avec le siret "02000000000000"
    Alors le paramétre de facturation numéro "1" est modifié

  @scenario2
  Scénario: Impossibilité de modifier un paramétre de facturation si l'utilisateur connecté n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@cli.com"
    Quand j'essaie de modifier le paramétre de facturation numéro "2" de l'entreprise avec le siret "02000000000000"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support

  @scenario3
  Scénario: Impossibilité de modifier un paramétre de facturation s'il n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de modifier le paramétre de facturation numéro "15" de l'entreprise avec le siret "02000000000000"
    Alors une erreur est levée car le paramétre de facturation il n'existe pas
