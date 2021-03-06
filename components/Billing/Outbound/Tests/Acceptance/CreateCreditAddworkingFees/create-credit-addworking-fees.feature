#language: fr

Fonctionnalit√©: Create credit addworking fees
  Contexte:
    Etant donn√© que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | access_to_billing |
      | 01000000000000 | Addworking1 | 0           | 0         | 1                 |
      | 02000000000000 | Clipresta2  | 1           | 1         | 1                 |
      | 03000000000000 | Cli3        | 1           | 1         | 0                 |
      | 04000000000000 | Presta4     | 0           | 1         | 1                 |

    Et que les utilisateurs suivants existent
      | email                       | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com   | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@cliprestadeux.com | Jean      | PAUL     | 0               | 02000000000000 |

    Et que l'echeance de paiement suivante existe
      | name    | display_name | value |
      | 0_days  | A reception  | 0     |

    Et que les factures outbound suivantes existent
      | siret          | number | month   | deadline_name | status  | parent |
      | 02000000000000 | 1      | 01/2020 | 0_days        | pending | null   |
      | 02000000000000 | 2      | 01/2020 | 0_days        | pending | 1      |

    Et que le taux de tva suivant existe
      | name | display_name | value |
      | 20%  | 20%          | 0.2   |

    Et que la facture inbound suivante existe
      | siret          | number | month   | deadline_name | status     | siret_customer |
      | 04000000000000 | 69     | 01/2020 | 0_days        | validated  | 02000000000000 |

    Et que la ligne de facture inbound suivante existe
      | siret          | number | month   | label   | quantity | unit_price | vat_rate |
      | 04000000000000 | 69     | 01/2020 | AAA     | 1        | 10         | 0.2       |

    Et que la ligne de facture outbound suivante existe
      | siret_vendor   | inbound_number | month   | siret_customer | outbound_number | label | quantity | unit_price | vat_rate | number |
      | 04000000000000 | 69             | 01/2020 | 02000000000000 | 1               | AAA   | 1        | 10         | 20       | 1      |

    Et que le param√®tre de facturation suivant existe
      | siret          | parameter_analytic_code | default_management_fees_by_vendor | custom_management_fees_by_vendor | fixed_fees_by_vendor_amount | subscription_amount | number |
      | 02000000000000 | ADD-02                  | 0                                 | 0.2                              | 42                          | 1500                | 1      |

    Et que les commissions Addworking suivantes existent
      | outbound_number | invoice_parameter_by_siret | vat_rate | siret_customer | outbound_item_number | siret_vendor   | type                   | amount_before_taxes | number |
      | 1               | 02000000000000             | 0.2      | 02000000000000 | 1                    | 04000000000000 | custom_management_fees | 20                  | 1      |
      | 1               | 02000000000000             | 0.2      | 02000000000000 | null                 | 04000000000000 | fixed_fees             | 42                  | 2      |

@creerUneCommissionDAvoir
  Sc√©nario: Cr√©er une commission d'avoir
    Etant donn√© que je suis authentifi√© en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de cr√©er la ligne d'avoir de la commission numero "1" pour la facture outbound numero "2"
    Alors la ligne d'avoir pour la commission num√©ro "1" est cr√©√©e

  Sc√©nario: Impossibilit√© de cr√©er une commission d'avoir si l'utilisateur connect√© n'est pas support
    Etant donn√© que je suis authentifi√© en tant que utilisateur avec l'email "jean.paul@cliprestadeux.com"
    Quand j'essaie de cr√©er la ligne d'avoir de la commission numero "1" pour la facture outbound numero "2"
    Alors une erreur est lev√©e car l'utilisateur connect√© n'est pas support

  Sc√©nario: Impossibilit√© de cr√©er une commission d'avoir si l'entreprise n'a pas acc√®s au module facturation
    Etant donn√© que je suis authentifi√© en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de cr√©er la ligne d'avoir de la commission numero "1" pour la facture outbound numero "2"
    Alors une erreur est lev√©e car l'entreprise n'a pas acces au module facturation

  Sc√©nario: Impossibilit√© de cr√©er une commission d'avoir si la commission n'existe pas
    Etant donn√© que je suis authentifi√© en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de cr√©er la ligne d'avoir de la commission numero "42" pour la facture outbound numero "2"
    Alors une erreur est lev√©e car la ligne de commission n'existe pas