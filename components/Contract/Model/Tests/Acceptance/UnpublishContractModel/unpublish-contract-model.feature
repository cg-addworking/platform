#language: fr
Fonctionnalité: unpublish contract model
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
      | number | siret          | display_name  | published_at | archived_at | name    |
      | 1      | 01000000000000 | draft         | null         | null        | model 1 |
      | 2      | 02000000000000 | published     | 2020-10-01   | null        | model 2 |
      | 3      | 01000000000000 | published     | 2020-10-01   | null        | model 3 |
      | 4      | 02000000000000 | published     | 2020-10-01   | null        | model 4 |

    Et que les contrats suivants existent
      | number | status    | enterprise_siret | name       | valid_from | valid_until | external_identifier | contract_model_number |
      | 1      | draft     | 01000000000000   | Contract 1 | 01-11-2020 | 2020-12-30  | random_ext_id_1     |  4                    |
      | 2      | draft     | 02000000000000   | Contract 2 | 01-11-2020 | 2020-12-30  | random_ext_id_2     |  3                    |
      | 3      | published | 03000000000000   | Contract 3 | 01-11-2020 | 2020-12-30  | random_ext_id_3     |  4                    |

  @scenario1
  Scénario: dépublier un modèle de contrat publié
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de dépublier le modèle de contrat numéro "2"
    Alors le modèle de contrat numéro "2" est dépublié
 
  @scenario2
  Scénario: Impossibilité de dépublier un modèle de contrat s'il n'est pas publié
      Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
      Quand j'essaie de dépublier le modèle de contrat numéro "1"
      Alors une erreur est levée car le modèle de contrat n'est pas publié

  @scenario3
  Scénario: Impossibilité de dépublier un modèle de contrat si l'utilisateur n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de dépublier le modèle de contrat numéro "2"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support

  @scenario4
  Scénario: Impossibilité de dépublier un modèle de contrat s'il a au moins un contrat
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de dépublier le modèle de contrat numéro "4"
    Alors une erreur est levée car le modèle de contrat a au moins un contrat

