#language: fr
Fonctionnalité: create construction offer
  Contexte:
    Étant donné les secteurs suivants  existent
      | number | name         | display_name |
      | 1      | construction | Construction |
      | 2      | transport    | Transport    |
      | 3      | it           | IT           |
  
    Et que les entreprises suivantes existent
      | siret          | name       | is_customer | is_vendor | sector_number |
      | 01000000000000 | Addworking | 0           | 0         | 1             |
      | 03000000000000 | client 2   | 1           | 0         | 1             |
      | 04000000000000 | client 2   | 1           | 0         | 2             |
      | 05000000000000 | vendor 1   | 0           | 1         | null          |

    Et que les utilisateurs suivants existent
      | email                          | firstname | lastname   | is_system_admin | siret          |
      | peter.parker@addworking.com    | Peter     | PARKER     | 1               | 01000000000000 |
      | clark.kent@client3.com         | Clark     | KENT       | 0               | 03000000000000 |
      | natasha.roumanouff@client4.com | Natasha   | ROUMANOUFF | 0               | 04000000000000 |
      | bruce.wayne@client5.com        | Bruce     | WAYNE      | 0               | 05000000000000 |

  
    Et que les chantiers suivants existent
      | number | name        | description  | estimated_budget | started_at | ended_at   | owner_siret    | created_by              |
      | 1      | Chantier n1 | description1 | 123456789.98     | 2021-02-20 | 2021-12-22 | 03000000000000 | clark.kent@client3.com  |
      | 2      | Chantier n2 | description2 | 123456709.98     | 2022-02-20 | 2022-12-22 | 03000000000000 | clark.kent@client3.com  |

  @scenario1
  Scénario: Créer une offre de mission en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "peter.parker@addworking.com"
    Quand j'essaie de créer une offre de mission pour l'entreprise avec le siret numéro "01000000000000"
    Alors l'offre de mission est crée
 
  @scenario2
  Scénario: Créer une offre de mission en tant que client associé au secteur BTP
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "clark.kent@client3.com"
    Quand j'essaie de créer une offre de mission pour l'entreprise avec le siret numéro "03000000000000"
    Alors l'offre de mission est crée

  @scenario3
  Scénario: Impossibilité de créer une offre de mission en tant qu'utilisateur si l'entreprise n'est pas cliente
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "bruce.wayne@client5.com"
    Quand j'essaie de créer une offre de mission pour l'entreprise avec le siret numéro "05000000000000"
    Alors une erreur est levée car l'entreprise n'est pas cliente

   @scenario4
  Scénario: Impossibilité de créer une offre de mission en tant que client s'il n'est pas associé au secteur BTP
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "natasha.roumanouff@client4.com"
    Quand j'essaie de créer une offre de mission pour l'entreprise avec le siret numéro "04000000000000"
    Alors une erreur est levée car l'entreprise n'est pas associée au secteur BTP
