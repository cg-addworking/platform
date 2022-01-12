#language: fr
Fonctionnalité: Create empty contract model
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor | access_to_contract |
      | 01000000000000 | Addworking1 | 0           | 0         | 1                  |
      | 02000000000000 | Client2     | 1           | 0         | 1                  |
      | 03000000000000 | Client3     | 1           | 1         | 0                  |

    Et que les utilisateurs suivants existent
      | email                     | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@clideux.com     | Jean      | PAUL     | 0               | 02000000000000 |
      | jean.paul@clitrois.com    | Jean      | PAUL     | 0               | 03000000000000 |

  @scenario1
  Scénario: Créer un modèle de contrat vide
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addwun.com"
    Quand j'essaie de créer un modèle de contrat vide pour l'entreprise avec le siret "02000000000000"
    Alors le modèle de contrat vide est crée

  @scenario2
  Scénario: Impossibilité de créer un modèle de contrat vide si l'utilisateur n'est pas support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@clideux.com"
    Quand j'essaie de créer un modèle de contrat vide pour l'entreprise avec le siret "02000000000000"
    Alors une erreur est levée car l'utilisateur connecté n'est pas support
