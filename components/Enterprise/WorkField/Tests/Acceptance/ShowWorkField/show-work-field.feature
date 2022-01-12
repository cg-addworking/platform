#language: fr
Fonctionnalité: show work field
  Contexte:
    Etant donné le secteur suivant existe
      | number | name         | display_name |
      | 1      | construction | Construction |

    Et que les entreprises suivantes existent
      | siret          | client_siret   | name       | is_customer | is_vendor | sector_number |
      | 01000000000000 | null           | Addworking | 0           | 0         | null          |
      | 02000000000000 | null           | client 1   | 1           | 0         | 1             |
      | 03000000000000 | null           | client 2   | 1           | 0         | 1             |
      | 04000000000000 | 03000000000000 | vendor 1   | 0           | 1         | 1             |

    Et que les utilisateurs suivants existent
      | email                          | firstname | lastname   | is_system_admin | siret          |  number | is_wf_creator |
      | peter.parker@addworking.com    | Peter     | PARKER     | 1               | 01000000000000 |  1      | 0             |
      | tony.stark@client2.com         | Tony      | STARK      | 0               | 02000000000000 |  2      | 0             |
      | clark.kent@client3.com         | Clark     | KENT       | 0               | 03000000000000 |  3      | 1             |
      | bruce.wayne@client3.com        | Bruce     | WAYNE      | 0               | 03000000000000 |  4      | 0             |
      | natasha.roumanouff@vendor4.com | Natasha   | ROUMANOUFF | 0               | 04000000000000 |  5      | 0             |

    Et que le chantier suivant existe 
      | number | name        | description | estimated_budget | started_at | ended_at   | owner_siret    | created_by             |
      | 1      | Chantier n1 | blablablaba | 123456789.98     | 2020-02-20 | 2021-12-22 | 03000000000000 | clark.kent@client3.com |

    Et que l'intervenant suivant existe
      | number | work_field_number | contributor_email       | enterprise_siret | is_admin |
      | 1      | 1                 | bruce.wayne@client3.com | 03000000000000   | 1        |


  @scenario1
  Scénario: Voir le détail d'un chantier en tant que propriétaire
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "clark.kent@client3.com"
    Quand j'essaie de voir le détail du chantier numéro "1"
    Alors le détail du chantier numéro "1" est affiché

  @scenario2
  Scénario: Voir le détail d'un chantier en tant qu'intervenant de celui-ci
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "bruce.wayne@client3.com"
    Quand j'essaie de voir le détail du chantier numéro "1"
    Alors le détail du chantier numéro "1" est affiché

  @scenario3
  Scénario: Impossibilité de voir le détail d'un chantier si l'utilisateur n'est en relation avec le chantier
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "natasha.roumanouff@vendor4.com"
    Quand j'essaie de voir le détail du chantier numéro "1"
    Alors une erreur est levée car l'utilisateur n'a pas de relation avec le chantier

  @scenario3B
  Scénario: Impossibilité de voir le détail d'un chantier si l'utilisateur n'est en relation avec le chantier
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "peter.parker@addworking.com"
    Quand j'essaie de voir le détail du chantier numéro "1"
    Alors une erreur est levée car l'utilisateur n'a pas de relation avec le chantier
  
  @scenario4
  Scénario: Impossibilité de voir le détail d'un chantier s'il n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "clark.kent@client3.com"
    Quand j'essaie de voir le détail du chantier numéro "42"
    Alors une erreur est levée car le chantier n'existe pas