#language: fr
Fonctionnalité: delete annex
  Contexte:
    Étant donné que les entreprises suivantes existent
      | siret          | parent_siret   | client_siret   | name       | is_customer | is_vendor |
      | 01000000000000 | null           | null           | Addworking | 0           | 0         |
      | 02000000000000 | null           | null           | client 1   | 1           | 0         |
      | 03000000000000 | 02000000000000 | null           | client 2   | 1           | 0         |
      | 04000000000000 | null           | null           | client 3   | 1           | 0         |
     
    Et que les utilisateurs suivants existent
      | email                        | firstname | lastname | is_system_admin | siret          | is_signatory | number |
      | warlock@addworking.com       | Peter     | PARKER   | 1               | 01000000000000 | 1            | 1      |
      | tony.stark@client1.com       | Tony      | STARK    | 0               | 02000000000000 | 1            | 2      |
      | clark.kent@client2.com       | Clark     | KENT     | 0               | 03000000000000 | 1            | 3      |
      | bruce.wayne@client3.com      | Bruce     | WAYNE    | 0               | 04000000000000 | 1            | 4      |

    Et que annexes suivantes existent
      | number | display_name   | name   | enterprise_siret |
      | 1      | display name 1 | name 1 | 01000000000000   |
      | 2      | display name 2 | name 2 | 02000000000000   |
      | 3      | display name 3 | name 3 | 03000000000000   |
      | 4      | display name 4 | name 4 | 04000000000000   |

  @scenario1
  Scénario: supprimer une annexe en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "warlock@addworking.com"
    Quand j'essaie de supprimer l'annex "1"
    Alors l'annexe "1" est supprimé

 @scenario2
  Scénario: supprimer une annexe en tant que membre de l'entreprise propriétaire de l'annexe
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "tony.stark@client1.com"
    Quand j'essaie de supprimer l'annex "2"
    Alors une erreur est levée car je ne suis pas membre du support

  @scenario4
  Scénario: Impossibilité de supprimer une annexe si elle n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "warlock@addworking.com"
    Quand j'essaie de supprimer l'annex "41"
    Alors une erreur est levée car l'annexe n'existe pas
