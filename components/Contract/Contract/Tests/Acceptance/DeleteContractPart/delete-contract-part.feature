#language: fr
Fonctionnalité: delete contract part
  Contexte:
    Étant donné que les entreprises suivantes existent
      | siret          | parent_siret   | client_siret   | name       | is_customer | is_vendor | access_to_contract |
      | 01000000000000 | null           | null           | Addworking | 0           | 0         | 1                  |
      | 02000000000000 | null           | null           | client 1   | 1           | 0         | 1                  |
      | 03000000000000 | 02000000000000 | null           | client 2   | 1           | 0         | 1                  |
      | 04000000000000 | null           | null           | client 3   | 1           | 0         | 1                  |
     
    Et que les utilisateurs suivants existent
      | email                        | firstname | lastname | is_system_admin | siret          | is_signatory | number |
      | peter.parker@addworking.com  | Peter     | PARKER   | 1               | 01000000000000 | 1            | 1      |
      | tony.stark@client1.com       | Tony      | STARK    | 0               | 02000000000000 | 1            | 2      |
      | clark.kent@client2.com       | Clark     | KENT     | 0               | 03000000000000 | 1            | 3      |
      | bruce.wayne@client3.com      | Bruce     | WAYNE    | 0               | 04000000000000 | 1            | 4      |
    
    Et que les modèles de contrat suivants existent
      | number | siret          | display_name             | published_at | archived_at |
      | 1      | 03000000000000 | published contract model | 2020-11-13   | null        |
      | 2      | 04000000000000 | published contract model | 2020-11-23   | null        |

    Et que les pièces du modèle suivantes existent
      | contract_model_number | number | display_name | order | name | should_compile | is_initialled | is_signed | 
      | 1                     | 100    | corps        | 1     | body | 0              | 0             | 0         |

    Et que les contrats suivants existent
      | number  | name       | contract_model_number | enterprise_siret | status | yousign_procedure_id |
      | 451     | contract_1 | 1                     | 02000000000000   | draft  | null                 |
      | 42      | contract_2 | 1                     | 02000000000000   | draft  | null                 |
      | 300     | contract_3 | 1                     | 02000000000000   | signed | random_id            |

    Et que les pièces de contrat suivantes existent
      | number  | name        | model_part_number | contract_number |display_name |should_compile | is_initialled | is_signed | contract_model_number |
      | 41      | piece_two   | 100               | 451             | piece_two   |0              | 0             | 0         | 1                     |
      | 40      | piece_three | 100               | 300             | piece_three |0              | 0             | 0         | 1                     |

  @scenario1
  Scénario: supprimer une piece de contrat en tant que support
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "peter.parker@addworking.com"
    Quand j'essaie de supprimer la piece de contract "41"
    Alors la piece de contrat "41" est supprimé

 @scenario2
  Scénario: supprimer une piece de contrat en tant que membre de l'entreprise propriétaire du contrat
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "tony.stark@client1.com"
    Quand j'essaie de supprimer la piece de contract "41"
    Alors la piece de contrat "41" est supprimé

  @scenario3
  Scénario: Impossibilité de supprimer une pièce de contrat si l'utilisateur n'est pas support et pas propriétaire du contract
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "bruce.wayne@client3.com"
    Quand j'essaie de supprimer la piece de contract "41"
    Alors une erreur est levée car l'utilisateur connecté n'est pas membre de l'entreprise propriétaire du contrat

  @scenario4
  Scénario: Impossibilité de supprimer une pièce de contrat si elle n'existe pas
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "peter.parker@addworking.com"
    Quand j'essaie de supprimer la piece de contract "2"
    Alors une erreur est levée car la piece de contrat n'existe pas
