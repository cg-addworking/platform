#language: fr

Fonctionnalité: Create credit line
  Contexte:
    Etant donné que les entreprises suivantes existent
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
      | siret          | number | month   | deadline_name | status         |
      | 02000000000000 | 1      | 01/2020 | 0_days        | file_generated |
      | 02000000000000 | 2      | 01/2020 | 0_days        | pending        |

    Et que le taux de tva suivant existe
      | name | display_name | value |
      | 20%  | 20%          | 0.2   |

    Et que la facture inbound suivante existe
      | siret          | number | month   | deadline_name | status     | siret_customer |
      | 04000000000000 | 69     | 01/2020 | 0_days        | validated  | 02000000000000 |

    Et que la ligne de facture inbound suivante existe
      | siret          | number | month   | label   | quantity | unit_price | vat_rate |
      | 04000000000000 | 69     | 01/2020 | AAA     | 1        | 10         | 0.2      |

    Et que la ligne de facture outbound suivante existe
      | siret_vendor   | inbound_number | month   | siret_customer | outbound_number | label | quantity | unit_price | vat_rate | number |
      | 04000000000000 | 69             | 01/2020 | 02000000000000 | 1               | AAA   | 1        | 10         | 0.2      | 1      |

    Et que la ligne ad-hoc de facture outbound suivante existe
      | siret_customer | outbound_number | label | quantity | unit_price | vat_rate | number |
      | 02000000000000 | 1               | XXX   | 2        | 20         | 0.2      | 2      |

@creerUneLigneDAvoir
  Scénario: Créer une ligne d'avoir d'une ligne inbound
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de créer la ligne d'avoir de la ligne outbound numéro "1" pour la facture outbound "2"
    Alors la ligne d'avoir pour la ligne outbound numéro "1" est créée

  Scénario: Créer une ligne d'avoir d'une ligne ad-hoc
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de créer la ligne d'avoir de la ligne outbound numéro "2" pour la facture outbound "2"
    Alors la ligne d'avoir pour la ligne outbound numéro "2" est créée

  Scénario: Impossibilité de créer une ligne d'avoir si l'utilisateur connecté n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@cliprestadeux.com"
    Quand j'essaie de créer la ligne d'avoir de la ligne outbound numéro "1" pour la facture outbound "2"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support

  Scénario: Impossibilité de créer une ligne d'avoir si l'entreprise n'a pas accès au module facturation
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de créer la ligne d'avoir de la ligne outbound numéro "1" pour la facture outbound "2"
    Alors une erreur est levée car l'entreprise n'a pas acces au module facturation

  Scénario: Impossibilité de créer une ligne d'avoir si la ligne outbound n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de créer la ligne d'avoir de la ligne outbound numéro "42" pour la facture outbound "2"
    Alors une erreur est levée car la ligne outbound n'existe pas

  Scénario: Impossibilité de créer une ligne d'avoir si la facture outbound n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de créer la ligne d'avoir de la ligne outbound numéro "1" pour la facture outbound "42"
    Alors une erreur est levée car la facture outbound n'existe pas
