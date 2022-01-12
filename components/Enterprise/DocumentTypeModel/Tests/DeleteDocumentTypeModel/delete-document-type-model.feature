#language: fr
Fonctionnalité: delete document type model
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | access_to_contract |
      | 01000000000000 | Addworking  | 0           | 0         | 1                  |
      | 02000000000000 | Client1     | 1           | 0         | 1                  |

    Et que les utilisateurs suivants existent
      | email                       | firstname | lastname | is_system_admin | siret          |
      | peter.parker@addworking.com | Peter     | PARKER   | 1               | 01000000000000 |
      | tony.stark@client.com       | Tony      | STARK    | 0               | 02000000000000 |

    Et que les documents types suivants existent
      | siret          | display_name    | description          | is_mandatory | validity_period | code | type        | legal_form_name |
      | 01000000000000 | document type 1 | Document legal       | 1            | 365             | ABCD | legal       | sasu            |
      | 02000000000000 | document type 2 | Document legal       | 1            | 365             | ABCD | legal       | sasu            |

    Et que les documents types model suivants existent
      | number    | type             | name                   | display_name          | description | content      |
      |  1        | document type 1  | document_type_model_1  | document type model 1 | Attestation | blablablabla |
      |  2        | document type 2  | document_type_model_2  | document type model 1 | Attestation | blablablabla |
      |  3        | document type 2  | document_type_model_3  | document type model 2 | Attestation | blablablabla |
      |  4        | document type 2  | document_type_model_4  | document type model 3 | Attestation | blablablabla |

  @scenario1
  Scénario: Supprimer un document type model pour un document type
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "peter.parker@addworking.com"
    Quand j'essaie de supprimer le document type model numéro "1"
    Alors le document type model "1" est supprimé

  @scenario2
  Scénario: Impossibilité de supprimer un document type model pour un document type si l'utilisateur n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "tony.stark@client.com"
    Quand j'essaie de supprimer le document type model numéro "2"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support