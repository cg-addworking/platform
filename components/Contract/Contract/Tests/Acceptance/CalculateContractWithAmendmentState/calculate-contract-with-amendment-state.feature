#language: fr
Fonctionnalité: calculer l'état des contrats
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
      | 04000000000000 | null           | null           | client 3   | 1           | 0         | 1                  | sarl            |
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


  @contrat_actif_avec_avenant_en_brouillon
  Scénario: contrat_actif_avec_avenant_en_brouillon
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date du jour est comprise entre la date de début et la date de fin du contrat
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant n'a pas de parties prenantes.
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_en_brouillon
  Scénario: contrat_actif_avec_avenant_en_brouillon
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat est inférieur ou égale à la date du jour
    Et que la date de fin du contrat n'est pas définie
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant n'a pas de parties prenantes.
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_en_brouillon
  Scénario: contrat_actif_avec_avenant_en_brouillon
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat n'est pas définie
    Et que la date de fin du contrat est supérieur à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant n'a pas de parties prenantes.
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_en_brouillon
  Scénario: contrat_actif_avec_avenant_en_brouillon
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat n'est pas définie
    Et que la date de fin du contrat n'est pas définie
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant n'a pas de parties prenantes.
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

## Contrat actif avec avenant A compléter

  @contrat_actif_avec_avenant_en_a_completer
  Scénario: contrat_actif_avec_avenant_en_a_completer
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date du jour est comprise entre la date de début et la date de fin du contrat
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant ne sont pas tous valides
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_a_completer
  Scénario: contrat_actif_avec_avenant_a_completer
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat est inférieur ou égale à la date du jour
    Et que la date de fin du contrat n'est pas définie
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant ne sont pas tous valides
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_en_a_completer
  Scénario: contrat_actif_avec_avenant_en_a_completer
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat n'est pas définie
    Et que la date de fin du contrat est supérieur à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant ne sont pas tous valides
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_a_completer
  Scénario: contrat_actif_avec_avenant_a_completer
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat n'est pas définie
    Et que la date de fin du contrat n'est pas définie
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant ne sont pas tous valides
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

# **Actif avec scénario 2 a completer**

  @contrat_actif_avec_avenant_en_a_completer
  Scénario: contrat_actif_avec_avenant_en_a_completer
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date du jour est comprise entre la date de début et la date de fin du contrat
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant ne sont pas tous renseignées
    Et que les documents de l'avenant sont valides
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_a_completer
  Scénario: contrat_actif_avec_avenant_a_completer
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat est inférieur ou égale à la date du jour
    Et que la date de fin du contrat n'est pas définie
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant ne sont pas tous renseignées
    Et que les documents de l'avenant sont valides
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_en_a_completer
  Scénario: contrat_actif_avec_avenant_en_a_completer
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat n'est pas définie
    Et que la date de fin du contrat est supérieur à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant ne sont pas tous renseignées
    Et que les documents de l'avenant sont valides
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_a_completer
  Scénario: contrat_actif_avec_avenant_a_completer
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat n'est pas définie
    Et que la date de fin du contrat n'est pas définie
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant ne sont pas tous renseignées
    Et que les documents de l'avenant sont valides
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

## **Actif avec scénario 3 a completer**

  @contrat_actif_avec_avenant_en_a_completer
  Scénario: contrat_actif_avec_avenant_en_a_completer
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date du jour est comprise entre la date de début et la date de fin du contrat
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant ne sont pas tous renseignées
    Et que les documents de l'avenant ne sont pas tous valides
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_a_completer
  Scénario: contrat_actif_avec_avenant_a_completer
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat est inférieur ou égale à la date du jour
    Et que la date de fin du contrat n'est pas définie
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant ne sont pas tous renseignées
    Et que les documents de l'avenant ne sont pas tous valides
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_en_a_completer
  Scénario: contrat_actif_avec_avenant_en_a_completer
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat n'est pas définie
    Et que la date de fin du contrat est supérieur à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant ne sont pas tous renseignées
    Et que les documents de l'avenant ne sont pas tous valides
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_a_completer
  Scénario: contrat_actif_avec_avenant_a_completer
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat n'est pas définie
    Et que la date de fin du contrat n'est pas définie
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant ne sont pas tous renseignées
    Et que les documents de l'avenant ne sont pas tous valides
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

