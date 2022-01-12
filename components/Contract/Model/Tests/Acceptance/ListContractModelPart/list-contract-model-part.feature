#language: fr
Fonctionnalité: list contract model pieces
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | access_to_contract |
      | 01000000000000 | Addworking1 | 0           | 0         | 1                  |
      | 02000000000000 | Client2     | 1           | 0         | 1                  |
      | 03000000000000 | Client3     | 1           | 0         | 1                  |
      | 04000000000000 | Presta1     | 0           | 1         | 1                  |


    Et que les utilisateurs suivants existent
      | email                      | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com  | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@clideux.com      | Jean      | PAUL     | 0               | 02000000000000 |
      | victor.hugo@miserables.com | Victor    | HUGO     | 0               | 03000000000000 |
      | claude.b@presta.com        | Claude    | BERNAT   | 0               | 04000000000000 |

    Et que les modèles de contrat suivants existent
      | number | siret          | display_name             | published_at | archived_at |
      | 1      | 02000000000000 | contract model draft     | null         | null        |
      | 2      | 02000000000000 | contract model published | 2020-10-01   | null        |
      | 3      | 02000000000000 | contract model archived  | 2020-10-05   | 2020-10-10  |
      | 4      | 03000000000000 | contract model published | 2020-10-10   | null        |
      | 5      | 03000000000000 | contract model archived  | 2020-10-02   | 2020-10-10  |
      | 6      | 04000000000000 | contract model published | 2020-10-10   | null        |

    Et que les pieces de modeles de contrat suivants existent
      | order | contract_model_number | number | name    | display_name | is_initialled | is_signed | should_compile |
      | 1     | 1                     | 1      | piece_1 | piece 1      | 1             | 0         | 1              |
      | 2     | 2                     | 2      | piece_2 | piece 2      | 1             | 0         | 1              |
      | 3     | 3                     | 3      | piece_3 | piece 3      | 1             | 0         | 1              |
      | 4     | 4                     | 4      | piece_4 | piece 4      | 1             | 0         | 1              |

  @scenario1
  Scénario: Lister les pieces de modeles de contrats
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de lister toute les pieces du model de contract numero "1"
    Alors toute les pieces du modeles de contrats numero "1" sont listes

  @scenario2
  Scénario: Impossibilité de lister les modèles de contrat si l'utilisateur n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de lister toute les pieces du model de contract numero "1"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support
