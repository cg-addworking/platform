@extends('layouts.contract')

@section('content')

<center>

@unless (config('app.env') == 'local')
    <img src="{{ asset('img/logo_addworking_vertical.png') }}" alt="Addworking Logo" width="15%">
@endunless

# CONTRAT DE PRESTATIONS DE SERVICE
# CLIENT / PRESTATAIRE

# _Intitulé « CPS3 »_

### _Numéro {{ $contract->name }}_

</center>

---

<h2 style="text-align: center">CONDITIONS PARTICULIERES</h2>

---


## Entre les soussignés :

<table width="100%" cellspacing="15">
    <tr>
        <td width="45%" height="250px" valign="top">
            <p>
                <b>{{ $contract->customer->name }}</b>,
                @lang("enterprise.enterprise.{$contract->customer->legalForm->name}"),
                dont le siège social est situé {{ $contract->customer->first_address }},
                @if($contract->customer->identification_number == null)
                    en cours de création,
                @else
                    immatriculée au Registre du Commerce et des Sociétés
                    @if ($contract->customer->registration_town)
                        de {{ $contract->customer->registration_town }}
                    @endif
                    sous le numéro {{ $contract->customer->identification_number }},
                @endif
                représentée par {{ $contract->customer->legalRepresentatives->first()->firstname }} {{ $contract->customer->legalRepresentatives->first()->lastname }}
                @if ($contract->customer->legalRepresentatives->first()->pivot->job_title)
                    agissant en sa qualité de {{ $contract->customer->legalRepresentatives->first()->pivot->job_title }}
                @endif
                .
                E-mail {{ $contract->customer->legalRepresentatives->first()->email }}.
            </p>
            <p>Activité du Client : {{ $contract->customer->activity }}</p>
            <p>Ci-après dénommé le "<b>Client</b>".</p>
            <p>D'une part,</p>
        </td>
        <td width="10%" style="text-align: center">Et</td>
        <td width="45%" height="250px" valign="top">
            <p>
                <b>{{ $contract->vendor->name }}</b>,
                @lang("enterprise.enterprise.{$contract->vendor->legalForm->name}"),
                dont le siège social est situé {{ $contract->vendor->first_address }},
                @if($contract->vendor->identification_number == null)
                    en cours de création,
                @else
                    immatriculée au Registre du Commerce et des Sociétés
                    @if ($contract->vendor->registration_town)
                        de {{ $contract->vendor->registration_town }}
                    @endif
                    sous le numéro {{ $contract->vendor->identification_number }},
                @endif
                représentée par {{ $contract->vendor->legalRepresentatives->first()->firstname }} {{ $contract->vendor->legalRepresentatives->first()->lastname }}
                @if ($contract->vendor->legalRepresentatives->first()->pivot->job_title)
                    agissant en sa qualité de {{ $contract->vendor->legalRepresentatives->first()->pivot->job_title }}
                @endif
                .
                E-mail {{ $contract->vendor->legalRepresentatives->first()->email }}.
            </p>
            <p>Activité du Prestataire : {{ $contract->vendor->activity }}</p>
            <p>Le Prestataire dispose, à ce titre, des moyens et installations techniques, des compétences, de la logistique, et de l'expérience requises par le Client pour répondre aux services contractuels qu'il a accepté de mettre à la disposition de du Client, selon les termes et conditions définis au présent contrat.
            </p>
            <p>Ci-après dénommée "<b>Prestataire</b>".</p>
            <p>D'autre part,</p>
        </td>
    </tr>
</table>

En présence d'**ADDWORKING**,

**ADDWORKING**, Société par Actions Simplifiée, dont le siège social est situé 17 rue du lac Saint André – Savoie Technolac – BP 350 – 73370 Le Bourget du Lac, immatriculée au Registre du Commerce et des Sociétés de Chambéry sous le numéro 810 840 900, représentée par Julien PERONA agissant en sa qualité de Président.

E-mail: contact@addworking.com.

Société de services sécurisant la gestion de la relation contractuelle entre les entreprises (ci-après « le Client ») et les prestataires (ci-après « le Prestataire ») via sa plateforme web originale (www.addworking.com). Elle propose à chacun d’entre eux une série de prestations de service notamment pour faciliter leur gestion financière, alléger leur charge administrative et réduire leurs risques juridiques.

