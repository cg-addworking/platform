#language: fr
Fonctionnalité: Create activity report
  Contexte:
    Etant donné que les entreprises suivantes existent
      | siret          | name        | is_customer | is_vendor |
      | 01000000000000 | neither     | 0           | 0         |
      | 02000000000000 | Client1     | 1           | 0         |
      | 03000000000000 | Presta1     | 0           | 1         |
      | 04000000000000 | Presta2     | 0           | 1         |
      | 05000000000000 | Presta3     | 0           | 1         |

    Et que les utilisateurs suivants existent
      | email                     | firstname | lastname  | siret          | is_active |
      | john.doe@addworking1.com  | John      | DOE       | 01000000000000 | true      |
      | john.smith@client1.com    | John      | SMITH     | 02000000000000 | true      |
      | john.stiles@presta1.com   | John      | STILES    | 03000000000000 | true      |
      | john.stiles@presta2.com   | John      | STILES    | 04000000000000 | false     |
      | john.stiles@presta3.com   | John      | STILES    | 05000000000000 | true      |

    Et que les partenariats suivants existent
      | siret_customer | siret_vendor   | activity_starts_at  |
      | 02000000000000 | 03000000000000 | 2017-01-01 00:00:00 |
      | 02000000000000 | 04000000000000 | 2017-01-01 00:00:00 |

  @createActivityReport
  Scénario: Créer le rapport d'activité pour le vendor
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "john.stiles@presta1.com"
    Quand j'essaie de créer un rapport de travail pour l'enterprise prestataire avec le siret "03000000000000"
    Alors le rapport d'activité est crée

  Scénario: Impossible de créer le rapport d'activité pour le vendor sans partenariat
    Etant donné que je suis authentifié en tant que utilisateur avec l'email "john.stiles@presta3.com"
    Quand j'essaie de créer un rapport de travail pour l'enterprise prestataire avec le siret "05000000000000"
    Alors l'erreur VendorNotActiveForAllCustomersException est levée
