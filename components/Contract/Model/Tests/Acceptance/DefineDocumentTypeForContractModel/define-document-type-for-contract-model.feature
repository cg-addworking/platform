#language: fr
Fonctionnalité: Define document for a steakholder
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
      | siret          | display_name | description          | validity_period | code | type        |
      | 02000000000000 | DOC 1        | Document legal       | 365             | ABCD | legal       |
      | 02000000000000 | DOC 2        | Document Business    | 365             | EFGH | business    |
      | 02000000000000 | DOC 3        | Document contractual | 365             | IJKL | contractual |
      | 02000000000000 | DOC 4        | Document legal       | 365             | MNOP | legal       |
      | 02000000000000 | DOC 5        | Document legal       | 365             | QRST | legal       |
      | 02000000000000 | DOC 6        | Document legal       | 365             | UVWX | legal       |
    Et que les modèles de contrat suivants existent
      | number | siret          | display_name             | published_at | archived_at |
      | 1      | 02000000000000 | contract model draft     | null         | null        |
      | 2      | 02000000000000 | contract model published | 2020-10-01   | null        |
      | 3      | 02000000000000 | contract model archived  | null         | 2020-10-10  |
    Et que les parties prenantes suivantes existent
      | contract_model_number | number | denomination                   | order |
      | 1                     | 1      | party contract model 1 order 1 | 1     |
      | 1                     | 2      | party contract model 1 order 2 | 2     |
      | 1                     | 3      | party contract model 1 order 3 | 3     |
      | 2                     | 4      | party contract model 2 order 1 | 1     |
      | 2                     | 5      | party contract model 2 order 2 | 2     |
      | 3                     | 6      | party contract model 3 order 1 | 1     |
      | 3                     | 7      | party contract model 3 order 2 | 2     |
      | 3                     | 8      | party contract model 3 order 3 | 3     |
      | 3                     | 9      | party contract model 3 order 4 | 4     |

  @scenario1
  Scénario: Definir un document type pour une partie prenante d'un modele de contrat
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de definir un document type pour la partie prenante "1" du modele de contrat numero "1"
    Alors La partie prenante numero "1" du modele de contrat numero "1" possede un document type

  @scenario2
  Scénario: Impossibilité de definir un document type pour une partie prenante d'un modele de contrat si l'utilisateur n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de definir un document type pour la partie prenante "1" du modele de contrat numero "1"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support

  @scenario3
  Scénario: Impossibilité de definir un document type pour une partie prenante d'un modele de contrat s'il est publié
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de definir un document type pour la partie prenante "2" du modele de contrat numero "2"
    Alors une erreur est levée car le modèle de contrat est publié

  @scenario4
  Scénario: Impossibilité de definir un document type pour une partie prenante d'un modele de contrat s'il est archivé
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de definir un document type pour la partie prenante "3" du modele de contrat numero "3"
    Alors une erreur est levée car le modèle de contrat est archivé