---


**Identification des prestations fournies par le Prestataire au Client** : {{ $contract->vendor->legalRepresentatives->first()->gender == 'male' ? "CHARGÉ DE RECRUTEMENT" : "CONSULTANTE EN RECRUTEMENT" }} ci-après le « Prestataire ».
Le Prestataire réalisera des missions de recrutement et il participera au développement de la marque EOTIM propriété de {{ $contract->customer->name }}.

**Nature du Contrat** :

*Le présent contrat, qui prend effet à compter du {{ $contract->valid_from->format('d/m/Y') }} est conclu pour une durée indéterminée.*

**Prix** :

*En cas de succès, cette mission sera rémunérée sur la base du montant facturé par {{ $contract->customer->name }} à ses clients.
La rémunération du Prestataire pourra être égale à 30% ou 50% ou 70% du montant facturé par {{ $contract->customer->name }} à son client. Il appartiendra à {{ $contract->customer->name }} de communiquer à ADDWORKING les primes variables dûent au Prestataire en fonction des conditions  de rémunération fixées préalablement et connues par le Prestataire pour chaque nouveau succès.*

**Assurances** :

*Pour cette mission, le Prestataire bénéficie de l’Assurance RC Pro de ADDWORKING.*


**Conditions de paiement** :

*Délais de paiement du Client à ADDWORKING : 30 jours à réception de facture*

*Délais de paiement de ADDWORKING au Prestataire : Délai selon art. 4.1 conditions générales CPS2*


**Conditions de réalisation des prestations :**

*Obligations particulières relatives à la mission :*

{{ $contract->customer->name }} a fixé la règle de commissionnement suivante : Rémunération dite «au succès».

Le Prestataire ne pourra prétendre à aucune rémunération fixe et non indexée au succès commercial de {{ $contract->customer->name }}, sauf cas exceptionnel fixé dans le cadre de la mission par {{ $contract->customer->name }}.

*Définition du succès :*

Dans le cadre de la réalisation des missions de recrutement en partenariat avec {{ $contract->customer->name }}, le Prestataire devra sélectionner les bons candidats, les présenter au client et obtenir l’accord du client pour un recrutement. Le Prestataire fera ses meilleurs efforts et prendra toutes les précautions d’usage afin d'assurer que les candidats présentés au client conviennent pour l'emploi. Le candidat devra débuter sa prise de poste au sein du client.

Dans ce cas, le Prestataire percevra une commission représentant 30% ou 50% ou 70% du volume d’affaire facturé par {{ $contract->customer->name }} à ses nouveaux clients. {{ $contract->customer->name }} s’engage à transmettre ce montant à ADDWORKING et au Prestataire pour chaque nouvelle signature réalisée par le Prestataire.

*Cas particulier dans la définition du succès :*

Si l'emploi d'un candidat est résilié pendant sa période d’essai initiale d’un maximum de 4 mois, pour quelque raison légale que ce soit, le Prestataire devra fournir à {{ $contract->customer->name }} un nouveau candidat pour le même poste, sans frais supplémentaires.

*Autres précisions :*

Dans le cadre du partenariat avec {{ $contract->customer->name }}, le Prestataire pourra bénéficier de l’appui administratif, logistique, informatique et commercial de {{ $contract->customer->name }} sous le nom de sa marque commericale EOTIM.

Le Prestataire pourra bénéficier d’un service d’email de type « prenom.nom.ext@eotim.com » afin de l’aider dans sa démarche de communication pour les missions concernant son partenariat avec {{ $contract->customer->name }}/EOTIM.

Attention l’utilisation du nom {{ $contract->customer->name }} ou EOTIM par le Prestataire et de tous les outils mis à sa disposition par {{ $contract->customer->name }} / EOTIM est réservé à la réalisation des missions en partenariat avec la société {{ $contract->customer->name }} /EOTIM. Si le Prestataire veut utiliser les outils ou les noms ci-dessus cités il doit en obtenir l’autorisation écrite par le gérant de la société {{ $contract->customer->name }} / EOTIM.

*Délais de réalisation spécifiques / Urgences particulières :*  sans objet.

