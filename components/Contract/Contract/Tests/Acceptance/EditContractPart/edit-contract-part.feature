#language: fr
Fonctionnalité: edit contract part
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | access_to_contract |
      | 01000000000000 | Addworking1 | 0           | 0         | 1                  |
      | 02000000000000 | Client2     | 1           | 0         | 1                  |
      | 03000000000000 | Presta3     | 0           | 1         | 1                  |

    Et que les utilisateurs suivants existent
      | email                      | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com  | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@clideux.com      | Jean      | PAUL     | 0               | 02000000000000 |
      | victor.hugo@miserables.com | Victor    | HUGO     | 0               | 03000000000000 |

    Et que le modèle de contrat suivant existe
      | number | siret          | display_name   | published_at | name  | owner_email           |
      | 1      | 02000000000000 | contract model | 01-11-2020   | model | jean.paul@clideux.com |

    Et que les parties prenantes du modèle suivantes existent
      | contract_model_number | number | denomination  | order |
      | 1                     | 10     | le presta     | 1     |
      | 1                     | 20     | le client     | 2     |

    Et que les pièces du modèle suivantes existent
      | contract_model_number | number | display_name | order | name | should_compile |
      | 1                     | 100    | corps        | 1     | body | 0              |

    Et que le contrat suivant existe
      | number  | name       | contract_model_number | enterprise_siret | status |
      | 110     | contract_1 | 1                     | 02000000000000   | draft  |

    Et que les parties prenantes suivantes existent
      | contract_model_party_number | number | denomination  | order | siret          | contract_number | email                      |
      | 10                          | 101    | le presta     | 1     | 02000000000000 | 110             | victor.hugo@miserables.com |
      | 20                          | 102    | le client     | 2     | 02000000000000 | 110             | jean.paul@clideux.com      |

    Et que les pièces de contrat suivantes existent
      | number  | name        | model_part_number | contract_number | is_hidden |
      | 40      | piece_one   | 100               | 110             | 0         |

@scenario1
  Scénario: Modifier la pièce d'un contrat en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de modifier la pièce de contrat numéro "40"
    Alors la pièce du contrat est modifiée

@scenario2
  Scénario: Impossibilité de modifier la pièce d'un contrat si elle n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de modifier la pièce de contrat numéro "404"
    Alors une erreur est soulevée car la pièce de contrat n'existe pas

@scenario3
  Scénario: Impossibilité de modifier la pièce d'un contrat si l'utilisateur n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de modifier la pièce de contrat numéro "40"
    Alors une erreur est soulevée car l'utilisateur connecté n'est pas support