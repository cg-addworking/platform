#language: fr
Fonctionnalité: delete offer
  Contexte:
    Étant donné le secteur suivant  existe
      | number | name         | display_name |
      | 1      | construction | Construction |
  
    Et que les entreprises suivantes existent
      | siret          | name       | is_customer | is_vendor | sector_number |
      | 01000000000000 | Addworking | 0           | 0         | 1             |
      | 03000000000000 | client 2   | 1           | 0         | 1             |
      | 04000000000000 | client 3   | 1           | 0         | 1             |

    Et que les utilisateurs suivants existent
      | email                          | firstname | lastname   | is_system_admin | siret          | number  |
      | peter.parker@addworking.com    | Peter     | PARKER     | 1               | 01000000000000 |   1     |
      | clark.kent@client3.com         | Clark     | KENT       | 0               | 03000000000000 |   2     |
      | natasha.roumanouff@client4.com | Natasha   | ROUMANOUFF | 0               | 04000000000000 |   3     |
      | bruce.wayne@client5.com        | Bruce     | WAYNE      | 0               | 04000000000000 |   4     |

    Et que les chantiers suivants existent
      | number | name       | description  | estimated_budget | started_at | ended_at   | owner_siret    | created_by                     |
      | 1      | Chantier_1 | description1 | 123456789.98     | 2021-02-20 | 2022-12-22 | 03000000000000 | clark.kent@client3.com         |
      | 2      | Chantier_2 | description2 | 123456709.98     | 2022-02-20 | 2022-12-22 | 03000000000000 | clark.kent@client3.com         |
      | 3      | Chantier_3 | description3 | 123456709.98     | 2022-02-20 | 2022-12-22 | 04000000000000 | natasha.roumanouff@client4.com |

    Et que les offres de missions suivantes existent
      | number   | name              | referent_number    | enterprise_siret   | label   | starts_at_desired  |  ends_at     | description | external_id | analytic_code | status        | workfield_number | created_by_number |
      |    1     | offre1            |       1            | 01000000000000     | lable1  | 2021-04-15         |  2022-04-30  |  offre1     |   id1       |  D1120        | to_provide    |    1             | 1                 |
      |    2     | offre2            |       4            | 04000000000000     | lable2  | 2021-04-16         |  2022-03-10  |  offre2     |   id2       |  D1121        | to_provide    |    null          | 3                 |
      |    3     | offre3            |       2            | 03000000000000     | lable3  | 2021-04-10         |  2022-05-13  |  offre3     |   id3       |  D1122        | communicated  |    2             | 2                 |
      |    4     | offre4            |       4            | 04000000000000     | lable4  | 2021-04-10         |  2022-05-13  |  offre4     |   id4       |  D1123        | to_provide    |    null          | 4                 |
    
  @scenario1
  Scénario: supprimer une offre de mission en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "peter.parker@addworking.com"
    Quand j'essaie de supprimer l'offre de mission numéro "1"
    Alors l'offre de mission numéro "1" est supprimée

  @scenario2
  Scénario: supprimer une offre de mission en tant qu'entreprise propriétaire
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "natasha.roumanouff@client4.com"
    Quand j'essaie de supprimer l'offre de mission numéro "2"
    Alors l'offre de mission numéro "2" est supprimée

  @scenario3
  Scénario: Impossibilité de supprimer une offre de mission si l'utilisateur n'est pas propriétaire
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "clark.kent@client3.com"
    Quand j'essaie de supprimer l'offre de mission numéro "4"
    Alors une erreur est levée car l'entreprise n'est pas propriétaire

  @scenario3
  Scénario: Impossibilité de supprimer une offre de mission si l'offre est diffusée 
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "clark.kent@client3.com"
    Quand j'essaie de supprimer l'offre de mission numéro "3"
    Alors une erreur est levée car l'offre est déjà diffusée 