## Contrat Actif avec avenant bon pour mise en signature

  @contrat_actif_avec_avenant_en_bon_pour_signature
  Scénario: contrat_actif_avec_avenant_en_bon_pour_signature
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date du jour est comprise entre la date de début et la date de fin du contrat
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que l'avenant n'est pas prêt à être signé sur yousign
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_en_bon_pour_signature
  Scénario: contrat_actif_avec_avenant_en_bon_pour_signature
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat est inférieur ou égale à la date du jour
    Et que la date de fin du contrat n'est pas définie
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que l'avenant n'est pas prêt à être signé sur yousign
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_en_bon_pour_signature
  Scénario: contrat_actif_avec_avenant_en_bon_pour_signature
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat n'est pas définie
    Et que la date de fin du contrat est supérieur à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que l'avenant n'est pas prêt à être signé sur yousign
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_en_bon_pour_signature
  Scénario: contrat_actif_avec_avenant_en_bon_pour_signature
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat n'est pas définie
    Et que la date de fin du contrat n'est pas définie
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que l'avenant n'est pas prêt à être signé sur yousign
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

## Contrat Actif avec avenant A signer

  @contrat_actif_avec_avenant_a_signer
  Scénario: contrat_actif_avec_avenant_a_signer
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date du jour est comprise entre la date de début et la date de fin du contrat
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que l'avenant est prêt à être signé sur yousign
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_a_signer
  Scénario: contrat_actif_avec_avenant_a_signer
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat est inférieur ou égale à la date du jour
    Et que la date de fin du contrat n'est pas définie
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que l'avenant est prêt à être signé sur yousign
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_a_signer
  Scénario: contrat_actif_avec_avenant_a_signer
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat n'est pas définie
    Et que la date de fin du contrat est supérieur à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que l'avenant est prêt à être signé sur yousign
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_a_signer
  Scénario: contrat_actif_avec_avenant_a_signer
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat n'est pas définie
    Et que la date de fin du contrat n'est pas définie
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que l'avenant est prêt à être signé sur yousign
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

# Contrat Actif avec avenant signé

  @contrat_actif_avec_avenant_signé
  Scénario: contrat_actif_avec_avenant_signé
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date du jour est comprise entre la date de début et la date de fin du contrat
    Alors l'état du contrat est "active".
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date de début de l'avenant est supérieur à la date du jour
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_signé
  Scénario: contrat_actif_avec_avenant_signé
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat est inférieur ou égale à la date du jour
    Et que la date de fin du contrat n'est pas définie
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date de début de l'avenant est supérieur à la date du jour
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_signé
  Scénario: contrat_actif_avec_avenant_signé
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat n'est pas définie
    Et que la date de fin du contrat est supérieur à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date de début de l'avenant est supérieur à la date du jour
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_signé
  Scénario: contrat_actif_avec_avenant_signé
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat n'est pas définie
    Et que la date de fin du contrat n'est pas définie
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date de début de l'avenant est supérieur à la date du jour
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

