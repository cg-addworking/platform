#language: fr
Fonctionnalit√©: attacher un intervenant √† un chantier
  Contexte:
    Etant donn√© que les secteurs suivants  existent
      | number | name         | display_name |
      | 1      | construction | Construction |
      | 2      | transport    | Transport    |
      | 1      | it           | IT           |

    Et que les entreprises suivantes existent
      | siret          | parent_siret   | client_siret   | name       | is_customer | is_vendor | sector_number |
      | 01000000000000 | null           | null           | Addworking | 0           | 0         | 1             |
      | 02000000000000 | null           | null           | client 1   | 1           | 0         | 1             |
      | 03000000000000 | 02000000000000 | null           | client 2   | 1           | 0         | 1             |
      | 04000000000000 | 02000000000000 | null           | client 3   | 1           | 0         | 2             |
      | 05000000000000 | null           | 03000000000000 | vendor 1   | 0           | 1         | null          |

    Et que les utilisateurs suivants existent
      | email                          | firstname | lastname   | is_system_admin | siret          |  number | is_work_field_creator |
      | peter.parker@addworking.com    | Peter     | PARKER     | 1               | 01000000000000 |  1      | 0                     |
      | tony.stark@client2.com         | Tony      | STARK      | 0               | 02000000000000 |  2      | 1                     |
      | jarvis.stark@client2.com       | Jarvis    | STARK      | 0               | 02000000000000 |  3      | 1                     |
      | john.smith@client2.com         | John      | SMITH      | 0               | 02000000000000 |  4      | 1                     |
      | clark.kent@client3.com         | Clark     | KENT       | 0               | 03000000000000 |  5      | 0                     |
      | natasha.roumanouff@client4.com | Natasha   | ROUMANOUFF | 0               | 04000000000000 |  6      | 1                     |
      | bruce.wayne@client5.com        | Bruce     | WAYNE      | 0               | 05000000000000 |  7      | 1                     |

    Et que les chantiers suivants existent
      | number | owner_siret    | name                 | display_name        | created_by_email       |
      | 1      | 02000000000000 | construction site  1 | Construction site 1 | tony.stark@client2.com |

    Et que les intervenants suivants existent
      | number | work_field_number | contributor_email      | enterprise_siret | is_admin | role  |
      | 1      | 1                 | john.smith@client2.com | 02000000000000   | 1        | buyer |

  @scenario1
  Sc√©nario: Attacher un intervenant √† un chantier en tant que cr√©ateur du dit chantier
    Etant donn√© que je suis authentifi√© en tant que utilisateur avec l'√©mail "tony.stark@client2.com"
    Quand j'essaie d'attacher l'intervenant avec l'email "jarvis.stark@client2.com" de l'entreprise avec le siret num√©ro "02000000000000" au chantier num√©ro "1"
    Alors l'intervenant avec l'email "jarvis.stark@client2.com" est attach√© au chantier num√©ro "1"

  @scenario2
  Sc√©nario: Attacher un intervenant √† un chantier quand il est membre d'une filiale de l'entreprise propri√©taire
    Etant donn√© que je suis authentifi√© en tant que utilisateur avec l'√©mail "tony.stark@client2.com"
    Quand j'essaie d'attacher l'intervenant avec l'email "clark.kent@client3.com" de l'entreprise avec le siret num√©ro "03000000000000" au chantier num√©ro "1"
    Alors l'intervenant avec l'email "clark.kent@client3.com" est attach√© au chantier num√©ro "1"

  @scenario3
  Sc√©nario: Impossibilit√© d'attacher un intervenant √† un chantier si le futur intervenant n'est pas membre de l'entreprise propri√©taire ou d'une de ses filiales
    Etant donn√© que je suis authentifi√© en tant que utilisateur avec l'√©mail "tony.stark@client2.com"
    Quand j'essaie d'attacher l'intervenant avec l'email "bruce.wayne@client5.com" de l'entreprise avec le siret num√©ro "05000000000000" au chantier num√©ro "1"
    Alors une erreur est lev√©e car le futur intervenant n'est pas membre de l'entreprise propri√©taire ou d'une de ses filiales

  @scenario4
  Sc√©nario: Attacher un intervenant √† un chantier en tant qu'administrateur du chantier
    Etant donn√© que je suis authentifi√© en tant que utilisateur avec l'√©mail "john.smith@client2.com"
    Et que je suis administrateur du chantier num√©ro "1"
    Quand j'essaie d'attacher l'intervenant avec l'email "jarvis.stark@client2.com" de l'entreprise avec le siret num√©ro "02000000000000" au chantier num√©ro "1"
    Alors l'intervenant avec l'email "jarvis.stark@client2.com" est attach√© au chantier num√©ro "1"

  @scenario5
  Sc√©nario: Impossibilit√© d'attacher un intervenant s'il est d√©j√† attach√© au m√™me chantier
    Etant donn√© que je suis authentifi√© en tant que utilisateur avec l'√©mail "tony.stark@client2.com"
    Quand j'essaie d'attacher l'intervenant avec l'email "john.smith@client2.com" de l'entreprise avec le siret num√©ro "02000000000000" au chantier num√©ro "1"
    Alors une erreur est lev√©e car le futur intervenant est d√©j√† intervenant du chantier
