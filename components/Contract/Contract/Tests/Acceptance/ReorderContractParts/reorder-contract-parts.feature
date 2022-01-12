#language: fr
Fonctionnalité: re-ordonner l'état des contrats
  Contexte:
     Etant donné que les formes légales suivantes existent
      | legal_form_name | display_name       | country |
      | sas             | SAS                | fr      |
      | sasu            | SASU               | fr      |
      | sarl            | SARL               | fr      |

    Et que les entreprises suivantes existent
      | siret          | parent_siret   | client_siret   | name       | is_customer | is_vendor | access_to_contract | legal_form_name |
      | 01000000000000 | null           | null           | Addworking | 0           | 0         | 1                  | sas             |
      | 02000000000000 | null           | null           | client 1   | 1           | 0         | 1                  | sasu            |
      | 03000000000000 | 02000000000000 | null           | client 2   | 1           | 0         | 1                  | sarl            |
      | 04000000000000 | null           | null           | client 3   | 1           | 0         | 1                  | sasu            |
      | 05000000000000 | null           | 03000000000000 | vendor 1   | 0           | 1         | 1                  | sasu            |
      | 06000000000000 | null           | 04000000000000 | vendor 2   | 0           | 1         | 1                  | sasu            |
      | 07000000000000 | null           | 04000000000000 | vendor 3   | 0           | 1         | 1                  | sasu            |

    Et que les utilisateurs suivants existent
      | email                        | firstname | lastname | is_system_admin | siret          | is_signatory | number |
      | peter.parker@addworking.com  | Peter     | PARKER   | 1               | 01000000000000 | 1            | 1      |
      | tony.stark@client1.com       | Tony      | STARK    | 0               | 02000000000000 | 1            | 2      |
      | clark.kent@client2.com       | Clark     | KENT     | 0               | 03000000000000 | 1            | 3      |
      | bruce.wayne@client3.com      | Bruce     | WAYNE    | 0               | 04000000000000 | 1            | 4      |
      | steve.rogers@vendor1.com     | Steve     | ROGERS   | 0               | 05000000000000 | 1            | 5      |
      | bruce.banner@vendor1.com     | Bruce     | BANNER   | 0               | 05000000000000 | 0            | 6      |
      | natasha.romanova@vendor2.com | Natasha   | ROMANOVA | 0               | 06000000000000 | 1            | 7      |
      | barry.allen@vendor3.com      | Barry     | ALLEN    | 0               | 06000000000000 | 1            | 8      |

    Et que les documents types suivants existent
      | siret          | display_name    | description          | is_mandatory | validity_period | code | type        | legal_form_name |
      | 02000000000000 | document type 1 | Document legal       | 1            | 365             | ABCD | legal       | sasu            |
      | 02000000000000 | document type 2 | Document Business    | 1            | 365             | EFGH | business    | sasu            |
      | 02000000000000 | document type 3 | Document contractual | 1            | 365             | IJKL | contractual | sasu            |

    Et que les documents suivants existent
      | document_type_display_name | siret          | status    | valid_from |
      | document type 1            | 02000000000000 | validated | 01-01-2021 |
      | document type 2            | 02000000000000 | pending   | 01-01-2021 |
      | document type 3            | 02000000000000 | pending   | 01-01-2021 |

    Et que les modèles de contrat suivants existent
      | number | siret          | display_name             | published_at |
      | 100    | 03000000000000 | published contract model | 2020-11-13   |

    Et que les parties prenantes suivantes (modèle de contrat) existent
      | number | contract_model_number | denomination | order |
      | 200    | 100                   | party 1      | 1     |
      | 201    | 100                   | party 2      | 2     |

    Et que les pièces suivantes (modèle de contrat) existent
      | number | contract_model_number | display_name  | order | is_initialled | is_signed | should_compile |
      | 300    | 100                   | part 1        | 1     | 0             | 0         | 1              |
      | 301    | 100                   | part 2        | 2     | 1             | 1         | 0              |
      | 302    | 100                   | part 3        | 3     | 1             | 1         | 0              |
      | 303    | 100                   | part 4        | 4     | 1             | 1         | 0              |
      | 304    | 100                   | part 5        | 5     | 1             | 1         | 1              |
      | 305    | 100                   | part 6        | 6     | 1             | 1         | 0              |

    Et que les variables suivantes (pièces du modèle de contrat) existent
      | number | contract_model_number | contract_model_party_number | contract_model_part_number | name |
      | 400    | 100                   | 200                         | 300                        | var1 |
      | 401    | 100                   | 200                         | 301                        | var2 |
      | 402    | 100                   | 201                         | 302                        | var3 |

    Et que les documents types suivantes (parties prenantes du modèle de contrat) existent
      | number | contract_model_party_number | document_type_display_name | mandatory | validation_required |
      | 500    | 200                         | document type 1            | 1         | 1                   |
      | 501    | 200                         | document type 2            | 0         | 1                   |

    Et que les contrats suivants existent
      | number | contract_parent_number | contract_model_number | siret          | name  | valid_from | valid_until | canceled_at | inactive_at | yousign_procedure_id |
      | 600    | null                   | 100                   | 03000000000000 | Lorem | 2021-01-01 | 2021-05-31  | null        | null        | yousign_id           |

    Et que les parties prenantes suivantes (contrat) existent
      | number | contract_number | contract_model_party_number | siret          | signatory_number | order | signed | signed_at  |
      | 700    | 600             | 200                         | 02000000000000 | 2                | 1     | 0      | null       |
      | 701    | 600             | 201                         | 05000000000000 | 6                | 2     | 0      | null       |

    Et que les pièces suivantes (contrat) existent
      | number | contract_model_part_number | contract_number | name       | order | is_hidden |
      | 800    | 300                        | 600             | part_one   | 1     | 0         |
      | 801    | 301                        | 600             | part_two   | 2     | 1         |
      | 802    | 302                        | 600             | part_three | 3     | 0         |
      | 803    | 303                        | 600             | part_four  | 4     | 0         |
      | 804    | 304                        | 600             | part_five  | 5     | 1         |
      | 805    | 305                        | 600             | part_six   | 6     | 0         |

    Et que les variables suivantes (contrat) existent
      | number | contract_number |  contract_model_variable_number | contract_party_number | value   |
      | 900    | 600             | 400                             | 700                   | alpha   |
      | 901    | 600             | 401                             | 700                   | bravo   |
      | 902    | 600             | 402                             | 701                   | charlie |

  @scenario1
  Scénario: Changer l'ordre d'une pièce vers le bas
    Étant donné que je suis authentifié en tant que utilisateur avec l'émail "peter.parker@addworking.com"
    Et que le contrat numéro "600" existe
    Et qu'il a au moins deux parties prenantes.
    Et que ses variables sont tous renseignées
    Et que les documents du contrat sont valides
    Et que le contrat a au moins deux pièces non volantes
    Quand je change l'ordre de la pièce numéro "800" vers le "bas"
    Alors l'ordre de la pièce numéro "800" devient "2"
    Et l'ordre des autres pièces du contrat numéro "800" a été adapté

  @scenario2
  Scénario: Impossible de changer l'ordre d'une pièce vers le bas
    Étant donné que je suis authentifié en tant que utilisateur avec l'émail "peter.parker@addworking.com"
    Et que le contrat numéro "600" existe
    Et qu'il a au moins deux parties prenantes.
    Et que ses variables sont tous renseignées
    Et que les documents du contrat sont valides
    Et que le contrat a au moins deux pièces non volantes
    Quand je change l'ordre de la pièce numéro "805" vers le "bas"
    Alors une erreur est survenue car l'ordre de la pièce est le dernier par rapport aux pièces non cachés

  @scenario3
  Scénario: Changer l'ordre d'une pièce vers le haut
    Étant donné que je suis authentifié en tant que utilisateur avec l'émail "peter.parker@addworking.com"
    Et que le contrat numéro "600" existe
    Et qu'il a au moins deux parties prenantes.
    Et que ses variables sont tous renseignées
    Et que les documents du contrat sont valides
    Et que le contrat a au moins deux pièces non volantes
    Quand je change l'ordre de la pièce numéro "802" vers le "haut"
    Alors l'ordre de la pièce numéro "802" devient "1"
    Et l'ordre des autres pièces du contrat numéro "802" a été adapté

  @scenario4
  Scénario: Impossible de changer l'ordre d'une pièce vers le haut
    Étant donné que je suis authentifié en tant que utilisateur avec l'émail "peter.parker@addworking.com"
    Et que le contrat numéro "600" existe
    Et qu'il a au moins deux parties prenantes.
    Et que ses variables sont tous renseignées
    Et que les documents du contrat sont valides
    Et que le contrat a au moins deux pièces non volantes
    Quand je change l'ordre de la pièce numéro "800" vers le "haut"
    Alors une erreur est survenue car l'ordre de la pièce est le premier