## **Contrat Actif 607 avec un avenant actif tous**

  @contrat_actif_avec_avenant_actif1
  Scénario: contrat_actif_avec_avenant_actif1
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date du jour est comprise entre la date de début et la date de fin du contrat
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date du jour est comprise entre la date de début et la date de fin de l'avenant
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_actif2
  Scénario: contrat_actif_avec_avenant_actif2
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date du jour est comprise entre la date de début et la date de fin du contrat
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date de début de l'avenant est inférieur ou égale à la date du jour
    Et que la date de fin de l'avenant n'est pas définie
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_actif3
  Scénario: contrat_actif_avec_avenant_actif3
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date du jour est comprise entre la date de début et la date de fin du contrat
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date de début de l'avenant n'est pas définie
    Et que la date de fin de l'avenant est supérieur à la date du jour
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_actif4
  Scénario: contrat_actif_avec_avenant_actif4
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date du jour est comprise entre la date de début et la date de fin du contrat
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date de début de l'avenant n'est pas définie
    Et que la date de fin de l'avenant n'est pas définie
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_608_avec_un_avenant_actif_tous
  Scénario: contrat_actif_608_avec_un_avenant_actif_tous
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat est inférieur ou égale à la date du jour
    Et que la date de fin du contrat n'est pas définie
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date du jour est comprise entre la date de début et la date de fin de l'avenant
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_actif5
  Scénario: contrat_actif_avec_avenant_actif5
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat est inférieur ou égale à la date du jour
    Et que la date de fin du contrat n'est pas définie
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date de début de l'avenant est inférieur ou égale à la date du jour
    Et que la date de fin de l'avenant n'est pas définie
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_actif6
  Scénario: contrat_actif_avec_avenant_actif6
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat est inférieur ou égale à la date du jour
    Et que la date de fin du contrat n'est pas définie
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date de début de l'avenant n'est pas définie
    Et que la date de fin de l'avenant est supérieur à la date du jour
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_actif7
  Scénario: contrat_actif_avec_avenant_actif7
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat est inférieur ou égale à la date du jour
    Et que la date de fin du contrat n'est pas définie
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date de début de l'avenant n'est pas définie
    Et que la date de fin de l'avenant n'est pas définie
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_609_avec_un_avenant_actif_tous
  Scénario: contrat_actif_609_avec_un_avenant_actif_tous
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat n'est pas définie
    Et que la date de fin du contrat est supérieur à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que les documents de l'avenant sont valides
    Et que la date du jour est comprise entre la date de début et la date de fin de l'avenant
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_actif8
  Scénario: contrat_actif_avec_avenant_actif8
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat n'est pas définie
    Et que la date de fin du contrat est supérieur à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date de début de l'avenant est inférieur ou égale à la date du jour
    Et que la date de fin de l'avenant n'est pas définie
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_actif9
  Scénario: contrat_actif_avec_avenant_actif9
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat n'est pas définie
    Et que la date de fin du contrat est supérieur à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date de début de l'avenant n'est pas définie
    Et que la date de fin de l'avenant est supérieur à la date du jour
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_actif10
  Scénario: contrat_actif_avec_avenant_actif10
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat n'est pas définie
    Et que la date de fin du contrat est supérieur à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date de début de l'avenant n'est pas définie
    Et que la date de fin de l'avenant n'est pas définie
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_610_avec_un_avenant_actif_tous
  Scénario: contrat_actif_610_avec_un_avenant_actif_tous
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat n'est pas définie
    Et que la date de fin du contrat n'est pas définie
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que la date du jour est comprise entre la date de début et la date de fin de l'avenant
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_actif11
  Scénario: contrat_actif_avec_avenant_actif11
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat n'est pas définie
    Et que la date de fin du contrat n'est pas définie
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date de début de l'avenant est inférieur ou égale à la date du jour
    Et que la date de fin de l'avenant n'est pas définie
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_actif12
  Scénario: contrat_actif_avec_avenant_actif12
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat n'est pas définie
    Et que la date de fin du contrat n'est pas définie
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date de début de l'avenant n'est pas définie
    Et que la date de fin de l'avenant est supérieur à la date du jour
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_actif17
  Scénario: contrat_actif_avec_avenant_actif17
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat n'est pas définie
    Et que la date de fin du contrat n'est pas définie
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date de début de l'avenant n'est pas définie
    Et que la date de fin de l'avenant n'est pas définie
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

## COntrat ACtif avec avenant échu :

  @contrat_actif_avec_un_avenant_échu
  Scénario: contrat_actif_avec_un_avenant_échu
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date du jour est comprise entre la date de début et la date de fin du contrat
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date de fin de l'avenant est inférieur ou égale à la date du jour
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_échu
  Scénario: contrat_actif_avec_avenant_échu
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat est inférieur ou égale à la date du jour
    Et que la date de fin du contrat n'est pas définie
    Et que le contrat a un avenant
    Alors l'état du contrat est "active".
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date de fin de l'avenant est inférieur ou égale à la date du jour
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_échu2
  Scénario: contrat_actif_avec_avenant_échu
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat n'est pas définie
    Et que la date de fin du contrat est supérieur à la date du jour
    Alors l'état du contrat est "active".
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date de fin de l'avenant est inférieur ou égale à la date du jour
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_échu
  Scénario: contrat_actif_avec_avenant_échu
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat n'est pas définie
    Et que la date de fin du contrat n'est pas définie
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date de fin de l'avenant est inférieur ou égale à la date du jour
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

# Contrat  actif avenant annulé
  @contrat_actif_avec_avenant_annulé_1
  Scénario: contrat_actif_avec_avenant_annulé_1
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date du jour est comprise entre la date de début et la date de fin du contrat
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant est "canceled".
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_annulé_2
  Scénario: contrat_actif_avec_avenant_annulé_2
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat est inférieur ou égale à la date du jour
    Et que la date de fin du contrat n'est pas définie
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant est "canceled".
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_annulé_3
  Scénario: contrat_actif_avec_avenant_annulé_3
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat n'est pas définie
    Et que la date de fin du contrat est supérieur à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant est "canceled".
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_annulé_4
  Scénario: contrat_actif_avec_avenant_annulé_4
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat n'est pas définie
    Et que la date de fin du contrat n'est pas définie
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant est "canceled".
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

