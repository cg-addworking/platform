#language: fr
Fonctionnalité: create document type model
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | access_to_contract |
      | 01000000000000 | Addworking1 | 0           | 0         | 1                  |
      | 02000000000000 | Client2     | 1           | 0         | 1                  |

    Et que les utilisateurs suivants existent
      | email                      | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com  | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@clideux.com      | Jean      | PAUL     | 0               | 02000000000000 |

    Et que les documents types suivants existent
      | siret          | display_name    | description          | is_mandatory | validity_period | code | type        | legal_form_name |
      | 01000000000000 | document type 1 | Document legal       | 1            | 365             | ABCD | legal       | sasu            |

  @scenario1
  Scénario: Créer un document type model pour un document type
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de créer un document type model pour le document type "document type 1"
    Alors le document type "document type 1" possède un document type model

  @scenario2
  Scénario: Impossibilité de créer un document type model pour un document type sans être membre du support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de créer un document type model pour le document type "document type 1"
    Alors une erreur est levée car je ne suis pas membre du support