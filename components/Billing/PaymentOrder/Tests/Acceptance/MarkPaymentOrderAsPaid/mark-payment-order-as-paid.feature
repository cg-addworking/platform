#language: fr

Fonctionnalit√©: Mark payment order as paid

  Contexte:
    Etant donn√© que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | access_to_billing |
      | 01000000000000 | Addworking1 | 0           | 0         | 1                 |
      | 02000000000000 | Client2     | 1           | 0         | 1                 |
      | 05000000000000 | Presta5     | 0           | 1         | 1                 |

    Et que les partenariats suivants existent
      | siret_customer | siret_vendor   |
      | 02000000000000 | 05000000000000 |

    Et que les ibans suivants existent
      | status   | siret          |
      | approved | 01000000000000 |
      | approved | 05000000000000 |

    Et que les utilisateurs suivants existent
      | email                     | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@clideux.com     | Jean      | PAUL     | 0               | 02000000000000 |

    Et que les echeances de paiement suivantes existent
      | name    | display_name | value |
      | 30_days | 30 Jours     | 30    |

    Et que les taux de tva suivants existent
      | name | display_name | value |
      | 20%  | 20%          | 0.2   |
      | 0%   | 0%           | 0     |

    Et que les factures outbound suivantes existent
      | siret          | number | month   | deadline_name | status         |
      | 02000000000000 | 1      | 2019-12 | 30_days       | file_generated |

    Et que les factures inbound suivantes existent
      | siret          | number | month   | deadline_name | status     | siret_customer | outbound_number |
      | 05000000000000 | 1      | 12/2019 | 30_days       | validated  | 02000000000000 | 1               |
      | 05000000000000 | 2      | 12/2019 | 30_days       | validated  | 02000000000000 | 1               |

    Et que les lignes factures inbound suivantes existent
      | siret          | number | month   | label   | quantity | unit_price | vat_rate |
      | 05000000000000 | 1      | 12/2019 | BBB     | 1        | 10         | 0.2      |
      | 05000000000000 | 2      | 12/2019 | AAA     | 1        | 10         | 0.2      |

    Et que les lignes factures outbound suivantes existent
      | siret_vendor   | inbound_number | month   | outbound_number | label   | quantity | unit_price | vat_rate |
      | 05000000000000 | 1              | 12/2019 | 1               | BBB     | 1        | 10         | 0.2      |
      | 05000000000000 | 2              | 12/2019 | 1               | AAA     | 1        | 10         | 0.2      |

    Et que les ordres de paiement suivants existent
      | number | siret_customer | invoice_number | status   |
      | 1      | 02000000000000 | 1              | pending  |
      | 2      | 02000000000000 | 1              | executed |
      | 3      | 02000000000000 | 1              | pending  |
      | 4      | 02000000000000 | 1              | pending  |

    Et que les lignes d'ordre de paiement suivantes existent
      | number | payment_order_number | inbound_number |
      | 1      | 1                    | 1              |
      | 2      | 2                    | 2              |

    Et que les fichiers des ordres de paiement suivants existent
      | number |
      | 1      |

  @mettreLeStatutPayeALordreDePaiement
  Sc√©nario: Changer le statut de l'ordre de paiement a Pay√©
    Etant donn√© que je suis authentifi√© en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de mettre le statut pay√© √† l'ordre de paiement numero "1"
    Alors l'ordre de paiement est au status pay√©

  Sc√©nario: Impossibilit√© de mettre le statut pay√© √† l'ordre de paiement si l'utilisateur n'est pas support
    Etant donn√© que je suis authentifi√© en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de mettre le statut pay√© √† l'ordre de paiement numero "1"
    Alors une erreur est lev√©e car l'utilisateur n'est pas support

  Sc√©nario: Impossibilit√© de mettre le statut pay√© √† l'ordre de paiement si l'ordre de paiement n'existe pas
    Etant donn√© que je suis authentifi√© en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de mettre le statut pay√© √† l'ordre de paiement numero "5"
    Alors une erreur est lev√©e car l'ordre de paiement n'existe pas

  Sc√©nario: Impossibilit√© de mettre le statut pay√© √† l'ordre de paiement si l'ordre de paiement n'a pas de fichier
    Etant donn√© que je suis authentifi√© en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de mettre le statut pay√© √† l'ordre de paiement numero "4"
    Alors une erreur est lev√©e car l'ordre de paiement n'a pas de fichier

  Sc√©nario: Impossibilit√© de mettre le statut pay√© √† l'ordre de paiement si l'ordre de paiement n'est pas au statut en attente
    Etant donn√© que je suis authentifi√© en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de mettre le statut pay√© √† l'ordre de paiement numero "2"
    Alors une erreur est lev√©e car l'ordre de paiement n'est pas au statut en attente