#language: fr
Fonctionnalité: list des motifs de refus de document type
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | parent_siret   | client_siret   | name         | is_customer | is_vendor |
      | 01000000000000 | null           | null           | Addworking1  | 0           | 0         |
      | 02000000000000 | null           | null           | head quarter | 1           | 0         |
      | 03000000000000 | 02000000000000 | null           | subsidiary   | 1           | 0         |
      | 04000000000000 | null           | null           | not related  | 1           | 0         |
      | 05000000000000 | null           | 03000000000000 | vendor 1     | 0           | 1         |

    Et que les utilisateurs suivants existent
      | email                        | firstname | lastname | is_system_admin | siret          |
      | batman@addwun.com            | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@head-quarter.com   | Jean      | PAUL     | 0               | 02000000000000 |
      | pierre.dupont@subsidiary.com | Pierre    | DUPONT   | 0               | 03000000000000 |
      | jean.michel@not-related.com  | Jean      | Michel   | 0               | 04000000000000 |
      | gandalf.leblanc@lotr.com     | Gandalf   | Leblanc  | 0               | 05000000000000 |

    Et que les documents types suivants existent
      | siret          | display_name    | description          | is_mandatory | validity_period | code | type        | legal_form_name |
      | 02000000000000 | document type 1 | Document legal       | 1            | 365             | ABCD | legal       | sasu            |
      | 02000000000000 | document type 2 | Document Business    | 1            | 365             | EFGH | business    | sasu            |
      | 02000000000000 | document type 3 | Document contractual | 1            | 365             | IJKL | contractual | sasu            |

    Et que les motifs de refus de documents types suivants existent
     | name                 | display_name                 | number | message   | document_type_display_name |
     | reject reason name 1 | reject reason display name 1 | 1      | message_1 | document type 1            |
     | reject reason name 2 | reject reason display name 2 | 2      | message_2 | null                       |
     | reject reason name 3 | reject reason display name 3 | 3      | message_3 | document type 1            |
     | reject reason name 4 | reject reason display name 4 | 4      | message_4 | document type 2            |
     | reject reason name 5 | reject reason display name 5 | 5      | message_5 | document type 2            |

  @scenario1
  Scénario: Lister les motifs de refus de documents types
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "batman@addwun.com"
    Quand j'essaie de lister tous les motifs de refus du document type "document type 1"
    Alors tous les motifs de refus du document type sont listés

  @scenario2
  Scénario: Impossibilité de lister les motifs de refus de documents types pour les non support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "gandalf.leblanc@lotr.com"
    Quand j'essaie de lister tous les motifs de refus du document type "document type 1"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support
