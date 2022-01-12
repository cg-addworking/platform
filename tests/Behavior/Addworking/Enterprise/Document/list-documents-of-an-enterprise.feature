# language: fr
Fonctionnalité: Lister les documents d'une entreprise

    Contexte:
        Etant donné que les entreprises suivantes existent
        | siret          | name        | is_customer | is_vendor | access_to_enterprise |
        | 01000000000000 | Addworking  | 0           | 0         | 1                    |
        | 02000000000000 | Presta2     | 0           | 1         | 1                    |
        | 03000000000000 | Presta3     | 0           | 1         | 1                    |
        | 04000000000000 | Prestacli4  | 1           | 1         | 1                    |
        | 05000000000000 | Client5     | 1           | 0         | 1                    |

        Et que les partenariats suivants existent
        | siret_customer | siret_vendor   |
        | 05000000000000 | 02000000000000 |

        Et que les utilisateurs suivants existent
        | email                     | firstname | lastname | is_system_admin | siret          |
        | antoine.pierre@addw.com   | Antoine   | PIERRE   | 1               | 01000000000000 |
        | jean.paul@prestadeux.com  | Jean      | PAUL     | 0               | 02000000000000 |
        | ant.paul@prestatrois.com  | Antoine   | PAUL     | 0               | 03000000000000 |
        | ant.jean@prestaquatre.com | Antoine   | JEAN     | 0               | 04000000000000 |
        | jean.pierre@clicinq.com   | Jean      | PIERRE   | 0               | 05000000000000 |


    Scénario: Lister les documents en tant que support
        Etant donné que je suis authentifié en tant que utilisateur avec l'email "antoine.pierre@addw.com"
        Quand j'essaie d'accéder à l'index des documents de l'entreprise avec le siret "02000000000000"
        Alors l'accès est permis

    Scénario: Lister les documents en tant que membre de l'entreprise
        Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.paul@prestadeux.com"
        Et que mon onboarding est à l'étape des téléchargements des documents
        Quand j'essaie d'accéder à l'index des documents de l'entreprise avec le siret "02000000000000"
        Alors l'accès est permis

    Scénario: Lister les documents en tant que membre d'une entreprise customer de l'entreprise
        Etant donné que je suis authentifié en tant que utilisateur avec l'email "jean.pierre@clicinq.com"
        Quand j'essaie d'accéder à l'index des documents de l'entreprise avec le siret "02000000000000"
        Alors l'accès est permis
