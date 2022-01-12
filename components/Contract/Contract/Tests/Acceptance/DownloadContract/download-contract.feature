#language: fr
Fonctionnalité: download contract
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | client_siret   |
      | 01000000000000 | Addworking1 | 0           | 0         | null           |
      | 02000000000000 | Client2     | 1           | 0         | null           |
      | 03000000000000 | Presta3     | 0           | 1         | 02000000000000 |
      | 04000000000000 | Presta4     | 0           | 1         | 02000000000000 |
      | 05000000000000 | Presta5     | 0           | 1         | null           |

    Et que les utilisateurs suivants existent
      | email                      | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com  | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@clideux.com      | Jean      | PAUL     | 0               | 02000000000000 |
      | victor.hugo@miserables.com | Victor    | HUGO     | 0               | 03000000000000 |
      | emile.zola@bonheur.com     | Emile     | ZOLA     | 0               | 04000000000000 |
      | bruce.wayne@vendor.com     | BRUCE     | WAYNE    | 0               | 05000000000000 |

    Et que le modèle de contrat suivant existe
      | number | siret          | display_name   | published_at | name  | owner_email           |
      | 1      | 02000000000000 | contract model | 01-11-2020   | model | jean.paul@clideux.com |

    Et que les parties prenantes du modèle suivantes existent
      | contract_model_number | number | denomination  | order |
      | 1                     | 15     | le client     | 1     |
      | 1                     | 16     | le presta     | 2     |

    Et que les pièces du modèle suivantes existent
      | contract_model_number | number | display_name | order | name   |
      | 1                     | 150    | pièce_1      | 1     | pièce1 |
      | 1                     | 155    | pièce_2      | 2     | pièce2 |
      | 1                     | 215    | pièce_3      | 3     | pièce3 |

    Et que les contrats suivants existent
      | number  | name      | state  | contract_model_number | enterprise_siret |
      | 110     | contract1 | active | 1                     | 02000000000000   |
      | 120     | contract2 | draft  | null                  | 02000000000000   |

    Et que les pièces de contrat suivantes existent
      | number  | name    | model_part_number | contract_number |
      | 1      | piece_1  | 150               | 110             |
      | 2      | piece_2  | 155               | 110             |

   Et que les parties prenantes suivantes existent
      | contract_model_party_number | number | denomination  | order | siret          | contract_number | email                      |
      | 10                          | 101    | le client     | 1     | 02000000000000 | 110             | jean.paul@clideux.com      |
      | 20                          | 202    | le presta     | 2     | 03000000000000 | 110             | victor.hugo@miserables.com |

  @scenario1
  Scénario: télécharger un contrat en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de télécharger le contrat numéro "110"
    Alors le contrat est téléchargé

  @scenario2
  Scénario: télécharger un contrat en tant que partie prenante du contrat
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "victor.hugo@miserables.com"
    Quand j'essaie de télécharger le contrat numéro "110"
    Alors le contrat est téléchargé

  @scenario3
  Scénario: télécharger un contrat en tant qu'entreprise propriétaire
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de télécharger le contrat numéro "110"
    Alors le contrat est téléchargé
  
  @scenario4
  Scénario: Impossibilité de télécharger un contrat s'il est en brouillon
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "victor.hugo@miserables.com"
    Quand j'essaie de télécharger le contrat numéro "120"
    Alors une erreur est levée car le contrat est en brouillon

  @scenario5
  Scénario: Impossibilité de télécharger un contrat s'il n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de télécharger le contrat numéro "15"
    Alors une erreur est levée car le contrat n'existe pas
  
  @scenario6
  Scénario: Impossibilité de télécharger un contrat si l'entreprise n'est pas propriétaire/ non partie prenante
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "bruce.wayne@vendor.com"
    Quand j'essaie de télécharger le contrat numéro "110"
    Alors une erreur est levée car l'entreprise n'est pas propriétaire/ non partie prenante