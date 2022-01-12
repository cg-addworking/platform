#language: fr
Fonctionnalité: show construction mission
  Contexte:
    Étant donné les secteurs suivants  existent
      | number | name         | display_name |
      | 1      | construction | Construction |
      | 2      | transport    | Transport    |

    Et que les entreprises suivantes existent
      | siret          | name       | is_customer | is_vendor | sector_number | vendor_siret   |
      | 01000000000000 | Addworking | 0           | 0         | null          | null           |
      | 05000000000000 | vendor_2   | 0           | 1         | null          | null           |
      | 03000000000000 | vendor_1   | 0           | 1         | null          | null           |
      | 02000000000000 | client_1   | 1           | 0         | 1             | 03000000000000 |
      | 04000000000000 | client_2   | 1           | 0         | 2             | 05000000000000 |

    Et que les utilisateurs suivants existent
      | number | email                          | firstname | lastname   | is_system_admin | siret          |
      | 1      | peter.parker@addworking.com    | Peter     | PARKER     | 1               | 01000000000000 |
      | 2      | clark.kent@client1.com         | Clark     | KENT       | 0               | 02000000000000 |
      | 3      | tony.stark@client2.com         | TONY      | STARK      | 0               | 02000000000000 |
      | 4      | natasha.roumanouff@vendor1.com | Natasha   | ROUMANOUFF | 0               | 03000000000000 |
      | 5      | bruce.wayne@client2.com        | Bruce     | WAYNE      | 0               | 04000000000000 |

    Et que les chantiers suivants existent
      | number | name       | description   | estimated_budget | started_at | ended_at   | owner_siret    | created_by              |
      | 1      | Chantier_1 | description_1 | 223056789        | 2021-05-15 | 2021-12-22 | 02000000000000 | clark.kent@client1.com  |
      | 2      | Chantier_2 | description_2 | 123456979        | 2022-05-15 | 2022-12-22 | 02000000000000 | tony.stark@client2.com  |

    Et que les missions suivantes existent
      | number   | name       | referent_number | enterprise_siret | label   | starts_at    |  ends_at     | description    | external_id  | analytic_code | status | workfield_number | vendor_siret   |
      |    1     | mission_1  | 2               | 02000000000000   | lable_1 | 2021-04-15   |  2022-04-30  |  mission_1     |   id_1       |  D1120        | draft  | 1                | 03000000000000 |
      |    2     | mission_2  | 3               | 02000000000000   | lable_2 | 2021-04-15   |  2022-04-30  |  mission_2     |   id_2       |  D1130        | draft  | 2                | 03000000000000 |

  @scenario1
  Scénario: Voir le détail d'une mission en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "peter.parker@addworking.com"
    Quand j'essaie de voir le détail de la mission numéro "1"
    Alors le détail de la mission numéro "1" est affiché

  @scenario2
  Scénario: Voir le détail d'une mission en tant qu'entreprise propriétaire
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "clark.kent@client1.com"
    Quand j'essaie de voir le détail de la mission numéro "1"
    Alors le détail de la mission numéro "1" est affiché

  @scenario3
  Scénario: Impossibilité de voir le détail d'une mission en tant qu'utilisateur si l'entreprise n'est pas propriétaire
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "natasha.roumanouff@vendor1.com"
    Quand j'essaie de voir le détail de la mission numéro "1"
    Alors une erreur est levée car l'entreprise n'est pas propriétaire

  @scenario4
  Scénario: Impossibilité de voir le détail d'une mission si elle n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "tony.stark@client2.com"
    Quand j'essaie de voir le détail de la mission numéro "15"
    Alors une erreur est levée car la mission n'existe pas