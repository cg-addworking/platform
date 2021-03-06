#language: fr
Fonctionnalit√©: list work field
  Contexte:
    Etant donn√© le secteur suivant existe
      | number | name         | display_name |
      | 1      | construction | Construction |

    Et que les entreprises suivantes existent
      | siret          | parent_siret   | name       | is_customer | is_vendor | sector_number |
      | 01000000000000 | null           | Addworking | 0           | 0         | null          |
      | 02000000000000 | null           | client 1   | 1           | 0         | 1             |
      | 03000000000000 | 02000000000000 | client 2   | 1           | 0         | 1             |

    Et que les utilisateurs suivants existent
      | email                          | firstname | lastname   | is_system_admin | siret          |  number | is_wf_creator |
      | peter.parker@addworking.com    | Peter     | PARKER     | 1               | 01000000000000 |  1      | 0             |
      | tony.stark@client2.com         | Tony      | STARK      | 0               | 02000000000000 |  2      | 0             |
      | clark.kent@client3.com         | Clark     | KENT       | 0               | 03000000000000 |  3      | 1             |
      | bruce.wayne@client3.com        | Bruce     | WAYNE      | 0               | 03000000000000 |  4      | 0             |

    Et que le chantier suivant existe 
      | number | name        | description | estimated_budget | started_at | ended_at   | owner_siret    | created_by              |
      | 1      | Chantier n1 | blablablaba | 123456789.98     | 2020-02-20 | 2021-12-22 | 03000000000000 | clark.kent@client3.com  |
      | 2      | Chantier n2 | blablablaba | 123456789.98     | 2020-02-20 | 2021-12-22 | 03000000000000 | bruce.wayne@client3.com |
      | 3      | Chantier n3 | blablablaba | 123456789.98     | 2020-02-20 | 2021-12-22 | 02000000000000 | tony.stark@client2.com |

    Et que l'intervenant suivant existe
      | number | work_field_number | contributor_email       | enterprise_siret | is_admin |
      | 1      | 1                 | bruce.wayne@client3.com | 03000000000000   | 1        |
      | 2      | 1                 | tony.stark@client2.com  | 02000000000000   | 0        |
      | 3      | 2                 | clark.kent@client3.com  | 03000000000000   | 0        |
      | 4      | 2                 | tony.stark@client2.com  | 02000000000000   | 1        |
      | 5      | 3                 | bruce.wayne@client3.com | 03000000000000   | 0        |
      | 6      | 3                 | clark.kent@client3.com  | 03000000000000   | 1        |

  @scenario1
  Sc√©nario: Lister les chantiers en tant que cr√©ateur
    Etant donn√© que je suis authentifi√© en tant que utilisateur avec l'email "clark.kent@client3.com"
    Quand j'essaie de lister tous les chantiers dont je suis cr√©ateur
    Alors tous les chantiers sont list√©s

  @scenario2
  Sc√©nario: Lister les chantiers en tant qu'administateur
    Etant donn√© que je suis authentifi√© en tant que utilisateur avec l'email "bruce.wayne@client3.com"
    Quand j'essaie de lister tous les chantiers dont je suis administrateur
    Alors tous les chantiers sont list√©s

  @scenario3
  Sc√©nario: Lister les chantiers en tant qu'intervenant
    Etant donn√© que je suis authentifi√© en tant que utilisateur avec l'email "tony.stark@client2.com"
    Quand j'essaie de lister tous les chantiers dont je suis intervenant
    Alors tous les chantiers sont list√©s