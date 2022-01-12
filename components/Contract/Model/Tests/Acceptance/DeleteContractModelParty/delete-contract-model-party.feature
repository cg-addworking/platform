#language: fr
Fonctionnalité: delete contract model party
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
      | 2      | 02000000000000 | contract model draft 2   | null         | null        |
      | 3      | 02000000000000 | contract model published | 2020-10-01   | null        |
      | 4      | 02000000000000 | contract model archived  | null         | 2020-10-10  |

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
      | 4                     | 10     | party contract model 4 order 1 | 1     |
      | 4                     | 11     | party contract model 4 order 2 | 2     |
      | 4                     | 12     | party contract model 4 order 3 | 3     |

  @scenario1
  Scénario: Supprimer une partie prenante
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de supprimer la partie prenante avec l'ordre "3" appartenant au modèle de contrat numéro "1"
    Alors la partie prenante sous l'ordre "3" appartenant au modèle de contract numéro "1" est supprimée

  @scenario2
  Scénario: Impossibilité de supprimer une partie prenante si inférieure à 2 parties
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de supprimer la partie prenante avec l'ordre "2" appartenant au modèle de contrat numéro "2"
    Alors une erreur est levée car le modèle de contrat ne possède que 2 parties prenantes

  @scenario3
  Scénario: Impossibilité de supprimer une partie prenante si l'utilisateur n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de supprimer la partie prenante avec l'ordre "3" appartenant au modèle de contrat numéro "1"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support

  @scenario4
  Scénario: Impossibilité de supprimer une partie prenante si le modèle de contrat est publié
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de supprimer la partie prenante avec l'ordre "3" appartenant au modèle de contrat numéro "3"
    Alors une erreur est levée car le modèle de contrat est publié

  @scenario5
  Scénario: Impossibilité de supprimer une partie prenante si le modèle de contrat est archivé
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de supprimer la partie prenante avec l'ordre "3" appartenant au modèle de contrat numéro "4"
    Alors une erreur est levée car le modèle de contrat est archivé