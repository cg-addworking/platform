#language: fr
Fonctionnalité: détacher un intervenant d'un chantier
  Contexte:
    Etant donné que les secteurs suivants  existent
      | number | name         | display_name |
      | 1      | construction | Construction |

    Et que les entreprises suivantes existent
      | siret          | parent_siret   | client_siret   | name       | is_customer | is_vendor | sector_number |
      | 01000000000000 | null           | null           | Addworking | 0           | 0         | null          |
      | 02000000000000 | null           | null           | client 1   | 1           | 0         | 1             |
      | 03000000000000 | 02000000000000 | null           | client 2   | 1           | 0         | 1             |


    Et que les utilisateurs suivants existent
      | email                       | firstname | lastname   | is_system_admin | siret          |  number | is_work_field_creator |
      | peter.parker@addworking.com | Peter     | PARKER     | 1               | 01000000000000 |  1      | 0                     |
      | tony.stark@client2.com      | Tony      | STARK      | 0               | 02000000000000 |  2      | 1                     |
      | jarvis.stark@client2.com    | Jarvis    | STARK      | 0               | 02000000000000 |  3      | 0                     |
      | john.smith@client2.com      | John      | SMITH      | 0               | 02000000000000 |  4      | 0                     |
      | clark.kent@client3.com      | Clark     | KENT       | 0               | 03000000000000 |  5      | 0                     |

    Et que les chantiers suivants existent
      | number | owner_siret    | name                 | display_name        | created_by_email       |
      | 1      | 02000000000000 | construction site  1 | Construction site 1 | tony.stark@client2.com |

    Et que les intervenants suivants existent
      | number | work_field_number | contributor_email        | enterprise_siret | is_admin |
      | 1      | 1                 | john.smith@client2.com   | 02000000000000   | 1        |
      | 2      | 1                 | jarvis.stark@client2.com | 02000000000000   | 0        |

@scenario1
  Scénario: Détacher un intervenant d'un chantier en tant que créateur du dit chantier
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "tony.stark@client2.com"
    Quand j'essaie de détacher l'intervenant numéro "2"
    Alors l'intervenant avec l'email "jarvis.stark@client2.com" est détaché du chantier

@scenario2
  Scénario: Détacher un intervenant d'un chantier en tant qu'administrateur du dit chantier
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "john.smith@client2.com"
    Quand j'essaie de détacher l'intervenant numéro "2"
    Alors l'intervenant avec l'email "jarvis.stark@client2.com" est détaché du chantier

@scenario3
  Scénario: Impossible de détacher un intervenant d'un chantier sans être créateur ou administrateur du dit chantier
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jarvis.stark@client2.com"
    Quand j'essaie de détacher l'intervenant numéro "1"
    Alors une erreur est levée car l'utilisateur connecté n'a pas la permission de détacher un intervenant

@scenario4
  Scénario: Impossible de détacher un intervenant d'un chantier en étant support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "peter.parker@addworking.com"
    Quand j'essaie de détacher l'intervenant numéro "1"
    Alors une erreur est levée car l'utilisateur connecté n'a pas la permission de détacher un intervenant

@scenario5
  Scénario: Impossible de détacher un intervenant d'un chantier s'il n'est pas attaché au dit chantier
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "john.smith@client2.com"
    Quand j'essaie de détacher l'intervenant numéro "42"
    Alors une erreur est levée car l'intervenant n'est pas attaché au chantier
