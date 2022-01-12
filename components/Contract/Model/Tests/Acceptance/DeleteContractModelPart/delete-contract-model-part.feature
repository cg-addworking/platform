#language: fr
Fonctionnalité: delete contract model part
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
      | 1      | 02000000000000 | contract model draft     | null         | null        |
      | 2      | 02000000000000 | contract model published | 2020-10-01   | null        |
      | 3      | 02000000000000 | contract model archived  | null         | 2020-10-10  |

    Et que les pieces de modeles de contrat suivants existent
      | order | number | contract_model_number | name                  | display_name          | is_initialled | is_signed | should_compile |
      | 1     | 1      | 1                     | contract_model_part_1 | contract model part 1 | 1             | 0         | 1              |
      | 2     | 2      | 2                     | contract_model_part_2 | contract model part 2 | 1             | 0         | 1              |
      | 3     | 3      | 3                     | contract_model_part_3 | contract model part 3 | 1             | 0         | 1              |

  @scenario1
  Scénario: supprimer une piece de modèle de contrat
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de supprimer la piece de contract qui a pour order "1" appartenant au model de contract "1"
    Alors la piece de contract qui a pour order "1" est suppriee

  @scenario2
  Scénario: Impossibilité de supprimer une pièce de modèle de contrat si l'utilisateur n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de supprimer la piece de contract qui a pour order "1" appartenant au model de contract "1"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support

  @scenario3
  Scénario: Impossibilité de supprimer un modèle de contrat s'il est publié
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de supprimer la piece de contract qui a pour order "2" appartenant au model de contract "2"
    Alors une erreur est levée car le modèle de contrat est publié

  @scenario4
  Scénario: Impossibilité de supprimer un modèle de contrat s'il est archivé
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de supprimer la piece de contract qui a pour order "3" appartenant au model de contract "3"
    Alors une erreur est levée car le modèle de contrat est archivé
