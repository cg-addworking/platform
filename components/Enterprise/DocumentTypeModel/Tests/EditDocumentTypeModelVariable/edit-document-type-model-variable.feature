#language: fr
Fonctionnalit√©: modifier les variables d'une attestation sur l'honneur
  Contexte:
    Etant donn√© que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor |
      | 01000000000000 | Addworking1 | 0           | 0         |
      | 02000000000000 | Client2     | 1           | 0         |

    Et que les utilisateurs suivants existent
      | email                      | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com  | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@clideux.com      | Jean      | PAUL     | 0               | 02000000000000 |

    Et que les documents types suivants existent
      | siret          | display_name    | description |
      | 01000000000000 | document type 1 | Document_1  |
      | 01000000000000 | document type 2 | Document_2  |

    Et que les attestations sur l'honneur suivantes existent
      | short_id | type            | display_name          | description   | content        | signature_page | published_at |
      | 1        | document type 1 | document type model 1 | Attestation_1 | Attestation_c1 | 1              | null         |   
      | 2        | document type 1 | document type model 2 | Attestation_2 | Attestation_c2 | 2              | 2021-11-11   |
      | 3        | document type 2 | document type model 3 | Attestation_3 | Attestation_c3 | 3              | null         |
      | 4        | document type 2 | document type model 4 | Attestation_4 | Attestation_c4 | 4              | 2021-11-11   |

    Et que les variables suivantes existent
      | short_id | document_type_model | display_name    | input_type              | default_value   | description       |
      | 1        | 1                   | siret           | enterprise_siren_number | null            | null              |
      | 2        | 2                   | enterprise_name | enterprise_name         | null            | null              |
      | 3        | 1                   | variable_1      | date                    | default_value_1 | description_var_1 |
      | 4        | 2                   | variable_2      | text                    | default_value_2 | description_var_2 |

  @scenario1
  Sc√©nario: modifier les variables d'une attestation sur l'honneur d'un document type en tant que support
    Etant donn√© que je suis authentifi√© en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de modifier la variable num√©ro "1"
    Alors la variable num√©ro "1" est modifi√©

  @scenario2
  Sc√©nario: Impossibilit√© de modifier les variables d'une attestation sur l'honneur d'un document type si elle est publi√©e 
    Etant donn√© que je suis authentifi√© en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de modifier la variable num√©ro "2" 
    Alors une erreur est lev√©e car l'attestation sur l'honneur est publi√©e

  @scenario3
  Sc√©nario: Impossibilit√© de modifier les variables d'une attestation sur l'honneur d'un document type si l'utilisateur connect√© n'est pas support
    Etant donn√© que je suis authentifi√© en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de modifier la variable num√©ro "3"
    Alors une erreur est lev√©e car l'utilisateur connect√© n'est pas support

  @scenario4
  Sc√©nario: Impossibilit√© de modifier les variables d'une attestation sur l'honneur d'un document type si les variables n'existent pas
    Etant donn√© que je suis authentifi√© en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de modifier la variable num√©ro "15"
    Alors une erreur est lev√©e car la variable n'existe pas