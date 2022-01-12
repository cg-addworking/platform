#language: fr
Fonctionnalité: Update Document Type Reject Reason
  Contexte:
    Etant donné que les utilisateurs suivants existent
      | email                        | firstname | lastname | is_system_admin | siret          |
      | gandalf.leblanc@lotr.com     | Gandalf   | Leblanc  | 1               | 01000000000000 |
      | jean.michel@not-related.com  | Jean      | Michel   | 0               | 02000000000000 |
      | pierre.dupont@subsidiary.com | Pierre    | DUPONT   | 0               | 03000000000000 |

    Et que les entreprises suivantes existent
      | siret          | parent_siret   | name         | is_customer | is_vendor |
      | 01000000000000 | null           | Addworking1  | 0           | 0         |
      | 02000000000000 | null           | customer one | 1           | 0         |
      | 03000000000000 | 02000000000000 | customer two | 1           | 0         |

    Et que les documents types suivants existent
      | siret          | display_name    | description          | is_mandatory | validity_period | code | type        |
      | 02000000000000 | document type 1 | Document legal       | 1            | 365             | ABCD | legal       |
      | 02000000000000 | document type 2 | Document Business    | 1            | 365             | EFGH | business    |
      | 02000000000000 | document type 3 | Document contractual | 1            | 365             | IJKL | contractual |
    
    Et que les motifs de refus suivant existent
      | document_type_display_name  | number   | name        | message            |
      | document type 1             | 1        | motif_un    | motif_un_message   |
      | document type 2             | 2        | motif_deux  | motif_deux_message |

@scenario1
  Scénario: Modifier un motif de refus pour un document type en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'émail "gandalf.leblanc@lotr.com"
    Quand j'essaie de modifier le motif de refus numéro "1"
    Alors le motif de refus numéro "1" est modifié

@scenario2
  Scénario: Impossibilité de modifier un motif de refus pour un document type si l'utilisateur n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'émail "jean.michel@not-related.com"
    Quand j'essaie de modifier le motif de refus numéro "2"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support

@scenario3
  Scénario: Impossibilité de modifier un motif de refus pour un document type s'il n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'émail "gandalf.leblanc@lotr.com"
    Quand j'essaie de modifier le motif de refus numéro "5"
    Alors une erreur est levée car le motif de refus n'existe pas

