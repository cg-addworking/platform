#language: fr
Fonctionnalité: create contract without model
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | parent_siret   | client_siret   | name             | is_customer | is_vendor | access_to_contract |
      | 01000000000000 | null           | null           | Addworking1      | 0           | 0         | 1                  |
      | 02000000000000 | null           | null           | head quarter     | 1           | 0         | 1                  |
      | 03000000000000 | 02000000000000 | null           | subsidiary       | 1           | 0         | 1                  |
      | 04000000000000 | null           | null           | Wayne industries | 0           | 1         | 1                  |
      | 05000000000000 | null           | 03000000000000 | vendor 1         | 0           | 1         | 1                  |

    Et que les utilisateurs suivants existent
      | email                        | firstname | lastname | is_system_admin | siret          |
      | antoine.pierre@addwun.com    | Antoine   | PIERRE   | 1               | 01000000000000 |
      | jean.paul@head-quarter.com   | Jean      | PAUL     | 0               | 02000000000000 |
      | pierre.dupont@subsidiary.com | Pierre    | DUPONT   | 0               | 03000000000000 |
      | jean.michel@not-related.com  | Jean      | Michel   | 0               | 04000000000000 |
      | gandalf.leblanc@lotr.com     | Gandalf   | Leblanc  | 0               | 05000000000000 |

    Et que les missions suivantes existent
      | number | label                    | client_siret   | vendor_siret   | contract_number | status | starts_at  |
      | 1      | mission without contract | 03000000000000 | 05000000000000 | null            | draft  | 2021-01-01 |

  @scenario1
  Scénario: Créer un contrat sans modèle pour une entreprise
    Etant donné que je suis authentifié en tant que utilisateur avec l'émail "antoine.pierre@addwun.com"
    Quand j'essaie de créer un contrat sans modèle pour l'entreprise avec le siret "03000000000000" avec un fichier
    Alors le contrat est crée

  @scenario2
  Scénario: Impossibilité de créer un contrat sans modèle et sans fichier
    Etant donné que je suis authentifié en tant que utilisateur avec l'émail "antoine.pierre@addwun.com"
    Quand j'essaie de créer un contrat sans modèle pour l'entreprise avec le siret "03000000000000" sans fichier
    Alors une erreur est levée car le fichier n'est pas renseigné
