#language: fr
Fonctionnalité: créer une réponse pour une offre 
  Contexte:
    Étant donné le secteur suivant existe
      | number | name         | display_name |
      | 1      | construction | Construction |

    Et que les entreprises suivantes existent
      | siret          | name       | is_customer | is_vendor | sector_number | client_siret   |
      | 01000000000000 | Addworking | 0           | 0         | 1             | null           |
      | 03000000000000 | client 1   | 1           | 0         | 1             | null           |
      | 04000000000000 | client 2   | 1           | 0         | 1             | null           |
      | 05000000000000 | vendor 1   | 0           | 1         | 1             | 04000000000000 |
      | 06000000000000 | vendor 2   | 0           | 1         | 1             | 01000000000000 |

    Et que les utilisateurs suivants existent
      | email                          | firstname | lastname   | is_system_admin | siret          |
      | peter.parker@addworking.com    | Peter     | PARKER     | 1               | 01000000000000 |
      | clark.kent@client3.com         | Clark     | KENT       | 0               | 03000000000000 |
      | natasha.roumanouff@client4.com | Natasha   | ROUMANOUFF | 0               | 04000000000000 |
      | bruce.wayne@client5.com        | Bruce     | WAYNE      | 0               | 04000000000000 |
      | jean.paul@clideux.com          | Jean      | PAUL       | 0               | 06000000000000 |

    Et que les chantiers suivants existent
      | number | name        | description  | estimated_budget | started_at | ended_at   | owner_siret    | created_by              |
      | 1      | Chantier n1 | description1 | 123456789.98     | 2021-02-20 | 2021-12-22 | 03000000000000 | clark.kent@client3.com  |
      | 2      | Chantier n2 | description2 | 123456709.98     | 2022-02-20 | 2022-12-22 | 03000000000000 | clark.kent@client3.com  |

    Et que les offres de missions suivantes existent
      | number   | name              | referent                 | enterprise_siret   | label   | starts_at_desired  |  ends_at     | description | external_id | analytic_code | status        | workfield_number | created_by                     | response_deadline |
      |    1     | offre1            | jean.paul@clideux.com    | 01000000000000     | lable1  | 2021-04-15         |  2022-04-30  |  offre1     |   id1       |  D1120        | communicated  |    1             | peter.parker@addworking.com    | 2030-06-24        |
      |    2     | offre2            | bruce.wayne@client5.com  | 04000000000000     | lable2  | 2021-04-16         |  2022-03-10  |  offre2     |   id2       |  D1121        | communicated  |    2             | natasha.roumanouff@client4.com | 2030-06-24        |
      |    3     | offre3            | clark.kent@client3.com   | 03000000000000     | lable3  | 2021-04-10         |  2022-05-13  |  offre3     |   id3       |  D1122        | draft         |   null           | clark.kent@client3.com         | 2030-06-24        |
      |    4     | offre4            | jean.paul@clideux.com    | 01000000000000     | lable4  | 2021-06-22         |  2022-05-13  |  offre4     |   id4       |  D1123        | communicated  |   1              | peter.parker@addworking.com    | 2021-06-24        |

    Et que les propositions suivantes existent
      | number   | mission_offer_number | vendor_enterprise_siret | created_by                     |
      |    1     |    2                 | 05000000000000          | natasha.roumanouff@client4.com |
      |    2     |    1                 | 06000000000000          | peter.parker@addworking.com    |
      |    3     |    4                 | 06000000000000          | peter.parker@addworking.com    |

  @scenario1
  Scénario: créer une réponse pour une offre en tant que membre d'une entreprise destinataire de l'offre
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de créer une réponse pour l'offre numéro "1"
    Alors la réponse est crée
  
  @scenario2
  Scénario: Impossibilité de créer une réponse pour une offre en tant que membre d'une entreprise si l'entreprise n'est pas destinataire de l'offre
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "bruce.wayne@client5.com"
    Quand j'essaie de créer une réponse pour l'offre numéro "2"
    Alors une erreur est levée car l'entreprise n'est pas destinataire de l'offre

  @scenario3
  Scénario: Impossibilité de créer une réponse pour une offre si l'offre n'est pas diffusée
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "clark.kent@client3.com"
    Quand j'essaie de créer une réponse pour l'offre numéro "3"
    Alors une erreur est levée car l'offre n'est pas diffusée

  @scenario4
  Scénario: Impossibilité de créer une réponse pour une offre si la date limite de réponse est atteinte 
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de créer une réponse pour l'offre numéro "4"
    Alors une erreur est levée car la date limite de réponse est atteinte
