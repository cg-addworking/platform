#language: fr
Fonctionnalité: Verifier la non conformité
  Contexte:
    Étant donné que les formes légales suivantes existent
      | name | display_name | country |
      | sas  | SAS          | fr      |
      | sasu | SASU         | fr      |
      | sarl | SARL         | fr      |

    Et que les entreprises suivantes existent
      | siret          | name       | is_customer | is_vendor | legal_form_name |
      | 01000000000000 | ADDWORKING | 0           | 0         | sas             |
      | 02000000000000 | CLIENT A   | 1           | 0         | sasu            |
      | 11000000000000 | VENDOR A   | 0           | 1         | sasu            |
      | 12000000000000 | VENDOR B   | 0           | 1         | sasu            |
      | 13000000000000 | VENDOR C   | 0           | 1         | sasu            |
      | 14000000000000 | VENDOR D   | 0           | 1         | sasu            |
      | 15000000000000 | VENDOR E   | 0           | 1         | sasu            |
      | 16000000000000 | VENDOR F   | 0           | 1         | sasu            |
      | 17000000000000 | VENDOR H   | 0           | 1         | sasu            |

    Et que les partenariats suivants existent
      | customer_siret | vendor_siret   | activity_starts_at  |
      | 02000000000000 | 12000000000000 | null                |
      | 02000000000000 | 13000000000000 | 2021-01-10 00:00:00 |
      | 02000000000000 | 14000000000000 | 2021-01-10 00:00:00 |
      | 02000000000000 | 15000000000000 | 2021-01-10 00:00:00 |
      | 02000000000000 | 16000000000000 | 2021-01-10 00:00:00 |
      | 02000000000000 | 17000000000000 | 2021-01-10 00:00:00 |

    Et que les documents types suivants existent
      | siret          | display_name                          | name                                  | is_mandatory | validity_period | code | type        | legal_form_name |
      | 01000000000000 | doc type 1 from 01 legal mandatory    | doc-type-1-from-01-legal-mandatory    | 1            | 365             | ABCD | legal       | sasu            |
      | 01000000000000 | doc type 2 from 01 legal no mandatory | doc-type-2-from-01-legal-no-mandatory | 0            | 365             | EFGH | legal       | sasu            |
      | 02000000000000 | doc type 3 from 02 legal mandatory    | doc-type-3-from-02-legal-mandatory    | 1            | 365             | IJKL | legal       | sasu            |
      | 02000000000000 | doc type 4 from 02 legal no mandatory | doc-type-4-from-02-legal-no-mandatory | 0            | 365             | MNOP | legal       | sasu            |
      | 01000000000000 | doc type 5 from 01 legal mandatory    | doc-type-5-from-01-legal-mandatory    | 1            | 365             | AAAA | legal       | sasu            |
      | 01000000000000 | doc type 6 from 01 legal mandatory    | doc-type-6-from-01-legal-mandatory    | 1            | 365             | BBBB | legal       | sasu            |
      | 01000000000000 | doc type 7 from 01 legal mandatory    | doc-type-7-from-01-legal-mandatory    | 1            | 365             | CCCC | legal       | sasu            |
      | 01000000000000 | doc type 8 from 01 legal mandatory    | doc-type-8-from-01-legal-mandatory    | 1            | 365             | DDDD | legal       | sasu            |
      | 01000000000000 | doc type 9 from 01 legal mandatory    | doc-type-9-from-01-legal-mandatory    | 1            | 365             | EEEE | legal       | sasu            |

    Et que les documents suivants existent
      | document_type_name                    | document_type_siret | vendor_siret   | status    | valid_from | valid_until | rejected_at |
      | doc-type-1-from-01-legal-mandatory    | 01000000000000      | 11000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-2-from-01-legal-no-mandatory | 01000000000000      | 11000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-3-from-02-legal-mandatory    | 02000000000000      | 11000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-4-from-02-legal-no-mandatory | 02000000000000      | 11000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-5-from-01-legal-mandatory    | 01000000000000      | 11000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-6-from-01-legal-mandatory    | 01000000000000      | 11000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-7-from-01-legal-mandatory    | 01000000000000      | 11000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-8-from-01-legal-mandatory    | 01000000000000      | 11000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-9-from-01-legal-mandatory    | 01000000000000      | 11000000000000 | validated | 01-01-2021 | add_month   | null        |
      #-----------------------------------------------------------------------------------------------------------------------------------#
      | doc-type-1-from-01-legal-mandatory    | 01000000000000      | 12000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-2-from-01-legal-no-mandatory | 01000000000000      | 12000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-3-from-02-legal-mandatory    | 02000000000000      | 12000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-4-from-02-legal-no-mandatory | 02000000000000      | 12000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-5-from-01-legal-mandatory    | 01000000000000      | 12000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-6-from-01-legal-mandatory    | 01000000000000      | 12000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-7-from-01-legal-mandatory    | 01000000000000      | 12000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-8-from-01-legal-mandatory    | 01000000000000      | 12000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-9-from-01-legal-mandatory    | 01000000000000      | 12000000000000 | validated | 01-01-2021 | add_month   | null        |
      #-----------------------------------------------------------------------------------------------------------------------------------#
      | doc-type-1-from-01-legal-mandatory    | 01000000000000      | 13000000000000 | pending   | 01-01-2021 | add_month   | null        |
      | doc-type-2-from-01-legal-no-mandatory | 01000000000000      | 13000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-3-from-02-legal-mandatory    | 02000000000000      | 13000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-4-from-02-legal-no-mandatory | 02000000000000      | 13000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-5-from-01-legal-mandatory    | 01000000000000      | 13000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-6-from-01-legal-mandatory    | 01000000000000      | 13000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-7-from-01-legal-mandatory    | 01000000000000      | 13000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-8-from-01-legal-mandatory    | 01000000000000      | 13000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-9-from-01-legal-mandatory    | 01000000000000      | 13000000000000 | validated | 01-01-2021 | add_month   | null        |
      #-----------------------------------------------------------------------------------------------------------------------------------#
      | doc-type-2-from-01-legal-no-mandatory | 01000000000000      | 14000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-3-from-02-legal-mandatory    | 02000000000000      | 14000000000000 | pending   | 01-01-2021 | add_month   | null        |
      | doc-type-4-from-02-legal-no-mandatory | 02000000000000      | 14000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-5-from-01-legal-mandatory    | 01000000000000      | 14000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-6-from-01-legal-mandatory    | 01000000000000      | 14000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-7-from-01-legal-mandatory    | 01000000000000      | 14000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-8-from-01-legal-mandatory    | 01000000000000      | 14000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-9-from-01-legal-mandatory    | 01000000000000      | 14000000000000 | validated | 01-01-2021 | add_month   | null        |
      #-----------------------------------------------------------------------------------------------------------------------------------#
      | doc-type-1-from-01-legal-mandatory    | 01000000000000      | 15000000000000 | outdated  | 01-01-2021 | sub_month   | null        |
      | doc-type-2-from-01-legal-no-mandatory | 01000000000000      | 15000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-3-from-02-legal-mandatory    | 02000000000000      | 15000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-4-from-02-legal-no-mandatory | 02000000000000      | 15000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-5-from-01-legal-mandatory    | 01000000000000      | 15000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-6-from-01-legal-mandatory    | 01000000000000      | 15000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-7-from-01-legal-mandatory    | 01000000000000      | 15000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-8-from-01-legal-mandatory    | 01000000000000      | 15000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-9-from-01-legal-mandatory    | 01000000000000      | 15000000000000 | validated | 01-01-2021 | add_month   | null        |
      #-----------------------------------------------------------------------------------------------------------------------------------#
      | doc-type-1-from-01-legal-mandatory    | 01000000000000      | 16000000000000 | rejected  | 01-01-2021 | add_month   | sub_month   |
      | doc-type-2-from-01-legal-no-mandatory | 01000000000000      | 16000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-3-from-02-legal-mandatory    | 02000000000000      | 16000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-4-from-02-legal-no-mandatory | 02000000000000      | 16000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-5-from-01-legal-mandatory    | 01000000000000      | 16000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-6-from-01-legal-mandatory    | 01000000000000      | 16000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-7-from-01-legal-mandatory    | 01000000000000      | 16000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-8-from-01-legal-mandatory    | 01000000000000      | 16000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-9-from-01-legal-mandatory    | 01000000000000      | 16000000000000 | validated | 01-01-2021 | add_month   | null        |
      #-----------------------------------------------------------------------------------------------------------------------------------#
      | doc-type-1-from-01-legal-mandatory    | 01000000000000      | 17000000000000 | rejected  | 01-01-2021 | add_month   | sub_month   |
      | doc-type-2-from-01-legal-no-mandatory | 01000000000000      | 17000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-3-from-02-legal-mandatory    | 02000000000000      | 17000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-4-from-02-legal-no-mandatory | 02000000000000      | 17000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-6-from-01-legal-mandatory    | 01000000000000      | 17000000000000 | validated | 01-01-2021 | add_month   | null        |
      | doc-type-7-from-01-legal-mandatory    | 01000000000000      | 17000000000000 | pending   | 01-01-2021 | add_month   | null        |
      | doc-type-8-from-01-legal-mandatory    | 01000000000000      | 17000000000000 | pending   | 01-01-2021 | add_month   | null        |
      | doc-type-9-from-01-legal-mandatory    | 01000000000000      | 17000000000000 | pending   | 01-01-2021 | add_month   | null        |
      #-----------------------------------------------------------------------------------------------------------------------------------#

  @scenario1
  Scénario: Impossiblité de vérifier si le prestataire est inclus dans la liste des prestataires non conformes car ils n'ont pas de partenariat
    Étant donné que l'entreprise de type "customer" avec le siret "02000000000000" existe
    Et que l'entreprise de type "vendor" avec le siret "11000000000000" existe
    Et que les deux entreprises ne sont pas partenaires
    Quand j'essaie de vérifier la conformité du prestataire par rapport au client
    Alors une erreur est levée car le prestataire n'est pas en partenariat avec le client

  @scenario2
  Scénario: vérifier que le prestataire n'est pas inclus dans la liste des non conformes car le prestataire n'est pas actif pour ce client
    Étant donné que l'entreprise de type "customer" avec le siret "02000000000000" existe
    Et que l'entreprise de type "vendor" avec le siret "12000000000000" existe
    Et que les deux entreprises sont partenaires
    Et que les deux entreprises ne sont pas en activité
    Quand j'essaie de vérifier la conformité du prestataire par rapport au client
    Alors une erreur est levée car le prestataire n'est pas actif pour le client

  @scenario3
  Scénario: vérifier que le prestataire n'est pas inclu dans la liste des non conformes s'il n'a que des documents légaux obligatoires addworking/client validé et/ou en attente
    Étant donné que l'entreprise de type "customer" avec le siret "02000000000000" existe
    Et que l'entreprise de type "vendor" avec le siret "13000000000000" existe
    Et que les deux entreprises sont partenaires
    Et que les deux entreprises sont en activité
    Quand j'essaie de vérifier la conformité du prestataire par rapport au client
    Alors le prestataire n'est pas inclus dans la liste des prestataires non conformes de ce client

  @scenario4
  Scénario: vérifier que le prestataire est inclu dans la liste des non conformes car le prestataire a au moins un document obligatoire légal demandé par addworking/client qui est manquant
    Étant donné que l'entreprise de type "customer" avec le siret "02000000000000" existe
    Et que l'entreprise de type "vendor" avec le siret "14000000000000" existe
    Et que les deux entreprises sont partenaires
    Et que les deux entreprises sont en activité
    Quand j'essaie de vérifier la conformité du prestataire par rapport au client
    Alors le prestataire est inclus dans la liste des prestataires non conformes de ce client

  @scenario5
  Scénario: vérifier que le prestataire est inclu dans la liste des non conformes car le prestataire a au moins un document obligatoire légal demandé par addworking/client qui est expiré
    Étant donné que l'entreprise de type "customer" avec le siret "02000000000000" existe
    Et que l'entreprise de type "vendor" avec le siret "15000000000000" existe
    Et que les deux entreprises sont partenaires
    Et que les deux entreprises sont en activité
    Quand j'essaie de vérifier la conformité du prestataire par rapport au client
    Alors le prestataire est inclus dans la liste des prestataires non conformes de ce client

  @scenario6
  Scénario: vérifier que le prestataire est inclu dans la liste des non conformes car le prestataire a au moins un document obligatoire légal demandé par addworking/client qui est rejeté
    Étant donné que l'entreprise de type "customer" avec le siret "02000000000000" existe
    Et que l'entreprise de type "vendor" avec le siret "16000000000000" existe
    Et que les deux entreprises sont partenaires
    Et que les deux entreprises sont en activité
    Quand j'essaie de vérifier la conformité du prestataire par rapport au client
    Alors le prestataire est inclus dans la liste des prestataires non conformes de ce client

  @scenario7
  Scénario: vérifier que le prestataire est inclu dans la liste des non conformes car le prestataire a au moins un document obligatoire légal demandé par addworking/client qui est rejeté et un autre qui est manquant et 3 en attente (pour rassurer Matthieu)
    Étant donné que l'entreprise de type "customer" avec le siret "02000000000000" existe
    Et que l'entreprise de type "vendor" avec le siret "17000000000000" existe
    Et que les deux entreprises sont partenaires
    Et que les deux entreprises sont en activité
    Quand j'essaie de vérifier la conformité du prestataire par rapport au client
    Alors le prestataire est inclus dans la liste des prestataires non conformes de ce client
