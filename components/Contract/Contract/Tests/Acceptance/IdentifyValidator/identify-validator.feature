#language: fr
Fonctionnalité: identify contract party
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
      | email                      | firstname | lastname | is_system_admin | is_signatory | siret          |
      | antoine.pierre@addwun.com  | Antoine   | PIERRE   | 1               | 0            | 01000000000000 |
      | jean.paul@clideux.com      | Jean      | PAUL     | 0               | 0            | 02000000000000 |
      | pipin@clideux.com          | Pipin     | Took     | 0               | 0            | 02000000000000 |
      | victor.hugo@miserables.com | Victor    | HUGO     | 0               | 0            | 03000000000000 |
      | emile.zola@bonheur.com     | Emile     | ZOLA     | 0               | 0            | 04000000000000 |

    Et que les modèles de contrat suivant existe
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

    Et que les contrats suivants existent
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

  @scenario1
  Scénario: Identifier un validateur d'un contrat par le support
    Etant donné que je suis authentifié en tant que utilisateur avec l'émail "antoine.pierre@addwun.com"
    Quand j'essaie d'identifier l'utilisateur avec l'email "pipin@clideux.com" comme validateur du contrat numéro "110"
    Alors l'utilisateur est identifiée comme validateur du contrat

  @scenario2
  Scénario: Identifier un validateur d'un contrat en tan que membre de l'entreprise propriètaire du contrat
    Etant donné que je suis authentifié en tant que utilisateur avec l'émail "jean.paul@clideux.com"
    Quand j'essaie d'identifier l'utilisateur avec l'email "pipin@clideux.com" comme validateur du contrat numéro "110"
    Alors l'utilisateur est identifiée comme validateur du contrat

  @scenario3
  Scénario: Identifier un validateur d'un contrat en tan qu'un utilisateur non membre de l'entreprise propriètaire du contrat
    Etant donné que je suis authentifié en tant que utilisateur avec l'émail "victor.hugo@miserables.com"
    Quand j'essaie d'identifier l'utilisateur avec l'email "pipin@clideux.com" comme validateur du contrat numéro "110"
    Alors une erreur est levée car l'utilisateur connecté n'est pas membre de l'entreprise propriétaire du contrat

  @scenario4
  Scénario: Identifier un validateur qui est déjà partie prenante sur un contrat par le support
    Etant donné que je suis authentifié en tant que utilisateur avec l'émail "antoine.pierre@addwun.com"
    Quand j'essaie d'identifier l'utilisateur avec l'email "jean.paul@clideux.com" comme validateur du contrat numéro "110"
    Alors aucun utilisateur n'est identifié en tan que validateur du contrat
