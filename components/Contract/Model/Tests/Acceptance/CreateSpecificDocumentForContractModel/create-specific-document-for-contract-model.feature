#language: fr
Fonctionnalité: Create Specific Document For Contract Model
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | access_to_contract |
      | 01000000000000 | Addworking1 | 0           | 0         | 1                  |
      | 02000000000000 | Client2     | 1           | 0         | 1                  |

    Et que les utilisateurs suivants existent
      | email                      | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com  | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@clideux.com      | Jean      | PAUL     | 0               | 02000000000000 |

    Et que les modèles de contrat suivants existent
      | number | siret          | display_name             | published_at | archived_at |
      | 1      | 01000000000000 | contract model draft     | null         | null        |
      | 2      | 01000000000000 | contract model published | 2020-10-01   | null        |
      | 3      | 01000000000000 | contract model archived  | null         | 2020-10-01  |

    Et que les parties prenantes suivantes existent
      | contract_model_number | number | denomination                   | order |
      | 1                     | 1      | party contract model 1 order 1 | 1     |
      | 1                     | 2      | party contract model 1 order 2 | 2     |
      | 2                     | 3      | party contract model 2 order 1 | 1     |
      | 2                     | 4      | party contract model 2 order 2 | 2     |
      | 3                     | 5      | party contract model 3 order 1 | 1     |
      | 3                     | 6      | party contract model 3 order 2 | 2     |

  @scenario1
  Scénario: Créer un document spécifique pour une partie prenant d'un modèle de contrat
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de créer un document spécifique pour la partie prenante "1" du modele de contrat numero "1"
    Alors le document spécifique est créé

  @scenario2
  Scénario: Impossibilité de créer un document spécifique pour une partie prenant d'un modèle de contrat si l'utilisateur n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de créer un document spécifique pour la partie prenante "1" du modele de contrat numero "1"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support

  @scenario3
  Scénario: Impossibilité de créer un document spécifique pour une partie prenant d'un modèle de contrat s'il est publié
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de créer un document spécifique pour la partie prenante "2" du modele de contrat numero "2"
    Alors une erreur est levée car le modèle de contrat est publié

  @scenario4
  Scénario: Impossibilité de créer un document spécifique pour une partie prenant d'un modèle de contrat s'il est archivé
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de créer un document spécifique pour la partie prenante "2" du modele de contrat numero "3"
    Alors une erreur est levée car le modèle de contrat est archivé
