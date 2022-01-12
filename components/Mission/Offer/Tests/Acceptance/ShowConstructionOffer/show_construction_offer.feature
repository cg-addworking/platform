#language: fr
Fonctionnalité: voir une offre de mission 
  Contexte:
    Étant donné les secteurs suivants  existent
      | number | name         | display_name |
      | 1      | construction | Construction |
      | 2      | transport    | Transport    |
      | 3      | it           | IT           |

    Et que les entreprises suivantes existent
      | siret          |  name       | client_siret    | is_customer | is_vendor | sector_number |
      | 01000000000000 |  Addworking | null            | 0           | 0         | 1             |
      | 03000000000000 |  client 2   | null            | 1           | 0         | 1             |
      | 04000000000000 |  client 3   | null            | 1           | 0         | 1             |
      | 05000000000000 |  client 4   | null            | 1           | 0         | 2             |
      | 06000000000000 |  vendor 1   | 03000000000000  | 0           | 1         | null          |
      | 07000000000000 |  vendor 2   | 03000000000000  | 0           | 1         | null          |

    Et que les utilisateurs suivants existent
      | email                          | firstname | lastname   | is_system_admin | siret          | number |
      | peter.parker@addworking.com    | Peter     | PARKER     | 1               | 01000000000000 | 1      |
      | clark.kent@client3.com         | Clark     | KENT       | 0               | 03000000000000 | 2      |
      | natasha.roumanouff@client4.com | Natasha   | ROUMANOUFF | 0               | 04000000000000 | 3      |
      | tony.stark@client.com          | Tony      | STARK      | 0               | 05000000000000 | 4      |
      | jean.paul@clideux.com          | Jean      | PAUL       | 0               | 06000000000000 | 5      |
      | jarvis.stark@client5.com       | Jarvis    | STARK      | 0               | 03000000000000 | 6      |
      | john.smith@vendor2.com         | John      | SMITH      | 0               | 07000000000000 | 7      |

    Et que les chantiers suivants existent
      | number | name        | description  | estimated_budget | started_at | ended_at   | owner_siret    | created_by              |
      | 1      | Chantier n1 | description1 | 123456789.98     | 2021-02-20 | 2021-12-22 | 03000000000000 | clark.kent@client3.com  |
      | 2      | Chantier n2 | description2 | 123456709.98     | 2022-02-20 | 2022-12-22 | 03000000000000 | clark.kent@client3.com  |

    Et que les offres de missions suivantes existent
      | number   | name              | referent_number  | enterprise_siret   | label   | starts_at_desired  |  ends_at     | description | external_id | analytic_code | status        | workfield_number | created_by_number |
      |    1     | offre1            | 1                | 01000000000000     | lable1  | 2022-04-15         |  2022-04-30  |  offre1     |   id1       |  D1120        | draft         |    1             |         1         |
      |    2     | offre2            | 6                | 03000000000000     | lable2  | 2022-04-16         |  2022-04-30  |  offre2     |   id2       |  D1121        | communicated  |    2             |         6         |
      |    3     | offre3            | 2                | 03000000000000     | lable3  | 2022-04-10         |  2022-04-13  |  offre3     |   id3       |  D1122        | communicated  |   null           |         2         |
      |    4     | offre4            | 2                | 03000000000000     | lable4  | 2022-04-10         |  2022-04-13  |  offre4     |   id4       |  D1123        | draft         |   null           |         2         |

    Et que les propositions suivantes existent
      | number   | mission_offer_number | vendor_enterprise_siret | created_by                     |
      |    1     |    2                 | 06000000000000          | jarvis.stark@client5.com       |
      |    2     |    3                 | 07000000000000          | clark.kent@client3.com         |

  @scenario1
  Scénario: Voir le détail d'une offre de mission en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "peter.parker@addworking.com"
    Quand j'essaie de voir le détail de l'offre de mission numéro "1"
    Alors le détail de l'offre de mission numéro "1" est affiché

  @scenario2
  Scénario: Voir le détail d'une offre de mission en tant qu'entreprise propriétaire
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jarvis.stark@client5.com"
    Quand j'essaie de voir le détail de l'offre de mission numéro "2"
    Alors le détail de l'offre de mission numéro "2" est affiché

  @scenario3
  Scénario: Impossibilité de voir le détail d'une offre de mission en tant qu'utilisateur si l'entreprise n'est pas propriétaire
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "natasha.roumanouff@client4.com"
    Quand j'essaie de voir le détail de l'offre de mission numéro "2"
    Alors une erreur est levée car l'entreprise n'est pas propriétaire

  @scenario4
  Scénario: Impossibilité de voir le détail d'une offre de mission si l'offre n'a pas de propositions
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de voir le détail de l'offre de mission numéro "4"
    Alors une erreur est levée car l'offre n'a pas de propositions

  @scenario5
    Scénario: Impossibilité de voir le détail d'une offre de mission si elle n'existe pas
      Etant donné que je suis authentifié en tant que utilisateur avec l'email "clark.kent@client3.com"
      Quand j'essaie de voir le détail de l'offre de mission numéro "10"
      Alors une erreur est levée car l'offre de mission n'existe pas