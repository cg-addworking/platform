#language: fr
Fonctionnalité: Generate outbound invoice file
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | access_to_billing |
      | 01000000000000 | Addworking1 | 0           | 0         | 1                 |
      | 02000000000000 | Client2     | 1           | 0         | 1                 |
      | 03000000000000 | Clipresta3  | 1           | 1         | 1                 |
      | 04000000000000 | Client4     | 1           | 0         | 0                 |
      | 05000000000000 | Presta5     | 0           | 1         | 0                 |
      | 06000000000000 | Presta6     | 0           | 1         | 0                 |

    Et les parameters de facturation suivants existent
      | siret          | number |
      | 02000000000000 | 1      |
      | 03000000000000 | 2      |

    Etant donné que les partenariats suivants existent
      | siret_customer | siret_vendor   |
      | 02000000000000 | 05000000000000 |
      | 02000000000000 | 03000000000000 |
      | 03000000000000 | 06000000000000 |
      | 02000000000000 | 06000000000000 |

    Et que les utilisateurs suivants existent
      | email                     | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@clideux.com     | Jean      | PAUL     | 0               | 02000000000000 |

    Et que les echeances de paiement suivantes existent
      | name    | display_name | value |
      | 0_days  | A reception  | 0     |
      | 30_days | 30 Jours     | 30    |
      | 40_days | 40 Jours     | 40    |

    Et que les taux de tva suivants existent
      | name | display_name | value |
      | 20%  | 20%          | 20    |
      | 0%   | 0%           | 0     |

    Et que les factures outbound suivantes existent
      | siret          | number | month   | deadline_name | status          |
      | 02000000000000 | 1      | 12/2019 | 30_days       | fees_calculated |
      | 02000000000000 | 2      | 12/2019 | 40_days       | pending         |
      | 02000000000000 | 3      | 12/2019 | 0_days        | pending         |
      | 03000000000000 | 4      | 12/2019 | 40_days       | pending         |
      | 03000000000000 | 5      | 12/2019 | 30_days       | pending         |
      | 03000000000000 | 6      | 02/2020 | 30_days       | pending         |
      | 03000000000000 | 7      | 03/2020 | 30_days       | validated       |

    Et que les factures inbound suivantes existent
      | siret          | number | month   | deadline_name | status     | siret_customer |
      | 05000000000000 | 1      | 12/2019 | 30_days       | validated  | 02000000000000 |
      | 05000000000000 | 2      | 12/2019 | 40_days       | validated  | 02000000000000 |
      | 05000000000000 | 3      | 12/2019 | 0_days        | associated | 02000000000000 |
      | 05000000000000 | 4      | 12/2019 | 30_days       | validated  | 02000000000000 |
      | 05000000000000 | 5      | 12/2019 | 30_days       | validated  | 02000000000000 |
      | 06000000000000 | 1      | 12/2019 | 30_days       | validated  | 02000000000000 |
      | 06000000000000 | 2      | 01/2020 | 30_days       | validated  | 03000000000000 |

    Et que les lignes factures inbound suivantes existent
      | siret          | number | month   | label   | quantity | unit_price | vat_rate |
      | 05000000000000 | 1      | 12/2019 | AAA     | 1        | 10         | 20       |
      | 05000000000000 | 2      | 12/2019 | AAB     | 2        | 20         | 20       |
      | 05000000000000 | 3      | 12/2019 | AAC     | 3        | 30         | 20       |
      | 05000000000000 | 4      | 12/2019 | AAD     | 1        | 40         | 20       |
      | 05000000000000 | 5      | 12/2019 | AA3     | 5        | 50         | 20       |
      | 06000000000000 | 1      | 12/2019 | BBA     | 1        | 20         | 20       |
      | 06000000000000 | 2      | 01/2020 | BBC     | 2        | 10         | 20       |

    Et que les lignes factures outbound suivantes existent
      | siret_vendor   | inbound_number | month   | outbound_number | label   | quantity | unit_price | vat_rate |
      | 05000000000000 | 1              | 12/2019 | 1               | AAA     | 2        | 20         | 20       |
      | 05000000000000 | 4              | 12/2019 | 4               | AAD     | 1        | 10         | 20       |

    Et les fees suivants existent
      | outbound_number | label | type                    | amount_before_taxes | vat_rate | siret_vendor   | siret_customer |
      | 1               | AAAA  | subscription            | 1000                | 20       | null           | 02000000000000 |
      | 1               | AAAB  | fixed_fees              | 50                  | 20       | 05000000000000 | 02000000000000 |
      | 1               | AAAC  | default_management_fees | 300                 | 20       | 05000000000000 | 02000000000000 |

  @genererLeFichierDeLaFacture
  Scénario: Generer le fichier de la facture
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de generer le fichier de la facture outbound numero "1" de l'entreprise avec le siret "02000000000000"
    Alors le fichier de la facture outbound numero "1" est generé

  Scénario: Impossibilité de generer le fichier de la facture outbound si l'utilisateur connecté n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de generer le fichier de la facture outbound numero "1" de l'entreprise avec le siret "02000000000000"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support

  Scénario: Impossibilité de generer le fichier de la facture outbound si l'entreprise cliente n'a pas accès au module "Facturation"
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de generer le fichier de la facture outbound numero "1" de l'entreprise avec le siret "04000000000000"
    Alors une erreur est levée car l'entreprise n'a pas accès au module facturation

  Scénario: Impossibilité de generer le fichier de la facture outbound si la facture outbound n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de generer le fichier de la facture outbound numero "15" de l'entreprise avec le siret "03000000000000"
    Alors une erreur est levée car la facture outbound n'existe pas

  Scénario: Impossibilité de generer le fichier de la facture outbound si la facture est validée
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de generer le fichier de la facture outbound numero "7" de l'entreprise avec le siret "03000000000000"
    Alors une erreur est levée car la facture est validée
