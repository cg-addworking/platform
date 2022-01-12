#language: fr
Fonctionnalité: list response 
  Contexte:
    Étant donné le secteur suivant  existe
      | number | name         | display_name |
      | 1      | construction | Construction |
  
    Et que les entreprises suivantes existent
      | siret          | name       | is_customer | is_vendor | sector_number |
      | 01000000000000 | Addworking | 0           | 0         | 1             |
      | 03000000000000 | client 2   | 1           | 0         | 1             |
      | 04000000000000 | client 2   | 1           | 0         | 1             |

    Et que les utilisateurs suivants existent
      | email                          | firstname | lastname   | is_system_admin | siret          |
      | peter.parker@addworking.com    | Peter     | PARKER     | 1               | 01000000000000 |
      | clark.kent@client3.com         | Clark     | KENT       | 0               | 03000000000000 |
      | natasha.roumanouff@client4.com | Natasha   | ROUMANOUFF | 0               | 04000000000000 |
      | bruce.wayne@client5.com        | Bruce     | WAYNE      | 0               | 04000000000000 |
      | jean.paul@clideux.com          | Jean      | PAUL       | 0               | 01000000000000 |

    Et que les chantiers suivants existent
      | number | name       | description  | estimated_budget | started_at | ended_at   | owner_siret    | created_by              |
      | 1      | Chantier_1 | description1 | 123456789.98     | 2021-02-20 | 2021-12-22 | 03000000000000 | clark.kent@client3.com  |
      | 2      | Chantier_2 | description2 | 123456709.98     | 2022-02-20 | 2022-12-22 | 03000000000000 | clark.kent@client3.com  |
    
    Et que les offres de missions suivantes existent
      | number   | name              | referent                 | enterprise_siret   | label   | starts_at_desired  |  ends_at     | description | external_id | analytic_code | status        | workfield_number | created_by                     |
      |    1     | offre1            | jean.paul@clideux.com    | 01000000000000     | lable1  | 2021-04-15         |  2022-04-30  |  offre1     |   id1       |  D1120        | communicated  |    1             | peter.parker@addworking.com    |
      |    2     | offre2            | bruce.wayne@client5.com  | 04000000000000     | lable2  | 2021-04-16         |  2022-03-10  |  offre2     |   id2       |  D1121        | communicated  |    2             | natasha.roumanouff@client4.com |
      |    3     | offre3            | clark.kent@client3.com   | 03000000000000     | lable3  | 2021-04-10         |  2022-05-13  |  offre3     |   id3       |  D1122        | closed        |   null           | clark.kent@client3.com         |

    Et que les reponses suivantes existent
      | number  |  starts_at  | ended_at   | amount_before_taxes | argument      | offer_number  |  created_by                     | enterprise_siret  | status       |
      |   1     |  2021-04-15 | 2022-04-30 | 183w45.60           | argument_1    | 1             |  natasha.roumanouff@client4.com | 04000000000000    | accepted     |
      |   2     |  2021-04-16 | 2022-03-10 | 22349.67            | argument_2    | 2             |  peter.parker@addworking.com    | 01000000000000    | pending      |
      |   3     |  2021-04-30 | 2022-04-30 | 34345.61            | argument_3    | 1             |  bruce.wayne@client5.com        | 04000000000000    | pending      |
      |   4     |  2021-04-16 | 2022-02-10 | 12305.55            | argument_4    | 2             |  jean.paul@clideux.com          | 01000000000000    | pending      |
      |   5     |  2021-04-16 | 2022-02-10 | 12305.55            | argument_5    | 3             |  bruce.wayne@client5.com        | 04000000000000    | accepted     |

  @scenario1
  Scénario: Lister les réponses d'une offre de mission en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "peter.parker@addworking.com"
    Quand j'essaie de lister toutes les réponses de l'offre numéro "1"
    Alors toutes les réponses pour l'offre numéro "1" sont listées

  @scenario2
  Scénario: Lister les réponses d'une offre de mission en tant que propriétaire de l'offre
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "clark.kent@client3.com"
    Quand j'essaie de lister toutes les réponses de l'offre numéro "3"
    Alors toutes les réponses pour l'offre numéro "3" sont listées

  @scenario3
  Scénario: Impossibilité de lister les réponses d'une offre si elle n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "natasha.roumanouff@client4.com"
    Quand j'essaie de lister toutes les réponses de l'offre numéro "4"
    Alors une erreur est levée car l'offre n'existe pas