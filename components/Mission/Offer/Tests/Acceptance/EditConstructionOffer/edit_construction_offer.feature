#language: fr
Fonctionnalité: modifier une offre de mission 
  Contexte:
    Étant donné les secteurs suivants  existent
      | number | name         | display_name |
      | 1      | construction | Construction |

    Et que les entreprises suivantes existent
      | siret          | vendor_siret     | name       | is_customer | is_vendor | sector_number |
      | 01000000000000 | null             | Addworking | 0           | 0         | 1             |
      | 03000000000000 | 05000000000000   | client 2   | 1           | 0         | 1             |
      | 04000000000000 | null             | client 2   | 1           | 0         | 1             |
      | 05000000000000 | null             | vendor 1   | 0           | 1         | null          |

    Et que les utilisateurs suivants existent
      | email                          | firstname | lastname   | is_system_admin | siret          | number |
      | peter.parker@addworking.com    | Peter     | PARKER     | 1               | 01000000000000 | 1      |
      | clark.kent@client3.com         | Clark     | KENT       | 0               | 03000000000000 | 2      |
      | natasha.roumanouff@client4.com | Natasha   | ROUMANOUFF | 0               | 04000000000000 | 3      |
      | bruce.wayne@client5.com        | Bruce     | WAYNE      | 0               | 03000000000000 | 4      |
      | tony.stark@vendor.com          | Tony      | STARK      | 0               | 05000000000000 | 5      |
  
    Et que les chantiers suivants existent
      | number | name        | description  | estimated_budget | started_at | ended_at   | owner_siret    | created_by              |
      | 1      | Chantier n1 | description1 | 123456789.98     | 2021-02-20 | 2021-12-22 | 03000000000000 | clark.kent@client3.com  |
      | 2      | Chantier n2 | description2 | 123456709.98     | 2022-02-20 | 2022-12-22 | 03000000000000 | clark.kent@client3.com  |

    Et que les offres de missions suivantes existent
      | number   | name              | referent_number  | enterprise_siret   | label   | starts_at_desired  |  ends_at     | description | external_id | analytic_code | status | workfield_number | created_by_number |
      |    1     | offre1            | 1                | 01000000000000     | lable1  | 2021-04-15         |  2021-04-30  |  offre1     |   id1       |  D1120        | draft  |    1             |         1         |
      |    2     | offre2            | 2                | 03000000000000     | lable2  | 2021-04-16         |  2021-04-30  |  offre2     |   id2       |  D1121        | draft  |    2             |         4         |
      |    3     | offre2            | 2                | 03000000000000     | lable2  | 2021-04-10         |  2021-04-13  |  offre3     |   id3       |  D1122        | closed |   null           |         1         |

  @scenario1
  Scénario: Modifier une offre de mission en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "peter.parker@addworking.com"
    Quand j'essaie de modifier l'offre de mission numéro "1"
    Alors l'offre de mission numéro "1" est modifié

  @scenario2
  Scénario: Modifier une offre de mission en tant qu'entreprise propriétaire
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "clark.kent@client3.com"
    Quand j'essaie de modifier l'offre de mission numéro "2"
    Alors l'offre de mission numéro "2" est modifié

  @scenario3
  Scénario: Impossibilité de modifier l'offre de mission en tant qu'utilisateur si l'entreprise n'est pas propriétaire
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "tony.stark@vendor.com"
    Quand j'essaie de modifier l'offre de mission numéro "2"
    Alors une erreur est levée car l'entreprise n'est pas propriétaire

  @scenario4
  Scénario: Impossibilité de modifier une offre de mission fermée
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "bruce.wayne@client5.com"
    Quand j'essaie de modifier l'offre de mission numéro "3"
    Alors une erreur est levée car l'offre de mission est fermée