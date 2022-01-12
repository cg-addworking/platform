#language: fr
Fonctionnalité: edit contract
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

    Et que les contrats suivants existent
      | number | status    | enterprise_siret | name       | valid_from | valid_until | external_identifier |
      | 1      | draft     | 01000000000000   | Contract 1 | 01-11-2020 | 2020-12-30  | random_ext_id_1     |
      | 2      | draft     | 02000000000000   | Contract 2 | 01-11-2020 | 2020-12-30  | random_ext_id_2     |
      | 3      | published | 03000000000000   | Contract 3 | 01-11-2020 | 2020-12-30  | random_ext_id_3     |

  @scenario1
  Scénario: Modifier contrat en mode draft
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de modifier le contrat numéro "1"
    Alors le contrat numéro "1" est modifié

  @scenario2
  Scénario: Impossibilité de modifier un contrat s'il est publié
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de modifier le contrat numéro "3"
    Alors une erreur est levée car le contrat est publié
    