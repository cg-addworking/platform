#language: fr
Fonctionnalité: create annex
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name       | is_customer | is_vendor |
      | 01000000000000 | Addworking | 0           | 0         |
      | 02000000000000 | client 1   | 1           | 0         |
      | 03000000000000 | client 2   | 1           | 0         |
      | 04000000000000 | client 3   | 1           | 0         |
      | 05000000000000 | vendor 1   | 0           | 1         |

    Et que les utilisateurs suivants existent
      | email                        | firstname | lastname | is_system_admin | siret          | number |
      | peter.parker@addworking.com  | Peter     | PARKER   | 1               | 01000000000000 | 1      |
      | tony.stark@warlock.com       | Tony      | STARK    | 0               | 02000000000000 | 2      |
      | clark.kent@client2.com       | Clark     | KENT     | 0               | 03000000000000 | 3      |
      | bruce.wayne@client3.com      | Bruce     | WAYNE    | 0               | 04000000000000 | 4      |
      | steve.rogers@vendor1.com     | Steve     | ROGERS   | 0               | 05000000000000 | 5      |
      | bruce.banner@vendor1.com     | Bruce     | BANNERS  | 0               | 05000000000000 | 6      |


  @scenario1
  Scénario: créer une annexe pour mon entreprise
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "tony.stark@warlock.com"
    Quand j'essaie de créer une annexe pour mon entreprise
    Alors une erreur est levée car je ne suis pas membre du support

  @scenario2
  Scénario: créer une annexe pour une entreprise en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "peter.parker@addworking.com"
    Quand j'essaie de créer une annexe pour mon entreprise
    Alors l'annexe est créé