*Interlocuteur chez le Client pour 'le Prestataire' :* Monsieur Jérémie LEMAITRE, jemerie.lemaitre@eotim.com, 07 82 76 12 13

*Interlocuteur chargé de mission chez le Prestataire pour 'le Client' :* sans objet.

*Moyens matériels et logistiques spécifiques fournis par le Client :* aucun.



---



<table width="100%" cellspacing="15" margin-bottom="500px">
    <tr>
        <td width="50%" height="100px" valign="bottom">
            Pour le Client :
            <b>{{ $contract->customer->signatories->first()->name }}
                , {{ $contract->customer->signatories->first()->pivot->job_title }}
            </b>
        </td>
        <td width="50%" height="100px" valign="bottom">
            Pour le Prestataire :
            <b>{{ $contract->vendor->signatories->first()->name }}
                , {{ $contract->vendor->signatories->first()->pivot->job_title }}
            </b>
        </td>
    </tr>
</table>

<div style="height: 46px; page-break-before: always;"><center><img src="{{ asset('img/logo_addworking_vertical.png') }}" alt="Addworking Logo" width="15%"></center></div>


<h1 style="text-align: center">CONTRAT DE PRESTATIONS DE SERVICE - CPS3</h1>

<h2 style="text-align: center">CONDITIONS GENERALES</h2>

---

**ADDWORKING** est une société de services sécurisant la gestion de la relation contractuelle entre les entreprises (ci-après « le Client ») et les prestataires (ci-après « Le Prestataire ») via sa plateforme web originale (www.addworking.com). Elle propose à chacun d’entre eux une série de prestations de service notamment pour faciliter leur gestion financière, alléger leur charge administrative et réduire leurs risques juridiques.

**« Le Client »** : entreprise signataire du présent contrat et inscrite sur le site web www.addworking.com, en vue de conclure des Contrats de Prestations de Service avec le Prestataire, via la plateforme web d'ADDWORKING.

**« Le Prestataire »** : entreprise signataire du présent contrat et inscrite sur le site web www.addworking.com, qui propose ses services aux Clients via la plateforme web mise en œuvre par ADDWORKING

**« L’AddWorker »** : la ressource du Prestataire en charge de la réalisation de la prestation de service chez le Client.

**« Le Contrat de commissionnement et de Prestations de Service «CLIENT» ou CPS1 »** : contrat conclu en ligne entre le Client et ADDWORKING via la plateforme web d'ADDWORKING définissant les services fournis par ADDWORKING au Client ainsi que leur prix et leurs conditions.

**« Le Contrat de commissionnement et de Prestations de Service «PRESTATAIRE» ou CPS2 »** : contrat conclu en ligne entre le Prestataire et ADDWORKING via la plateforme web d'ADDWORKING définissant les services fournis par ADDWORKING au Prestataire ainsi que leur prix et leurs conditions.

**« Les Conditions particulières au CPS3 »** : conditions particulières attachées au CPS3 et convenues entre le Prestataire et le Client.

**Les conditions particulières attachées au présent contrat appelées « conditions particulières au CPS3 » prévalent sur les conditions générales convenues au présent contrat.**

Par conséquent, les Parties ont décidé de conclure le présent contrat.


## Il a été convenu et arrêté ce qui suit :

### Article 1 - Objet
Le présent contrat a pour objet de définir les prestations fournies par le Prestataire au Client telles que détaillées à l’Article 2 et aux conditions particulières attachées, la rémunération due en contrepartie ainsi que les conditions générales applicables aux Parties.

### Article 2 – Prestations – Missions

#### 2.1 Identification et volume des Prestations

Les prestations de service (ci-après la ou les « Prestation(s) ») que le Prestataire se propose de fournir au Client, sans aucune exclusivité, leur volume et leurs modalités de mise en oeuvre sont visées aux conditions particulières attachées au présent CPS3.

#### 2.2 Démarrage des Prestations

Le démarrage des Prestations est convenu aux conditions particulières attachées au présent CPS3.

### Article 3 - Prix

#### 3.1 Prix

En contrepartie de l’exécution des Prestations, le Prestataire percevra le Prix arrêté aux conditions particulières.

#### 3.2 Montant de la Provision

Sans objet pour le présent CSP3.

#### 3.3 Echéances successives

