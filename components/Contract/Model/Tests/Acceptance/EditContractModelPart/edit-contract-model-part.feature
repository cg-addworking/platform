#language: fr
Fonctionnalité: edit contract model part
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | access_to_contract |
      | 01000000000000 | Addworking1 | 0           | 0         | 1                  |
      | 02000000000000 | Client2     | 1           | 0         | 1                  |
      | 03000000000000 | Client3     | 1           | 0         | 1                  |

    Et que les utilisateurs suivants existent
      | email                      | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com  | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@clideux.com      | Jean      | PAUL     | 0               | 02000000000000 |
      | victor.hugo@miserables.com | Victor    | HUGO     | 0               | 03000000000000 |

    Et que les modèles de contrat suivants existent
      | number | siret          | display_name             | published_at | archived_at |
      | 1      | 02000000000000 | contract model draft     | null         | null        |
      | 2      | 02000000000000 | contract model published | 2020-10-01   | null        |
      | 3      | 02000000000000 | contract model archived  | null         | 2020-10-10  |

    Et que les parties prenantes suivantes existent
      | contract_model_number | number | denomination | order |
      | 1                     | 1      | party 1      | 1     |
      | 1                     | 2      | party 2      | 2     |
      | 1                     | 3      | party 3      | 3     |
      | 2                     | 4      | party 1      | 1     |
      | 2                     | 5      | party 2      | 2     |
      | 3                     | 6      | party 1      | 1     |
      | 3                     | 7      | party 2      | 2     |
      | 3                     | 8      | party 3      | 3     |
      | 3                     | 9      | party 4      | 4     |

    Et que les pièces suivantes existent
      | contract_model_number | number | display_name  | order | is_initialled | is_signed | should_compile | signature_mention | signature_page |
      | 1                     | 1      | part number 1 | 1     | 1             | 1         | 1              | approved          | 1              |
      | 1                     | 2      | part number 2 | 2     | 1             | 1         | 0              | approved          | 1              |
      | 1                     | 3      | part number 3 | 3     | 1             | 1         | 1              | approved          | 1              |
      | 2                     | 4      | part number 4 | 1     | 1             | 1         | 0              | approved          | 1              |
      | 2                     | 5      | part number 5 | 2     | 1             | 1         | 1              | approved          | 1              |
      | 3                     | 6      | part number 6 | 1     | 1             | 1         | 0              | approved          | 1              |
      | 3                     | 7      | part number 7 | 1     | 1             | 1         | 1              | approved          | 1              |
      | 3                     | 8      | part number 8 | 1     | 1             | 1         | 0              | approved          | 1              |
      | 3                     | 9      | part number 9 | 1     | 1             | 1         | 1              | approved          | 1              |

    Et que les variables suivantes existent
      | contract_model_number | contract_model_party_number | contract_model_part_number | number | name               |
      | 1                     | 1                           | 1                          | 1      | party_1_variable_1 |
      | 1                     | 1                           | 1                          | 2      | party_1_variable_2 |
      | 1                     | 3                           | 3                          | 3      | party_3_variable_1 |
      | 2                     | 5                           | 5                          | 4      | party_2_variable_1 |
      | 2                     | 5                           | 5                          | 5      | party_2_variable_2 |
      | 2                     | 5                           | 5                          | 6      | party_2_variable_3 |

  @scenario1
  Scénario: Modifier une pièce du modèle de contrat avec zone de texte
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de modifier la pièce numéro "1"
    Alors la pièce numéro "1" est modifiée

  @scenario2
  Scénario: Modifier une pièce du modèle de contrat avec fichier
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de modifier la pièce numéro "2"
    Alors la pièce numéro "2" est modifiée

  @scenario3
  Scénario: Impossibilité de modifier une pièce si l'utilisateur n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de modifier la pièce numéro "1"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support

  @scenario4
  Scénario: Impossibilité de modifier une pièce si le modèle de contrat est publié
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de modifier la pièce numéro "4"
    Alors une erreur est levée car le modèle de contrat est publié

  @scenario5
  Scénario: Impossibilité de modifier une pièce si le modèle de contrat est archivé
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de modifier la pièce numéro "6"
    Alors une erreur est levée car le modèle de contrat est archivé
