#language: fr
Fonctionnalité: list document type of contract model by party
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
      | 01000000000000 | DOC 1        | Document legal       | 365             | ABCD | legal       |
      | 02000000000000 | DOC 2        | Document Business    | 365             | EFGH | business    |
      | 02000000000000 | DOC 3        | Document contractual | 365             | IJKL | contractual |

    Et que les modèles de contrat suivants existent
      | number | siret          | display_name             | published_at | archived_at |
      | 1      | 02000000000000 | contract model draft     | null         | null        |

    Et que les parties prenantes suivantes existent
      | contract_model_number | number | denomination                   | order |
      | 1                     | 1      | party contract model 1 order 1 | 1     |

    Et que les documents types sont definis pour les parties prenantes existent
      | number | contract_model_number | contract_model_party_order | document_type_display_name | validation_required |
      | 1      | 1                     | 1                          | DOC 1                      | 1                   |
      | 2      | 1                     | 1                          | DOC 2                      | 0                   |
      | 3      | 1                     | 1                          | DOC 3                      | 0                   |

  @scenario1
  Scénario: Lister les documents type d'une partie prenante d'un modele de contrat
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de lister tout les documents type de la  partie prenante "1" du modele de contrat numero 1
    Alors les documents type de la  partie prenante sont listés

  @scenario2
  Scénario: Impossibilité de lister les documents type d'une partie prenante d'un modele de contrat si l'utilisateur n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de lister tout les documents type de la  partie prenante "1" du modele de contrat numero 1
    Alors une erreur est levée car l'utilisateur connecté n'est pas support

  @scenario3
  Scénario: Impossibilité de lister les documents type d'une partie prenante d'un modele de contrat si la partie prenante n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de lister tout les documents type de la  partie prenante "2" du modele de contrat numero 1
    Alors une erreur est levée car la partie prenante n'existe pas
