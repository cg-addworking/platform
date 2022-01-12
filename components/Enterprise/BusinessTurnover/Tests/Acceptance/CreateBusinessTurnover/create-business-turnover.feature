#language: fr
Fonctionnalité: créer un chiffre d'affaire pour une année donnée
  Contexte:
    Étant donné que les entreprises suivantes existent
      | siret          | client_siret   | name             | is_customer | is_vendor | collect_business_turnover |
      | 01000000000000 | null           | Addworking       | 0           | 0         | 0                         |
      | 02000000000000 | null           | Marvel Studios   | 1           | 0         | 0                         |
      | 03000000000000 | 02000000000000 | Rand Corporation | 0           | 1         | 1                         |
      | 04000000000000 | 02000000000000 | Pym Technologies | 0           | 1         | 0                         |
      | 05000000000000 | 02000000000000 | Oscorp           | 0           | 1         | 1                         |

    Et que les utilisateurs suivants existent
      | email                             | firstname | lastname | is_system_admin | enterprise_siret | is_allowed_to_view_business_turnover |
      | john.smith@addworking.com         | John      | SMITH    | 1               | 01000000000000   | 0                                    |
      | stan.lee@marvel-studios.com       | Stan      | LEE      | 0               | 02000000000000   | 1                                    |
      | tony.stark@marvel-studios.com     | Tony      | STARK    | 0               | 02000000000000   | 0                                    |
      | rand.wendell@rand-corporation.com | Rand      | WENDELL  | 0               | 03000000000000   | 0                                    |
      | hank.pym@pym-technologies.com     | Hank      | PYM      | 0               | 04000000000000   | 0                                    |
      | norman.osborn@oscorp.com          | Norman    | OSBORN   | 0               | 05000000000000   | 0                                    |

    Et que les chiffres d'affaire suivants  existent
      | number | enterprise_siret | created_by_email         | amount   |
      | 1      | 05000000000000   | norman.osborn@oscorp.com | 23532.75 |

  @scenario1
  Scénario: Créer un chiffre d'affaire en tant que prestataire à qui on lui a demandé le CA
    Étant donné que je suis authentifié en tant que utilisateur avec l'émail "rand.wendell@rand-corporation.com"
    Quand j'essaie de créer un chiffre d'affaire pour l'année précédente pour l'entreprise avec le siret numéro "03000000000000"
    Alors le chiffre d'affaire est crée

  @scenario2
  Scénario: Impossibilité de créer un chiffre d'affaire en tant que prestataire à qui on a pas demandé le CA
    Étant donné que je suis authentifié en tant que utilisateur avec l'émail "hank.pym@pym-technologies.com"
    Quand j'essaie de créer un chiffre d'affaire pour l'année précédente pour l'entreprise avec le siret numéro "04000000000000"
    Alors une erreur est levée car l'entreprise en question n'a pas l'obligation de créer des chiffres d'affaire

  @scenario3
  Scénario: Impossibilité de créer un chiffre d'affaire pour l'année dernière quand on l'a déjà fait
    Étant donné que je suis authentifié en tant que utilisateur avec l'émail "norman.osborn@oscorp.com"
    Quand j'essaie de créer un chiffre d'affaire pour l'année précédente pour l'entreprise avec le siret numéro "05000000000000"
    Alors une erreur est levée car le chiffre d'affaire pour l'année dernière est déjà declaré

  @scenario4
  Scénario: Impossibilité de créer un chiffre d'affaire par le support
    Étant donné que je suis authentifié en tant que utilisateur avec l'émail "john.smith@addworking.com"
    Quand j'essaie de créer un chiffre d'affaire pour l'année précédente pour l'entreprise avec le siret numéro "05000000000000"
    Alors une erreur est levée car le support ne peut pas créer de chiffre d'affaire
