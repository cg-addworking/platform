#language: fr
Fonctionnalité: lister les postes de dépense
  Contexte:
    Étant donné que les entreprises suivantes existent
      | siret          | client_siret   | name             | is_customer | is_vendor |
      | 01000000000000 | null           | Addworking       | 0           | 0         |
      | 02000000000000 | null           | Marvel Studios   | 1           | 0         |
      | 03000000000000 | 02000000000000 | Rand Corporation | 0           | 1         |
      | 04000000000000 | 02000000000000 | Pym Technologies | 0           | 1         |
      | 05000000000000 | 02000000000000 | Oscorp           | 0           | 1         |

    Et que les utilisateurs suivants existent
      | email                             | firstname | lastname | is_system_admin | enterprise_siret | is_financial |
      | john.smith@addworking.com         | John      | SMITH    | 1               | 01000000000000   | 0            |
      | stan.lee@marvel-studios.com       | Stan      | LEE      | 0               | 02000000000000   | 1            |
      | tony.stark@marvel-studios.com     | Tony      | STARK    | 0               | 02000000000000   | 0            |
      | rand.wendell@rand-corporation.com | Rand      | WENDELL  | 0               | 03000000000000   | 0            |
      | hank.pym@pym-technologies.com     | Hank      | PYM      | 0               | 04000000000000   | 0            |
      | norman.osborn@oscorp.com          | Norman    | OSBORN   | 0               | 05000000000000   | 0            |

    Et que les postes de dépense suivants existent
      | number | name             | display_name      | enterprise_siret |
      | 1      | prestation-one   | Prestataire one   | 02000000000000   |
      | 2      | prestation-two   | Prestataire two   | 02000000000000   |
      | 3      | prestation-three | Prestataire three | 02000000000000   |
      | 4      | prestation-one   | Prestation one    | 03000000000000   |
      | 5      | prestation-two   | Prestation two    | 03000000000000   |

  @scenario1
  Scénario: Lister les postes de dépense en tant que support
    Étant donné que je suis authentifié en tant que utilisateur avec l'émail "john.smith@addworking.com"
    Quand j'essaie de lister les postes de dépense pour l'entreprise avec le siret numéro "02000000000000"
    Alors les postes de dépense sont listés

  @scenario2
  Scénario: Lister les postes de dépense en tant que membre de l'entreprise avec le rôle financier
    Étant donné que je suis authentifié en tant que utilisateur avec l'émail "stan.lee@marvel-studios.com"
    Quand j'essaie de lister les postes de dépense pour l'entreprise avec le siret numéro "02000000000000"
    Alors les postes de dépense sont listés

  @scenario3
  Scénario: Impossibilité de lister les postes de dépense en tant que membre de l'entreprise sans le rôle financier
    Étant donné que je suis authentifié en tant que utilisateur avec l'émail "tony.stark@marvel-studios.com"
    Quand j'essaie de lister les postes de dépense pour l'entreprise avec le siret numéro "02000000000000"
    Alors une erreur est levée car je n'ai pas le rôle financier

  @scenario4
  Scénario: Impossibilité de créer un poste de dépense si je ne suis pas membre de l'entreprise
    Étant donné que je suis authentifié en tant que utilisateur avec l'émail "stan.lee@marvel-studios.com"
    Quand j'essaie de lister les postes de dépense pour l'entreprise avec le siret numéro "03000000000000"
    Alors une erreur est levée car je ne suis pas membre de l'entreprise