# Contrat  actif avenant inactif

  @contrat_actif_avec_avenant_inactif_1
  Scénario: contrat_actif_avec_avenant_inactif_1
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date du jour est comprise entre la date de début et la date de fin du contrat
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant est "inactive".
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_inactif_2
  Scénario: contrat_actif_avec_avenant_inactif_2
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat est inférieur ou égale à la date du jour
    Et que la date de fin du contrat n'est pas définie
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant est "inactive".
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_inactif_3
  Scénario: contrat_actif_avec_avenant_inactif_3
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat n'est pas définie
    Et que la date de fin du contrat est supérieur à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant est "inactive".
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_actif_avec_avenant_inactif_4
  Scénario: contrat_actif_avec_avenant_inactif_4
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat n'est pas définie
    Et que la date de fin du contrat n'est pas définie
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant est "inactive".
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

# Contrat signé avec avenant

## Contrat signé avenant en brouillon

  @contrat_signé_avec_avenant_brouillon
  Scénario: contrat_signé_avec_avenant_brouillon
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat est supérieur à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant n'a pas de parties prenantes.
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "signed".

  @contrat_signé_avec_avenant_a_compléter
  Scénario: contrat_signé_avec_avenant_a_compléter
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat est supérieur à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant ne sont pas tous valides
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "signed".

  @contrat_signé_avec_avenant_a_completer2
  Scénario: contrat_signé_avec_avenant_a_completer2
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat est supérieur à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant ne sont pas tous renseignées
    Et que les documents de l'avenant sont valides
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "signed".

  @contrat_signé_avec_avenant_a_completer3
  Scénario: contrat_signé_avec_avenant_a_completer3
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat est supérieur à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant ne sont pas tous renseignées
    Et que les documents de l'avenant ne sont pas tous valides
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "signed".

## Contrat signé avec avenant bon pour signature.

  @contrat_signé_avec_avenant_bon_pour_signature
  Scénario: contrat_signé_avec_avenant_bon_pour_signature
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat est supérieur à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que l'avenant n'est pas prêt à être signé sur yousign
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "signed".

## Contrat signé avec avenant A signer.

  @contrat_signé_avec_avenant_a_signer
  Scénario: contrat_signé_avec_avenant_a_signer
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat est supérieur à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que l'avenant est prêt à être signé sur yousign
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "signed".

# Contrat signé avec avenant signé.

  @contrat_signé_avec_avenant_signé
  Scénario: contrat_signé_avec_avenant_signé
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat est supérieur à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date de début de l'avenant est supérieur à la date du jour
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "signed".

## Contrat signé avec un avenant Actif

  @contrat_signé_avec_avenant_actif_1
  Scénario: contrat_signé_avec_avenant_actif_1
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat est supérieur à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date du jour est comprise entre la date de début et la date de fin de l'avenant
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_signé_avec_avenant_actif_2
  Scénario: contrat_signé_avec_avenant_actif_2
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat est supérieur à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date de début de l'avenant est inférieur ou égale à la date du jour
    Et que la date de fin de l'avenant n'est pas définie
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_signé_avec_avenant_actif_3
  Scénario: contrat_signé_avec_avenant_actif_3
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat est supérieur à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date de début de l'avenant n'est pas définie
    Et que la date de fin de l'avenant est supérieur à la date du jour
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_signé_avec_avenant_actif_4
  Scénario: contrat_signé_avec_avenant_actif_4
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat est supérieur à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date de début de l'avenant n'est pas définie
    Et que la date de fin de l'avenant n'est pas définie
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

# Contrat  Signé avenant échu

  @contrat_signé_avec_avenant_échu_4
  Scénario: contrat_signé_avec_avenant_échu_4
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat est supérieur à la date du jour
    Et que le contrat a un avenant
    Alors l'état du contrat est "signed".
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date de fin de l'avenant est inférieur ou égale à la date du jour
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "due".

# Contrat  Signé avenant annulé

  @contrat_signé_avec_avenant_annulé_4
  Scénario: contrat_signé_avec_avenant_annulé_4
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat est supérieur à la date du jour
    Alors l'état du contrat est "signed".
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant est "canceled".
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "signed".

