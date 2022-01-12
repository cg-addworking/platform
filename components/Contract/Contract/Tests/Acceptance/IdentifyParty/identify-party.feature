#language: fr
Fonctionnalité: identify contract party
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | parent_siret   | client_siret   | name       | is_customer | is_vendor | access_to_contract |
      | 01000000000000 | null           | null           | Addworking | 0           | 0         | 1                  |
      | 02000000000000 | null           | null           | client 1   | 1           | 0         | 1                  |
      | 03000000000000 | 02000000000000 | null           | client 2   | 1           | 0         | 1                  |
      | 04000000000000 | null           | null           | client 3   | 1           | 0         | 1                  |
      | 05000000000000 | null           | 03000000000000 | vendor 1   | 0           | 1         | 1                  |
      | 06000000000000 | null           | 04000000000000 | vendor 2   | 0           | 1         | 1                  |

    Et que les utilisateurs suivants existent
      | email                     | firstname | lastname | is_system_admin | siret          | is_signatory |
      | antoine.pierre@addwun.com | Antoine   | PIERRE   | 1               | 01000000000000 | 1            |
      | jean.paul@client1.com     | Jean      | PAUL     | 0               | 02000000000000 | 1            |
      | pierre.dupont@client2.com | Pierre    | DUPONT   | 0               | 03000000000000 | 1            |
      | john.smith@client3.com    | John      | MICHEL   | 0               | 04000000000000 | 1            |
      | alfred.hanz@vendor1.com   | Alfred    | HANZ     | 0               | 05000000000000 | 1            |
      | jane.doe@vendor1.com      | Jane      | DOE      | 0               | 05000000000000 | 0            |
      | paul.navarre@vendor2.com  | Paul      | NAVARRE  | 0               | 06000000000000 | 1            |

    Et que les modèles de contrat suivants existent
      | number | siret          | display_name             | published_at | archived_at |
      | 1      | 03000000000000 | published contract model | 2020-11-13   | null        |

    Et que les parties prenantes suivantes existent
      | contract_model_number | number | denomination | order |
      | 1                     | 1      | party 1      | 1     |
      | 1                     | 2      | party 2      | 2     |

    Et que les contracts suivants existent
      | contract_model_number | number | status | siret          | name  | valid_from | valid_until |
      | 1                     | 1      | draft  | 03000000000000 | Lorem | 2021-01-01 | 2021-05-31  |

  @scenario1
  Scénario: Identifier une entreprise comme partie prenante du contrat par le support
    Etant donné que je suis authentifié en tant que utilisateur avec l'émail "antoine.pierre@addwun.com"
    Quand j'essaie d'identifier l'entreprise "05000000000000" comme partie prenante et l'utilisateur avec l'émail "alfred.hanz@vendor1.com" comme signataire du contrat numéro "1"
    Alors l'entreprise est identifiée comme partie prenante du contrat

  @scenario2
  Scénario: Identifier une entreprise comme partie prenante du contrat par un membre de l'entreprise propriétaire du contrat
    Etant donné que je suis authentifié en tant que utilisateur avec l'émail "pierre.dupont@client2.com"
    Quand j'essaie d'identifier l'entreprise "05000000000000" comme partie prenante et l'utilisateur avec l'émail "alfred.hanz@vendor1.com" comme signataire du contrat numéro "1"
    Alors l'entreprise est identifiée comme partie prenante du contrat

  @scenario3
  Scénario: Impossibilité d'identifier une entreprise comme partie prenante du contrat si l'utilisateur n'est pas membre de l'entreprise propriétaire du contrat
    Etant donné que je suis authentifié en tant que utilisateur avec l'émail "john.smith@client3.com"
    Quand j'essaie d'identifier l'entreprise "05000000000000" comme partie prenante et l'utilisateur avec l'émail "alfred.hanz@vendor1.com" comme signataire du contrat numéro "1"
    Alors une erreur est levée car l'utilisateur connecté n'est pas membre de l'entreprise propriétaire du contrat

  @scenario4
  Scénario: Impossibilité d'identifier une entreprise comme partie prenante du contrat si elle n'a aucune relation avec l'entreprise propriétaire du contrat
    Etant donné que je suis authentifié en tant que utilisateur avec l'émail "antoine.pierre@addwun.com"
    Quand j'essaie d'identifier l'entreprise "06000000000000" comme partie prenante et l'utilisateur avec l'émail "alfred.hanz@vendor1.com" comme signataire du contrat numéro "1"
    Alors une erreur est levée car l'entreprise choisie n'a aucune relation avec le contrat

  @scenario5
  Scénario: Impossibilité d'identifier une entreprise comme partie prenante du contrat si le signataire choisi n'est pas signataire de l'entreprise choisie comme partie prenante du contrat
    Etant donné que je suis authentifié en tant que utilisateur avec l'émail "antoine.pierre@addwun.com"
    Quand j'essaie d'identifier l'entreprise "05000000000000" comme partie prenante et l'utilisateur avec l'émail "jane.doe@vendor1.com" comme signataire du contrat numéro "1"
    Alors une erreur est levée car le signataire choisi n'est pas signataire de l'entreprise choisie comme partie prenante
