#language: fr
Fonctionnalité: show contract
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | access_to_contract |
      | 01000000000000 | Addworking1 | 0           | 0         | 1                  |
      | 02000000000000 | Client2     | 1           | 0         | 1                  |
      | 03000000000000 | Presta3     | 0           | 1         | 1                  |
      | 04000000000000 | Presta4     | 0           | 1         | 1                  |

    Et que les utilisateurs suivants existent
      | email                      | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com  | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@clideux.com      | Jean      | PAUL     | 0               | 02000000000000 |
      | victor.hugo@miserables.com | Victor    | HUGO     | 0               | 03000000000000 |
      | emile.zola@bonheur.com     | Emile     | ZOLA     | 0               | 04000000000000 |

    Et que le modèle de contrat suivant existe
      | number | siret          | display_name   | published_at | name  | owner_email           |
      | 1      | 02000000000000 | contract model | 01-11-2020   | model | jean.paul@clideux.com |

    Et que les parties prenantes du modèle suivantes existent
      | contract_model_number | number | denomination  | order |
      | 1                     | 10     | le client     | 1     |
      | 1                     | 20     | le presta     | 2     |

    Et que les pièces du modèle suivantes existent
      | contract_model_number | number | display_name | order | name |
      | 1                     | 100    | tête         | 1     | head |
      | 1                     | 200    | corps        | 2     | body |
      | 1                     | 300    | pied         | 3     | foot |

    Et que le contrat suivant existe
      | number  | name       | contract_model_number | enterprise_siret |
      | 110     | contract_1 | 1                     | 02000000000000   |

   Et que les parties prenantes suivantes existent
      | contract_model_party_number | number | denomination  | order | siret          | contract_number | email                      |
      | 10                          | 101    | le client     | 1     | 02000000000000 | 110             | jean.paul@clideux.com      |
      | 20                          | 202    | le presta     | 2     | 03000000000000 | 110             | victor.hugo@miserables.com |

  @scenario1
  Scénario: Voir le détail d'un contrat en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de voir le détail du contrat numéro "110"
    Alors le détail du contrat numéro "110" est affiché

  @scenario2
  Scénario: Voir le détail d'un contrat en tant que partie prenante du contrat
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "victor.hugo@miserables.com"
    Quand j'essaie de voir le détail du contrat numéro "110"
    Alors le détail du contrat numéro "110" est affiché

  @scenario3
  Scénario: Impossibilité de voir le détail d'un contrat s'il n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de voir le détail du contrat numéro "42"
    Alors une erreur est levée car le contrat n'existe pas