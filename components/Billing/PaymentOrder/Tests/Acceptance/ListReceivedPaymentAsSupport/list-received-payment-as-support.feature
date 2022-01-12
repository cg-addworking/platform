#language: fr

Fonctionnalité: List Received Payments As Support
  Contexte:
  Étant donné que les entreprises suivantes existent
    | siret          | name        | is_customer | is_vendor | access_to_billing |
    | 01000000000000 | Addworking1 | 0           | 0         | 1                 |
    | 02000000000000 | Client2     | 1           | 0         | 1                 |
    | 03000000000000 | Client3     | 1           | 0         | 1                 |
    | 04000000000000 | Client4     | 1           | 0         | 1                 |
    | 05000000000000 | Client5     | 1           | 0         | 1                 |
    | 06000000000000 | Client6     | 1           | 0         | 1                 |

  Et que les utilisateurs suivants existent
    | email                          | firstname | lastname | is_system_admin | siret          |
    | antoine.pierre@addworking1.com | Antoine   | PIERRE   | 1               | 01000000000000 |
    | jean.paul@client2.com          | Jean      | PAUL     | 0               | 02000000000000 |
    | pierre.dupont@client3.com      | Pierre    | DUPONT   | 0               | 03000000000000 |
    | jean.michel@client4.com        | Jean      | MICHEL   | 0               | 04000000000000 |
    | gandalf.leblanc@client5.com    | Gandalf   | LEBLANC  | 0               | 05000000000000 |
    | tony.stark@client6.com         | Tony      | STARK    | 0               | 06000000000000 |

  Et que les ibans suivants existent
    | status   | siret          |
    | approved | 01000000000000 |

  Et que les factures addworking suivantes existent
    | siret_customer | number | month   | deadline_name | status          |
    | 02000000000000 | 101    | 2020-06 | 0_days        | pending         |
    | 02000000000000 | 102    | 2020-06 | 0_days        | calculated_fees |
    | 02000000000000 | 103    | 2020-06 | 0_days        | file_generated  |
    | 03000000000000 | 104    | 2020-06 | 0_days        | pending         |
    | 03000000000000 | 105    | 2020-06 | 0_days        | calculated_fees |
    | 03000000000000 | 106    | 2020-06 | 0_days        | file_generated  |
    | 05000000000000 | 107    | 2020-06 | 0_days        | pending         |
    | 05000000000000 | 108    | 2020-06 | 0_days        | calculated_fees |
    | 05000000000000 | 109    | 2020-06 | 0_days        | file_generated  |
    | 06000000000000 | 110    | 2020-06 | 0_days        | pending         |
    | 06000000000000 | 111    | 2020-06 | 0_days        | calculated_fees |
    | 06000000000000 | 112    | 2020-06 | 0_days        | file_generated  |

    Et que les paiements reçus suivants existent
    | number | siret_addworking_for_iban | siret          | outbound_invoice_number |
    | 201    | 01000000000000            | 02000000000000 | 101                     |
    | 202    | 01000000000000            | 02000000000000 | 101                     |
    | 203    | 01000000000000            | 02000000000000 | 103                     |
    | 204    | 01000000000000            | 03000000000000 | 105                     |
    | 205    | 01000000000000            | 03000000000000 | 105                     |
    | 206    | 01000000000000            | 03000000000000 | 105                     |
    | 207    | 01000000000000            | 03000000000000 | 105                     |
    | 208    | 01000000000000            | 03000000000000 | 105                     |
    | 209    | 01000000000000            | 05000000000000 | 107                     |
    | 210    | 01000000000000            | 05000000000000 | 108                     |
    | 211    | 01000000000000            | 05000000000000 | 108                     |
    | 212    | 01000000000000            | 05000000000000 | 108                     |
    | 213    | 01000000000000            | 05000000000000 | 109                     |
    | 214    | 01000000000000            | 05000000000000 | 109                     |
    | 215    | 01000000000000            | 05000000000000 | 109                     |
    | 216    | 01000000000000            | 05000000000000 | 109                     |
    | 217    | 01000000000000            | 05000000000000 | 109                     |
    | 218    | 01000000000000            | 05000000000000 | 109                     |
    | 219    | 01000000000000            | 05000000000000 | 109                     |
    | 220    | 01000000000000            | 05000000000000 | 109                     |
    | 221    | 01000000000000            | 06000000000000 | 111                     |
    | 222    | 01000000000000            | 06000000000000 | 111                     |
    | 223    | 01000000000000            | 06000000000000 | 111                     |
    | 224    | 01000000000000            | 06000000000000 | 112                     |

  @scenario1
  Scénario: Lister tous les paiements reçus si l'utilisateur connecté est support
    Étant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addworking1.com"
    Quand j'essaie de lister tous les paiements reçus
    Alors les paiements reçus sont listées

  @scenario2
  Scénario: Impossibilité de lister les paiements reçus si l'utilisateur connecté n'est pas support
    Étant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@client2.com"
    Quand j'essaie de lister tous les paiements reçus
    Alors une erreur est levée car l'utilisateur connecté n'est pas support
