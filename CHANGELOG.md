<img height="100px" src="https://app.addworking.com/img/logo_addworking_vertical.png" alt="Addworking" align="right">

# Addworking Platform

## Changelog [FR]
Tous les changements notables apportés à ce projet seront documentés dans ce fichier.

Le format est basé sur [Keep a Changelog](https://keepachangelog.com/fr/1.0.0/),

### [Unreleased]
### [0.73.1] 2021-02-08
#### Fixed
* Formulaire d'inscription d'un utilisateur sur invitation (#3792)
* Ne pas checker les documents si le modèle de contrat n'a pas de parties prenantes #3789 (#3790)
* Génération du PDF des factures outbound incluant des lignes addhoc #3762 (#3786)

#### Added
* Ajout de variables systeme a un model de contrat #3767 (#3779)
* Index "Mes Exports" #3721 (#3787)

### [0.73.0] 2021-02-05
#### Fixed
* Correction de la recherche des passworks Sogetrel departements corses #3761 (#3783)
* Bug sur les exports des lignes de suivi. (#3773)
* Mise en place d'un nouveau input pour les numéros de téléphone lors de la creation - modification d'une entreprise #3755 (#3780)
* Ajustement des policies par rapport à Business + #3763 (#3774)
* Bug sur les exports des factures prestataires #issue-3760 (#3777)

#### Changed
* Mise en place d'un nouveau input pour les numéros de téléphone lors de la creation d'un utilisateur #3781 (#3782)
* Remplissage des noms des variables sont automatiquement lors de la création du modèle #issue-3766 (#3778)
* Permettre au support de changer les dates de signatures des parties #3764 (#3776)

#### Added
* Créations des scénarios aux calculs des états sur les contrats #issue-3665 (#3750)

### [0.72.6] 2021-02-02
#### Fixed
* Bug lien dans le menu vers les factures dans l'ancien template #3753 (#3754)

### [0.72.5] 2021-02-02
#### Fixed
* Lister les missions et suivis de mission dont l'entreprise est soit cliente soit vendor #3744 (#3752)

#### Changed
* Arrondir les MT HT des lignes et afficher les PU avec précision #3713 (#3730)
* Permettre aux clients de prendre l'offre Business+  #3718 (#3732)
* Ajustement sur la fin de procédure yousign (#3751)

#### Removed
* Nettoyage de l'ancien système de facturation #3724 (#3749)

### [0.72.4] 2021-01-28
#### Fixed
* Supprimer la validation HTML quand la selection de mission n'est pas visible (#3747)

### [0.72.3] 2021-01-28
#### Fixed
* (re)calculer l'etat du contrat à la modification #issue-3665 (#3707)

#### Changed
* Pouvoir lier des factures prestataires dont l'échéance de paiement est supérieur ou égale à l'échance de paiement de la facture addworking #issue-3714 (#3742)
* Mise à jour l'état d'un contrat pour lequel le dernier document vient d'être validé #3720 (#3739)
* Rendre impossible l'association de lignes de suivi de mission à une facture prestataire #3717 (#3735)
* le prix unitaire de ligne de suivi de mission peut désormais être sur 4 chiffres  #3712 (#3728)
* Recherche par nom / id externe de contrat dans l'index #3715 (#3727)
* (tech) déplacement de foundation dans platform #issue-3723 (#3738)
* (tech) déplacement de foundation dans platform #issue-3723 (#3737)

#### Added
* Permettre la recherche d'attachement Airtable directement dans l'app pour Sogetrel #issue-3719 (#3734)
* Ajout de l'attribut "updated_by" sur les factures prestataires et addworking #3722 (#3729)
* Pouvoir lier ou créer une mission lors de la création d'un contrat #issue-3674 (#3696)

### [0.72.2] 2021-01-26
#### Fixed
* Traductions allemandes (#3736)

#### Added
* Ajout des tests pour le usecase ajour de contrat sans modele #3716 (#3731)

### [0.72.1] 2021-01-25
#### Added
* Ajout des differents webhook pour collecter les informations Yousign #3726 (#3733)

### [0.72.0] 2021-01-25
#### Fixed
* Traductions allemandes #3709 (#3711)

### [0.71.9] 2021-01-24
#### Fixed 
* Logo addworking (#3710)

#### Added
* Signature electronique avec Yousign #3610 (#3692)

### [0.71.8] 2021-01-22
#### Fixed
* Filtre sur les états d'un contrat dans l'index #issue-3665 (#3708)
* (tech) Ajuster la commande de mise à jour des états de contrats #issue-3665 (#3706)

### [0.71.7] 2021-01-22
#### Fixed
* Edition des parties prenantes d'un contrat #3704 (#3705)

### [0.71.6] 2021-01-22
#### Added
* La capacité de créer un contrat est administrable au niveau des droits utilisateurs #3693 (#3703)
* Lorsqu'un contrat a un avenant de prolongation, la date de fin du contrat se voit modifée #3700 (#3702)

### [0.71.5] 2021-01-21
#### Fixed
* Traductions allemandes (#3688)
* Les pièces volantes ajoutées au contrat seront obligatoirement en PDF #issue-3668 (#3685)
* Traductions sur la vue Edit des variables d'un contrat #3667 (#3681)

#### Changed
* Changement de l'état d'un contrat lorsque l'on "Met à jour le contrat signé" #3695 (#3701)
* Afficher "Mes contrats (bêta)" dans le menu #issue-3673 (#3687)

#### Added
* dupliquer un modèle de contrat #3669 (#3690)
* Ajout de l'input "signed_at" au formulaire de creation d'un contrat sans model (#3699)
* Mise a jour du formulaire d'un contrat sans model #3666 (#3689)
* Possibilité des memebres multi entreprises de voir tout leurs prestataires #issue-3655-1 (#3691)
* Possibilité de changer les parties prenantes d'un contrat #3671 (#3679)
* Ajout du Pays dans le formaulaire des entreprises #3611 (#3645)
* Accès aux documents demandés aux parties pour un contrat #3672 (#3684)
* Traductions allemandes (#3686)

### [0.71.4] 2021-01-14
#### Changed
* Désactivation du mail automatique envoyé aux parties prenantes pour completer les documents attachés a un contrat #3682 (#3683)

#### Added
* feature: creation customer contract access from the contract index #3675 (#3676)
* Ajout de l'identifiant externe au contrat #3670 (#3677)
* Suppression d'une piece de contrat #issue-3654 (#3664)

### [0.71.3] 2021-01-13
#### Fixed
* Edit des factures prestataires. Fix de l’erreur avec Iban. 3648 (#3659)
* Changer l’adresse email de benjamin lorsque le client requiert le support technique après un message d’erreur. #3656 (#3660)
* Impossibilité de créer un contrat sans modèle #3614 (#3643)
* Vérification que les variables et les documents sont renseignés avant d’afficher le bouton générer le contrat (#3641)

#### Changed
* Possibilité d’upload un contrat signé sans pièces de contrat, sans modèle et sans parties prenantes (#3646)
* Changement de input fichier #3649 (#3658)
* Mise à jour d’un état de contrat selon la date et le jour #3618 (#3644)

#### Added
* Ajout du code postal et de la ville dans le type de variable adresse dans l’édit des variables #3650 (#3662)
* Accès à l’index des modèles de contrat depuis l’index des contrats support #3653 (#3661)
* Création des états des contrats #issue-3617 (#3647)
* Une fois le contrat généré le bouton générer le contrat devient « Re-générer le contrat » (#3657)
* Traductions allemandes (#3642)
* Index des contrats, ainsi que le show, les noms des entreprises sont maintenant cliquable et redirige vers le profil de l’entreprise #3628 (#3634)
* Création de Yousign client #3609 (#3632)

### [0.71.2] 2021-01-07
#### Changed
* Changement d'affichage de la liste des contrats d'une entreprise depuis son menu action #3627 (#3635)
* Retrait des avenants dans l'index des contrats d'une entreprise #3581 (#3603)
* Changement des liens des onglets contrat du tableau de bord des utilisateurs(#3605)

#### Fixed
* Correctif sur la sélection des entreprises propriétaires d'un contrat(#3639)
* Correctif sur les clés de traduction (#3636)
* Correctif sur l'affichage des anciens contrats qui ont un modèle de contrat sans modèle de parties prenantes #3630 (#3633)
* Correctif sur la mise à jour des statuts de documents des prestataires inactif #issue-3624 (#3626)

#### Added
* Ajout de la traduction allemande sur la plateforme #3623 (#3638)
* Ajout des tests du cas d'usage de création d'un avenant de contrat #3616 (#3631)

### [0.71.1] 2021-01-06
#### Fixed
* Migration des fichiers des anciens contrats vers des pièces de nouveaux contrats

#### Added
* Ajout traduction allemande (#3625)
* Ajout traduction allemande (#3607)

### [0.71.0] 2021-01-05
#### Fixed
* Correction de la création d'avenant de contrat (#3600)

#### Changed
* (tech) Mise en place de variables système pour activer ou désactiver les commandes du scheduler(#3606)
* (tech) bump axios from 0.18.1 to 0.21.1 (#3604)
* Calculs de commissions déplacés en queue de traitement #3577 (#3601)
* Mise à jour des changelogs v0.70.4 (#3599)


### [0.70.4]
#### Fixed
* Fluidification du processus de création de contrat #3597 (#3598)
* Correction des statuts de contrat #3580 (#3589)
* Correction de l'affichage des boutons d'actions possibles sur la vue de détail d'un contrat selon son état #3587 (#3594)
* Correction sur la barre de recherche de l'index des contrats (#3593)
* Suppression des anciennes pièces de contrat à la régénération d'un contrat #issue-3526 (#3590)
* Correction de l'affichage du nom d'entreprise dans la sélection de la modification de contrat #3586 (#3588)

#### Added
* Création d'une commande de mise à jour des statuts d'un contrat #3583 (#3596)
* Ajout de la séléction de date de signature à la mise à jour des contrats signés #3585 (#3595)
* Ajout d'une séléction de l'entreprise propriétaire d'un contrat #3582 (#3591)

#### Changed
* Remplacement des accès pour le nouveau système de contrat #3569 (#3592)

### [0.70.3]
#### Changed
* Refonte de la vue de détail d'un contrat #3525 (#3571)
* Retrait des paramètres non utilisés dans la génération de contrat (#3578)

### [0.70.2]
#### Added
* Création de contrat sans modèle de contrat (#3568)
* Ajout de la notion d'affacturage sur les factures prestataires #3528 (#3560)
* Notification des parties prenantes pour ajout de documents #3530 (#3566)
* Ajout des variables système à la création des variables de modèle de contrat #issue-3528 (#3564)
* Téléchargement de contrats signés hors plateforme #3531 (#3559)
* Création d'avenant de contrat #3441 (#3557)
* Assignement direct d'une mission depuis l'offre de mission #issue-3534 (#3558)
* Création de pièce de contrat sans pièce modèle #3533 (#3551)

#### Changed
* Tri des lignes de suivi de mission par ordre croissant #3561 (#3565)
* Ajout de la forme légale et du siret dans la vue de détail d'un document #3539 (#3549)
* Restriction de la modification de la valeur des variables d'un contrat au support et au propriétaire #3529 (#3552)

### [0.70.1]
#### Added
* Ajout de l'unité "unité" dans la sélection des réponses d'offre de mission #issue-3547 (#3554)
* Suppression des anciennes pièces de contrat à la régénération d'un contrat #issue-3526 (#3544)

#### Changed
* Ajout de la modification des dates d'un document à la volée pour le support #3535 (#3545)
* Modification du wording du filtre siret dans l'index de passwork sogetrel #issue-3546 (#3550)

#### Fixed
* Correctif sur le bouton de réactivation d'un utilisateur désactivé (#3553)
* Correction du bouton de retour et du fil d'ariane sur l'index des documents des parties prenantes d'un contrat #issue-3527 (#3541)
* Correction d'erreurs et ajustements sur les modèles de contrat #3517 (#3520)
* Correction du format des dates des documents dans la vue de détail #3535 (#3555)

### [0.70.0]
#### Changed
* Changement de l'emplacement du scheduler pour la commande send-vendors-to-navibat (#3521)
* Déplacement du cas d'utilisation génération du fichier d'une facture addworking dans un job (#3522)

#### Fixed
* Ajout de tests pour les paramètres de facturation (#3524)
* Correction traduction du fichier composants (#3523)

### [0.69.6]
#### Added
* Ajout des pièces de contrat à la vue de détail d'un contrat (#3518)

### [0.69.5]
#### Added
* Ajout de la génération d'un contrat #3485 (#3514)

### [0.69.4]
#### Added
* Améliorations sur les contrats #3482 (#3515)
* Possibilité de téléverser plusieurs fichiers dans les suivis de mission #3469 (#3512)

#### Changed
* Mise à jour des changelogs pour v0.69.4
* Récupération des métiers et compétences de tous les ancêtres à la création d'une offre de mission #issue-3477 (#3513)
* (tech) Suppression des tests inutilisés (#3358)

### [0.69.3]
#### Added
* Vérification si le contrat est prêt pour génération #3484
* Ajout de l'index des variables d'un contrat (#3505)
* Ajout du remplissage des documents d'un contrat #issue-3483 (#3506)
* Notifier les partiess prenantes de la création d'un contrat #3481 (#3498)
* (tech) Ajout du package liuggio/fastest (#3503)
* Lister les partiess prenantes d'un contrat sur la vue de détail #3486 (#3502)
* Ajout de la complétion des variables #3444 (#3473)
* Ajout des informations de remplissage des variables sur la vue d'ajout d'une pièce de contrat #3487 (#3500)
* Ajout de la vue de détail d'un contrat #3480 (#3493)
* Ajout de la modification des variables du modèle de contrat #issue-3488 (#3492)

#### Fixed
* Correction des traductions sur les vues de modèle de contrat#3446 (#3507)

#### Changed
* Mise à jour des changelogs pour v0.69.3

### [0.69.2]
#### Added

* Ajout de la suppression d'un contrat #issue-3440 (#3490)
* Afficher les montants des encards avec les filtres sur le show des factures prestataires #3476 (#3497) 

#### Changed
* Modification de la policy du show facture prestataire #3474 (#3496)

### [0.69.1]

#### Fixed
* fix: Modification de la relation signataires dans l'ancien système de parties prenantes (#3494) 

### [0.69.0]
#### Added

* Modification du changelog pour la v0.69

### [0.68.3]
#### Added

* Ajout de l'identification des parties prenantes d'un contrat

### [0.68.2]
#### Fixed

* Correction de méthodes pour l'upload des fichiers
* Correction de bugs
* (tech) Correction psr-2
* (tech) Correction de méthodes manquantes

#### Changed

* Modification des accès et de l'onboarding à l'invitation de membre
* Modification des tables pour la v2 des contrats

#### Added

* Ajout de la modification des contrats
* Ajout de l'index des contrats pour le support
* Ajout de la création des paramètres de facturation
* Ajout de traduction allemandes
* Ajout de l'index des contrats
* Ajout de traduction allemandes
* (tech) Modification du ci.sh pour retirer les fichiers js
* Nouveau service pour la validation des documents
* Ajout du validateur des documents urssaf
* Ajout de la librairie de validation des kbis
* Ajout du scrapper infogreffe
* Extraction des données des certificats urssaf
* Ajout des bases d'extracteur de données de documents
* Ajout d'interfaces de détecteur et d'exctrateur pour les documents
* Ajout de job
* Ajout du test de création de texte libre
* Ajout de nouveaux providers
* Ajout de tout format acceptés dans le texte libre
* Ajout de migration
* (tech) Ajout de méthodes pour le traitement des fichiers
* Modification des tests de l'api google vision
* Ajout de l'extracteur de texte
* Ajout de la représentation en texte des fichiers pdf
* (tech) Ajout du package bdelespierre/blade-linter
* Ajout de la création d'un contrat depuis un modèle de contrat
* Ajout de l'index des factures prestataires pour les clients
* Ajout de traduction allemandes
* Ajout du changelog pour la v0.68.1

### [0.68.1] 2020-11-23
#### Fixed
* Correction du filtre type de l'index support des entreprises (#3451)
* Correction de la preview pdf des modèles de contrats #3435 (#3452)

#### Changed
* Modification des dates de notifications pour le rapport d'activité #issue-3437 (#3455)
* Modification de l'email de non-conformité pour séparation des nouveaux non-conformes aux anciens #3394 (#3421)

#### Added
* Ajout de la liste des variables d'un modèle de contrat #issue-3399 (#3430)

### [0.68.0]
#### Fixed
* (tech) Envoi des documents prestataires au ftp sogetrel (#3453)
* Correction des fichiers de Babel Traduction (#3449)

### [0.67.3] 2020-11-17
#### Fixed
* (tech) Utilisation de GhostScript pour merger et compresser des pdfs avant envoi à Navibat (#3429)
* Ajout de la persistance des filtres et de la sélection du nombre d'items par page sur l'index des factures prestataires (#3428)
* Ajout de la persistance des filtres et de la sélection du nombre d'items par page (#3427)

#### Added
* **MTLA:** Amélioration de l'attachement SOGETREL au niveau de la modification et du listing #3420 (#3425)
* **Contrat v2:** Création de la preview des modéles de contrat #3400 (#3418)
* Changement des dispositions des dates dans le show des documents des prestataires #3397 (#3419)

### [0.67.2] 2020-11-12
#### Added
* **Contrat v2:** Publication d'un modèle de contrat #issue-3314 (#3416)
* Suppression de la sensibilité à la case pour les emails lors de la connexion #issue-3396 (#3417)
* **Contract v2:** Suppression d'une pièce du modèle de contrat #3401 (#3409)

#### Changed
* (tech) Mise a jour de la version du Framework Laravel v7 => v8 #3320 (#3415)

### [0.67.1] 2020-11-06
#### Fixed
* Merge des fichiers pdfs et changement de nom avant l'envoi vers le ftp de Sogetrel (#3410)
* Ajout de la persistance des filtres et affichage de 100 contrats par page #3395 (#3411)

#### Added
* Nouveau index d'entreprise pour le support #3393-2 (#3414)
* **Contrat v2:** Modification de la pièce du modèle de contrat #issue-3402 (#3408)
* **Contrat v2:** Lister les pièces du modèle de contrat #3403 (#3407)
* Traductions (#3404) (#3379) (#3377)

### [0.67.0] 2020-11-04
#### Fixed
* Ajout de relances pour les 7 premiers jours de chaque mois pour les rapports d'activité #issue-3398 (#3405)

### [0.66.7] 2020-10-30
#### Fixed
* Correction d'un bug qui fait planter le dashboard des prestataires (#3390)
* Correction de la policy du store des lignes de suivi de missions (#3390)

### [0.66.6] 2020-10-30
#### Fixed
* Correction de la policy pour la création de lignes de suivi de mission (#3389)

#### Added
* Contrat v2: Supprimer un document-type demandé précédemment [#3367](https://github.com/addworking/platform/issues/3367) (#3384)
* Modification du métier monteur cableur radio dans le passwork sogetrel [#3354](https://github.com/addworking/platform/issues/3354) (#3373)
* Contrat v2: Ajout d'une pièce au modèle de contrat (#3382)
* Contrat v2: Création de l'index des documents type associés à une partie prenante d'un modèle de contrat [#3366](https://github.com/addworking/platform/issues/3366) (#3385)
* Ajout de la condition d'être en prod pour modifier le domain route dans l'url [#3355](https://github.com/addworking/platform/issues/3355) (#3386)
* Ajout du commentaire dans la notification pour demande de bpu au référent de l'offre de mission [#3353](https://github.com/addworking/platform/issues/3353) (#3383)
* Ajout de la traduction des statuts dans les filtres des index des outbound invoices [#3352](https://github.com/addworking/platform/issues/3352) (#3381)
* Contrat v2: Définir des docs pour des parties prenantes [#3364](https://github.com/addworking/platform/issues/3364) (#3374)
* Contrat v2: Permettre au support de supprimer une partie prenante depuis la vue show d'un modèle de contrat. [#issue-3363](https://github.com/addworking/platform/issues/3363) (#3372)

### [0.66.5] 2020-10-27
#### Fixed
* Ajout du mois en cours dans le select Periode à la création d'une facture prestataire (#3380)

#### Added
* (infrastructure) Ajout du package heroku buildpack poppler (#3378)

### [0.66.4] 2020-10-25
#### Fixed
* Correction du nombre d'entreprise à contacter pour le rapport d'activité mensuel [#3357](https://github.com/addworking/platform/issues/3357) (#3375)

#### Added
* Tri par nom d'entreprise vendor et par numéro croissant d'inbound invoices l'export des inbound invoices contenues dans une outbound invoice #3317 (#3376)
* Contrat v2: Ajout de la partie prenante au contrat [#issue-3362](https://github.com/addworking/platform/issues/3362) (#3370)

### [0.66.3] 2020-10-21
#### Fixed
* Filtrer l'index des documents d'un vendor selon le propriétaire du document type (#3371)

### [0.66.2] 2020-10-20
#### Fixed
* Correction du doublon de l'entrée du code APE dans les formulaires d'entreprise (#3369)

### [0.66.1] 2020-10-20
#### Added
* Modifier le code APE par le support [#3351](https://github.com/addworking/platform/issues/3351) (#3365)
* Contrat v2: Ajout de la vue de détail d'un modèle de contrat [#issue-3356](https://github.com/addworking/platform/issues/3356) (#3359)

#### Changed
* (infrastructure) Mise à jour de la config de Sentry et la version du package pour intégrer le monitoring (#3368)

### [0.66.0] 2020-10-19
#### Added
* Contrat v2: Index des modèles de contrats pour le support [#3227](https://github.com/addworking/platform/issues/3227) (#3346)
* Contrat v2: Ajout de la possibilité de supprimer un modèle de contrat (par  le support) quand il est en mode draft [#issue-3228](https://github.com/addworking/platform/issues/3228) (#3344)


### [0.65.4] 2020-10-15
#### Fixed
* Changer l'id par le nom d'entreprise dans le filtre partie prenante quand on consulte les contrats d'un presta depuis l'index **mes prestataires** (#3347)

### [0.65.3] 2020-10-15
#### Added
* Réduire le nombre de requêtes sur l'index des contrats pour gagner en rapidité d'éxécution en utilisant l'eager loading (pré-chargement des relations). (#3342)
* Contrat V2 : Mise à jour du modèle de contrat quand il est en mode draft [#issue-3226](https://github.com/addworking/platform/issues/3226) (#3341)
* Mise en place des bases de l'implémentation de l'OCR Google Vision (#3340)
* (tech) Nouvelles commandes de traduction (#3339)
* Contrat V2 : Création de modèle de contrat vide par le support [#issue-3225](https://github.com/addworking/platform/issues/3225) (#3325)
* Ajout d'une confirmation avant génération d'un bon de commande [#3319](https://github.com/addworking/platform/issues/3319) (#3335)

### [0.65.2] 2020-10-12
#### Fixed
* correctifs MTLA  [#3330](https://github.com/addworking/platform/issues/3330) (#3333)
* correctifs ACL documents sur onboarding  [#3331](https://github.com/addworking/platform/issues/3331) (#3332)

### [0.65.1] 2020-10-08
#### Fixed
* Correction des filtres sur l'index des contrats [#3262](https://github.com/addworking/platform/issues/3262) (#3311)

#### Added
* Rendre plus explicite pourquoi le vendor ne peut pas déposer ses factures [#3321](https://github.com/addworking/platform/issues/3321) (#3327)
* (tech) contract v2: Migrations pour les maquettes de contrat (#3329)
* (tech) Lancer la commande de non-conformité tous les lundis à 15h (heure de Paris) seulement [#3318](https://github.com/addworking/platform/issues/3318) (#3328)
* Ajout de l'accès aux missions d'une offre de mission [#3316](https://github.com/addworking/platform/issues/3316) (#3326)
* MTLA : Ajout de la vue de détail (show page) [#3324](https://github.com/addworking/platform/issues/3324)
* MTLA : Associer un fichier à un attachement [#3323](https://github.com/addworking/platform/issues/3323)

### [0.65.0] 2020-10-05
#### Fixed
* Restreindre l'accès à l'index des documents au membres de l'entreprise prestataire propriétaire des documents ainsi qu'à ses customer(s) et les ancetres de son customer. [#issue-3269](https://github.com/addworking/platform/issues/3269) (#3300)
* Correction du picto du statut d'onboarding sur l'index de "mes prestataires" [#3271](https://github.com/addworking/platform/issues/3271) (#3305)

#### Added
* Envoi de l'export csv des rapports d'activité du mois précédent au support. [#issue-3288](https://github.com/addworking/platform/issues/3288) (#3290)
* Ajout de Maintenance du reseau optique dans les filtres du passwork sogetrel (#3308)

### [0.64.5] 2020-10-02
#### Fixed
* (tech) prise en compte des interfaces & des traits dans la commande de renommage des classes (#3306)
* Correctif sur la route de création de profil pour les offres de missions (#3307)

#### Added
* Traductions (#3304)

### [0.64.4] 2020-09-30
#### Added
* Ajout des clés de traduction sur les menus des vues dans le composant composer addworking/foundation 
* Filtres pour l'index support de lignes de suivi de mission [#3302](https://github.com/addworking/platform/issues/3230)
* Ajout de description pour la nouvelle façon d'inviter les prestataires [#3231](https://github.com/addworking/platform/issues/3231) (#3299)
* Ajout de la vue index support pour les ligne de suivi de missionf [#3203](https://github.com/addworking/platform/issues/3203)
* Correctif des duplications de proposions de mission aux nouvelles diffusion d'une offre de mission [#3270](https://github.com/addworking/platform/issues/3270) (#3295)
* Ajout d'un menu déroulant dans la barre de navigation pour pouvoir changer la langue (#3292)
* Ajout de la vue de création d'attachement pour les lignes de suivi de mission
* (tech) Ajout des interfaces pour les models dans les composants
* (tech) Ajout des useCases pour le suivi de mission et la ligne de suivi de mission
* (tech) Ajout des interfaces Utilisateur
* (tech) Ajout des interfaces Entreprise
* (tech) Ajout des interfaces communs
* Traductions (#3296) (#3298)

#### Changed
* Mise à jour des partials pour les fils d'ariane

#### Removed
* Retrait du check de l'onboarding sur la commande de non conformité [#3272](https://github.com/addworking/platform/issues/3272) (#3297)

### [0.64.3] 2020-09-29
* (tech) Ajout d'un attribut temporary_url dans le model File (#3294)

### [0.64.2] 2020-09-29
#### Added
* (infrastructure) Installation de Scout APM pour le monitoring de la plateforme (#3289)
* Refonte de la vue de détail d'une proposition de mission (#3287)
* Traductions (#3293)

### [0.64.1] 2020-09-28
#### Fixed
* Correction du menu actions des passwork [#3264](https://github.com/addworking/platform/issues/3264) (#3281)

#### Added
* Notification pour inviter les vendors à renseigner leurs activités du mois en cours (SOGETREL) [#issue-3223](https://github.com/addworking/platform/issues/3223) (#3241)
* Refactoring de l'onglet/index des réponses depuis une offre de mission [#3265](https://github.com/addworking/platform/issues/3265) (#3282)
* Traductions (#3286) (#3285) (#3284) (#3280) (#3283)

### [0.64.0] 2020-09-23
#### Fixed
* Export de la db de prod (avec anonymisation) pour l'environnement de dev [#3276](https://github.com/addworking/platform/issues/3276) [#3273](https://github.com/addworking/platform/issues/3273)

#### Added
* Export csv des informations d'entreprises [#3246-1](https://github.com/addworking/platform/issues/3246-1) (#3255)
* Ajout d'une question au passwork sogetrel (La Maintenance de réseau optique) [#3268](https://github.com/addworking/platform/issues/3268) (#3279)
* Traductions (#3259) (#3260) (#3277) (#3278)

#### Changed
* (tech) Mise à jour du package addworking/foundation à v1.6

### [0.63.10] 2020-09-21
* Correction des wordings des notifications de non-conformité adressées aux vendors (#3261)

### [0.63.9] 2020-09-18
#### Fixed
* Restreindre la visibilité de l'auteur et la date de creation des commentaires seulement aux support quand l'auteur de ce dernier est une personne du support (#3257)
* (tech) Correction du test behat pour la création de commission (#3258)
* Correction de la route pour la validation du passwork lors de l'onboarding [#3247](https://github.com/addworking/platform/issues/3247) (#3248)

### [0.63.8] 2020-09-16
#### Fixed
* Correction de la notifications pour les documents expirés et ceux arrivant à expiration (#3256)

#### Added
* Traductions (#3252) (#3254)

### [0.63.7] 2020-09-15
#### Added
* Correction des filtres de notification de non-conformité [#3222](https://github.com/addworking/platform/issues/3222) (#3238)

### [0.63.6] 2020-09-15
#### Fixed
* Correction de la commande pour mettre le statut des documents expirés à **Périmé** (#3253)

### [0.63.5] 2020-09-14
#### Fixed
* Prise en compte des entreprises clientes ancêtres à celles clientes actives des prestataires (#3251)

### [0.63.4] 2020-09-14
#### Fixed
* Correctif sur la commande qui check les documents expirés (#3250)

### [0.63.3] 2020-09-14
#### Fixed
* Correction du changement de statut pour les documents expirés (#3249)

#### Added
* (tech) Ajout des attachements aux lignes de suivi de mission sogetrel : création des models et migration [#3202](https://github.com/addworking/platform/issues/3202) (#3245)

### [0.63.2] 2020-09-10
#### Added
* (tech) Amélioration du code du builder csv des commissions AddWorking (#3244)
* Ajout d'un export csv des commissions d'une facture AddWorking (#3243)
* Traductions (#3237)

### [0.63.1] 2020-09-08
#### Fixed
* Correction du bug de la route show de la proposition lors de l'envoi du BPU
  
### [0.63.0] 2020-09-07
#### Added
* Traductions (#3212)
* Ajout de la possibilité de faire des paiements reçus en multi outbound (#3234)
* Mise à jour du wording concernant les notifications de documents expirés [#3230](https://github.com/addworking/platform/issues/3230) (#3233)
* Ajout d'une alerte sur le dashboard des vendors qui ont des docs expirés [#3219](https://github.com/addworking/platform/issues/3219) (#3221)
* Ajout d'une commande pour megatron (backup & duplication de base de données de prod (avec anonymisation) en vue de l'utiliser dans les environnements de dev/demo (#3220)
* Marquer l'entreprise prestataire comme 'active' à la référenciation par un customer [#issue-3217](https://github.com/addworking/platform/issues/3217) (#3218)

#### Changed
* Correction des règles de notification d'un vendor sur ces documents expirés : [#3193](https://github.com/addworking/platform/issues/3193) (#3210)
  * Filtrer les notif seulement sur les documents où le vendor est actif pour le customer
  * Filtrer les notif seulement sur les documents ayant un doc-type
  * Filtrer les répétitions du même document à notifier (docs demandés par plusieurs customers)
  * Filtrer sur les formes légales demandées par le doc-type

* (tech) : mise à jour du package **http-proxy** de 1.17.0 à 1.18.1 (#3235)
* (tech) : mise à jour du package **decompress** de 4.2.0 à 4.2.1 (#3216)

### [0.62.8] 2020-09-03
#### Fixed
* Lien du bouton calculer commisions dans l'index des commissions (#3214)

#### Added
* Mise à jour des urls envoyés dans les différentes notifications mail selon le domain du customer [#issue-2997](https://github.com/addworking/platform/issues/2997) (#3211)
* Exclusion du prestataire inactif pour tous ses clients du process de conformité (notification && check des documents) [#issue-3143](https://github.com/addworking/platform/issues/3143) (#3151)

### [0.62.7] 2020-09-02
### Fixed
* Correction des valeurs de la colonne cps3 actif dans l'export prestataire [#3162](https://github.com/addworking/platform/issues/3162) (#3189)

#### Added
* Ajout de l'UseCase : Création d'une commission Addworking [#3195](https://github.com/addworking/platform/issues/3195) (#3199)
* Ajout d'un compteur d'invitations acceptées sur l'index des invitations [#issue-3157](https://github.com/addworking/platform/issues/3157) (#3173)
* Ajout de label pour l'iban [#3197](https://github.com/addworking/platform/issues/3197) (#3198)

### Changed
* Modificatioon de la manière dont la référence d'une ordre de paiement est construite [#3196](https://github.com/addworking/platform/issues/3196) (#3199)

### [0.62.6] 2020-09-01
#### Fixed
* Correction de l'attachement de numéro de téléphone à l'inscription et à la modification de l'utilisateur [#3160](https://github.com/addworking/platform/issues/3160) (#3191)

### [0.62.5] 2020-09-01
#### Fixed
* Bug dans le select des periode de facturation des inbounds (#3190)

### [0.62.4] 2020-08-31
#### Fixed
* Correction d'un format de date sur l'envoi de l'offre de mission [#3181](https://github.com/addworking/platform/issues/3181) (#3188)

#### Added
* Ajout de la vue/logique **Modifier le paiement reçu** [#3176](https://github.com/addworking/platform/issues/3176) (#3186)

### [0.62.3] 2020-08-31
#### Added
* Ajout de l'index des notifications de fonds reçus pour une facture addworking [#3176](https://github.com/addworking/platform/issues/3176) (#3185)

#### Changed
* (tech) Déplacement de code pour **billing/outbound** vers **billing/payment_order** [#3177](https://github.com/addworking/platform/issues/3177) (#3187)

### [0.62.2] 2020-08-28
#### Fixed
* Ajout du mois en cours dans le select **période de facturation** dans le formulaire des Factures Addworking (#3184)

#### Added
* Création d'une notification de fonds reçus pour une facture Addworking [#3175](https://github.com/addworking/platform/issues/3175) (#3179)
* Mettre la date de fin de la période d'activité d'une resource en optionnel [#3163](https://github.com/addworking/platform/issues/3163) (#3172)

#### Changed
* Amélioration du composant Outbound (#3178)

### [0.62.1] 2020-08-26
#### Added
* feature: adding edit action for phone number of user [#3165](https://github.com/addworking/platform/issues/3165) (#3170)

#### Changed
* Amélioration du composant Outbound (#3171)

### [0.62.0] 2020-08-25
#### Fixed
* fix: Lien entre l'index des prestataires et les contrats [#3037](https://github.com/addworking/platform/issues/3037) (#3133)

#### Added
* Exécution de l'ordre de paiement à la banque [#3031](https://github.com/addworking/platform/issues/3031) (#3169)
* Ajout de l'action de suppression des ordres de paiement [#3030](https://github.com/addworking/platform/issues/3030) (#3167)
* Ajout des entreprises dont l'utilisateur fait partie dans la vue de détail de celui-ci [#3164](https://github.com/addworking/platform/issues/3164) (#3168)
* Génération du fichier XML d'un ordre de paiement [#3029](https://github.com/addworking/platform/issues/3029) (#3154)

### [0.61.1] 2020-08-17
#### Fixed
* Correction du bug quand le support essaye de mettre une facture prestataire au statut **Payé** (#3155)
* Orthographe (#3142)
* Orthographe (#3141)
* Fichiers de traduction
* (tech) Ignorer les fichiers supprimés du git hook pre-commit
* Orthographe
* Traductions de labals
* Traductions
* (tech) Ajout de confirmation à la commande **translation:add-missin-key**
* Affichage du status des parties prenantes du contrat [#3036](https://github.com/addworking/platform/issues/3036) (#3131)
* (tech) Correction des namespaces

#### Added
* Permettre la saisie à priori des informations concernant l'entreprise invitée : nom du contact et nom de l'entreprise prestataire, séparées d'une virgule: [#issue-3132](https://github.com/addworking/platform/issues/3132) (#3150)
* Ajout de la dissociation des factures prestataires aux ordres de paiement [#3028](https://github.com/addworking/platform/issues/3028) (#3145)
* Ajout des dates de début et de fin de partenariat entre le customer et le vendor (#3146)
* Ajout de l'association des factures prestataire aux ordres de paiement [#3027](https://github.com/addworking/platform/issues/3027) (#3138)
* (tech) Ajout de la commande **translation:check** à *bin/pre-commit.sh* et *bin/ci.sh*
* (tech) Ajout de la commande **blade:lint** to *bin/pre-commit.sh* et *bin/ci.sh*
* (tech) Meilleure serialization dans la commande **translation:fix**
* (tech) Ajout de la commande **translation:fix**
* Traductions (#3139)

#### Changed
* chore: Mise à jour du composant **bdelespierre/laravel-blade-lint** vers v1.1.0

#### Removed
* (tech) Suppressions des tests de consistence
* (tech) Suppression du package **joedixon/laravel-translation**

### [0.61.0] 2020-08-17
#### Added
* Ajout du lien de l'outbound invoice sur l'inbound invoice (#3135)
* Traductions (#3129)
* Ajout de la commande **translation:add-missing-keys**

### [0.60.14] 2020-08-14
#### Fixed
* Vues des ordres de paiements (#3128)
* (tech) Pre-commit hook validation
* (tech) Exclusion des test d'acceptance de l'analyse phpcs
* (tech) relation inexistante dans la factiry des ordres de paiement

#### Added
* Ajout des traductions (#3118)
* Vue Show des ordres de paiement #3119 (#3120)
* Vue edition des ordres de paiement (#3122)
* Vue de la repartition des metiers par prestataires #3061 (#3125)
* (tech) installation du package joedixon/laravel-translation
* (tech) Ajout de la commande translation:summary
* (tech) Ajout de la commande class:rename

### [0.60.13] 2020-08-12
#### Fixed
* Lien des factures Addworking dans le dashboard client

### [0.60.12] 2020-08-12
#### Fixed
* Export des lignes de factures Addworking (#3124)

### [0.60.11] 2020-08-11
#### Fixed
* Affichage de Parties prenanates dans le menu actions des contrats #3109

#### Added
* Export des lignes d'une facture Addworking et adaptation des vues du nouveau systeme de facturation aux clients (#3123)
* Ajout des traductions (#3121)
* Vue index des ordres de paiement #3114 (#3116)

### [0.60.10] 2020-08-10
#### Fixed
* Suppression des deadlines du label des Factures Addworking

### [0.60.9] 2020-08-10
#### Fixed
* Vue show des factures prestataires (#3117)

#### Added
* (tech) Script d'agréagation des git commits
* (tech) Commande de verifications des traductions

### [0.60.8] 2020-08-10
#### Fixed
* (tech) Script d'integration continue
* (tech) Script d'integration continue

#### Added
* Creation d'un ordre de paiement (payment order uc-1) (#3105)
* Ajout du numero de telephone au formulaire d'inscription et ajout des logs dans la commande d'envoi de fichiers au S3 #3062 (#3112)
* (tech) Amelioration du pre-commit hook
* (tech) Amelioration de la commande de verification des traductions

### [0.60.7] 2020-08-05
#### Fixed
* Corrections des traductions dans les emails conformité (#3111)
* Correction export prestataires (#3111)

### [0.60.6] 2020-08-05
#### Fixed
* Correction de la commande d'envoi des documents aux FTP sogetrel

#### Added
* Ajout des traductions (#3106)
* Ajout des traductions (#3107)
* Ajout des traductions (#3110)
* Ajout des traductions (#3108)

### [0.60.5] 2020-08-03
#### Fixed
* Correction des erreurs liées a la traduction sur le bon de commande (#3102)

### [0.60.4] 2020-07-31
#### Fixed 
* Multiple erreurs de syntaxe dans les vues
* Libellé dans factures sortantes

#### Changed
* Wording sur le passwork Sogetrel (#3093)
* Refactoring des vues des invitations (#3092)

#### Added
* Filtre entreprise dans la vue index des contrats #3098 (#3099)
* Affichage d'une liste de toutes les entreprises dans le formulaire de contrat (#3097)
* Mise a jour des conmpteurs de contrats #3100
* Avenanats des contrats (#3088)
* Ajout du lien vers le Helpdesk dans la navbar (#3095)
* Envoi des notifications de conformité seulement aux prestataires actifs (#3084)
* (tech) Installation du package magentron/laravel-blade-lint
* (tech) Mise a jour du package elliptic de 6.5.2 à 6.5.3 (#3090)
* Ajout des traductions (#3094)
* Ajout des traductions (#3086)
* Ajout des traductions (#3091)
* Ajout des traductions (#3087)
* Ajout des traductions (#3085)

### [0.60.3] 2020-07-28
#### Fixed
* Erreurs dans les traductions au niveau de l'onboarding

#### Added
* Relance multiple des invitations (#3083)
* Ajout des traductions (#3079)

### [0.60.2] 2020-07-28
#### Added
* Ajout des statuts 'payé' au factures Addworking (#3082)
* Creation de la migration BDD pour les tables des ordres de paiements (#3080)
* Modification d'une facture Addworking (billing uc-12) #issue-2970 (#3074)
* Generation automatique du contrat CPS2 pour les prestataires (#3054)
* Suppression des commissions dans une facture Addworking (#3069)

#### Changed
* Changement dans la modal d'acceptation des passwork sogetrel (#3081)
* (tech) Mise a jour du package addworking/foundation v1.5.0

### [0.60.1] 2020-07-28
#### Fixed
* Correctifs du recaptcha a l'inscription
* Correctifs sur les vues de factures sortantes

### [0.60.0] 2020-07-28
#### Fixed
* Correctifs des fichiers de trad
* Correctifs divers dans les vues

#### Added
* Les docs contractuels ne sont désormais plus visibles si aucun contrat en face (#3071)
* (tech) Ajout d'une commande pour vérifier les clés de trad (#3070)
* Ajout d'un recaptcha a l'inscription (#3048)
* ajout de la suppression d'une ligne ad-hoc de facture addworking (#3052)
* Annulation d'une facture Addworking  (billing uc-10 part-3) (#3018)
* Creation de la commande de migration des fichiers sur AWS S3 #issue-2931 (#2951)
* Ajout des traductions (#3055)
* Ajout des traductions (#3043)
* Ajout des traductions (#3050)

### [0.59.10] 2020-07-23
#### Added
* L'ajout d'une vue index pour lister les ressources dédiées chez un customer (depuis la vue mes prestataires) #issue-3004 (#3047)

### [0.59.9] 2020-07-23
#### Added
* Correction bug de traduction au niveau des factures prestataires (#3051)

### [0.59.8] 2020-07-22
#### Added
* Possibilité d'ajouter des pieces jointes aux ressources #issue-3045 (#3046)
* Ajout des clés de traduction de la partie facturation (#3044)

### [0.59.7] 2020-07-22
#### Added
* Ajout des ressources aux entreprises prestataires #3005 (#3042) (#3033)
* Ajout des traductions (#3020)

#### Changed
* Amelioration de la vue show des documents prestataires (#3041)
* Mise a jour des traductions(#3040)

### [0.59.6] 2020-07-20
#### Added
* Ajout de la possibilité de la selection des adresses de facturation avant generation du PDF de la facture outbound (#3034)
* Envoi d'une demande de modification des informations d'une entreprise par le client ou le prestataire #issue-2999 (#3024)

### [0.59.5] 2020-07-17
#### Fixed
* (tech) suppression de test

### [0.59.4] 2020-07-17
#### Fixed
* (tech) login sans mot de passe

#### Added
* Contract v2 (#2862)
* Annulation d'une facture Addworking (billing uc-10 part-2) (#2995)

### [0.59.3] 2020-07-17
#### Fixed
* fix: queueing notifications when sharing sogetrel passworks (#3021)
* chore: bump lodash from 4.17.15 to 4.17.19 (#3019)

### [0.59.2] 2020-07-15
* fix: delete line of total management fees in outbound invoice file (#3017)
* feature: billing uc-16 (#3010)
* feature: sharing passwork to multiple recipients #issue-2998 (#3012)

### [0.59.1] 2020-07-15
* fix: remove legal notice from outbound invoice create (#3011)

### [0.59.0] 2020-07-13
#### Fixed
* Bug dans la génération du fichier de la facture Addworking (#3008)

#### Added 
* Calcul des réductions sur les commissions Addworking (#3008)
* Ajout du logo dans la vue details des entreprises #issue-2958 (#2992)

#### Removed
* Suppression de la notification d'ajout de document envoyé au support (#2993)

### [0.58.7] 2020-07-10
#### Added
* Ajout des options (Mentions légales) avant la génération du fichier d'une facture addworking (#2991)
* Création d'un avoir pour une facture Addworking (billing uc-10) (#2987)

### [0.58.6] 2020-07-09
#### Added
* Ajout de l'identifiant externe sur les suivis de mission (#2990)
* Ajout de mention légale sur les factures addworking (#2990)
* Amélioration sur le nouveau systeme de facturation (#2990)

### [0.58.5] 2020-07-07
#### Fixed
* Auto génération des factures Addworking dans l'ancien systeme (#2986)

### [0.58.4] 2020-07-06
#### Fixed
* Ajout du dispatcher des contrats

#### Added
* Création de la vue des détails d'une facture Addworking uc-13 #issue-2971 (#2985)
* Option de publication et de dé-publication d'une facture Addworking uc-11 (#2982)

### [0.58.3] 2020-07-03
#### Fixed
* Affichage des images dans les iframe #2966 (#2967)

#### Added
* Systeme de facturation Addworking **Partie 2** #2597 (#2946)
  * Calculer les commissions AddWorking UC-6
  * Générer le PDF d'une facture Outbound UC-7
  
### [0.58.2] 2020-07-02
#### Fixed
* Correction d'un bug sur le edit de facture prestataire (#2968)

### [0.58.1] 2020-07-02
#### Fixed
* Correction d'un bug sur le show de facture prestataire (#2965)

### [0.58.0] 2020-07-01
#### Fixed
* Correction de quelques bug sur l'ancien système de facturation (#2960)
* Recherche par nom dans la vue index du passwork sogetrel #2956

#### Added
* Exclusion des documents optionnels et d'information de l'export csv des prestataires et de la notification de non conformité [#issue-2927](https://github.com/addworking/platform/issues/2927) (#2948)
* (tech) Ajout d'un manager de repositories (#2952)

### [0.57.5] 2020-06-24
#### Fixed
* Exclusion des onboarding prestataire de la liste des notifications de non conformité [#issue-2914](https://github.com/addworking/platform/issues/2914) (#2924)

#### Removed
* Suppression de pré-remplissage des champs dans le formulaire d'acceptation des passswork sogetrel [#issue-2939](https://github.com/addworking/platform/issues/2939) (#2945)

#### Added
* Ajout de nouvelles colonnes dans l'export CSV des prestataires [#issue-2932](https://github.com/addworking/platform/issues/2932) (#2941)
* Systeme de facturation Addworking **Partie 1** (#2773)
  * Migration de la structure des tables
  * Création de Facture Outbound UC-1
  * Lister les Factures Outbound UC-2
  * Création de ligne de Facture Ad-hoc UC-3
  * Associer les factures presta à inclure UC-4
  * Dissocier les factures presta d'une outbound UC-5

### [0.57.4] 2020-06-19
#### Fixed
* Assignation de missions par Everial [#issue-2930](https://github.com/addworking/platform/issues/2930)

### [0.57.3] 2020-06-18
#### Fixed
* Correction de l'ajout des lignes de suivi à une facture inbound (association suivis de mission) (#2928)

### [0.57.2] 2020-06-17
#### Added
* Ajout des referents client pour les prestataires [#issue-2882](https://github.com/addworking/platform/issues/2882) (#2908)

#### Fixed
* (tech) Correction du test de gestion des prestataires
* (tech) Correction de la configuration du package Foundation
* (tech) Correction affichage navbar (addworking/foundation v1.1.4)

#### Removed
* (tech) Suppression des templates inutilisés sur github

#### Security
* (tech) Mise a jour de websocket-extensions (#2909)

### [0.57.1] 2020-06-05
#### Added
* Prise en compte du sous-domaine dans les mails **Sogetrel** [#issue-2836](https://github.com/addworking/platform/issues/2836) (#2860)
* Pouvoir consulter l'historique d'un document-type pour un vendor [#2890](https://github.com/addworking/platform/issues/2890) (#2892)
* Ajout de l'info bulle du dernier commentaire d'un document sur l'index [#2884](https://github.com/addworking/platform/issues/2884) (#2891)

#### Changed
* Masquer le bouton « Ajouter » from scratch + Mettre le bouton en centre dans la vue index [#2760](https://github.com/addworking/platform/issues/2760) (#2889)

### [0.57.0] 2020-06-01
#### Added
* Ajout du logo du client au mail d'invitation des prestataires [#issue-2874](https://github.com/addworking/platform/issues/2874) (#2877)
* Ajout de motifs de refus pour les documents [#2883](https://github.com/addworking/platform/issues/2883) (#2887)

#### Changed
* Ajout de colonnes sur le csv d'onboarding [#2885](https://github.com/addworking/platform/issues/2885) (#2888)

### [0.56.5] 2020-05-28
#### Added
* Recherche par plusieurs clients (selection multiple) et prise en charge des ancetres pour la recherche des types de documents sur la vue index des documents [#2832](https://github.com/addworking/platform/issues/2832) (#2878)

#### Changed
* Ajout de colonnes sur le vendor csv (#2875)

### [0.56.4] 2020-05-28
#### Fixed
* Mettre à jour l'entreprise courante de l'utilisateur lors de son déréferencement d'une entreprise quand celui ci a plusieurs enterprises [#issue-2879](https://github.com/addworking/platform/issues/2879) (#2880)

### [0.56.3] 2020-05-27
#### Changed
* Ajustements esthétiques au niveau du menu et de la taille de la police (#2876)

### [0.56.2] 2020-05-26
#### Fixed
* Correction de l'erreur due à l'association des lignes de suivi de mission dans une facture inbound [#2761](https://github.com/addworking/platform/issues/2761) (#2871)
* Fixer la taille minimale d'upload de fichier à 1ko pour le fichier uploadé lors de la création du passwork [#issue-2868](https://github.com/addworking/platform/issues/2868) (#2869)
* Correction de traduction sur le passwork sogetrel [#issue-2840](https://github.com/addworking/platform/issues/2840) (#2864)

#### Added
* Ajout de colonnes pour l'export CSV de **mes prestataires** [#issue-2831](https://github.com/addworking/platform/issues/2831) (#2843)
* Ajout de l'action **remplacer** dans le menu d'actions des documents [#2838](https://github.com/addworking/platform/issues/2838) (#2866)
* Ajout d'un code analytique pour les référentiels de mission d'everial [#2839](https://github.com/addworking/platform/issues/2839) (#2865)
* Ajout du numéro de mission dans le titre du suivi de mission [#2842](https://github.com/addworking/platform/issues/2842) (#2863)
* Tri alphabétique sur le nom des entreprises pour la vue mes prestataires [#issue-2841](https://github.com/addworking/platform/issues/2841) (#2859)
* Ajout de sélection de notification pour le support sur la création de suivi de mission [#issue-2826](https://github.com/addworking/platform/issues/2826) (#2829)
* Notifier le support quand un préstataire est déréférencé [#issue-2835](https://github.com/addworking/platform/issues/2835) (#2856)
* Pouvoir faire une recherche par numéro de siret dans la vue index des passworks sogetrel [#issue-2804](https://github.com/addworking/platform/issues/2804) (#2854)

### [0.56.1] 2020-05-20
#### Fixed
* Fixer la taille minimale d'upload de fichier à 1ko pour tous les fichiers uploadés [#issue-2587](https://github.com/addworking/platform/issues/2587) (#2846)

### [0.56.0] 2020-05-18
#### Fixed
* Ne pas afficher les documents orphelins (entreprise supprimée) [#issue-2830](https://github.com/addworking/platform/issues/2830) (#2844)

### [0.55.4] 2020-05-14
#### Added
* Ajout de redirection pour l'UX customer pour la reconciliation [#issue-2827](https://github.com/addworking/platform/issues/2827) (#2828)

### [0.55.3] 2020-05-14
#### Added
* Aider le client à voir s'il y a besoin de réconcilier. [#issue-2811](https://github.com/addworking/platform/issues/2811) (#2816)
* Mise à jour de l'export csv prestataires [#issue-2806](https://github.com/addworking/platform/issues/2806) (#2813)

### [0.55.2] 2020-05-13
#### Fixed
* Correction du layout de génération du bon de commande (#2825)

### [0.55.1] 2020-05-12
#### Fixed
* Correction du bug de non prise en compte du nouveau fichier uploadé dans un suivi de mission [#issue-2805](https://github.com/addworking/platform/issues/2805) (#2821)
* Réparation de l'affichage de l'index des factures prestataires [#issue-2817](https://github.com/addworking/platform/issues/2817) (#2822)

#### Added
* Ajout de l'action inviter un membre dans l'index de gestion de membres [#issue-2808](https://github.com/addworking/platform/issues/2808) (#2818)
* Ajout de l'action **Supprimer** les lignes de suivi de mission pour le support [#issue-2759](https://github.com/addworking/platform/issues/2759) (#2810)
* Permettre au client de voir les numéros de téléphone de ses prestataires [#issue-2807](https://github.com/addworking/platform/issues/2807) (#2812)

### [0.55.0] 2020-05-05
#### Fixed
* Erreur dans l'index support des lignes de suivi de mission (#2802)
* Suppression du séparateur des milliers dans la vue create de lignes de factures depuis les lignes de suivi de mission, qui plantait le calcul [#issue-2762](https://github.com/addworking/platform/issues/2762) (#2799)

#### Added
* Ajout d'un champ label qui sera pris comme label pour la premiere ligne de suivi de mission crée automatiquement lors de la création de suivi de mission [#issue-2757](https://github.com/addworking/platform/issues/2757)
* Normalisation de la demande de validation pour la clôture d'une offre de mission pour **Edenred** [#issue-2596](https://github.com/addworking/platform/issues/2596) (#2797)

### [0.54.3] 2020-04-30
#### Fixed
* Correctif sur la vue index des contrats

#### Added
* Ouverture des droits de vue sur les dossiers clients pour les prestataires [#addw-2779](https://github.com/addworking/platform/issues/2779) (#2795)
* (tech) ajout d'un nouveau script de stats **phpstats.sh**
* feature: Ajout d'un nouveau type de document **informative** [#addw-2777](https://github.com/addworking/platform/issues/2777) (#2781)

### [0.54.2] 2020-04-28
#### Fixed
* Correctif sur la vue index des items des factures inbound [#issue-2783](https://github.com/addworking/platform/issues/2783) [#issue-2790](https://github.com/addworking/platform/issues/2790) (#2791)
* Correctif sur les migrations pour le module contrat
* Correctif pour le test EnterpriseMemberControllerTest::testIndex (#2776)

#### Added
* Permettre la saisie d'une quantité négative dans la vue create d'une ligne de suivi de mission et la vue create d'un item inbound invoice [#issue-2763](https://github.com/addworking/platform/issues/2763) (#2787)
* Ajout de la colonne total HT à la vue show du suivi de mission. [#issue-2758](https://github.com/addworking/platform/issues/2758) (#2786)
* (tech) Mise à jour du composant **addworking/contract** à v1.2.1
* (tech) Migrations pour le module contrat [#2696](https://github.com/addworking/platform/issues/2696) (#2774)
* Confirmation sur les actions de suppression [#issue-2756](https://github.com/addworking/platform/issues/2756) (#2775)
* Recherche par nom de prestataire dans la vue index des factures outbound [#issue-2765](https://github.com/addworking/platform/issues/2765) (#2772)
* Ajout de la colonne N° de mission et tri par période à la vue de creation de lignes de facture à partir de lignes de suivi de mission [#issue-2755](https://github.com/addworking/platform/issues/2755) (#2770)
* Ajout de la demande par mail pour clôturer des offres de mission [#2595](https://github.com/addworking/platform/issues/2595) (#2752)

### [0.54.1] 2020-04-22
#### Fixed
* Correction de vues et policies concernant le composant **addworking/contract**
* (tech) Trait viewable pour les models [#2750](https://github.com/addworking/platform/issues/2750)

#### Added
* Ajout de la recherche sur l'identifiant externe (et navibat_id dans le cas de sogetrel) sur la vue mes prestataires [#issue-2767](https://github.com/addworking/platform/issues/2767) (#2769)

#### Changed
* (infrastructure) Déplacement de la partie contrat vers le composant **addworking/contract** [#2750](https://github.com/addworking/platform/issues/2750)
* (infrastructure) Déplacement de la partie foundation vers le composant **addworking/foundation** #2753

### [0.54.0] 2020-04-20
#### Fixed
* Remise en place du logo de Addworking dans le template mail [#issue-2590](https://github.com/addworking/platform/issues/2590) (#2748)

#### Changed
* (tech) Retirer le système de contrat existant. [#2695](https://github.com/addworking/platform/issues/2695)
* (tech) Déplacement de code du model contract vers des repositories [#2715](https://github.com/addworking/platform/issues/2715) (#2718)

### [0.53.6] 2020-04-15
#### Fixed
* (tech) Correction du nom de table postgres. [#issue-2591](https://github.com/addworking/platform/issues/2591) (#2717)
* Correction du bug sur l'unicité de l'adresse quand on crée une enterprise avec une adresse déjà utilisée [#issue-2588](https://github.com/addworking/platform/issues/2588) (#2716)
* Correction de redirection si une facture sortante a déjà un numéro [#addw-2592](https://github.com/addworking/platform/issues/2592) (#2714)

#### Added
* Ajout de système de recherche multiple **Searchable** à la vue index des documents [#addw-2606](https://github.com/addworking/platform/issues/2606) (#2632)
* Ajout de système de recherche multiple **Searchable** à la vue index des suivis de mission [#addw-2609](https://github.com/addworking/platform/issues/2609) (#2633)

### [0.53.5] 2020-04-10
#### Fixed
* Changement de l'emplacement des commentaires dans la vue show des factures inbound (#2637)

#### Added
* Ajout de système de recherche multiple **Searchable** à la vue index des dossiers [#issue-2608](https://github.com/addworking/platform/issues/2608) (#2636)
* Ajout de système de recherche multiple **Searchable** à la vue index des factures outbound [#issue-2602](https://github.com/addworking/platform/issues/2602) (#2631)

### [0.53.4] 2020-04-09
#### Fixed
* Changement de la colonne quantity pour la table inbound_invoice dans la db à **décimal** (#2635)

### [0.53.3] 2020-04-09
#### Fixed
* (tech) Réutilisation des objets crées par les factories au lieu d'en créer des nouveaux pour *EnterpriseTest::testScopeSearch* (#2622)

#### Added
* Ajout de système de recherche multiple **Searchable** à la vue index des factures inbound [#addw-2601](https://github.com/addworking/platform/issues/2601) (#2618)
* Ajout de système de recherche multiple **Searchable** à la vue index des contrats [#issue-2607](https://github.com/addworking/platform/issues/2607) (#2624)
* Ajout de système de recherche multiple **Searchable** à la vue index des referentiels de mission pour **Everial** [#issue-2610](https://github.com/addworking/platform/issues/2610) (#2623)
* Ajout de système de recherche multiple **Searchable** à la vue index des codes **Edenred** [#issue-2605](https://github.com/addworking/platform/issues/2605) (#2621)

### [0.53.2] 2020-04-07
#### Added
* Ajout de 2 nouveaux prestaraires dans la config **TSE** (#2620)

### [0.53.1] 2020-04-07
#### Fixed
* Format de la date dans l'import CSV des missions pour **TSE**

#### Added
* Recherche activée pour métiers/compétence dans la vue mes prestaraire [#2600](https://github.com/addworking/platform/issues/2600) (#2617)

### [0.53.0] 2020-04-06
#### Fixed
* Affichage du lieu - localisation des missions (#2615)
* Correctif sur les règles de validation de l'acceptation pour contractualisation du passwork sogetrel [#2589](https://github.com/addworking/platform/issues/2589) (#2613)

#### Added
* Ajout de système de recherche multiple **Searchable** à la vue index de l'onboarding process [#addw-1315](https://addworking.atlassian.net/browse/ADDW-1315) (#2585)
* Ajout de système de recherche multiple **Searchable** à la vue index des bons de commande [#addw-1311](https://addworking.atlassian.net/browse/ADDW-1311) (#2584)
* Ajout de système de recherche multiple **Searchable** à la vue index des utilisateurs [#addw-1316](https://addworking.atlassian.net/browse/ADDW-1316) (#2582)

### [0.52.7] 2020-04-02
#### Fixed
* Correc tion au niveau de la vue show du formulaire Covid-19 [#addw-1346](https://addworking.atlassian.net/browse/ADDW-1346) (#2579)

#### Added
* Ajout systeme de recherche multiple 'searchable' a la vue index propositions de mission [#addw-1312](https://addworking.atlassian.net/browse/ADDW-1312) (#2580)
* Ajout systeme de recherche multiple 'searchable' a la vue index offres de mission [#addw-1336](https://addworking.atlassian.net/browse/ADDW-1336) (#2578)

#### Changed
* (tech) Mise a jour du framework Laravel v6 => v7

### [0.52.6] 2020-03-31
#### Fixed
* Paramétrage des échéances de paiement pour un vendor dans options de facturation [#addw-1345](https://addworking.atlassian.net/browse/ADDW-1345) (#2577)

#### Added
* Ajout systeme de recherche multiple 'searchable' a la vue index entreprises [#addw-1319](https://addworking.atlassian.net/browse/ADDW-1319) (#2566)

### [0.52.5] 2020-03-31
#### Changed
* Refactoring de la facturation des prestataires [#addw-1206](https://addworking.atlassian.net/browse/ADDW-1206) (#2549)

### [0.52.4] 2020-03-30
#### Removed
* Suppression du wording 'Soprema' du formulaire Covid-19

#### Added
* Ajout filtres dans les réponses du formulaire Covid-19
* Ajout systeme de recherche multiple 'searchable' a la vue index missions [#addw-1310](https://addworking.atlassian.net/browse/ADDW-1310) (#2575)

### [0.52.3] 2020-03-27
#### Fixed
* Correction au niveau du formulaire Covid-19

### [0.52.2] 2020-03-27
#### Added
* Creation formulaire Covid-19

### [0.52.1] 2020-03-26
#### Added
* Ajout de la relation entre les contrats et leur modèle [#addw-1278](https://addworking.atlassian.net/browse/ADDW-1278) (#2539)
* Ajout de la liste des jobs/skills du client et de ses ancetres [#addw-1333](https://addworking.atlassian.net/browse/ADDW-1333) (#2564)
* Ajout de la notion de customer dans les mails de non-conformité [#addw-1335](https://addworking.atlassian.net/browse/ADDW-1335) (#2558)

#### Fixed
* Meilleur contrôle des données entrées sur la page de validation des outbounds [#addw-1285](https://addworking.atlassian.net/browse/ADDW-1285) (#2565)
* Correction du formulaire de création de contrats [#addw-1286](https://addworking.atlassian.net/browse/ADDW-1286) (#2567)
* Correction de SendVendorsDocumentToFtpServer::prepareXml [#addw-1288](https://addworking.atlassian.net/browse/ADDW-1288) (#2568)
* Correction de la vue des tracking de missions [#addw-1294](https://addworking.atlassian.net/browse/ADDW-1294) (#2570)
* Correction de la policy ProposalResponsePolicy::indexOfferAnswers pour éviter qu'on puisse afficher un lien vers des réponses à des offres qui n'existent pas [#addw-1297](https://addworking.atlassian.net/browse/ADDW-1297) (#2571)
* Ajout d'une contraine maxlength à l'input activity sur le formulaire de création d'entreprise [#addw-1299](https://addworking.atlassian.net/browse/ADDW-1299) (#2572)
* Amélioration de la génération du path sur l'objet file attaché aux inbound invoice pour éviter les collisions [#addw-1327](https://addworking.atlassian.net/browse/ADDW-1327) (#2573)
* Ajout de validation sur la requête de MAJ de passwork Sogetrel [#addw-1328](https://addworking.atlassian.net/browse/ADDW-1328) (#2574)
* Correction des règles de validation de StoreDocumentRequest [#addw-1298](https://addworking.atlassian.net/browse/ADDW-1298) (#2563)
* Correction de l'affichage d'un lien dans la vue show des TJM [#addw-1291](https://addworking.atlassian.net/browse/ADDW-1291) (#2569)
* Correction de la commande document:send-to-storage (#2559)

### [0.52.0] 2020-03-23
#### Added
* Ajout des commentaires automatiques de changement de statut pour les factures prestataires [#addw-1276]((https://addworking.atlassian.net/browse/ADDW-1276)) (#2547)
* Ajout de la notion d'ancre dans les url [#addw-1283](https://addworking.atlassian.net/browse/ADDW-1283) (#2555)

### [0.51.10] 2020-03-19
#### Fixed
* Correction du filtre Date de début sur la vue index des missions [#addw-1301](https://addworking.atlassian.net/browse/ADDW-1301) (#2554)
* Prise en charge du cas où l'utilisateur ne demande pas une copie quand il partage un passwork sogetrel [#addw-1251](https://addworking.atlassian.net/browse/ADDW-1251) (#2550)

### [0.51.9] 2020-03-18
#### Fixed
* Correction de l'upload du document (zip) sur S3

### [0.51.8] 2020-03-18
#### Fixed
* Gestion de l'unicité du siret lors de la validation de la mise à jour de l'entreprise [#addw-1271](https://addworking.atlassian.net/browse/ADDW-1271) (#2546)

#### Added
* Ajout de lien vers la proposition de mission et  passwork dans l'onglet propositions de la vue offre de mission pour **Sogetrel** [#addw-1280](https://addworking.atlassian.net/browse/ADDW-1280) (#2520)

### [0.51.7] 2020-03-18
#### Fixed
* (tech) correctif sur npm audit

#### Added
* Ajout d'un message d'alerte concernant le covid sur les dashboards customer et vendor [#addw-1304](https://addworking.atlassian.net/browse/ADDW-1304) (#2548)
* (tech) Tutoriel pour refactoring de modèles laravel
* (tech) Tutoriel pour bien découper les branches github
* (tech) Ajout du script bin/find-usage.sh
* Création du module de templates de contrats [#addw-1277](https://addworking.atlassian.net/browse/ADDW-1277) (#2536)
* Activation de la recherche par nom et numéro de siret dans la vue mes prestataires [#addw-1169](https://addworking.atlassian.net/browse/ADDW-1169) (#2514)

#### Changed
* (tech) Réorganisation du code pour le modèle Enterprise
* (tech) Mise à jour du package npm acorn de 6.3.0 à 6.4.1 (#2537)
* (tech) Mise à jour du template de création de PR de github

### [0.51.6] 2020-03-13
#### Fixed
* Correction d'indentation

### [0.51.5] 2020-03-13
#### Fixed
* Mise en place d'une taille minimale (1ko) du fichier uploadé pour l'iban [#addw-1274](https://addworking.atlassian.net/browse/ADDW-1274) (#2531)

#### Added
* Ajout du mode 'simulation' pour la commande de vérification de  conformité

#### Changed
* (tech) Mise à jour du template de création de PR de github

#### Removed
* (tech) nettoyage de la base de donnée

### [0.51.4] 2020-03-12
#### Fixed
* Correction des policies du Passwork [#addw-1292](https://addworking.atlassian.net/browse/ADDW-1292) (#2519)
* Correction sur la date d'expiration d'une invitation [#addw-1289](https://addworking.atlassian.net/browse/ADDW-1289) (#2517)

### [0.51.3] 2020-03-10
#### Fixed
* (tech) Correction sur le systeme d'integration continu (CI)

### [0.51.2] 2020-03-10
#### Fixed
* Correction sur le menu actions dans les vues index

#### Changed
* (tech) Déplacement de méthodes du model vers le repository (#2515)

### [0.51.1] 2020-03-10
#### Fixed
* Erreurs remontés par rapport au système d'invitations [#addw-1275](https://addworking.atlassian.net/browse/ADDW-1275) (#2512)
* (tech) Différents fixes par rapport aux tests phpunit

#### Added
* Introduction du système de dossiers (chantiers)

#### Changed
* Google tag manager : utilisation du dataLayer (#2513)

### [0.51.0] 2020-03-09
#### Fixed
* Avoir une erreur 404 (non trouvé) quand on envoie un UUID incorrect [#addw-1270](https://addworking.atlassian.net/browse/ADDW-1270) (#2507)
* Gestion du type d'utilisateur au niveau de google tag manager (#2509)

#### Added
* Envoi de notification au responsable comformité (nouveau rôle) pour chaque prestataire non-conforme [#addw-1253](https://addworking.atlassian.net/browse/ADDW-1253) (#2505)

### [0.50.7] 2020-03-05
#### Changed
* Amelioration de l'action de switch d'entreprise [#addw-1255](https://addworking.atlassian.net/browse/ADDW-1255) (#2500)
* chore: improve datalayer (#2504) !!!

### [0.50.6] 2020-03-02
#### Added
* Le teasing des offres de mission pour des vendors invités pas encore inscrit (#2492)
* Ajout du google tag manager (#2503)

### [0.50.5] 2020-02-27
#### Added
* Export des lignes de suivi de mission [#addw-1234](https://addworking.atlassian.net/browse/ADDW-1234) (#2501)
* Ajout de la nature du document sur l'index support des documents avec le filtre associé [#addw-1264](https://addworking.atlassian.net/browse/ADDW-1264) (#2497)

#### Changed
* Avoir les deux colonnes de conformité légal et métier sur la vue mes prestataires [#addw-1247](https://addworking.atlassian.net/browse/ADDW-1247) (#2498)

#### Fixed
* Affichage de l'onglet données sogetrel (#2502)

### [0.50.4] 2020-02-24
#### Fixed
* Creation d'offre de mission pour edenred [#addw-1268](https://addworking.atlassian.net/browse/ADDW-1268) (#2499)

#### Added
* Competence "installateur d'infra pour voiture électrique" dans le passwork Sogetrel [#addw-1257](https://addworking.atlassian.net/browse/ADDW-1257) (#2490)
* Numero de TVA AddWorking dans la vue de creation d'une facture prestataire [#addw-1258](https://addworking.atlassian.net/browse/ADDW-1258) (#2496)
* Numero de mission dans l'index des suivi de mission [#addw-1256](https://addworking.atlassian.net/browse/ADDW-1256) (#2494)

#### Changed
* Affiner les informations visibles aux utilisateurs [#addw-1215](https://addworking.atlassian.net/browse/ADDW-1215) (#2481)
* Filtre sur le label d'une ofre de mission dans l'index [#addw-1263](https://addworking.atlassian.net/browse/ADDW-1263) (#2495)

### [0.50.3] 2020-02-26
#### Fixed
* Correction du flux d'envoi des documents des presta sur le  FTP de Sogetrel (#2493)

#### Changed
* Envoi des mails lors de l'acceptation d'une offre de mission [#addw-1259](https://addworking.atlassian.net/browse/ADDW-1259) (#2489)

### [0.50.2] 2020-02-25
#### Fixed
* Modification de la periode dans les factures prestataires
* Ancienne page de management des prestataires

### [0.50.1] 2020-02-25
#### Fixed
* Vue de la facture outbound (#2488)

### [0.50.0] 2020-02-24
#### Fixed
* Retro-compatibilité upload des doc sous IE 11

#### Added
* Export des factures inbound (prestataires) pour le support [#addw-1231](https://addworking.atlassian.net/browse/ADDW-1231) (#2471)
* Implementation du systeme de forme légale et ajout aux documents types des clients [#addw-1201](https://addworking.atlassian.net/browse/ADDW-1201) (#2446)

#### Changed
* Suppression des accents dans l'export csv des passworks sogetrel [#addw-1218](https://addworking.atlassian.net/browse/ADDW-1218) (#2484)

### [0.49.7] 2020-02-21
#### Fixed
* Selection de l'écheance de paiement dans les factures inbound
* Envoi du mail de confirmation lors de l'accpetation d'une invitation (#2485)

### [0.49.6] 2020-02-21
#### Fixed
* Update des factures Inbound (prestataire)
* (tech) changement de la configuration Sentry (#2482)

### [0.49.5] 2020-02-20
#### Fixed
* Acces/roles des utilisateurs (#2477)

#### Added
* Identifiant externe sur les contrats [#addw-1237](https://addworking.atlassian.net/browse/ADDW-1237) (#2478)

### [0.49.4] 2020-02-19
#### Fixed
* Vue details (show) d'une offre de mission edenred
* Acces pour les utilisateurs de sogetrel aux entreprises prestataires [#addw-1236](https://addworking.atlassian.net/browse/ADDW-1236) (#2474)
* Perte des acces dans la vue des membres d'une entreprise
* Régle d'acces a la modification des documents d'un prestataire
* (tech) Test de la policy des document
* (tech) Désactivation de inspector.dev pour phpunit (#2479)

#### Changed
* Suppression virtuelle (softdelete) d'un utilisateur dans la plateforme [#addw-1220](https://addworking.atlassian.net/browse/ADDW-1220) (#2456)
* Decoupage du formulaire de création d'une facture prestataire en 2 étapes [#addw-1229](https://addworking.atlassian.net/browse/ADDW-1229) (#2458)

#### Added
* Ajout de nouveaux rôles pour diffuser et clore les offres de mission [#addw-1227](https://addworking.atlassian.net/browse/ADDW-1227) (#2454)
* (tech) Mise a jour de la configuration Sentry (#2469)
* (tech) Installation de inspector.dev pour le monitoring

### [0.49.3] 2020-02-17
#### Fixed
* (tech) Nettoyer le nom d'entreprise avant la validation de la request #1252
* Rattachement d'un utilisateur a une entreprise par le support (#2473)
* Etape de creation d'un passwork dans l'onboarding qui prend en compte les paramètres du client et de ses parents

#### Changed
* Donner access aux proposition de mission pour un membre à la fois prestataire et client [#addw-1239](https://addworking.atlassian.net/browse/ADDW-1239) (#2472)
* Texte dans le mail envoyé apres cloture d'une offre de mission [#addw-1240](https://addworking.atlassian.net/browse/ADDW-1240) (#2467)

#### Added
* Ajout de la recherche dans les select de la vue creation des contrats [#addw-1238](https://addworking.atlassian.net/browse/ADDW-1238) (#2470)

### [0.49.2] 2020-02-12
#### Fixed
* Action d'envoi d'une seule entreprise à Navibat (#2466)

### [0.49.1] 2020-02-12
#### Added
* Ajout de codes analytics pour EVERIAL [#addw-1248](https://addworking.atlassian.net/browse/ADDW-1248)
* Envoi d'une notification au referent de l'offre de mission lorsque un bon de commande est crée [#addw-1243](https://addworking.atlassian.net/browse/ADDW-1243) (#2465)

#### Changed
* Amélioration du traitement des invitations pour envoi de masse  (#2464)
* Implementation du système d'heritage des metiers/compétences pour une entreprise et ses filliales [#addw-1249](https://addworking.atlassian.net/browse/ADDW-1249)
* Notifier le référent de l'offre de mission lorsqu'une réponse est créée à la place du créateur de l'offre [#addw-1245](https://addworking.atlassian.net/browse/ADDW-1245) (#2462)

#### Fixed
* (tech) Repository des reponses aux propositions de mission

#### Removed
* Suppression de l'alerte de signature des contrats dans le dashboard [#addw-1244](https://addworking.atlassian.net/browse/ADDW-1244) (#2463)

### [0.49.0] 2020-02-11
#### Added
* Ajout du bouton de synchronisation navibat des prestataire de sogetrel [#addw-1241](https://addworking.atlassian.net/browse/ADDW-1241) (#2459)
* Invitation membres et prestataires (#2457)

#### Changed
* Suppresion du l'email scmdo lors du partage d'un passwork sogetrel [#addw-1246](https://addworking.atlassian.net/browse/ADDW-1246) #2460

#### Removed
* (tech) Suppression de fichiers inutile

### [0.48.5]
#### Fixed
* La vue edit et show des inbound invoice #addw-1226 (#2453)
* (tech) Modification du timeout sur le projet megatron (#2452)

#### Changed
* Interdire au vendor l'ajout d'une facture inbound si il a pas renseigné son RIB #addw-1214 (#2448)

### [0.48.4]
#### Fixed
* Support peux supprimer un passwork #addw-1219 (#2451)
* Correction de la signature dans les emails #addw-1217 (#2449)
* Le vendor peut terminer une mission #addw-1224 (#2447)

#### Added
* Code analytique Everial #addw-1126 (#2450)

### [0.48.3]
#### Fixed
* (tech) Competences routes #addw-1225
* Attachement de la facture inbound a l'outbound #addw-1194
* (tech) Enterprise member controller test (#2445)
* Email de confirmation de l'IBAN (#2443)

#### Added
* (tech) Nouvelle factory de test pour les request
* Gestion des membres des entreprises (#2429)

### [0.48.2]
#### Fixed
* Principe de la conformité des prestataires par rapport a un client

### [0.48.1] - 2020-01-30
### Fixed
* Permettre l'accès à la réponse si vendor non conforme pour Sogetrel seulement (#2441)
* Correction impossibilité pour endenred de créer une offre de mission (#2440)

### [0.48.0] - 2020-01-29
#### Fixed
* Correction de l'ajout d'un fichier sur le passwork sogetrel (#2437)
* Correction du statut de conformité du vendor (#2436)
* Correction commande d'envoi des fichier sur le ftp Sogetrel (#2434)
* Correction Dashboard - Mettre un S à mission... [#addw-1223](https://addworking.atlassian.net/browse/ADDW-1223) (#2433)
* (tech) Correction script make-model

#### Added
* Index BDC - Ajouter le prix HT de la mission [#addw-1222](https://addworking.atlassian.net/browse/ADDW-1222) (#2432)
* SOGETREL - Mieux gérer les demandes d'info [#addw-1177](https://addworking.atlassian.net/browse/ADDW-1177) (#2420)
* Griser la réponse si vendor non conforme [#addw-1199](https://addworking.atlassian.net/browse/ADDW-1199) (#2421)

### [0.47.4] - 2020-01-23
#### Fixed
* (tech) Ajout de la commande "drop" avant le seeder sur megatron
* Correctif sur l'association des factures Addworking maintenant dans un repository
* (tech) Suppression de tests obsolètes

#### Added
* Ajout de la possibilité de pouvoir attacher plusieurs fichiers à un document.
* Création de la structure de type de deadline pour les factures [#addw-1207](https://addworking.atlassian.net/browse/ADDW-1207)
* Ajout de l'accès aux passworks **Sogetrel** depuis l'index des réponses

#### Changed
* (tech) Ajout de variables env dans le env.example
* (tech) Seeder la base de données en utilisant db dump

### [0.47.1] - 2020-01-16
#### Fixed
* Correctif sur la création du suivi de mission quand la mission est créée depuis l'offre [#addw-1205](https://addworking.atlassian.net/browse/ADDW-1205) (#2416)
* Correctif l'accès au données sur la vue de détail de l'entreprise #RGPD
* Correctif sur l'attachement des vendors aux customers quand leur passwork est accepté [#addw-1186](https://addworking.atlassian.net/browse/ADDW-1186) (#2412)

#### Added
* Le vendor ne peut désormais plus répondre à une proposition dont l'offre est close [#addw-1198](https://addworking.atlassian.net/browse/ADDW-1198) (#2411)
synchronizeNavibat
#### Changed
* (tech) Mise à jour des codeowners
* Refonte de la page d'édition des mots de passe [#addw-1197](https://addworking.atlassian.net/browse/ADDW-1197)
* Suppression de l'alerte de validation de compte [#addw-1202](https://addworking.atlassian.net/browse/ADDW-1202) (#2410)
* Ajout du lien vers la mission sur l'index des suivis de mission [#addw-1203](https://addworking.atlassian.net/browse/ADDW-1203)
* Refactor le système des inbound invoices en ajoutant les structures invoiceable et vat_rate [#addw-1163](https://addworking.atlassian.net/browse/ADDW-1163) (#2407)
* Dès qu'une offre est diffusée, changer l'action principale de l'offre de mission par "Clôturer l'offre" [#addw-960](https://addworking.atlassian.net/browse/ADDW-960) (#2405)
* Changement des règles de conformité des documents d'entreprise [#addw-1183](https://addworking.atlassian.net/browse/ADDW-1183) #2403

### [0.47.0] - 2020-01-13
#### Fixed
* Correctif sur le création de milestone
* Correctif sur l'accès de la vue mes prestataires [#addw-1192](https://addworking.atlassian.net/browse/ADDW-1192) (#2401)

#### Added
* Création de la vue index ligne de mission pour le support [#addw-1153](https://addworking.atlassian.net/browse/ADDW-1153) (#2385)
* Création du csv pour l'onboarding process [#addw-1182](https://addworking.atlassian.net/browse/ADDW-1182) (#2394)

#### Changed
* Suppresion de l'ancien système de propositions de mission pour **Sogetrel** [#addw-1187](https://addworking.atlassian.net/browse/ADDW-1187) (#2386)

### [0.46.5] - 2020-01-09
#### Fixed
* Correctif sur l'onglet proposition dans la vue show des offres de mission [#addw-1191](https://addworking.atlassian.net/browse/ADDW-1191) #2396
* Correctif sur le filter client dans la vue index des documents pour le support [#addw-1179](https://addworking.atlassian.net/browse/ADDW-1179) (#2397)

#### Added
* Ajout de nouveaux détails sur le bon de commande [#addw-1178](https://addworking.atlassian.net/browse/ADDW-1178) (#2399)

#### Changed
* Permission d'accès sur le referentiel de mission  [#addw-1185](https://addworking.atlassian.net/browse/ADDW-1185) (#2392)

### [0.46.4] - 2020-01-08
#### Fixed
* fix: Prendre en charge les prestataires **Sogetrel** qui n'ont pas de passwork in index/show views [#addw-1190](https://addworking.atlassian.net/browse/ADDW-1190) (#2395)

### [0.46.3] - 2020-01-08
#### Fixed
* Permettre au prestataire et au client de pouvoir terminer une mission [#addw-1189](https://addworking.atlassian.net/browse/ADDW-1189) (#2389)
* (tech) Integration continue (CI)
* (tech) Tests de cohérence

#### Added
* Inclure **Sogetrel** dans la relance mail pour les prestataires qui n'ont pas fini leur onboarding [#addw-1165](https://addworking.atlassian.net/browse/ADDW-1165) #2368
* Harmoniser le fil d'ariane pour les factures entrantes coté prestataires [#addw-1180](https://addworking.atlassian.net/browse/ADDW-1180) #2391
* Notification mail pour le support lors de l'upload d'une facture entrante [#addw-1184](https://addworking.atlassian.net/browse/ADDW-1184) (#2390)

#### Changed
* (tech) mise à jour du package addworking/laravel-models à la  v1.2
* (tech) mise à jour composer (Laravel 6.9.0 entre autres)

### [0.46.2] - 2020-01-06
#### Fixed
* (tech) Correctif sur les TJM **Edenred** [#addw-1188](https://addworking.atlassian.net/browse/ADDW-1188) (#2384)

#### Added
* Ajout de la fonctionalité BPU (Bordereau de prix unitaire) pour **Sogetrel** [#addw-1167](https://addworking.atlassian.net/browse/ADDW-1167) (#2382)

#### Removed
* Enlever les anciens "acceptations/refus" de mission pour **Sogetrel** [#addw-1088](https://addworking.atlassian.net/browse/ADDW-1088) (#2383)

### [0.46.1] - 2019-12-31
#### Fixed
* (tech) Correctif sur l'export CSV des documents

### [0.46.0] - 2019-12-30
#### Added
* Nouveau attribut (SIREN) pour l'export XML de Sogetrel [#addw-1181](https://addworking.atlassian.net/browse/ADDW-1181) (#2379)
* Envoi de mail au référent et au prestataire après la création de suivi de mission [#addw-1145](https://addworking.atlassian.net/browse/ADDW-1145) (#2347)
* (tech) Ajout de la définition du RPG au fichier PROCESS.md (#2374)

#### Changed
* Déplacement des commentaires en bas de la vue show du suivi de mission [#addw-1164](https://addworking.atlassian.net/browse/ADDW-1164) (#2378)
* Exclure des relances les prestataires qui ont leurs documents obligatoires en attente de validation [#addw-1166](https://addworking.atlassian.net/browse/ADDW-1166) (#2377)
* Mise à jour de l'export CSV des passworks sogetrel (#2372)

### [0.45.7] - 2019-12-18
#### Fixed
* Correction de bugs mineurs (#2373)

#### Added
* (tech) Ajout de la règle WIP LIMIT pour PROCESS.md (#2369)

### [0.45.6] - 2019-12-18
#### Added
* Ajout de la foncionnalité permettant au support de forcer les statuts de signature d'un contrat [#addw-1119](https://addworking.atlassian.net/browse/ADDW-1119) (#2316)

#### Changed
* Suppression du lien sur le nom des entreprises dans la vue des documents pour éviter d'avoir accès aux membres addworking / numéro de téléphone[#addw-1173](https://addworking.atlassian.net/browse/ADDW-1173) (#2370)

### [0.45.5] - 2019-12-17
#### Fixed
* (tech) Test de validation pour les reponses aux offres de mission
* (tech) Bug mineur sur la factory File

### [0.45.4] - 2019-12-17
#### Fixed
* Bug a la generation d'une facture de reliquat [#addw-1134](https://addworking.atlassian.net/browse/ADDW-1134)

#### Added
* Récuperation des informations dans le Bon de commande (BDC) d'une mission lors de l'assignation direct d'une offre de mission à un prestataire [#addw-1142](https://addworking.atlassian.net/browse/ADDW-1142) (#2361)

### [0.45.3] - 2019-12-17
#### Fixed
* Bug lors de l'ajout d'un fichier modele sur un type de document (#2367)
* Bug sur le titre dans la vue edition d'un suivi de mission (#2365)

### [0.45.2] - 2019-12-16
#### Fixed
* Bug sur le formulaire edition d'une offre de mission pour everial (#2364)

### [0.45.1] - 2019-12-16
#### Fixed
* Bug sur la route de la methode edition d'une offre de mission pour everial [#addw-1171](https://addworking.atlassian.net/browse/ADDW-1171) (#2363)

### [0.45.0] - 2019-12-16
#### Changed
* (tech) Amélioration du script de generation de models

### [0.44.16] - 2019-12-12
#### Fixed
* (tech) Correctif sur le document repository (#2359)
* (tech) Correctif sur le constructeur du document repository (#2358)

### [0.44.15] - 2019-12-12
#### Added
* Ajout du commentaire lors du refus d'un document et envoi d'une notification [#addw-1150](https://addworking.atlassian.net/browse/ADDW-1150) (#2356)

#### Removed
* Suppression de la colonne 'contrat' dans la vue 'Mes clients'

#### Fixed
* Bug lié a la balise du titre dans plusieurs vues
* Bug lié a la balise du titre de la vue 'creation' du suivi de mission (#2355)
* Bug lié a l'ajout a une ligne dans la facture outbound

### [0.44.14] - 2019-12-11
#### Added
* Ajout d'une vue Index des factures des prestataires pour le support [#addw-1149](https://addworking.atlassian.net/browse/ADDW-1149) (#2354)

#### Fixed
* Bug sur la vue 'show' des ordres de paiement des factures

### [0.44.13] - 2019-12-10
#### Added
* Ajout de l'export CSV des documents pour le support [#addw-1146](https://addworking.atlassian.net/browse/ADDW-1146)
* Ecriture des tests pour la classe Entreprise

#### Changed
* Mise a jour des hooks

#### Fixed
* La balise du titre de la vue 'creation' de l'offre de mission
* Bugs introduit par le refactoring des traits viewable et routable

### [0.44.12] - 2019-12-09
#### Changed
* Mise a niveau de la version de PHP a 7.3 et correction des problemes liées a la méthode compact (#2352)
* Formatage des commentaires pour accepter les retours a la ligne [#addw-1148](https://addworking.atlassian.net/browse/ADDW-1148) (#2353)
* Ajout d'une action back lors de la validation finale d'une réponse a une proposition de mission pour fermer l'offre de mission [#addw-1082](https://addworking.atlassian.net/browse/ADDW-1082)
* Refactoring des vues des documents

#### Removed
* Suppression de l'affichage de la numérotation des étapes du processus onboarding [#addw-1140](https://addworking.atlassian.net/browse/ADDW-1140) (#2332)

#### Fixed
* Fonctionnalité de sauveagarde des recherches de passworks [#addw-1157](https://addworking.atlassian.net/browse/ADDW-1157) (#2349)
* Systeme des pieces jointes du suivi de mission [#addw-1144](https://addworking.atlassian.net/browse/ADDW-1144) (#2340)
* Enregistrement du bon de commande (BDC)
* Statut de suivi de mission #addw-1130 (#2343)

### [0.44.11] - 2019-12-09
#### Added
* Téléchargement de l'ensemble des documents validés du prestataire sous format Zip [#addw-1147](https://addworking.atlassian.net/browse/ADDW-1147) (#2345)
* Création du contrat CPS2 manuellement (#2342)

#### Changed
* Amélioration du système de référentiel [#addw-1159](https://addworking.atlassian.net/browse/ADDW-1159) (#2346)

### [0.44.10] - 2019-12-06
#### Fixed
* Refonte de la sidebar [#addw-1143](https://addworking.atlassian.net/browse/ADDW-1143) (#2337)

#### Added
* Ajout du tag double-check dans l'index des documents (Support) [#addw-1133](https://addworking.atlassian.net/browse/ADDW-1133) (#2329)
* Ajout de l'entrée **Mes passworks** dans le menu (#2313)
* Redirection à la vue suivi de mission après cloture de la mission [#addw-1129](https://addworking.atlassian.net/browse/ADDW-1129) (#2308)

### [0.44.9] - 2019-12-04
#### Fixed
* Correctif du bouton Actions dans les vues show de l'application.

### [0.44.8] - 2019-12-04
#### Fixed
* Correctif sur la vue index des passworks (#2335)
* Correction de la date sur les navigateurs Safari & Edge
* (tech) Correctif sur les traits Routable & Viewable pour les models de la partie billing

### [0.44.7] - 2019-12-04
#### Fixed
* Correctif sur le menu déroulant du bouton Actions dans la vue index du passwork de **Sogetrel** (#2333)

### [0.44.6] - 2019-12-03
#### Fixed
* Correctif sur la vue show de l'ordre de paiement (#2331)

### [0.44.5] - 2019-12-03
#### Fixed
* Correctif sur la vue show de l'ordre de paiement (#2330)

### [0.44.4] - 2019-12-03
#### Fixed
* Correctif sur la vue show des factures entrantes (#2327)

### [0.44.3] - 2019-12-03
#### Fixed
* Correctif sur la vue show du code **Edenred** (#2325)
* Correctif sur les chemins cassé dans certaines vues [#addw-1156](https://addworking.atlassian.net/browse/ADDW-1156) (#2324)
* Correctif sur le chemin cassé dans la vue passwork de **Sogetrel** (#2326)

#### Added
* Ajout de la vue index des documents pour le **Support** [#addw-1098](https://addworking.atlassian.net/browse/ADDW-1098) (#2318)

### [0.44.2] - 2019-12-02
#### Fixed
* Remise en place de l'anncien système de commentaire pour les factures sortantes [#addw-1139](https://addworking.atlassian.net/browse/ADDW-1139) (#2323)
* Correctif sur la vue show des offres de mission #addw-1155 (#2322)

### [0.44.1] - 2019-12-02
#### Fixed
* (tech) : correctif sur la migration des doctype au niveau de la maison mère (#2321)

### [0.44.0] - 2019-12-02
#### Fixed
* (tech) Bug dans la création de l'onboarding
* (tech) Mise à jour du message de commit pour le hook de git

#### Added
* Prise en compte des doctype au niveau de la maison mère [#addw-1131](https://addworking.atlassian.net/browse/ADDW-1131) (#2317)
* Envoi du bon de commande par mail au prestataire [#addw-1127](https://addworking.atlassian.net/browse/ADDW-1127) (#2306)
* Relances mails tous les 3j aux prestataires qui n'ont pas fini leur onboarding (hors sogetrel) [#addw-1132](https://addworking.atlassian.net/browse/ADDW-1132) (#2314)
* (tech) Ajout de la méthode **Routable::has**

#### Changed
* Cacher l'entrée de menu **Mon Iban** dans le menu *Client* [#addw-1118](https://addworking.atlassian.net/browse/ADDW-1118) (#2315)

#### Removed
* (tech) Commandes non utilisés
* (tech) Trait **hasViews**

### [0.43.4] - 2019-11-26
#### Changed
* Désactivation de l'auto-generation des contrats **CPS2**
* Onboarding : Désactivation des étapes **CPS2** et **Iban**

### [0.43.3] - 2019-11-21
#### Fixed
* Importation référentielle everial (#2312)
* Mise à jour de purchase_order pour gérer l'affectation de l'offre directement au vendor [#addw-1137](https://addworking.atlassian.net/browse/ADDW-1137) (#2311)

### [0.43.2] - 2019-11-21
#### Fixed
* Correction sur la vue create et edit entreprise  [#addw-1136](https://addworking.atlassian.net/browse/ADDW-1136) (#2310)

### [0.43.1] - 2019-11-21
#### Changed
* Simplification de l'affichage de l'entrée de menu "Appel d'offre" pour everial [#addw-1126](https://addworking.atlassian.net/browse/ADDW-1126) (#2303)
* Assignation directe d'une offre de mission a un vendor et création de mission pour ce dernier [#addw-1095](https://addworking.atlassian.net/browse/ADDW-1095) (#2304)
* Affichage du numero de mission sur la vue index mission [#addw-1128](https://addworking.atlassian.net/browse/ADDW-1128) (#2305)
* Ajustement du bon de commande pour Everial [#addw-1097](https://addworking.atlassian.net/browse/ADDW-1097) (#2292)
* (tech) Améliorations du trait viewable

### [0.43.0] - 2019-11-20
#### Changed
* Nouvel omnisearch
* Ajout de l'étape création du passwork dans l'onboarding addworking [#addw-1125](https://addworking.atlassian.net/browse/ADDW-1125) (#2302)
* Le support peut maintenant voir directement les cients depuis la vue entreprise
* (tech) Ajout du paramètre routable sur les models

#### Fixed
* (tech) Traduction des noms de route en snake_case dans le trait routable

### [0.42.8] - 2019-11-14
#### Changed
* (tech) Déplacement des routes dans leurs services correspondants.
* Refonte de la vue index de l'onboarding process sous le nouveau template [#addw-1090](https://addworking.atlassian.net/browse/ADDW-1090) (#2299)

#### Removed
* Enlever le mode de suivi du formulaire de modification de la mission [#addw-1102](https://addworking.atlassian.net/browse/ADDW-1102) (#2298)
* Cacher l'entrée de menu **Mes attestations** lorsque l'utilisateur n'est pas à l'étape de l'upload des documents [#addw-1048](https://addworking.atlassian.net/browse/ADDW-1048) (#2245)

### [0.42.7] - 2019-11-13
#### Fixed
* (tech) Correction de certaines commands artisan

### [0.42.6] - 2019-11-13
#### Changed
* (tech) Refactoring des commandes artisan
* Mode de suivi de mission déterminé par défaut sur **fin de mission**, dans la vue de création du suivi de mission [#addw-1080](https://addworking.atlassian.net/browse/ADDW-1080) (#2294)

### [0.42.5] - 2019-11-12
#### Fixed
* (tech) La commande artisan `document:send-to-storage command` sauvegarde les documents supprimés aussi
* (tech) Correction de l'affichage de console lors du process CI

#### Added
* (tech) Ajout de la commande artisan `document:send-to-storage`
* (tech) Ajout de la methode descendents() pour le modèle Enterpriseadding

### [0.42.4] - 2019-11-12
#### Fixed
* Regression : Changement automatique du statut de la réponse à une proposition de mission dans le cas **Edenred** [#addw-1052](https://addworking.atlassian.net/browse/ADDW-1052) (#2290)
* (support) Pouvoir modifier le fichier associé à un contrat [#addw-988](https://addworking.atlassian.net/browse/ADDW-988) (#2279)

#### Added
* Ajouter le tag **soconnext** dans la vue show des entreprises si un de ses membres l'a [#addw-1089](https://addworking.atlassian.net/browse/ADDW-1089) (#2268) 
* Ajout de l'espace de stockage **Amazon S3** pour le backup des documents
* Ajout de la colonne **Date de début souhaitée** dans la vue index des propositions de missions [#addw-1083](https://addworking.atlassian.net/browse/ADDW-1083) (#2275)
* Ajout du système de commentaire pour le changement de statut d'une facture sortante [#addw-1100](https://addworking.atlassian.net/browse/ADDW-1100) (#2286)
* (tech) Migration des commentaires des factures sortantes de n'ancien système de commentaires au nouveau [#addw-1117](https://addworking.atlassian.net/browse/ADDW-1117) (#2291)

#### Changed
* Cacher les entrées **Ma convention** & **Mes attestations** dans le menu customer [#addw-1085](https://addworking.atlassian.net/browse/ADDW-1085) (#2269)

### [0.42.3] - 2019-11-07
#### Fixed
* Migration des commentaires sans auteurs dans les passworks (sogetrel) (#2288)

### [0.42.2] - 2019-11-07
#### Fixed
* Création des ordres de paiements [#addw-1116](https://addworking.atlassian.net/browse/ADDW-1116) (#2285)
* (tech) Ignorer les tests dans la vérification faite parle pre-commit de git.
* Mise à jour de la facture entrante [#addw-1062](https://addworking.atlassian.net/browse/ADDW-1062) (#2282)
* (tech) Ignorer les classes qui n'ont pas besoin d'être testé lors de la vérification faite par le pre-commit de git (#2284)

#### Added
* Accès à l'onglet data pour les membres de **Sogetrel** [#addw-1099](https://addworking.atlassian.net/browse/ADDW-1099)
* Migration des commentaires sans auteurs dans les passworks [#addw-1087](https://addworking.atlassian.net/browse/ADDW-1087) (#2266)
* (tech) Domaine **Support** pour faciliter le support [#addw-1091](https://addworking.atlassian.net/browse/ADDW-1091) (#2254)

#### Changed
* feature: Amélioration de la vue index des documents [#addw-1076](https://addworking.atlassian.net/browse/ADDW-1076) (#2259)

#### Removed
* Suppression de la redirection à la vue create de ligne de suivi de mission quand une ligne de suivi est refusée [#addw-1079](https://addworking.atlassian.net/browse/ADDW-1079) (#2277)

### [0.42.1] - 2019-11-05
#### Fixed
* Surcharger la methode getKeyType() dans le package [laravel-has-uuid](https://github.com/addworking/laravel-has-uuid) pour éviter de définir la propriété $keyType dans chaque modèle eloquent.

### [0.42.0] - 2019-11-05
#### Fixed
* Le statut de la visibilité dans le formulaire d'ajout de commentaire est réglé par défaut à **public** [#addw-1112](https://addworking.atlassian.net/browse/ADDW-1112) (#2278)
* (tech) Ajout du fichier de referentiel **everial** (#2264)

#### Added
* Statut **interessé** pour demande d'information par le vendor au référent de PM [#addw-1086](https://addworking.atlassian.net/browse/ADDW-1086) (#2256)
* Possibilité de rediffuser une proposition de mission aux vendors qui l'ont déjà reçu  [#addw-1074](https://addworking.atlassian.net/browse/ADDW-1074) (#2252)

#### Changed
* (tech) Mise à jour du framework laravel à la version 6.4.1 [#addw-1067](https://addworking.atlassian.net/browse/ADDW-1067) (#2276)
* (tech) Mise à jour composants
* (tech) Changements dans le CPS2
* (tech) Mise à jour de la procédure **pre-commit** de git

#### Removed
* Suppression de l'attribut **objectives** du modèle Offer (offre de mission) [#addw-1084](https://addworking.atlassian.net/browse/ADDW-1084) (#2272)

### [0.41.3] - 2019-10-31
#### Fixed
* Correction des bugs liés a l’accès au passwork et a la selection des prestataires pour une offre de mission sogetrel (#2274)

### [0.41.2] - 2019-10-30
#### Fixed
* Correction de la suppression du statut Vendor lors de la modification d'une entreprise #boyscout [#addw-1105](https://addworking.atlassian.net/browse/ADDW-1105) (#2271)

#### Added
* (tech) Ajout d'un nouveau script d'integration continue (#2265)

#### Changed
* Ameliorations dans la vue Mes prestataires [#addw-1057](https://addworking.atlassian.net/browse/ADDW-1057) (#2250)
* (tech) Deplacement de quelques helpers dans les controllers

### [0.41.1] - 2019-10-25
#### Fixed
* Correction de l'affichage de la vue Index des offres de missions #boyscout [#addw-1059](https://addworking.atlassian.net/browse/ADDW-1059) (#2224)
* Correction de l'export csv des factures sortantes TSE [#addw-1041](https://addworking.atlassian.net/browse/ADDW-1041) (#2244)

#### Added
* Ajout de l'import automatique des donneés dans le referentiel de mission everial [#addw-1023](https://addworking.atlassian.net/browse/ADDW-1023) (#2228)
* Ajout de la creation d'une premiere ligne de suivi de mission dans la vue de creation 'Suivi de mission' [#addw-1081](https://addworking.atlassian.net/browse/ADDW-1081) (#2258)
* Ajout de l'entrée de menu 'mission' pour everial [#addw-1078](https://addworking.atlassian.net/browse/ADDW-1078) (#2260)
* Ajout de l'option 'recherche' sur les select dans la vue de creation offre de mission [#addw-1050](https://addworking.atlassian.net/browse/ADDW-1050) (#2232)

#### Changed
* (tech) Mise a jour des données (seeders) [#addw-1092](https://addworking.atlassian.net/browse/ADDW-1092) (#2257)
* (tech) Normalisation des URLs des documents #boyscout [#addw-1063](https://addworking.atlassian.net/browse/ADDW-1063) (#2237)
* Changement des régles d'acces (policies) aux passworks [#addw-1043](https://addworking.atlassian.net/browse/ADDW-1043) (#2220)

#### Removed
* Suppression de la configuration liée au package Passport [#addw-1093](https://addworking.atlassian.net/browse/ADDW-1093) (#2263)

### [0.41.0] - 2019-10-22
#### Fixed
* Correction de l'erreur 404 au clic dans les emails de confirmation
* (tech) Ameliorations sur le test inscription utilisateur

#### Added
* (tech) Ajout du test de confirmation de l'email
* (tech) Ajout du test inscription utilisateur
* Refactoring de la vue index mes prestataires [#addw-1053](https://addworking.atlassian.net/browse/ADDW-1053) (#2235)

### [0.40.4] - 2019-10-17
#### Fixed
* Correction du nom de fichier HasStatus

#### Added
* Conception du test qui verifie que l'utilisateur peut se connecter avec un reset manuel de son mot de passe

### [0.40.3] - 2019-10-16
#### Fixed
* Correction permettant aux utilisateurs de voir leurs attestations (#2242)

#### Added
* (tech) Envoi des notifications lors de la création des utilisateurs pendant l'import des vendors
* Fonctionnalité permettant de relancer une offre de mission auprès d'un vendor [#addw-1058](https://addworking.atlassian.net/browse/ADDW-1058) (#2233)

### [0.40.2] - 2019-10-15
#### Fixed
* Réparation de la vue mes clients [#addw-1061](https://addworking.atlassian.net/browse/ADDW-1061) (#2236)
* (tech) Validation de l'adresse et du pays dans le système d'import des vendors

#### Added
* Ajout de la description d'aide du document dans la vue index des documents [#addw-1044](https://addworking.atlassian.net/browse/ADDW-1044) (#2234)
* Masquer l'entrée de menu "Mes attestations" tant que l'utilisateur n'est pas à l'étape d'upload des documents dans le processus d'onboarding [#addw-1048](https://addworking.atlassian.net/browse/ADDW-1048) (#2230)
* Affichage de la date de dépôt d'un document sur la vue index des documents [#addw-1046](https://addworking.atlassian.net/browse/ADDW-1046) (#2225)
* Avoir le lien qui pointe sur le passwork correspondant au subdomain dans la vue "Mes prestataires" [#addw-1055](https://addworking.atlassian.net/browse/ADDW-1055) (#2229)

### [0.40.1] - 2019-10-14
#### Fixed
* Changement de wording
* (tech) Sérialisation des exceptions pour le csv loader
* (tech) Génération de contrôleur avec la commande make-model
* (tech) Création des migrations avec la commande make-model
* Pouvoir suivre l'état des propositions de mission envoyées [#addw-1051](https://addworking.atlassian.net/browse/ADDW-1051) (#2223)
* Désactivation des contrôles de cohérence des itinéraires

#### Added
* Lister les erreurs lors de l'import des vendors
* (tech) La commande make-model génère maintenant les vues show
* (tech) La commande make-model génère maintenant les actions
* (tech) La commande make-model génère maintenant les vues index
* (tech) Nouvelle commande make-model
* Ajout de commentaires pour les documents [#addw-1047](https://addworking.atlassian.net/browse/ADDW-1047) (#2221)
* Nettoyage des statuts inutiles des missions [#addw-1049](https://addworking.atlassian.net/browse/ADDW-1049) (#2231)
* Ajout d'une condition pour que n'apparaisse "télécharger le modèle" que si le modèle du document type existe. #addw-1045 (#2219)[https://github.com//pull/2219]
* Cartographie des zones de couverture aux départements
* Sélection multiple sur les zones de couverture de spie

#### Changed
* Normalisation des routes #addw-1027 (#2212)[https://addworking.atlassian.net/browse/ADDW-1027]

### [0.40.0] - 2019-10-07
#### Fixed
* Attachement du prestataire au client et réorganisation du modèle Enterprise [#addw-1033](https://addworking.atlassian.net/browse/ADDW-1033)

#### Added
* Ajout de mails pour offre de mission fermé [#addw-998](https://addworking.atlassian.net/browse/ADDW-998)
* Créer une vue spécifique pour everial afin de sélectionner le destinataire de l'offre de mission [#addw-1024](https://addworking.atlassian.net/browse/ADDW-1024)
* Notification de partage du passwork sogetrel [#addw-984](https://addworking.atlassian.net/browse/ADDW-984)

#### Changed
* Ajout de règles de test dans le guide de processus
* Rétablir la base de données de test en sqlite_testing
* Changements mineurs dans process.md
* Processus de mise à jour

### [0.39.2] - 2019-10-02
#### Fixed
* (tech) Ajout du répertoire TEMP pour corriger le problème de consultation et téléchargement de fichiers
* (tech) Correction de la contrainte unique pour les noms d'entreprises [#addw-1016](https://addworking.atlassian.net/browse/ADDW-1016)

#### Added
* Ajout des accès et permissions pour le bon de commande [#addw-1026](https://addworking.atlassian.net/browse/ADDW-1026)
* Envoi de notification au propriétaire d'une offre de mission quand une nouvelle réponse est envoyée [#addw-996](https://addworking.atlassian.net/browse/ADDW-996)
* (tech) Création du guide de process

#### Changed
* (tech) Nettoyage

### [0.39.1] - 2019-10-01
#### Fixed
* Le premier utilisateur d'une entreprise rattaché est désormais admin par défaut [#addw-1020](https://addworking.atlassian.net/browse/ADDW-1020)
* Correction lorsqu'un customer ajoute lui même un nouveau prestataire [#addw-1012](https://addworking.atlassian.net/browse/ADDW-1012)
* (tech) Ajout de tests unitaires quand on utilise postgres
* (tech) Correctionsur le référencement d'un utilisateur à une entreprise [#addw-1031](https://addworking.atlassian.net/browse/ADDW-1031)

#### Added
* Ajout d'un nouveau bouton dans les offres de mission pour les opérateurs edenred pour demander la validation et la diffusion de celle-ci [#addw-1022](https://addworking.atlassian.net/browse/ADDW-1022)
* Envoi d'un email à julie@addworking.com quand un passwork est accepté pour contractualisation [#addw-999](https://addworking.atlassian.net/browse/ADDW-999)
* Envoi d'un email au référent de l'offre de mission quand le statut change à "bon pour échange" [#addw-997](https://addworking.atlassian.net/browse/ADDW-997)
* Envoi d'un email à conformite@addworking.com quand un document est uploadé [#addw-993](https://addworking.atlassian.net/browse/ADDW-993)
* Création d'une commande pour les documents bientôt expirés [#addw-994](https://addworking.atlassian.net/browse/ADDW-994) [#addw-995](https://addworking.atlassian.net/browse/ADDW-995)
* Création d'entreprises à partir des info des passworks existants [#addw-867](https://addworking.atlassian.net/browse/ADDW-867)
* Création de l'import générique csv de vendors [#addw-739](https://addworking.atlassian.net/browse/ADDW-739)
* Création de l'import spie et du moteur de recherche

#### Changed
* (tech) Mise à jour des seeders [#addw-1029](https://addworking.atlassian.net/browse/ADDW-1029)
* (tech) Mise à jour des règles de code owners

### [0.39.0] - 2019-09-24
#### Fixed
* (tech) Erreur fatale sentry sur l'onboarding process #sentry-addworking-e6
* Retrait temporaire du passwork dans l'onboarding edenred #2200

#### Added
* Création des vues spécifiques d'offre de mission pour everial [#addw-1007](https://addworking.atlassian.net/browse/ADDW-1007)
* Création de la vue index de la liste des prix pour la grille tarifaire [#addw-1009](https://addworking.atlassian.net/browse/ADDW-1009)
* Ajout du tag so connext sur les prestataires [#addw-970](https://addworking.atlassian.net/browse/ADDW-970)

#### Changed
* Désactiver un utilisateur au lieu de le supprimer [#addw-983](https://addworking.atlassian.net/browse/ADDW-983)

### [0.38.5] - 2019-09-19
#### Fixed
* Supprimer la liste des propositions de la vue show des offres de mission [#addw-1019](https://addworking.atlassian.net/browse/ADDW-1019)
* La vue index des vendors **Sogetrel** [#addw-1018](https://addworking.atlassian.net/browse/ADDW-1018)
* Attacher Un vendor à **Sogetrel** [#stack-overflow-60](https://stackoverflow.com/c/addworking/questions/60)

#### Added
* Filtre sur le code postal des passworks **Sogetrel** [#addw-982](https://addworking.atlassian.net/browse/ADDW-982) (#2189)
* (tech) Migration pour la liste des prix pour **Everial** [#addw-1006](https://addworking.atlassian.net/browse/ADDW-1006) (#2186)
* Pouvoir supprimer un Référenciel mission pour **Everial** [#addw-1004]((https://addworking.atlassian.net/browse/ADDW-1004)) (#2180)

### [0.38.4] - 2019-09-16
#### Fixed
* (tech) Correctif pour la migration des suivis d'action de changement des (anciens) commentaires vers le nouveau système [#addw-1013](https://addworking.atlassian.net/browse/ADDW-1013) (#2185)

### [0.38.3] - 2019-09-13
#### Fixed
* Synchronier le statut du contrat CPS2 entre Addworking & SigningHub [#rd-12](https://addworking.atlassian.net/browse/RD-12)
* Supprimer le menu déroulant sur la barre de navigation pour l"oprion **se connecter en tant que client** #2175

#### Added
* Référenciel mission **Everial** : vue edit [#addw-1005](https://addworking.atlassian.net/browse/ADDW-1005) (#2179)
* Boutton de synchronisation avec navibat [#addw-794](https://addworking.atlassian.net/browse/ADDW-794) (#2178)
* Vue index des bons de commandes par entreprise [#addw-883](https://addworking.atlassian.net/browse/ADDW-883) (#2156)
* Référenciel mission **Everial** : Vue index [#addw-1001](https://addworking.atlassian.net/browse/ADDW-1001) (#2176)
* Widget pour les nouvelles réponses de propositions sur le dashboard client [#addw-991](https://addworking.atlassian.net/browse/ADDW-991) (#2172)
* Possibilité de changer l'entreprise courante
* Référenciel mission **Everial** : vue show [addw-1003](https://addworking.atlassian.net/browse/ADDW-1003) (#2169)
* Widget pour les propositions de mission dans sur le dashboard prestataire [#addw-992](https://addworking.atlassian.net/browse/ADDW-992) (#2171)
* (tech) codeowners (github)
* Référenciel mission **Everial** : Migration & modele & vue create [#addw-1000](https://addworking.atlassian.net/browse/ADDW-1000) (#2162)

#### Changed
* L'unité par défaut sur le formulaire de réponse de proposition est fixée à **jour** [#addw-987](https://addworking.atlassian.net/browse/ADDW-987) (#2174)
* Migration des suivis d'action de changement des (anciens) commentaires vers le nouveau système [#addw-981](https://addworking.atlassian.net/browse/ADDW-981) (#2167)
* (tech) mise à jour des seeders [#addw-1011](https://addworking.atlassian.net/browse/ADDW-1011) (#2170)
* Les messages d'erreur de l'app ne sont plus crypté pour le support

### [0.38.2] - 2019-09-10
#### Fixed
* (tech) Route pour la vue store du suivi de mission[#addw-973](https://addworking.atlassian.net/browse/ADDW-973) (#2164)
* (tech) Helpers & FormRequest des factures entrantes [#rd-10](https://addworking.atlassian.net/browse/RD-10) [#rd-11](https://addworking.atlassian.net/browse/RD-11)
* (tech) Helper pour le log des contrats [#addw-986](https://addworking.atlassian.net/browse/ADDW-986) (#2158)

### [0.38.1] - 2019-09-10
#### Fixed
* Meilleure isolation pour la relation de Edenred avec les propositions de mission [#addw-985](https://addworking.atlassian.net/browse/ADDW-985) (#2161)
* (tech) Utilisation de l'alias mission_offer() à la place de offer()
* (tech) Différents correctifs et nettoyage de code

#### Added
* Pouvoir se connecter en tant que client (menu déroulant sur la barre de navigation) [#addw-944](https://addworking.atlassian.net/browse/ADDW-944) (#2150)

#### Removed
* (tech) forges

### [0.38.0] - 2019-09-09
#### Fixed
* Export CSV d'une facture de sortie pour TSE Express Medical
* Label de mission cassé sur le fil d'ariane de la vue create du suivi de mission [#addw-972](https://addworking.atlassian.net/browse/ADDW-972) (#2159)
* Couleur d'arrière plan sur la page de connexion pour Microsoft Edge (pour les utilisateurs de Sogetrel entre autre)
* Message d'accueil pour Sogetrel So'Connext
* (tech) Mise en place de correctifs suggérés par l'outil de vérification de code PHPStan
* (tech) Correctifs sur le package laravel-models
* (tech) Ajout d'alias mission_offer() pour le  model Offer

#### Added
* Pouvoir supprimer un bon de commande [#addw-887](https://addworking.atlassian.net/browse/ADDW-887) (#2154)
* Pouvoir générer un bon de commande pour une mission [#addw-810](https://addworking.atlassian.net/browse/ADDW-810) #boyscout (#2139)
* Affichage du montant dans la vue show d'une mission[#addw-957](https://addworking.atlassian.net/browse/ADDW-957) (#2149)
* (tech) Vérification de code (PHPStan) par défaut à chaque nouveau développement
* (tech) Création de test pour la duplication de nom de classe
* (tech) Création de test pour les repositories des models
* (tech) Création de test pour les politiques d'autorisations/permissions (policies)
* (tech) Création de test pour les noms de tables
* (tech) Nouveau package Addworking **OpenSource** : [laravel-class-finder](https://github.com/addworking/laravel-class-finder)
* (tech) Ajout du model et repository Offer pour Everial [#addw-906](https://addworking.atlassian.net/browse/ADDW-906) (#2151)

#### Changed
* (tech) Déplacement du test d'unicité des noms de classe dans son scénario
* (tech) Extraction des helpers de models dans un [package](https://github.com/addworking/laravel-models) **OpenSource** à part

#### Removed
* Message concernant la mise en place du nouveau template [#addw-990](https://addworking.atlassian.net/browse/ADDW-990) (#2160)
* (tech) Migration et model pour Everial (#2157)

### [0.37.3] - 2019-08-30
#### Fixed
* Le client peut maintenant changer le statut de la facture entrante #rd-9
* Rendre le type de milestone nul par défaut dans la mission [#addw-947](https://addworking.atlassian.net/browse/ADDW-947) (#2145)

#### Added
* Faire télécharger les documents juridiques au moment de l'onboarding [#addw-200](https://addworking.atlassian.net/browse/ADDW-200) (#2143)

### [0.37.2] - 2019-08-29
#### Fixed
* Téléchargement dans l'ordre de paiement #rd-8
* Configuration du test pour une exécution sur une base de données différente [#addw-976](https://addworking.atlassian.net/browse/ADDW-976) (#2144)
* Tache tech: pre-commit hook

#### Added
* Permettre l'ajout d'un référent dans l'offre de mission [#addw-938](https://addworking.atlassian.net/browse/ADDW-938) [#addw-939](https://addworking.atlassian.net/browse/ADDW-939) (#2142)
* Définir le statut après avoir comparé le tarif quotidien moyen au prix unitaire [#addw-940](https://addworking.atlassian.net/browse/ADDW-940) (#2138)
* Ajout de commentaires pour les statuts de réponses [#addw-470](https://addworking.atlassian.net/browse/ADDW-470) (#2136)
* Ajout d'un lien pour déterminer la milestone [#addw-956](https://addworking.atlassian.net/browse/ADDW-956) (#2141)

#### Changed
* tache tech : renomage des tests

### [0.37.1] - 2019-08-27
#### Fixed
* Correction du changement de statut de facture entrante #rd-6
* Désactivation du script de post-installation dans heroku #addw-971 (#2137)

#### Added
* Création de la vue show des bons de commande [#addw-886](https://addworking.atlassian.net/browse/ADDW-886) (#2124)
* Nouveau git hooks!

#### Changed
* Modification de la redirection vers l'index utilisateur lors de la connexion en tant que support [#addw-943](https://addworking.atlassian.net/browse/ADDW-943) (#2134)
* Modification de wording dans le statut de l'offre de mission [#addw-941](https://addworking.atlassian.net/browse/ADDW-941) (#2129)
* Afficher les filtres sur les index [#addw-946](https://addworking.atlassian.net/browse/ADDW-946) (#2133)
* Modification de wording dans la vue création de profil de mission [#addw-953](https://addworking.atlassian.net/browse/ADDW-953) (#2128)
* Modification de wording dans proposition de réponse à une mission [#addw-959](https://addworking.atlassian.net/browse/ADDW-959) (#2130)
* Afficher l'URL des propositions de mission sans le "s" à la fin [#addw-954](https://addworking.atlassian.net/browse/ADDW-954) (#2131)
* Amélioration des migrations
* Suite du refactoring des tests de cohérence

#### Removed
* Enlevement des vieux hooks de commit

### [0.37.0] - 2019-08-26
#### Fixed
* Correction de la traduction du tarif journalier moyen [#addw-875](https://addworking.atlassian.net/browse/ADDW-875) (#2132)
* suppression d'un use inutil dans la classe des notifications [#addw-966](https://addworking.atlassian.net/browse/ADDW-966)(#2127)
* correction sur l'edition d'une facture entrante #rd-1

#### Changed
* mise à jour des packages de l'application

### [v0.36.9] - 2019-08-23
#### Fixed
* Correction des noms des CPS3 dans les factures outbound #rd-3
* Suppression de l'ancien système d'address dans user #addw-950 (#2126)

### [v0.36.8] - 2019-08-23
* Mise à jour de sécurité

### [v0.36.7] - 2019-08-21
#### Fixed
* Correction de l'usage des classes de modèles dans les migrations
* Correction des problèmes de namespace
* Patchs mineurs concernant les vuees
* Suppression des appels 'action(...)' dans les vues responsables des plantages
* Correction des vues des contrats
* Amélioration mineure du test des vues
* Mise à jour des fixtures
* Correction du dashboard prestataire
* Refactoring d'une partie du système de contrats
* Refactoring d'une partie du système de gestion electronique de documents
* Correction des routes de la facturation
* Suppression du système d'export de factures inbound
* Suppression des anciennes routes des factures inbound

#### Added
* Ajout d'un test pour contrôler l'usage des modèles dans les migrations
* Ajout d'un test pour valider les espaces de noms du projet
* Ajout d'un test pour contrôler les liens dans les vues
* Nouveau design pour les pages d'erreur
* Changement du montant total en quantité dans les responses aux offres de mission

### [v0.36.6] - 2019-08-21
#### Fixed
* Correctifs concernant les vues non connectées

### [v0.36.5] - 2019-08-21
#### Fixed
* Mise à jour des packages

### [0.36.4] - 2019-08-20
### Fixed
* Correction de l'envoi des factures par un vendor

### Added
* Il est désormais possible de créer un site (géographique) pour une entreprise #addw-889 (#2108)

### [0.36.3] - 2019-08-19
### Fixed
* Ajout d'une condition de non-duplicata pour attacher un prestataire à une entreprise #addw-881 (#2119)
* Certaines vues ne se chargeait pas sans utilisateur connecté
* Mauvaise URL dans la vue de création de factures

### Added
* Ajout des codes analytiques aux offres de mission #addw-896 (#2116)
* Ajout des départements à l'export CSV des passworks #addw-929 (#2117)
* Amélioration du mail de réinitialisation de mot de passe #addw-350 (#2110)
* On peut désormais transfomer une réponse à une offre de mission en mission #addw-811 (#2095)
* Réparation du système de fichiers de factures d'entrée et de sortie

### [0.36.2] - 2019-08-13
#### Fixed
* Correction de l'affichage du status des factures #addw-933 (#2111)

### [0.36.1] - 2019-08-13
#### Fixed
* Correction de l'affichage du status des factures #addw-933 (#2111)

### [0.36.0] - 2019-08-12
#### Fixed
* Correction de nombreuses classes du système concernant le système des viewables (#2107)
* Suppression de vues inutilisées

#### Added
* Ajout de la colone 'créé le' sur l'index des offres de mission (#2105)
* Ajout du nouveau système de visualisation des objets

### [0.35.4] - 2019-08-07
#### Fixed
* Correction de la generation du pdf des factures emises [#addw-879](https://addworking.atlassian.net/browse/ADDW-879) (#2096)

#### Added
* Creation des factories er routes pour les models (#2055)

### [0.35.3] - 2019-08-05
#### Fixed
* Refonte des Url (routes) specifique à la brique mission edenred (#2081)
* Correction des bugs dans la brique Mission [addw-878](https://addworking.atlassian.net/browse/ADDW-878) (#2097)

#### Changed
* Désactivation les boutons d'acceptation/refus de ligne de suivi de mission en fonction du contexte [#addw-856](https://addworking.atlassian.net/browse/ADDW-856) (#2092)
* Refonte de la gestion des numéros de telephones [#addw-788](https://addworking.atlassian.net/browse/ADDW-788) (#2056)
  * Mise a jour des données des seeders
* Modification du processus d'onboarding [#addw-752](https://addworking.atlassian.net/browse/ADDW-752) (#2058)
* Changement automatique du statut du suivi de mission lors de l'ajout d'une ligne a ce dernier [#addw-814](https://addworking.atlassian.net/browse/ADDW-814) (#2088)
* Changement du statut d'une ligne de suivi de mission a 'Validée' aprés création directement [#addw-852](https://addworking.atlassian.net/browse/ADDW-852) (#2086)
* Refonte de la vue index des reponses au propositions de mission [addw-837](https://addworking.atlassian.net/browse/ADDW-837) (#2084)

#### Added
* Création d'une vue qui permet de definir le mode de suivi d'une mission [#addw-865](https://addworking.atlassian.net/browse/ADDW-865) (#2098)
* Ajout de la redirection automatique vers la creation d'une nouvelle ligne de suivi de mission si cette derniere a été refusé [#addw-858](https://addworking.atlassian.net/browse/ADDW-858) (#2094)
* Ajout du motif de refus a la reponse d'une proposition de mission [#addw-850](https://addworking.atlassian.net/browse/ADDW-850) (#2093)
* Ajout l'entrée "Récapitulatif" dans le menu actions de l'offre de mission [#addw-864](https://addworking.atlassian.net/browse/ADDW-864) (#2091)
* Ajout du bouton 'Ajouter' a la vue index de mission [#addw-851](https://addworking.atlassian.net/browse/ADDW-851) (#2083)
* Ajout du badge 'Nouveau' dans la vue index de mission [#addw-866](https://addworking.atlassian.net/browse/ADDW-866) (#2070)
* Ajout du motif de refus à la ligne de suivi de mission [#addw-813](https://addworking.atlassian.net/browse/ADDW-813) (#2082)
* Création de la vue recapitulatif des reponses aux propositions de mission quand l'offre de mission l'utilisateur 'ferme' cette derniere [#addw-809](https://addworking.atlassian.net/browse/ADDW-809) (#2080)

### [0.35.2] - 2019-08-01
#### Fixed
* Remplacer les 3 petits points 'Actions' par un bouton cliquable [#addw-876](https://addworking.atlassian.net/browse/ADDW-876) (#2078)
* Autoriser l'accès aux clients a l'index des suivis de mission [#addw-857](https://addworking.atlassian.net/browse/ADDW-857) (#2072)

#### Changed
* Modification dans la page de details de la proposition de mission [#addw-804](https://addworking.atlassian.net/browse/ADDW-804) (#2067)
  * Remplacement du label 'Début de mission' par 'Date de début souhaité'
  * Suppression du bouton 'Voir réponses'
  * Ajout d'un onglet 'Réponses' a la page avec le liste des réponses de la proposition de mission
  * Restructuration de la page
* Modification de la colonne starts_at dans la table des offres de mission dans la base de données [#addw-805](https://addworking.atlassian.net/browse/ADDW-805) (#2077)
  * Mise a jour des seeders
* Modification de l'onglet proposition de mission dans la page details d'offre de mission [#addw-803](https://addworking.atlassian.net/browse/ADDW-803) (#2075)
  * Ajouter dans le menu action un lien vers les reponses filtré sur la proposition en question
  * Mettre le tableau dans un conteneur pour respecter les gouttières
  * Ajout des liens sur les noms des entreprises
  * Suppression de la colonne "Offre de mission" et UUID
* Normalisation de l'Url (route) de la brique Selection des prestataires [#addw-820](https://addworking.atlassian.net/browse/ADDW-820) (#2073)
* Normalisation de l'Url (route) de la brique Reponse aux propositions de mission [#addw-835](https://addworking.atlassian.net/browse/ADDW-835) (#2071)
* Modification de l'ordre des etapes dans le processus d'onboarding 'sogetrel' [#addw-571](https://addworking.atlassian.net/browse/ADDW-571) (#2062)
* Mise a jour des seeders [#addw-875](https://addworking.atlassian.net/browse/ADDW-875) (#2069)

#### Added
* Ajout de la fonction d'export des logs utilisateur dans un fichier .csv [#addw-728](https://addworking.atlassian.net/browse/ADDW-728) (#2074)
* Initialisation du fichier changelog de la plateforme (#2068)
* Ajout de la fonction 'commentaires' dans la vue details des suivis de mission [#addw-815](https://addworking.atlassian.net/browse/ADDW-815) (#2076)

### [0.35.1] - 2019-07-30
#### Fixed
* Problème du téléchargement des factures reçues depuis la page de validation de la facture emise [#addw-874](https://addworking.atlassian.net/browse/ADDW-874)

#### Changed
* Modification du texte dans la section informations dans la page des details du suivi de mission [#addw-812](https://addworking.atlassian.net/browse/ADDW-812) (#2066)
* Stabilisation du la brique reponses a l'offre de mission [#addw-844](https://addworking.atlassian.net/browse/ADDW-844) (#2060)
  * Suppression du dropdown menu 'actions' dans la page de details des reponses a l'offre de mission
  * Modification du breadcrumb dans la page index des offres de mission quand l'utilisateur est connecté en tant que prestataire
  * Changement du comportment du bouton 'Nouvelle réponse' suivant les droits d'acces de l'utilisateur
* Modification de la visibilité des commentaires sur les passworks de 'protegé a public' [#addw-871](https://addworking.atlassian.net/browse/ADDW-871) (#2065)
* Stabilisation de la brique selection des prestataires de l'offre de mission [#addw-802](https://addworking.atlassian.net/browse/ADDW-802) (#2063)
  * Ajout des liens sur les noms des entreprises dans la page index
  * Ajout de la classe "table-striped" sur le tableau de l'index
  * Suppression de la colonne 'UUID'
* Ajout de nouvelles données a l'export CSV des passworks [#addw-873](https://addworking.atlassian.net/browse/ADDW-873) (#2061)
