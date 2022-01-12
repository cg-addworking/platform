#language: fr
Fonctionnalité: edit document type model
  Contexte:
    Etant donné que les entreprises suivantes existent
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

    Et que les models suivants existent
      | short_id | type            | display_name          | description   | content        | signature_page |
      | 1        | document type 1 | document type model 1 | Attestation_1 | Attestation_c1 | 1              |

  @scenario1
  Scénario: modifier le model d'un document type en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de modifier le model numéro "1"
    Alors le model numéro "1" est modifié

  @scenario2
  Scénario: Impossibilité de modifier un model d'un document si le model n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de modifier le model numéro "2" 
    Alors une erreur est levée car le model n'existe pas

  @scenario3
  Scénario: Impossibilité de modifier un model d'un document si l'utilisateur connecté n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de modifier le model numéro "1"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support