Le Prix fait l'objet de paiements successifs mensuels à concurrence des Prestations réalisées.

Au début de chaque mois, le Client communique à ADDWORKING dans un délai maximum de 5 jours, sauf délai différent prévu aux conditions particulières attachées aux CPS1 et CPS3, les prestatations réalisées et facturables par le Prestataire sur le mois précédent.
En cas d’erreur sur une échéance déjà facturée et payée, la facture de l’échéance suivante prendra alors en compte, le cas échéant, la mise à jour des prestations dus ou à déduire (ci-après « Solde Intermédiaire de Gestion »).

#### 3.4 Frais

Le Client rembourse au Prestataire ses frais sur les bases visées aux conditions particulières attachées au CPS3.

### Article 4 - Procédure de facturation

Les factures seront émises par ADDWORKING et payables sur la base du Prix, des modalités de mise en oeuvre des Prestations et des frais convenus aux conditions particulières ainsi que du Solde Intermédiaire de Gestion. Ces sommes seront ensuite versées à l'Addworker par ADDWORKING dans les conditions visées aux CPS1 et CPS2.

Sauf contradiction avec d’éventuelles conditions particulières déterminées d’un commun accord entre les Parties, lesquelles prévaudront, les conditions financières générales arrêtées en Annexe 1 seront applicables.

### Article 5 - Obligations des Parties

#### 5.1 Obligations du Prestataire

Le Prestataire s’engage à apporter toute la diligence nécessaire et exécutera ses Prestations dans les règles de l’art et dans le respect de ses obligations sociales et fiscales ainsi que des lois et réglementations en vigueur applicables à ses Prestations dont il pourra raisonnablement avoir connaissance ou dont le Client l’aura informé.

Le Prestataire devra utiliser ses moyens spécifiques sans que cette liste soit limitative pour l’exécution des Prestations. Lorsque la réalisation des Prestations nécessitera des moyens exceptionnels sortant du cadre des moyens spécifiques usuels mis en œuvre par le Prestataire, celui-ci informera le Client des conditions de mise en œuvre de ces moyens exceptionnels aux fins d’acceptation préalable par ce dernier.

Le Prestataire devra réaliser les Prestations dans les conditions visées aux conditions particulières.

Le Prestataire s’engage à respecter les dispositions légales et réglementaires applicables à son activité et notamment à mettre en œuvre tout moyen de nature à assurer la qualité des Prestations. Il s'engage également à respecter scrupuleusement la Charte des bonnes pratiques ADDWORKING présentée dans le CPS2.

#### 5.2 Obligations du Client

Le Client collaborera au mieux avec le Prestataire pour lui permettre de mener à bien ses Prestations.

Le Client communiquera au Prestataire tous documents, fichiers et données destinés à être traités dans le cadre de ses Prestations ainsi que tous autres documents et informations nécessaires au bon accomplissement de ses Prestations.

En cas d’exécution des Prestations dans les locaux du Client, celui-ci maintiendra à la disposition du Prestataire, tous moyens matériels et logistiques usuels nécessaires à la bonne exécution des Prestations et qu’il n’appartiendrait pas à au Prestataire de fournir lui-même et notamment ceux visés aux conditions particulières.

Le Client s’engage à observer toutes préconisations et tous avertissements que le Prestataire pourra émettre dans le cadre de l’exécution de ses Prestations.

Le Client s'engage également à respecter scrupuleusement la Charte des bonnes pratiques ADDWORKING présentée dans le CPS1.

### Article 6 - Responsabilité

#### 6.1

Chaque Partie assume sa propre et entière responsabilité civile et commerciale envers les dommages causés directement ou indirectement par ses matériels et/ou son personnel aux tiers.

#### 6.2

ADDWORKING ne pourra nullement être tenue responsable du fait des conséquences directes ou indirectes de l’exécution, de l’inexécution ou de la mauvaise exécution du contrat entre le Client et le Prestataire.

De plus, ADDWORKING se dégage de toute responsabilité en cas de requalification en contrat de travail et/ou de poursuites pour travail illégal dès lors que les Alertes prévues aux articles 2.1.3 des contrats CPS1 et CPS2 ont été diffusées au Client et au Prestataire.

### Article 7 – Assurances

#### 7.1

