#language: fr
Fonctionnalité: generate contract
  Contexte:
    Etant donné que les formes légales suivantes existent
      | legal_form_name | display_name       | country |
      | sas             | SAS                | fr      |
      | sasu            | SASU               | fr      |
      | sarl            | SARL               | fr      |

    Et que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | access_to_contract | legal_form_name |
      | 01000000000000 | Addworking1 | 0           | 0         | 1                  | sas             |
      | 02000000000000 | Client2     | 1           | 0         | 1                  | sasu            |
      | 03000000000000 | Presta3     | 0           | 1         | 1                  | sasu            |
      | 04000000000000 | Presta4     | 0           | 1         | 1                  | sarl            |

    Et que les utilisateurs suivants existent
      | email                      | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com  | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@clideux.com      | Jean      | PAUL     | 0               | 02000000000000 |
      | victor.hugo@miserables.com | Victor    | HUGO     | 0               | 03000000000000 |
      | emile.zola@bonheur.com     | Emile     | ZOLA     | 0               | 04000000000000 |

    Et que les documents types suivants existent
      | siret          | display_name    | name   | type        | legal_form_name |
      | 02000000000000 | document type 1 | type_1 | legal       | sarl            |
      | 02000000000000 | document type 2 | type_2 | business    | sasu            |
      | 02000000000000 | document type 3 | type_3 | legal       | sasu            |
      | 02000000000000 | document type 4 | type_4 | business    | sasu            |

    Et que les documents suivants existent
      | type_name       | siret          | status    | valid_from |
      | document type 1 | 03000000000000 | validated | 01-01-2001 |
      | document type 2 | 03000000000000 | validated | 01-01-2001 |
      | document type 3 | 03000000000000 | pending   | 01-01-2001 |
      | document type 4 | 03000000000000 | pending   | 01-01-2001 |

    Et que le modèle de contrat suivant existe
      | number | siret          | display_name   | published_at | name  | owner_email           |
      | 1      | 02000000000000 | contract model | 01-11-2020   | model | jean.paul@clideux.com |
      | 2      | 02000000000000 | contract model | 01-11-2020   | model | jean.paul@clideux.com |

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

    Et que les variables du modèle suivantes existent
      | contract_model_number | contract_model_party_number | contract_model_part_number | number | name        |
      | 1                     | 10                          | 100                        | 01     | 1.variable1 |
      | 1                     | 10                          | 100                        | 02     | 1.variable2 |
      | 2                     | 40                          | 400                        | 03     | 1.variable3 |
      | 2                     | 40                          | 400                        | 04     | 1.variable4 |

    Et que les document types du modèle suivants existent
      | number   | contract_model_number | contract_model_party_number | document_type_display_name | validation_required |
      | 001      | 1                     | 20                          | document type 1            | 0                   |
      | 002      | 1                     | 20                          | document type 2            | 0                   |
      | 003      | 2                     | 40                          | document type 3            | 1                   |
      | 004      | 2                     | 40                          | document type 4            | 0                   |

    Et que le contrat suivant existe
      | number  | name       | contract_model_number | enterprise_siret |
      | 110     | contract_1 | 1                     | 02000000000000   |
      | 220     | contract_2 | 1                     | 02000000000000   |
      | 330     | contract_3 | 2                     | 02000000000000   |
      | 440     | contract_4 | 1                     | 02000000000000   |

   Et que les parties prenantes suivantes existent
      | contract_model_party_number | number | denomination  | order | siret          | contract_number | email                      |
      | 10                          | 101    | le client     | 1     | 02000000000000 | 110             | jean.paul@clideux.com      |
      | 10                          | 102    | le client     | 1     | 02000000000000 | 220             | jean.paul@clideux.com      |
      | 20                          | 103    | le presta     | 2     | 03000000000000 | 220             | victor.hugo@miserables.com |
      | 30                          | 104    | le client     | 1     | 02000000000000 | 330             | jean.paul@clideux.com      |
      | 40                          | 105    | le presta     | 2     | 03000000000000 | 330             | victor.hugo@miserables.com |
      | 10                          | 106    | le client     | 1     | 02000000000000 | 440             | jean.paul@clideux.com      |
      | 20                          | 107    | le presta     | 2     | 03000000000000 | 440             | victor.hugo@miserables.com |

    Et que les variables du contrat suivantes existent
      | number | value | contract_number | contract_model_variable_number | party_number |
      | 0001   | ABC   | 440             | 01                             | 101          |
      | 0002   | DEF   | 440             | 02                             | 101          |
      | 0003   | ABC   | 330             | 03                             | 105          |
      | 0004   | DEF   | 330             | 04                             | 105          |

@scenario1
  Scénario: Générer le contrat en tant que propriétaire du contrat
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de générer la pièce du contrat numéro "440" à partir de la pièce numéro "100" du modèle de contrat
    Alors la pièce du contrat est créee

@scenario2
  Scénario: Générer le contrat en tant que partie prenante du contrat
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "victor.hugo@miserables.com"
    Quand j'essaie de générer la pièce du contrat numéro "440" à partir de la pièce numéro "100" du modèle de contrat
    Alors la pièce du contrat est créee

@scenario3
  Scénario: Générer le contrat en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de générer la pièce du contrat numéro "440" à partir de la pièce numéro "100" du modèle de contrat
    Alors la pièce du contrat est créee

@scenario4
  Scénario: Impossibilité de générer le contrat s'il n'y a pas au moins deux parties prenantes
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de générer la pièce du contrat numéro "110" à partir de la pièce numéro "100" du modèle de contrat
    Alors une erreur est levée car il n'y a pas assez de parties prenantes renseignées

@scenario5
  Scénario: Impossibilité de générer le contrat si le contrat n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de générer la pièce du contrat numéro "42" à partir de la pièce numéro "42" du modèle de contrat
    Alors une erreur est levée car le contract n'existe pas

@scenario6
  Scénario: Impossibilité de générer le contrat si l'utilisateur connecté n'est pas partie prenante du contrat
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "emile.zola@bonheur.com"
    Quand j'essaie de générer la pièce du contrat numéro "440" à partir de la pièce numéro "100" du modèle de contrat
    Alors une erreur est levée car l'utilisateur connecté n'est pas partie prenante du contrat