## Contrat  Signé avenant inactif

  @contrat_signé_avec_avenant_inactif_4
  Scénario: contrat_signé_avec_avenant_inactif_4
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les documents du contrat sont valides
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de début du contrat est supérieur à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant est "inactive".
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "signed".

# Contrat échu avec avenant

  @contrat_échu_avec_avenant_en_brouillon
  Scénario: contrat_échu_avec_avenant_en_brouillon
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de fin du contrat est inférieur ou égale à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant n'a pas de parties prenantes.
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "due".

  @contrat_échu_avec_avenant_a_completer
  Scénario: contrat_échu_avec_avenant_a_completer
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de fin du contrat est inférieur ou égale à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant ne sont pas tous valides
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "due".

  @contrat_échu_avec_avenant_a_completer
  Scénario: contrat_échu_avec_avenant_a_completer
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de fin du contrat est inférieur ou égale à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant ne sont pas tous renseignées
    Et que les documents de l'avenant sont valides
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "due".

  @contrat_échu_avec_avenant_a_completer
  Scénario: contrat_échu_avec_avenant_a_completer

    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de fin du contrat est inférieur ou égale à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant ne sont pas tous renseignées
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "due".

  @contrat_échu_avec_avenant_bon_pour_mise_en_signature
  Scénario: contrat_échu_avec_avenant_bon_pour_mise_en_signature
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de fin du contrat est inférieur ou égale à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que l'avenant n'est pas prêt à être signé sur yousign
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "due".

  @contrat_échu_avec_avenant_a_signer
  Scénario: contrat_échu_avec_avenant_a_signer
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de fin du contrat est inférieur ou égale à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que l'avenant est prêt à être signé sur yousign
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "due".

  @contrat_échu_avec_avenant_signé
  Scénario: contrat_échu_avec_avenant_signé
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de fin du contrat est inférieur ou égale à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date de début de l'avenant est supérieur à la date du jour
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "due".

  @contrat_échu_avenant_actif_1
  Scénario: contrat_échu_avenant_actif_1
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de fin du contrat est inférieur ou égale à la date du jour
    Alors l'état du contrat est "due".
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date du jour est comprise entre la date de début et la date de fin de l'avenant
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_échu_avenant_actif_2
  Scénario: contrat_échu_avenant_actif_2
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de fin du contrat est inférieur ou égale à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date de début de l'avenant est inférieur ou égale à la date du jour
    Et que la date de fin de l'avenant n'est pas définie
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_échu_avenant_actif_3
  Scénario: contrat_échu_avenant_actif_3
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de fin du contrat est inférieur ou égale à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date de début de l'avenant n'est pas définie
    Et que la date de fin de l'avenant est supérieur à la date du jour
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_échu_avenant_actif_4
  Scénario: contrat_échu_avenant_actif_4
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de fin du contrat est inférieur ou égale à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les documents de l'avenant sont valides
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date de début de l'avenant n'est pas définie
    Et que la date de fin de l'avenant n'est pas définie
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "active".

  @contrat_échu_avenant_échu
  Scénario: contrat_échu_avenant_échu
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de fin du contrat est inférieur ou égale à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant a au moins deux parties prenantes.
    Et que les variables de l'avenant sont tous renseignées
    Et que les parties prenantes de l'avenant ont des dates de signatures renseignées.
    Et que la date de fin de l'avenant est inférieur ou égale à la date du jour
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "due".

## Contrat échu avenant annulé
  @contrat_échu_avec_avenant_annulé_4
  Scénario: contrat_échu_avec_avenant_annulé_4
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de fin du contrat est inférieur ou égale à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant est "canceled".
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "due".

## Contrat  échu avenant inactif
  @contrat_échu_avec_avenant_inactif_4
  Scénario: contrat_échu_avec_avenant_inactif_4
    Etant donné que le contrat existe
    Et que le contrat a au moins deux parties prenantes.
    Et que les variables du contrat sont toutes renseignées
    Et que les parties prenantes du contrat ont des dates de signatures renseignées.
    Et que la date de fin du contrat est inférieur ou égale à la date du jour
    Et que le contrat a un avenant
    Etant donné que l'avenant existe
    Et que l'avenant est "inactive".
    Quand je calcule l'état du contrat
    Alors l'état du contrat est "due".

