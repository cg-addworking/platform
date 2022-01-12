#language: fr
Fonctionnalité: create construction mission
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
      | email                          | firstname | lastname   | is_system_admin | siret          |
      | peter.parker@addworking.com    | Peter     | PARKER     | 1               | 01000000000000 |
      | clark.kent@client1.com         | Clark     | KENT       | 0               | 02000000000000 |
      | tony.stark@client2.com         | TONY      | STARK      | 0               | 02000000000000 |
      | natasha.roumanouff@vendor1.com | Natasha   | ROUMANOUFF | 0               | 03000000000000 |
      | bruce.wayne@client2.com        | Bruce     | WAYNE      | 0               | 04000000000000 |

    Et que les chantiers suivants existent
      | number | name       | description   | estimated_budget | started_at | ended_at   | owner_siret    | created_by              |
      | 1      | Chantier_1 | description_1 | 223056789        | 2021-05-15 | 2021-12-22 | 02000000000000 | clark.kent@client1.com  |
      | 2      | Chantier_2 | description_2 | 123456979        | 2022-05-15 | 2022-12-22 | 02000000000000 | tony.stark@client2.com  |

  @scenario1
  Scénario: Créer une mission en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "peter.parker@addworking.com"
    Quand j'essaie de créer une mission pour l'entreprise avec le siret numéro "02000000000000"
    Alors la mission est crée

  @scenario2
  Scénario: Créer une mission en tant que client associé au secteur BTP
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "clark.kent@client1.com"
    Quand j'essaie de créer une mission pour l'entreprise avec le siret numéro "02000000000000"
    Alors la mission est crée

  @scenario3
  Scénario: Impossibilité de créer une mission en tant qu'utilisateur si l'entreprise n'est pas associée au secteur BTP
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "peter.parker@addworking.com"
    Quand j'essaie de créer une mission pour l'entreprise avec le siret numéro "04000000000000"
    Alors une erreur est levée car l'entreprise n'est pas associée au secteur BTP
