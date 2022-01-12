#language: fr
Fonctionnalité: supprimer un poste de dépense
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
      | number | name            | display_name     | enterprise_siret |
      | 1      | prestataire     | Prestataire      | 02000000000000   |
      | 2      | agent-comptable | Agent comptable  | 03000000000000   |
      | 3      | prestation      | Prestation       | 02000000000000   |

    Et que les missions suivantes existent
      | number | label           | client_siret   | vendor_siret   | status | starts_at  |
      | 1      | this is a label | 02000000000000 | 05000000000000 | draft  | 2021-01-01 |

    Et que les milestones suivantes existent
      | mission_number | starts_at  | ends_at    |
      | 1              | 2021-01-01 | 2021-04-30 |

    Et que les suivis de mission suivants existent
     | number | mission_number | milestone_mission_number | status    | description           |
     | 1      | 1              | 1                        | validated | this is a description |

    Et que les lignes de suivis de mission suivantes existent
      | label  | quantity | unit_price | unit | validation_vendor | validation_customer | tracking_number | accounting_expense_number |
      | mtl    | 4        | 150        | days |validated          | validated           | 1               | 3                         |

  @scenario1
  Scénario: Supprimer un poste de dépense en tant que support
    Étant donné que je suis authentifié en tant que utilisateur avec l'émail "john.smith@addworking.com"
    Quand j'essaie de supprimer le poste de dépense numéro "1" pour l'entreprise avec le siret numéro "02000000000000"
    Alors le poste de dépense numéro "1" est supprimé

  @scenario2
  Scénario: Supprimer un poste de dépense en tant que membre de l'entreprise avec le rôle financier
    Étant donné que je suis authentifié en tant que utilisateur avec l'émail "stan.lee@marvel-studios.com"
    Quand j'essaie de supprimer le poste de dépense numéro "1" pour l'entreprise avec le siret numéro "02000000000000"
    Alors le poste de dépense numéro "1" est supprimé

  @scenario3
  Scénario: Impossibilité de supprimer un poste de dépense en tant que membre de l'entreprise sans le rôle financier
    Étant donné que je suis authentifié en tant que utilisateur avec l'émail "tony.stark@marvel-studios.com"
    Quand j'essaie de supprimer le poste de dépense numéro "1" pour l'entreprise avec le siret numéro "02000000000000"
    Alors une erreur est levée car je n'ai pas le rôle financier

  @scenario4
  Scénario: Impossibilité de supprimer un poste de dépense si je ne suis pas membre de l'entreprise
    Étant donné que je suis authentifié en tant que utilisateur avec l'émail "stan.lee@marvel-studios.com"
    Quand j'essaie de supprimer le poste de dépense numéro "2" pour l'entreprise avec le siret numéro "03000000000000"
    Alors une erreur est levée car je ne suis pas membre de l'entreprise

  @scenario5
  Scénario: Impossibilité de supprimer un poste de dépense s'il est lié à au moins une ligne de suivi de mission (MTL)
    Étant donné que je suis authentifié en tant que utilisateur avec l'émail "john.smith@addworking.com"
    Quand j'essaie de supprimer le poste de dépense numéro "3" pour l'entreprise avec le siret numéro "02000000000000"
    Alors une erreur est levée car le poste de dépense a des lignes de suivi de mission associées
