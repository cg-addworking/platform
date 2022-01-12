#language: fr
Fonctionnalité: Dissociate inbound invoice from outbound invoice
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | access_to_billing |
      | 01000000000000 | Addworking1 | 0           | 0         | 1                 |
      | 02000000000000 | Client2     | 1           | 0         | 1                 |
      | 03000000000000 | Clipresta3  | 1           | 1         | 1                 |
      | 04000000000000 | Client4     | 1           | 0         | 0                 |
      | 05000000000000 | Presta5     | 0           | 1         | 0                 |
      | 06000000000000 | Presta6     | 0           | 1         | 0                 |

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
      | 02000000000000 | 1      | 2019-12 | 30_days       | pending         |
      | 02000000000000 | 2      | 2019-12 | 40_days       | fees_calculated |
      | 02000000000000 | 3      | 2019-12 | 0_days        | pending         |
      | 03000000000000 | 4      | 2019-12 | 40_days       | pending         |
      | 03000000000000 | 5      | 2019-12 | 30_days       | pending         |
      | 03000000000000 | 6      | 2020-02 | 30_days       | pending         |

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

  @dissocierUneFactureInboundDepuisFactureOutbound
  Scénario: Dissocier une facture inbound depuis une facture outbound
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de dissocier la facture inbound de l'entreprise avec le siret "05000000000000" numero "1" periode "12/2019" depuis la facture outbound de l'entreprise avec le siret "02000000000000" numero "1"
    Alors la facture inbound de l'entreprise avec le siret "05000000000000" numero "1" periode "12/2019" est dessocie de la facture outbound numero "1"

  Scénario: Impossibilité de dissocier une facture inbound depuis une facture outbound si l'utilisateur connecté n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de dissocier la facture inbound de l'entreprise avec le siret "05000000000000" numero "1" periode "12/2019" depuis la facture outbound de l'entreprise avec le siret "02000000000000" numero "1"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support

  Scénario: Impossibilité de dissocier une facture inbound depuis une facture outbound si l'entreprise cliente n'a pas accès au module "Facturation"
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de dissocier la facture inbound de l'entreprise avec le siret "05000000000000" numero "1" periode "12/2019" depuis la facture outbound de l'entreprise avec le siret "04000000000000" numero "1"
    Alors une erreur est levée car l'entreprise n'a pas accès au module facturation

  Scénario: Impossibilité de dissocier une facture inbound depuis une facture outbound si le client n'a pas de partenariat avec le prestataire
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de dissocier la facture inbound de l'entreprise avec le siret "05000000000000" numero "1" periode "12/2019" depuis la facture outbound de l'entreprise avec le siret "03000000000000" numero "2"
    Alors une erreur est levée car les deux entreprises n'ont de partenariat commercial

  Scénario: Impossibilité de dissocier une facture inbound depuis une facture outbound si la facture outbound n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de dissocier la facture inbound de l'entreprise avec le siret "06000000000000" numero "2" periode "01/2020" depuis la facture outbound de l'entreprise avec le siret "03000000000000" numero "7"
    Alors une erreur est levée car la facture outbound n'existe pas

  Scénario: Impossibilité de dissocier une facture inbound à une facture outbound si la facture inbound n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de dissocier la facture inbound de l'entreprise avec le siret "06000000000000" numero "42" periode "12/2019" depuis la facture outbound de l'entreprise avec le siret "02000000000000" numero "3"
    Alors une erreur est levée car la facture inbound n'existe pas

  Scénario: Impossibilité de dissocier une facture inbound depuis une facture outbound si la facture inbound n'est pas associé a cette derniere
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de dissocier la facture inbound de l'entreprise avec le siret "05000000000000" numero "5" periode "12/2019" depuis la facture outbound de l'entreprise avec le siret "02000000000000" numero "1"
    Alors une erreur est levée car la facture inbound n'est pas associé a cette facture outbound

  Scénario: Impossibilité d'associer une facture inbound à une facture outbound si la facture outbound n'est pas au statut "en attente"
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de dissocier la facture inbound de l'entreprise avec le siret "05000000000000" numero "2" periode "12/2019" depuis la facture outbound de l'entreprise avec le siret "02000000000000" numero "2"
    Alors une erreur est levée car la facture outbound dn'est pas au statut en attente