Le Prestataire souscrira et maintiendra une police d’assurance garantissant sa responsabilité civile professionnelle pour tous dommages causés aux tiers.

#### 7.2

Le Prestataire déclare être assuré pour sa responsabilité civile professionnelle auprès d’une compagnie notoirement solvable pour tous les dommages consécutifs à l’exécution de ses Prestations.

#### 7.3

Le Prestataire communiquera au Client via ADDWORKING une attestation d’assurance avant le début des Prestations.

### Article 8 – Confidentialité

Tant pendant la durée du présent contrat que deux (2) ans après sa cessation, les informations, données et documents de toute nature (commerciaux, financiers, techniques, industriels, etc.) des Parties, et notamment celles relatives aux activités, savoir-faire, secrets de fabrication ou secrets d’affaires, communiqués à l’occasion de leurs relations précontractuelles ou de l’exécution du présent contrat, ou dont leurs salariés, mandataires ou collaborateurs auraient eu connaissance, sont strictement confidentiels (ci-après dénommées les « Informations Confidentielles »), quelles qu’en soient leur forme, à l’exclusion de celles qui étaient notoirement et publiquement divulguées ou déjà connues, à charge pour la Partie destinataire d’en apporter la preuve.

En conséquence, chaque Partie s’engage expressément à :
* respecter le caractère confidentiel des Informations Confidentielles ;
* faire respecter par leurs salariés, mandataires sociaux et collaborateurs les
    termes de la présente clause.

### Article 9 - Durée et résiliation du contrat

***(1) - Soit contrat à durée déterminée***

Prise d’effet aux dates visées aux conditions particulières attachées. Il ne pourra en aucun cas se renouveler par tacite reconduction. Les Parties seront donc libres, à l'expiration de la durée initiale, de renégocier un nouveau contrat, si elles le souhaitent.

***(2) - Soit contrat à durée indéterminée***

Prise d’effet à compter de la date convenue aux conditions particulières. Chacune des Parties pourra y mettre fin, à tout moment, sans avoir à justifier sa décision, mais à condition de respecter un préavis de rupture de un (1) mois avant la cessation effective des relations contractuelles, courant à compter de la réception de la notification adressée afin de signifier la résiliation du contrat, en lettre recommandée avec demande d'avis de réception (ci-après « LRAR »), au co-contractant, par la Partie ayant pris l'initiative de la rupture.

### Article 10 - Résiliation anticipée du contrat

#### 10.1 Résiliation anticipée du contrat sans préavis à mi-parcours pour les contrats inférieurs à 1 mois

Si contrat inférieur à 1 mois, chaque Partie pourra résilier le présent contrat de plein droit, sans formalité judiciaire et sans justification jusqu'à la réalisation de la moitié des Prestations telles que visées à l'article 2.2 du présent Contrat et aux conditions particulières attachées par l’envoi d’un email avec avis de réception adressé simultanément à l'autre Partie et à ADDWORKING avant de commencer l'exécution de l'autre moitié des Prestations.

En cas de contradiction entre la date réelle de mi-parcours et la date de mi-parcours arrêtée aux conditions particulières, la date de mi-parcours arrêtée au présent contrat prévaudra.

Si une Partie use de la faculté de résiliation anticipée, ADDWORKING remboursera à au Client dans les meilleurs délais le Prix des Prestations non consommées, sous réserve que ce Prix ait été encaissé, après communication par le Client de ses coordonnées bancaires à ADDWORKING.

Les Prestations et leur Prix sont dus jusqu'à la date de mi-parcours inclus.

#### 10.2 Résiliation du contrat pour faute

Résiliation par chaque Partie de plein droit et sans formalité judiciaire par l’envoi d’une lettre recommandée avec accusé de réception à l’autre Partie en cas de manquement à l’une de ses obligations au titre du présent contrat à l’expiration d’un délai de quinze (15) jours calendaires après l’envoi par LRAR une mise en demeure d’exécuter ladite obligation demeurée en tout ou partie infructueuse, et ce, sans préjudice de tous dommages et intérêts auxquels la Partie non défaillante pourrait prétendre.

Le Client pourra également résilier le présent contrat de plein droit et sans formalité judiciaire par l’envoi d’une LRAR au Prestataire en cas de force majeure ayant empêché le Prestataire d’exécuter ses Prestations au titre du présent contrat pendant une période ininterrompue d’au moins quinze (15) jours calendaires.

