#language: fr
Fonctionnalité: Delete Document Type Reject Reason
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | parent_siret   | name         | is_customer | is_vendor | access_to_contract |
      | 01000000000000 | null           | Addworking1  | 0           | 0         | 1                  |
      | 02000000000000 | null           | Client1      | 1           | 0         | 1                  |
      | 03000000000000 | 02000000000000 | Client2      | 1           | 0         | 1                  |
      | 04000000000000 | null           | Client3      | 1           | 0         | 1                  |

    Et que les utilisateurs suivants existent
      | email                        | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com    | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@head-quarter.com   | Jean      | PAUL     | 0               | 02000000000000 |
      | pierre.dupont@subsidiary.com | Pierre    | DUPONT   | 0               | 03000000000000 |
      | jean.michel@not-related.com  | Jean      | Michel   | 0               | 04000000000000 |

    Et que les documents types suivants existent
      | siret          | display_name    | description          | is_mandatory | validity_period | code | type        | legal_form_name |
      | 02000000000000 | document type 1 | Document legal       | 1            | 365             | ABCD | legal       | sasu            |
      | 02000000000000 | document type 2 | Document Business    | 1            | 365             | EFGH | business    | sasu            |
      | 02000000000000 | document type 3 | Document contractual | 1            | 365             | IJKL | contractual | sasu            |

    Et que les motifs de refus suivants existent
      | number | document_type_display_name | name             | display_name     | message        |
      |  1     | document type 1            | motif de refus 1 | motif de refus 1 | description 1  |
      |  2     | document type 2            | motif de refus 2 | motif de refus 2 | description  2 |

@scenario1
  Scénario: Supprimer un motif de refus pour un document type en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'émail "antoine.pierre@addwun.com"
    Quand j'essaie de supprimer le motif de refus numéro "1"
    Alors le motif de refus numéro "1" est supprimé

@scenario2
  Scénario: Impossibilité de supprimer un motif de refus pour un document type si l'utilisateur connecté n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'émail "jean.paul@head-quarter.com"
    Quand j'essaie de supprimer le motif de refus numéro "2"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support


