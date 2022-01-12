#language: fr
Fonctionnalité: create contract part
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
      | claude.monet@art.com       | Claude    | Monet    | 0               | 04000000000000 |

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

      Et que les contrats suivants existent
      | number  | name       | contract_model_number | enterprise_siret | status | yousign_procedure_id |
      | 451     | contract_1 | 1                     | 02000000000000   | draft  | null                 |
      | 42      | contract_2 | 1                     | 02000000000000   | draft  | null                 |
      | 300     | contract_3 | 1                     | 02000000000000   | signed | random_id            |

      Et que les parties prenantes suivantes existent
      | contract_model_party_number | number | denomination   | order | siret          | contract_number | email                      | signed_at  |
      | 10                          | 101    | le prestataire | 1     | 02000000000000 | 451             | victor.hugo@miserables.com | null       |
      | 20                          | 102    | le client      | 2     | 03000000000000 | 451             | jean.paul@clideux.com      | null       |
      | 10                          | 103    | le prestataire | 1     | 02000000000000 | 300             | victor.hugo@miserables.com | 2021-01-01 |
      | 20                          | 104    | le client      | 2     | 03000000000000 | 300             | jean.paul@clideux.com      | 2021-01-01 |
      | 10                          | 105    | le prestataire | 1     | 02000000000000 | 42              | victor.hugo@miserables.com | null       |
      | 20                          | 106    | le client      | 2     | 03000000000000 | 42              | jean.paul@clideux.com      | null       |

      Et que les pièces de contrat suivantes existent
      | number  | name        | model_part_number | contract_number |
      | 41      | piece_two   | 100               | 451             |
      | 40      | piece_three | 100               | 300             |

@scenario1
  Scénario: Ajouter une annexe au contrat en tant que propriétaire
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie d'ajouter une pièce de contrat au contrat numéro "451"
    Alors la pièce de contrat est ajoutée

@scenario2
  Scénario: Ajouter une annexe au contrat en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie d'ajouter une pièce de contrat au contrat numéro "451"
    Alors la pièce de contrat est ajoutée

@scenario3
  Scénario: Impossibilité d'ajouter une annexe au contrat si le contrat n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie d'ajouter une pièce de contrat au contrat numéro "404"
    Alors une erreur est levée car le contrat n'existe pas

@scenario4
  Scénario: Impossibilité d'ajouter une annexe au contrat si le contrat est signé par au moins une partie prenante
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie d'ajouter une pièce de contrat au contrat numéro "300"
    Alors une erreur est levée car le contrat est déjà signée

@scenario5
  Scénario: Impossibilité d'ajouter une annexe au contrat en tant que partie prenante du contrat
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "claude.monet@art.com"
    Quand j'essaie d'ajouter une pièce de contrat au contrat numéro "451"
    Alors une erreur est levée car l'entreprise choisie n'a aucune relation avec le contrat