Le présent contrat sera résilié de plein droit et sans formalité judiciaire en cas de procédure de sauvegarde, de redressement ou de liquidation judiciaire du Prestataire en l’absence de décision de poursuite du présent contrat ou, en cas de décision de poursuite du présent contrat, à l’expiration d’un délai de quinze (15) jours calendaires après l’envoi par LRAR d’une mise en demeure du Prestataire d’exécuter le contrat demeuré en tout ou partie infructueuse.

La résiliation du présent contrat entraînera la résiliation de toutes Prestations en cours.

#### 10.3 Résiliation pour non paiement d'une échéance

En cas de non paiement du prix correspondant à une échéance, le contrat est considéré comme rompu automatiquement sans formalité judiciaire au dernier jour du mois civil correspondant aux Prestations réalisées.

#### 10.4 Résiliation amiable

Hors les cas de résiliation visés aux articles 9, 10.1 et 10.2, les Parties ont toujours la possibilité de mettre un terme au Contrat par accord amiable formalisé par écrit signé par chacune des Parties et transmis à ADDWORKING.

#### 10.5 Pénalités en cas de rupture anticipée en dehors des règles contractuelles

Sans préjudice du droit pour chaque Partie de demander réparation de son entier préjudice, la rupture du Contrat en dehors des règles gouvernant les résiliations fixées aux articles 9 et 10.1, 10.2 et 10.4 ne donne pas lieu au versement de pénalités.

#### 10.6 Résiliation du CPS3 consécutive à la résiliation des CPS1 et/ou CPS2

Les Parties sont informées que la résiliation du CPS1 et/ou du CPS2 entraine la résiliation     automatique du CPS3 et en acceptent les conséquences.

### Article 11 - Cession - intuitu personae

Le présent contrat étant conclu intuitu personae, chaque Partie ne pourra céder à tout tiers ses droits et obligations au titre du présent contrat sans accord préalable écrit de l’autre Partie. En tout état de cause, la Partie cédante se portera garante de la solvabilité du cessionnaire et restera garante à l’égard de l’autre Partie du respect des dispositions du présent contrat par le cessionnaire.

### Article 12 - Indépendance

Chaque Partie agit en son nom et pour son compte au titre du présent contrat. Aucune clause du présent contrat ne pourra être interprétée comme créant entre les Parties une relation d’agent commercial, de mandat, d'associés ou un lien de subordination.
Le présent contrat n’aura aucun effet sur l’indépendance de chaque Partie en ce qui concerne notamment l’exercice de son activité et la poursuite de son objet social, chaque Partie continuant à exercer en toute indépendance sa gestion, ses droits et ses obligations et à assumer ses responsabilités. À ce titre, le Prestataire ne se substituera en aucune façon au Client dans l’exercice de son activité et dans la responsabilité que ce dernier pourra encourir à ce titre.

### Article 13 - Non-sollicitation de personnel

Chaque Partie s’engage à ne pas faire d’offres de mission, débaucher ou embaucher directement ou indirectement le personnel de l’autre Partie ayant participé directement ou indirectement à la réalisation du Service de contrat, et ce, pendant toute la durée de celui-ci.

### Article 14 - Dispositions diverses

#### 14.1

Le présent contrat, ses annexes et conditions particulières attachées constituent l’intégralité des dispositions liant les Parties et forment un ensemble indivisible et indissociable. Le présent contrat bénéficie et lie les Parties, leurs successeurs et ayants droit.

#### 14.2

Le présent contrat, ses annexes et conditions particulières attachées ne pourront être modifiés que par un écrit signé par les Parties. Les Parties contacteront dans ce cas ADDWORKING qui leur répondra dans un délai de 1 jour ouvrable.

#### 14.3

Dans l’hypothèse où une disposition du présent contrat serait considérée comme nulle, invalide ou inapplicable, par une loi, un règlement ou une décision de justice définitive, elle sera réputée non écrite et les autres dispositions du présent contrat garderont toute leur force et leur portée. Les Parties s’efforceront dans un délai de d'un (1) mois, à compter de l’évènement ayant entraîné la nullité, l’invalidité ou l’inapplicabilité de la clause, de s’accorder sur les termes d’une clause de remplacement équitable tout en respectant l’esprit et l’économie actuelle du présent contrat.

