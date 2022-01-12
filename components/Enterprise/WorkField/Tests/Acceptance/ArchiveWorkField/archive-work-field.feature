#language: fr
Fonctionnalité: archive work field
  Contexte:
    Etant donné le secteur suivant existe
      | number | name         | display_name |
      | 1      | construction | Construction |

    Et que l'entreprise suivante existe
      | siret          | client_siret   | name       | is_customer | is_vendor | sector_number |
      | 03000000000000 | null           | client 2   | 1           | 0         | 1             |

    Et que les utilisateurs suivants existent
      | email                          | firstname | lastname   | is_system_admin | siret          |  number | is_wf_creator |
      | clark.kent@client3.com         | Clark     | KENT       | 0               | 03000000000000 |  3      | 1             |
      | bruce.wayne@client3.com        | Bruce     | WAYNE      | 0               | 03000000000000 |  4      | 0             |

    Et que les chantiers suivants existent
      | number | name        | description | estimated_budget | started_at | ended_at   | owner_siret    | created_by              |
      | 1      | Chantier n1 | blablablaba | 123456789.98     | 2021-02-20 | 2021-12-22 | 03000000000000 | clark.kent@client3.com  |
      | 2      | Chantier n2 | desbabption | 123456709.98     | 2022-02-20 | 2022-12-22 | 03000000000000 | bruce.wayne@client3.com |

    Et que les intervenants suivants existent
      | number | work_field_number | contributor_email       | enterprise_siret | is_admin |
      | 1      | 1                 | bruce.wayne@client3.com | 03000000000000   | 1        |
      | 2      | 2                 | clark.kent@client3.com  | 03000000000000   | 0        |
      
  @scenario1
  Scénario: archiver un chantier en tant que créateur
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "clark.kent@client3.com"
    Quand j'essaie d'archiver le chantier numéro "1"
    Alors le chantier numéro "1" est archivé

  @scenario2
  Scénario: archiver un chantier en tant qu'administrateur
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "bruce.wayne@client3.com"
    Quand j'essaie d'archiver le chantier numéro "1"
    Alors le chantier numéro "1" est archivé

  @scenario3
  Scénario: Impossibilité d'archiver un chantier si l'utilisateur n'est pas créateur ou administrateur
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "clark.kent@client3.com"
    Quand j'essaie d'archiver le chantier numéro "2"
    Alors une erreur est levée car l'utilisateur n'a pas le rôle de créateur/administrateur
