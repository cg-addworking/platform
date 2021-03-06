#language: fr
Fonctionnalit√©: Create Document Type Reject Reason
  Contexte:
    Etant donn√© que les entreprises suivantes existent
      | siret          | parent_siret   | client_siret   | name         | is_customer | is_vendor | access_to_contract |
      | 01000000000000 | null           | null           | Addworking1  | 0           | 0         | 1                  |
      | 02000000000000 | null           | null           | head quarter | 1           | 0         | 1                  |
      | 03000000000000 | 02000000000000 | null           | subsidiary   | 1           | 0         | 1                  |
      | 04000000000000 | null           | null           | not related  | 1           | 0         | 1                  |
      | 05000000000000 | null           | 03000000000000 | vendor 1     | 0           | 1         | 1                  |

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

    Et que les documents suivants existent
      | document_type_display_name | siret          | status    | valid_from |
      | document type 1            | 02000000000000 | validated | 01-01-2021 |
      | document type 2            | 02000000000000 | pending   | 01-01-2021 |
      | document type 3            | 02000000000000 | pending   | 01-01-2021 |
      | document type 1            | 03000000000000 | validated | 01-01-2021 |
      | document type 2            | 03000000000000 | validated | 01-01-2021 |
      | document type 3            | 03000000000000 | validated | 01-01-2021 |

@scenario1
  Sc√©nario: Cr√©er un motif de refus pour un document type en tant que support
    Etant donn√© que je suis authentifi√© en tant que utilisateur avec l'√©mail "batman@addwun.com"
    Quand j'essaie de cr√©er un motif de refus pour le document type "document type 1"
    Alors le motif de refus est cr√©e

@scenario2
  Sc√©nario: Impossibilit√© de cr√©er un motif de refus pour un document type en tant que non support
    Etant donn√© que je suis authentifi√© en tant que utilisateur avec l'√©mail "jean.paul@head-quarter.com"
    Quand j'essaie de cr√©er un motif de refus pour le document type "document type 1"
    Alors une erreur est lev√©e car l'utilisateur connect√© n'est pas support

@scenario3
  Sc√©nario: Cr√©er un motif de refus pour tous les document types
    Etant donn√© que je suis authentifi√© en tant que utilisateur avec l'√©mail "batman@addwun.com"
    Quand j'essaie de cr√©er un motif de refus tous les document types
    Alors le motif de refus est cr√©e

