#language: fr
Fonctionnalité: créer un chantier
  Contexte:
    Étant donné les secteurs suivants  existent
      | number | name         | display_name |
      | 1      | construction | Construction |
      | 2      | transport    | Transport    |
      | 1      | it           | IT           |

    Et que les entreprises suivantes existent
      | siret          | client_siret   | name       | is_customer | is_vendor | sector_number |
      | 01000000000000 | null           | Addworking | 0           | 0         | 1             |
      | 02000000000000 | null           | client 1   | 1           | 0         | 1             |
      | 03000000000000 | null           | client 2   | 1           | 0         | 1             |
      | 04000000000000 | null           | client 2   | 1           | 0         | 2             |
      | 05000000000000 | 03000000000000 | vendor 1   | 0           | 1         | null          |

    Et que les utilisateurs suivants existent
      | email                          | firstname | lastname   | is_system_admin | siret          |  number | is_work_field_creator |
      | peter.parker@addworking.com    | Peter     | PARKER     | 1               | 01000000000000 |  1      | 0                     |
      | tony.stark@client2.com         | Tony      | STARK      | 0               | 02000000000000 |  2      | 1                     |
      | clark.kent@client3.com         | Clark     | KENT       | 0               | 03000000000000 |  3      | 0                     |
      | natasha.roumanouff@client4.com | Natasha   | ROUMANOUFF | 0               | 04000000000000 |  3      | 1                     |
      | bruce.wayne@client5.com        | Bruce     | WAYNE      | 0               | 05000000000000 |  4      | 1                     |

  @scenario1
  Scénario: Créer un chantier en tant que client
    Étant donné que je suis authentifié en tant que utilisateur avec l'émail "tony.stark@client2.com"
    Quand j'essaie de créer un chantier pour l'entreprise avec le siret numéro "02000000000000"
    Alors le chantier est crée

  @scenario2
  Scénario: Impossibilité de créer un chantier en tant qu'utilisateur s'il n'a pas le rôle adéquat
    Étant donné que je suis authentifié en tant que utilisateur avec l'émail "clark.kent@client3.com"
    Quand j'essaie de créer un chantier pour l'entreprise avec le siret numéro "03000000000000"
    Alors une erreur est levée car l'utilisateur n'a pas le rôle adéquat

  @scenario3
  Scénario: Impossibilité de créer un chantier en tant que client s'il n'est pas associé au secteur BTP
    Étant donné que je suis authentifié en tant que utilisateur avec l'émail "natasha.roumanouff@client4.com"
    Quand j'essaie de créer un chantier pour l'entreprise avec le siret numéro "04000000000000"
    Alors une erreur est levée car l'entreprise n'est pas associée au secteur BTP

  @scenario4
  Scénario: Impossibilité de créer un chantier en tant qu'utilisateur si l'entreprise n'est pas cliente
    Étant donné que je suis authentifié en tant que utilisateur avec l'émail "bruce.wayne@client5.com"
    Quand j'essaie de créer un chantier pour l'entreprise avec le siret numéro "05000000000000"
    Alors une erreur est levée car l'entreprise n'est pas cliente
