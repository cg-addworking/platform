#language: fr
Fonctionnalité: publish contract model
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
      | number | siret          | display_name                   | published_at | archived_at |
      | 1      | 02000000000000 | draft with 2 parties & 1 part  | null         | null        |
      | 2      | 02000000000000 | draft with no parties & 1 part | null         | null        |
      | 3      | 02000000000000 | draft with 2 parties & no part | null         | null        |
      | 4      | 02000000000000 | published                      | 2020-10-01   | null        |
      | 5      | 02000000000000 | archived                       | null         | 2020-10-10  |

    Et que les parties prenantes suivantes existent
      | contract_model_number | number | denomination                   | order |
      | 1                     | 1      | party contract model 1 order 1 | 1     |
      | 1                     | 2      | party contract model 1 order 2 | 2     |
      | 1                     | 3      | party contract model 1 order 3 | 3     |
      | 3                     | 4      | party contract model 3 order 1 | 1     |
      | 3                     | 5      | party contract model 3 order 2 | 2     |
      | 3                     | 6      | party contract model 3 order 3 | 3     |
      | 3                     | 7      | party contract model 3 order 4 | 4     |
      | 4                     | 8      | party contract model 4 order 1 | 1     |
      | 4                     | 9      | party contract model 4 order 2 | 2     |
      | 4                     | 10     | party contract model 4 order 3 | 3     |
      | 5                     | 11     | party contract model 5 order 1 | 1     |
      | 5                     | 12     | party contract model 5 order 2 | 2     |

    Et que les pièces suivantes existent
      | contract_model_number | number | display_name  | order | is_initialled | is_signed | should_compile |
      | 1                     | 1      | part number 1 | 1     | 1             | 1         | 1              |
      | 2                     | 2      | part number 2 | 1     | 1             | 1         | 0              |
      | 4                     | 3      | part number 3 | 1     | 1             | 1         | 0              |
      | 4                     | 4      | part number 4 | 2     | 1             | 1         | 1              |
      | 5                     | 5      | part number 5 | 1     | 1             | 1         | 0              |
      | 5                     | 6      | part number 6 | 2     | 1             | 1         | 1              |

  @scenario1
  Scénario: publier un modèle de contrat
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de publier le modèle de contrat numéro "1"
    Alors le modèle de contrat numéro "1" est publié

  @scenario2
  Scénario: Impossibilité de publier un modèle de contrat si l'utilisateur n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de publier le modèle de contrat numéro "1"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support

  @scenario3
  Scénario: Impossibilité de publier un modèle de contrat s'il n'a pas au moins deux parties prenantes
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de publier le modèle de contrat numéro "2"
    Alors une erreur est levée car le modèle de contrat n'a pas au moins deux parties prenantes

  @scenario4
  Scénario: Impossibilité de publier un modèle de contrat s'il n'a pas au moins une pièce
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de publier le modèle de contrat numéro "3"
    Alors une erreur est levée car le modèle de contrat n'a pas au moins une pièce

  @scenario5
  Scénario: Impossibilité de publier un modèle de contrat s'il est publié
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de publier le modèle de contrat numéro "4"
    Alors une erreur est levée car le modèle de contrat est publié

  @scenario6
  Scénario: Impossibilité de publier un modèle de contrat s'il est archivé
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de publier le modèle de contrat numéro "5"
    Alors une erreur est levée car le modèle de contrat est archivé