#### 14.4

Le fait pour l’une des Parties de ne pas se prévaloir ou de tarder à se prévaloir de l’application d’une disposition du présent contrat ne saurait être interprété comme une renonciation à se prévaloir de cette disposition à l’avenir.

#### 14.5

Pour les besoins de l’exécution du présent contrat, chacune des Parties fait élection de domicile à son adresse figurant en tête du présent contrat ou à toute autre adresse qu’elle notifierait par écrit à l’autre Partie.

#### 14.6

Le présent contrat est rédigé en langue française.

### Article 15 - Loi applicable et règlement des litiges

#### 15.1

Le présent Contrat est soumis au droit français.

#### 15.2

Les Parties tenteront d’abord de régler amiablement tout différend relatif à l'interprétation et/ou à l'exécution du Contrat. La Partie la plus diligente soumettra le différend, par lettre recommandée avec demande d'avis de réception visant le présent article à l’autre Partie. Les deux Parties se réuniront afin de trouver une solution amiable dans le délai de trente (30) jours suivant la notification de leur différend.

#### 15.3

Dans le cas où aucun accord amiable n’aurait pu être trouvé dans un de trente (30) jours à compter de la notification du différend par la Partie la plus diligente, celui-ci sera porté devant les Tribunaux de Paris, nonobstant pluralité de défendeurs, intervention forcée, notamment appel en garantie. Cette attribution de compétence s'applique également en matière de référé.




<div style="height: 46px; page-break-before: always;"><center><img src="{{ asset('img/logo_addworking_vertical.png') }}" alt="Addworking Logo" width="15%"></center></div>


<center>

# CONTRAT DE PRESTATIONS DE SERVICE - CPS3


## ANNEXE 1

### _CONDITIONS FINANCIERES GENERALES_

</center>

---


* Les Prix sont exprimés en euros et hors taxes;
* Pour le Prix fixe, les factures de Provision seront émises par ADDWORKING dès signature du présent contrat, les factures suivantes à chaque échéance mensuelle;
* Pour le Prix variable, les factures seront émises à l'échéance suivant la réception par ADDWORKING des éléments de facturation transmis par le Client
* Tout retard de paiement à l’échéance fera courir, de plein droit et sans mise en demeure, des intérêts de retard mensuels au taux légal en vigueur majoré de trois (3) points;
* Les factures revêtent la forme éléctronique;
* Toute contestation concernant une facture devra être motivée et notifiée par écrit dans un délai de sept (7) jours calendaires à compter de sa date de réception. Passé ce délai, le Client sera réputé d'accord avec la facture qui lui a été adressée et aucune contestation ne sera plus admise par le Prestataire et/ou ADDWORKING;
* Le Client prendra à sa charge tous impôts, taxes, intérêts et pénalités de toute nature exigés par toute administration, collectivité ou autorité à raison du présent contrat et, dans le cas où le Prestataire en aurait fait l’avance, lui en remboursera le montant;
* Les paiements sont effectués selon règles fixées ci-dessous.


### IMPORTANT :

Lors de paiements par virements bancaires, le Client s'engage à indiquer impérativement les références comptables communiquées par ADDWORKING dans ses factures, à défaut desquelles ADDWORKING ne pourra être en mesure d'identifier les paiements intervenus et considérera le Client comme défaillant.


Le Prix visé à l'article 3.1 et aux conditions particulières du Contrat est intégralement payé par le Client à ADDWORKING à réception de la facture électronique émise par ADDWORKING.

Modalités de paiement : les paiements s’effectuent aux choix selon les modalités et conditions suivantes

<table width="100%" cellspacing="15">
    <tr>
        <th width="50%">Modalités de paiement</th>
        <th width="50%">Conditions</th>
    </tr>
    <tr>
        <td width="50%">Virement bancaire au crédit du compte : Société Générale  ADDWORKING  - N°IBAN : FR76 3000 3005 7100 0201 2497 429</td>
        <td width="50%"><b>Indication impérative de la référence de facture dans l’ordre de virement</b></td>
    </tr>
</table>

@endsection
