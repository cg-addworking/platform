# Procédures Techniques

Document préliminaire.

## Roles

### Directeur Technique

[Benjamin DELESPIERRE](mailto:benjamin@addworking.com) @bdelespierre

### Product Owner

[Matthieu FRAVALO](mailto:matthieu@addworking.com)

### Scrum Master

[Benjamin DELESPIERRE](mailto:benjamin@addworking.com) @bdelespierre

### Release Manager

[@addworking/release-managers][6]

### Responsable QA

[@addworking/quality-assurance][7]

### Responsable Process

[Benjamin DELESPIERRE](mailto:benjamin@addworking.com) @bdelespierre

### Développeur

+ [Nadir BENNAI](mailto:nadir@addworking.com) @nadir-bnn
+ [Lucy TABACZYNSKY](mailto:lucy@addworking.com) @ltbczpro
+ [Hicham LEMGHARI](mailto:hicham@addworking.com) @cyberhicham
+ [Robin MULLER](mailto:robin@addworking.com) @romutech

## Faire une release

C'est la responsabilité du Release Manager de faire de releases régulières tout au long du sprint.

Le Release Manager peut faire des releases dans les cas suivants:

+ en début de sprint, faire la release du sprint précédent, en général il s'agit d'incrémenter le [numéro de version mineur](#semantic-versionning)
+ sur demande du Product Owner
+ quand le Release Manager estime qu'il y a suffisament d'éléments livrables
+ quand il faut déployer un patch en urgence

Dans tous les cas, le Release Manager doit obtenir l'approbation du Responsable QA pour effectivement déployer une release en production.

Une release **ne peut en aucun cas être faite un vendredi** sauf dérogation exceptionnelle du Directeur Technique.

*Une release* est un ensemble d'éléments livrables identifiés par un [numéro de version](#semantic-versionning). Il s'agit plus concrêtement d'un ensemble de commits, présents sur la branche `develop`, taggués avec un [numéro de version](#semantic-versionning).

*Faire une release* consiste à déployer en production une release. Plus concrêtement cela consiste à:

1. créer une branche locale de release avec le nom `release/v1.2.3` (voir [numéro de version](#semantic-versionning)) à partir de `develop`
2. merger la branche de release sur `master`
3. pusher master sur `origin` ([GitHub][1])
4. détruire la branche de release
5. déployer la branche master sur la [Dyno Heroku][2] `addworking-master`
6. vérifier le résultat des [tests d'integration continue][3] suite au déploiement
7. se synchroniser avec le Responsable QA pour enfin déployer en production en cliquant sur `Promote to production` sur la [Dyno Heroku][2] `addworking-master`

Les opérations 1. à 3. peuvent être effectuées automatiquement avec la commande `php artisan make:release`.

## Faire la review d'une pull-request

C'est la responsabilité de chaque [Développeur](#developpeur) d'effectuer les reviews des pull-requests de ses collègues.

*Une review* est une revue de code qui consiste à valider **sémantiquement et fonctionnellement** un code source dans le contexte d'une [pull-request][4].

*Une pull-request* est une demande de modification du code source du dépôt central sur [GitHub][4]. Cela permet de valider le code produit avant de l'accepter dans l'historique du projet.

*Effectuer une review* consiste à relire et valider le code d'un autre développeur.

Si le code n'est pas conforme au standard ou présente des bugs évidents, alors le reviewer a pour consigne de rejeter la pull-request associée en justifiant son refus par un commentaire.

Les règles pour qu'une [pull-request][4] soit acceptable sont décrites dans [la maquette de pull-request][5].

### Aide mémoire

+ une méthode ne doit pas avoir de comportement caché, on ne doit pas avoir besoin de regarder son code pour comprendre ce qu'elle fait
+ le nom d'une méthode devrait toujours comporter un verbe
+ le nom d'une classe devrait toujours être un nom au singulier
+ il est courant pour une interface ou un trait de finir avec le suffixe *'able'* (Commentable, Routable, Htmlable) ou de commencer par *'has'* (HasUuid, HasPartners, HasPermissions)
+ autant que possible, les prototypes doivent être typés: les paramètres doivent être [type-hintés][8] et le [type de retour][9] doit être défini
+ une méthode qui ne renvoie rien peut renvoyer `$this` sans risque
+ sauf cas exceptionnel, les membres d'une classe sont soit `public` soit `protected`
+ quel que soit le contexte, une variable est toujours en `$snake_case`
+ les attributs et noms de méthodes sont toujours en `camelCase`
+ les noms des routes, chemins de configurations, clés de cache, clés de trads, noms de routes etc. sont toujours en `kebab-case.dot-notation`
+ on évite d'utiliser les fonctions de helpers désormais et on préfèrera utiliser leurs équivalents Facade: `Arr::get()` au lieu de `array_get()` par exemple
+ on n'utilise jamais les helpers de modèle ailleus que dans les vues (`enterprise()`, `mission_offer()`, `sogetrel_passwork()`, etc.)
+ enlèvez les blocs de commentaires: 95% du temps ils n'ajoutent rien et ne sont presque jamais mis à jour
+ si c'est possible, préférez toujours `"une chaine avec une {$variable}"` plutôt que `'une chaine avec une ' . $concatenation`
+ utilisez les directives pré-établies pour vous dans `AppServiceProvider` comme `@money` ou `@bool`, ou encore `@support`
+ dans les vues, évitez les `@if` pour désactiver un boutton, préférez utiliser une gate avec `@can`
+ évitez la forme `{!! $condition ? '<html ...>' : '' !!}` préférez `@if ($condition) <html ...> @endif`
+ préférez toujours les routes du modèle, quitte à créer un modèle vous-même: `{{ mission_offer([])->customer()->associate($enterprise)->routes->index }}`

## Faire une passe de non-régression

C'est la responsabilité du [Responsable QA](#responsable-qa) d'effectuer les passes de non-régression.

*Une passe de non-régression* est une revue fonctionnelle qui consiste à vérifier qu'aucune ancienne fonctionnalité dysfonctionne à l'ajout de nouvelles fonctionnalités.

*Effectuer une passe de non-régression* consiste à effectuer toute une série d'étapes présentée sous forme d'une [checklist][10] sur la plateforme demandée par le [Release Manager](#release-manager) (le plus souvent **addworking-master**) tout en reportant les bugs rencontrés et les idées d'améliorations.

S'il y a des bugs bloquants alors le [Responsable QA](#responsable-qa) se doit d'invalider la passe de non-régression. Les bugs bloquants devront être réparés avant une éventuelle mise en production par le [Release Manager](#release-manager).

Un *bug bloquant* est une erreur survenue qui empêche l'utilisation basique de la plateforme.

## Semantic versionning

Soit un numéro de version `MAJEUR.MINEUR.PATCH`, incrémentez:

+ MAJEUR quand vous faites un changement d'API incompatible,
+ MINEUR quand vous créez une fonctionnalité en préservant la compatibilité ascendante, et
+ PATCH quand vous faites une correction de bug en préservant la compatibilité ascendante

## La WIP limit

C'est la responsabilité de chaque [Développeur](#developpeur) de respecter la WIP limit.

*La WIP Limit* est la limite de charge de tickets en cours qu'un développeur se doit de gérer.

Elle est de **2 tickets maximum en review** et **1 ticket en doing** dans le board.

Outrepasser cette limite peut amener une surcharge de travail pour le developpeur et ses reviewers: le Développeur peut se perdre dans ses tâches et rendre un travail moins fiable ce qui demandera plus d'efforts lors de la review. Stocker trop de tickets en review engorge la fluidité du process du board.


## Le RPG

C'est la responsabilité du [Responsable Process](#responsable-process) et des [développeurs](#developpeur) de tenir le RPG quotidiennement.

*Le RPG* est un fichier excel à remplir de manière journalière par les développeurs. D'une manière gamifiée, il permet une tracabilité des actions effectuées lors d'un sprint par un développeur. Il est ensuite analysé par le Responsable Process.


[1]: https://github.com/addworking/platform
[2]: https://dashboard.heroku.com/pipelines/82749d67-3be2-4040-a69c-a90196863086
[3]: https://dashboard.heroku.com/pipelines/82749d67-3be2-4040-a69c-a90196863086/tests
[4]: https://github.com/addworking/platform/pulls
[5]: https://github.com/addworking/platform/blob/develop/.github/PULL_REQUEST_TEMPLATE.md
[6]: https://github.com/orgs/addworking/teams/release-managers
[7]: https://github.com/orgs/addworking/teams/quality-assurance
[8]: https://www.php.net/manual/en/functions.arguments.php#functions.arguments.type-declaration
[9]: https://www.php.net/manual/en/functions.returning-values.php#functions.returning-values.type-declaration
[10]: https://app.process.st/dashboard/folder/home