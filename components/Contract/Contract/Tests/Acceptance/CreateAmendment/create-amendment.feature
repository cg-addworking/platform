#language: fr
Fonctionnalité: create an amendment
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
      | number | siret          | display_name     | published_at | name   | owner_email           |
      | 1      | 02000000000000 | contract model   | 01-11-2020   | model1 | jean.paul@clideux.com |
      | 2      | 02000000000000 | amendment model  | 01-11-2020   | model2 | jean.paul@clideux.com |
      | 3      | 02000000000000 | Unpublihed model | null         | model3 | jean.paul@clideux.com |

    Et que les parties prenantes du modèle suivantes existent
      | contract_model_number | number | denomination  | order |
      | 1                     | 10     | le client     | 1     |
      | 1                     | 20     | le presta     | 2     |
      | 2                     | 30     | le client     | 1     |
      | 2                     | 40     | le presta     | 2     |

    Et que les pièces du modèle suivantes existent
      | contract_model_number | number | display_name | order | name | should_compile |
      | 1                     | 100    | bras         | 1     | arm  | 1              |
      | 1                     | 200    | corps        | 2     | body | 0              |
      | 1                     | 300    | pied         | 3     | foot | 0              |
      | 2                     | 400    | pied         | 1     | foot | 1              |

    Et que les contrat suivant existe
      | number  | name       | contract_model_number | parent_number |enterprise_siret |
      | 110     | contract_1 | 1                     | null          |02000000000000   |
      | 220     | contract_2 | 1                     | null          |02000000000000   |
      | 330     | contract_3 | 2                     | null          |02000000000000   |
      | 440     | contract_4 | 1                     | 110           |02000000000000   |

   Et que les parties prenantes suivantes existent
      | contract_model_party_number | number | denomination  | order | siret          | contract_number | email                      |
      | 10                          | 101    | le client     | 1     | 02000000000000 | 110             | jean.paul@clideux.com      |
      | 10                          | 102    | le client     | 1     | 02000000000000 | 220             | jean.paul@clideux.com      |
      | 20                          | 103    | le presta     | 2     | 03000000000000 | 220             | victor.hugo@miserables.com |
      | 30                          | 104    | le client     | 1     | 02000000000000 | 330             | jean.paul@clideux.com      |
      | 40                          | 105    | le presta     | 2     | 03000000000000 | 330             | victor.hugo@miserables.com |
      | 10                          | 106    | le client     | 1     | 02000000000000 | 440             | jean.paul@clideux.com      |
      | 20                          | 107    | le presta     | 2     | 03000000000000 | 440             | victor.hugo@miserables.com |

@scenario1
  Scénario: Créer un avenant à partir d'un model de contract
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de créer un avenant à partir du contract "110" et du model de contract "2"
    Alors l'avenant du contrat est créee

@scenario2
Scénario: Créer un avenant sans model de contract
  Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
  Quand j'essaie de créer un avenant à partir du contract "110" sans model
  Alors une erreur est levée car le model n'est pas renseigné

@scenario3
Scénario: Créer un avenant à partir d'un model de contract qui n'est pas publié
  Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
  Quand j'essaie de créer un avenant à partir du contract "110" et du model de contract "3"
  Alors une erreur est levée car le modèle de contrat n'est pas publié

@scenario4
Scénario: Créer un avenant à partir d'un avenant
  Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
  Quand j'essaie de créer un avenant à partir du contract "440" et du model de contract "3"
  Alors une erreur est levée car le contract parent est un avenant
