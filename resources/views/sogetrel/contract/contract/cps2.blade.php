@extends('layouts.contract')

@section('content')
    <center>
        @unless (config('app.env') == 'local')
            <img src="{{ asset('img/logo_addworking_vertical.png') }}" alt="Addworking Logo" width="15%">
        @endunless

        <h1>CONTRAT DE PRESTATIONS DE SERVICE</h1>
        <h1><i>Intitulé « CPS2 »</i></h1>

        <h1>PRESTATAIRE / ADDWORKING</h1>
    </center>

    <hr>

    <h2>Entre les soussignés :</h2>

    <table width="100%" cellspacing="15">
        <tr>
            <td width="45%" height="250px" valign="top">
                <p>
                    <b>{{ $vendor->name }}</b>, @lang("enterprise.enterprise.{$vendor->legalForm->name}"), {{ ($address = $vendor->addresses->first()) ? "dont le siège social est situé {$address}, " : "" }}{{ $vendor->identification_number ? "immatriculée au Registre du Commerce et des Sociétés de {$vendor->registration_town} sous le numéro {$vendor->identification_number}," : "en cours de création," }} représentée par {{ $vendor->legalRepresentatives()->first()->name }} agissant en sa qualité de {{ ucwords($vendor->legalRepresentatives()->first()->pivot->job_title ?: "Gérant") }}. E-mail {{ strtolower($vendor->legalRepresentatives()->first()->email) }}.
                </p>
                <p>Ci-après dénommé le "<b>Prestataire</b>".</p>
                <p>D'une part,</p>
            </td>
            <td width="10%" style="text-align: center">Et</td>
            <td width="45%" height="250px" valign="top">
                <p>
                    <b>ADDWORKING</b>, Société par Actions Simplifiée, dont le siège social est situé 17 rue du lac Saint André – Savoie Technolac – BP 350 – 73370 Le Bourget du Lac, immatriculée au Registre du Commerce et des Sociétés de Chambéry sous le numéro 810 840 900, représentée par Julien PERONA agissant en sa qualité de Président. E-mail: contact{{'@'}}addworking.com.
                </p>
                <p>Ci-après dénommée "<b>ADDWORKING</b>".</p>
                <p>D'autre part,</p>
            </td>
        </tr>
    </table>

    <p>Ci-après dénommée(s) individuellement une Partie et ensemble les Parties</p>

    <div style="page-break-after: always;"></div>

    <h2 id="-tant-rappel-ce-qui-suit">Étant rappelé ce qui suit :</h2>

    <p><b>ADDWORKING</b> est une société de services sécurisant la gestion de la relation contractuelle entre les entreprises donneurs d’ordre (ci-après « le Client ») et les prestataires (ci-après « le Prestataire ») via sa plateforme web originale (www.addworking.com). Elle propose à chacun d’entre eux une série de prestations de service notamment pour faciliter leur gestion financière, alléger leur charge administrative et réduire leurs risques juridiques.</p>

    <p>ADDWORKING propose également un service de mise en relation entre le Client et le Prestataire.</p>

    <p><b>« Le Prestataire »</b> : entreprise signataire du présent contrat et inscrite sur le site www.addworking.com, qui propose ses services au Client via la plateforme web mise en œuvre par ADDWORKING.</p>

    <p><b>En signant le présent Contrat et en cochant la case à cet effet, le Prestataire accepte pleinement et sans réserve l’ensemble des termes du présent contrat.</b></p>

    <p><b>« Le Client »</b> : entreprise inscrite sur le site web www.addworking.com, en vue de conclure des Contrats de Prestations de Service avec le Prestataire, via la plateforme web d&#39;ADDWORKING.</p>

    <p><b>« Le Contrat de Prestations de Service » ou CPS3</b> : contrat conclu en ligne entre le Client et le Prestataire suite à leur rencontre grâce à l’entremise de la plateforme web mise en œuvre par ADDWORKING pour l’exécution d’une mission par le Prestataire pour le Client.</p>

    <p>Le présent contrat remplace tout CPS2 précédemment conclu entre ADDWORKING et le Prestataire.</p>

    <p><b>Les conditions particulières attachées, le cas-échéant, au présent contrat appelées « conditions particulières au CPS2 » prévalent sur les conditions générales convenues au présent contrat.</b></p>

    <div style="page-break-after: always;"></div>

    <h2 id="il-est-convenu-et-arr-t-ce-qui-suit-">Il est convenu et arrêté ce qui suit :</h2>

    <h3 id="article-1-objet">Article 1 – Objet</h3>

    <p>Le présent contrat a pour objet de définir les Prestations fournies par ADDWORKING au Prestataire telles que détaillées à l’Article 2, la rémunération due en contrepartie par le Prestataire, les engagements des Parties dans le cadre de l’utilisation de la plateforme web ADDWORKING ainsi que les conditions générales applicables aux Parties.</p>

    <h3 id="article-2-obligations-d-addworking">Article 2 – Obligations d’ADDWORKING</h3>

    <h4 id="2-1-mise-en-relation">2.1 Mise en relation</h4>

    <p>ADDWORKING, par l’entremise de sa plateforme web www.addworking.com et des fonctions innovantes qu’elle propose, agit en qualité d’intermédiaire indépendant mettant en relation les Prestataires et les Clients.</p>

    <p>ADDWORKING permet ainsi au Prestataire d’avoir accès aux offres de missions des Clients. ADDWORKING assure également une gestion en temps réel de son planning et de ses disponibilités.</p>

    <h4 id="2-2-prestations-de-services-support-administratif-et-juridique">2.2 Prestations de services : support administratif et juridique</h4>

    <h5 id="2-2-1-identification-des-addworkers-">2.2.1 Identification des Addworkers :</h5>

    <p>Le Prestataire devra identifier sur son compte www.addworking.com, ses ressources « AddWorkers » en mission chez le Client. Le Prestataire aura la possibilité de renseigner les compétences de ses AddWorkers à travers le Passwork dont il pourra, le cas échéant, en déléguer l’accès pour une complétude faite directement par l’Addworker.</p>

    <h5 id="2-2-2-contrat-de-prestations-de-service-cps3-">2.2.2 Contrat de Prestations de Service (CPS3) :</h5>

    <p>ADDWORKING édite et gère le CPS3 conclu entre le Client et le Prestataire.</p>

    <h5 id="2-2-3-aide-et-suivi-administratif-pour-la-prestation-de-service-">2.2.3 Aide et suivi administratif pour la Prestation de service :</h5>

    <p>ADDWORKING organise la certification administrative du Prestataire. Elle l’assiste pour réunir et fournir les pièces administratives et légales nécessaires pour effectuer les Prestations de service auprès du Client. Il s’agit des attestations permettant de s’assurer que le Prestataire est régulièrement constitué et satisfait à ses obligations déclaratives et de paiement auprès des organismes sociaux notamment ceux visés à l&#39;article 3.2. ADDWORKING vérifie l&#39;authenticité desdites attestations.</p>

    <p>ADDWORKING établit et met à la disposition du Prestataire un compte entreprise personnalisé avec un suivi administratif, business, financier et juridique et réalisation de statistiques.</p>

    <h5 id="2-2-4-police-d-assurance-">2.2.4 Police d&#39;assurance :</h5>

    <p>Le Prestataire peut souscrire via ADDWORKING une police d&#39;assurance offerte à compter de la date de signature du 1er CPS3 à condition d’y être éligible selon les conditions particulières attachées au CPS3. Cette police d&#39;assurance n&#39;est valable que pour les Prestations réalisées via ADDWORKING dans le cadre de CPS3.</p>

    <h5 id="2-2-5-alertes-">2.2.5 Alertes : En cas de situations à risque constatées chez le Prestataire, telles que, et sans que cette liste ne soit exhaustive, non-conformités administratives, non-respect de la législation sociale et fiscale, existence d’une situation de dépendance économique du Prestataire constatée par ADDWORKING</h5>

    <p>Alertes en cas de situation à risque, de non-conformité administrative du Prestataire ou de situation de mono clientèle détectées par ADDWORKING, cette dernière mettra tout en œuvre pour alerter le Prestataire, dans les meilleurs délais dès qu’elle en aura connaissance, de l’absence de multiplicité de missions et/ou la non-conformité administrative.</p>

    <p>Conformément à l’article 5 du présent Contrat, ADDWORKING exclut toute responsabilité pour les dommages directs ou indirects résultant de l’exécution de cette Alerte qui s’entend comme une simple obligation de moyen.</p>

    <p>ADDWORKING alertera, en exécution d’une obligation de résultat, le Client dans un délai maximum de 24 heures, dès qu’elle aura eu connaissance de ces éléments à risque.</p>

    <h5 id="2-2-6-facturation-">2.2.6 Facturation :</h5>

    <p>ADDWORKING proposera un service au Prestataire permettant de transmettre ses factures émises au titre du (ou des) CPS3, chaque fin de mois ou de réaliser sa facture électronique au sein de la plateforme web www.addworking.com. Pour le Prix variable, la facture sera éditée trois (3) jours après communication à ADDWORKING par le Client du montant facturable.</p>

    <h4 id="2-3-cession-de-cr-ance-et-garantie-de-paiement">2.3 Cession de créance et garantie de paiement</h4>

    <h5 id="2-3-1-cession-de-cr-ance-addworking">2.3.1 Cession de créance à ADDWORKING</h5>

    <p>En application des dispositions de l’article 1321 et suivants du Code civil, le Prestataire cède à ADDWORKING, la créance qu’il détient sur le Client, au titre des prestations effectuées dans le cadre de l’exécution du CPS3.</p>

    <p>Au titre de la cession de créance cédée au profit d’ADDWORKING ainsi que de la subrogation dans les droits du Prestataire, le Prestataire facturera ADDWORKING du montant convenu avec le Client au titre du CPS3, déduction faite des frais de commission dus par le Prestataire à ADDWORKING.</p>

    <p>ADDWORKING déclare et garantit que cette cession de créance a été portée à la connaissance du Client.</p>

    <p>En conséquence de ce qui précède, le Prestataire reconnaît et accepte que le paiement des créances lui revenant au titre de l’exécution des prestations détaillées dans le CPS3 soit effectué exclusivement entre les mains d’ADDWORKING.</p>

    <h5 id="2-3-2-garantie-de-paiement-du-prix-fixe-des-prestations-effectu-es-par-le-prestataire">2.3.2 Garantie de paiement du Prix fixe et du Prix Variable des Prestations effectuées par le Prestataire</h5>

    <p>ADDWORKING s’engage, à titre d’obligation de résultat, selon les modalités et délais ci-après définis, à verser au Prestataire le Prix fixe convenu avec le Client au CPS3 et aux conditions particulières attachées, en contrepartie de l’exécution de sa mission.</p>

    <p>Sous les mêmes conditions que celles précédemment énoncées, ADDWORKING s’engage à régler, au Prestataire, le Prix Variable tel que défini par le CPS3.</p>

    <p>ADDWORKING est donc le seul débiteur du Prestataire à qui il garantit le reversement du Prix fixe et/ou variable des Prestations qu’il aura effectuées conformément au CPS3 conclu avec le Client, déduction faite de la commission due par le Prestataire à ADDWORKING.</p>

    <p>Le versement des sommes dues au Prestataire sera effectué selon les modalités rappelées à l’article 4 des présentes.</p>



    <h3 id="article-3-obligations-du-prestataire">Article 3 – Obligations du Prestataire</h3>

    <h4 id="3-1-paiement-d-une-commission-addworking">3.1 Paiement d’une Commission à ADDWORKING</h4>

    <p><em>applicable aux nouveaux Prestataires proposés au Client par ADDWORKING</em></p>

    <p>Lorsque la conclusion du CPS3 résulte d’une mise en relation du Prestataire avec le Client par ADDWORKING, le Prestataire versera à ADDWORKING, en contrepartie des Prestations de services fournies, une Commission correspondant à 5% du Prix Total HT convenu avec le Client, précisé à l’article 3 du CPS3 conclu entre ces deux dernières parties (ci après : Commission »).</p>

    <h4 id="3-2-communication-de-documents-addworking">3.2 Communication de documents à ADDWORKING</h4>

    <p>Le Prestataire respectera la législation sociale et la réglementation du travail applicable et devra être à jour des cotisations imposées par la législation et être en mesure d'en fournir la preuve lors de la signature du Contrat et à tout moment, à la demande d’ADDWORKING et tous les six mois ou dans tous délais requis par la loi ou la règlementation, en fournissant les documents suivants et tous ceux requis par la loi et la règlementation.</p>

    <ul>
        <li>Une carte d'identification justifiant de l'immatriculation au registre de métiers ou un extrait de l'inscription au Registre du Commerce et des Sociétés (extrait K ou KBIS) de moins de 3 mois ou un récépissé de dépôt de déclaration auprès d’un centre de formalités des entreprises pour les personnes physiques ou morales en cours d’inscription;</li>
        <li>Une attestation de fourniture de déclarations sociales émanant de l'organisme de protection sociale chargé du recouvrement des cotisations, datant de moins de 6 mois;</li>
        <li>Une attestation sur l'honneur certifiant notamment que le travail sera réalisé avec des salariés régulièrement employés au regard des dispositions du Code du Travail.</li>
    </ul>

    <p>Le défaut de communication et/ou d'authenticité desdits documents autorise ADDWORKING à résilier le présent contrat sans délai, en application des dispositions de l’article 8 Résiliation.</p>

    <h4 id="3-3-obligations-g-n-rales-li-es-au-bon-fonctionnement-du-site-www-addworking-com">3.3 Obligations générales liées au bon fonctionnement du site www.addworking.com</h4>

    <p>Le Prestataire s’engage à réaliser toutes les déclarations et formalités nécessaires à son activité, ainsi qu’à satisfaire à toutes ses obligations légales, sociales, administratives et fiscales et à toutes les obligations spécifiques qui lui incombe, le cas échéant en application du droit français dont il dépend, dans le cadre de son activité et de l’utilisation du site web d&#39;ADDWORKING.</p>

    <p>En cas de demande, le Prestataire s’engage à fournir, sans délai, à ADDWORKING tout justificatif prouvant qu’il remplit les conditions énoncées dans le présent article.</p>

    <p>Le Prestataire s&#39;engage en outre à répondre dans un délai de 48 heures à toute demande d&#39;information d&#39;ADDWORKING et à compléter tout questionnaire de suivi remis par ADDWORKING dans le même délai, le non respect de ces obligations étant susceptible d'être sanctionné par la résiliation du Contrat selon les modalités de l‘article 8.</p>

    <h3 id="article-4-proc-dure-de-facturation-modalit-s-et-d-lais-de-paiement-du-prestataire">Article 4 – Procédure de facturation, modalités et délais de paiement du Prestataire</h3>

    <p>L’ensemble des sommes dues au Prestataire par ADDWORKING, lui seront réglées dans un délai de cinq jours ouvrables suivant la réception des sommes versées par le Client en rémunération des prestations effectuées en exécution du CPS3.</p>

    <p>Les sommes seront versées au Prestataire, déduction faite du montant de la commission visée à l’article 3.1 due à ADDWORKING.</p>

    <p>Tout retard de paiement fera courir de plein droit des pénalités calculées sur la base du taux minimal prévu par l’article L441-6 du Code de Commerce, à compter de la date d'échéance de la facture impayée.</p>

    <p>En sus de ce qui précède, tout retard de paiement sera sanctionné de plein droit par l’octroi d’une indemnité forfaitaire pour frais de recouvrement, fixée par l’article D441-5 du Code de Commerce (et à ce jour d’un montant de quarante euros (40€).</p>


    <h3 id="article-5-responsabilit-exclusion-et-limitation">Article 5 – Responsabilité - exclusion et limitation</h3>

    <h4 id="5-1">5.1</h4>

    <p>Chaque Partie assume sa propre et entière responsabilité civile et commerciale envers les dommages causés directement ou indirectement par ses matériels et/ou son personnel aux tiers.</p>

    <h4 id="5-2">5.2</h4>

    <p>ADDWORKING ne pourra nullement être tenue responsable du fait des conséquences directes ou indirectes de l’exécution, de l’inexécution ou de la mauvaise exécution du CPS3 entre le Client et le Prestataire</p>


    <h3 id="article-6-confidentialit-">Article 6 – Confidentialité</h3>

    <p>Tant pendant la durée du présent contrat que deux (2) ans après sa cessation, les informations, données et documents de toute nature (commerciaux, financiers, techniques, industriels, etc.) des Parties, et notamment celles relatives aux activités, savoir-faire, secrets de fabrication ou secrets d’affaires, communiqués à l’occasion de leurs relations précontractuelles ou de l’exécution du présent contrat, ou dont leurs salariés, mandataires ou collaborateurs auraient eu connaissance, sont strictement confidentiels (ci-après dénommées les « Informations Confidentielles »), quelles qu’en soient leur forme, à l’exclusion de celles qui étaient notoirement et publiquement divulguées ou déjà connues, à charge pour la Partie destinataire d’en apporter la preuve.</p>

    <p>En conséquence, chaque Partie s’engage expressément à :</p>

    <ul>
        <li>respecter le caractère confidentiel des Informations Confidentielles et à prendre toutes mesures utiles pour empêcher la divulgation, directe ou indirecte, à toute personne autre que celles qui en ont impérativement et directement besoin aux fins du présent contrat, sauf autorisation écrite et préalable de l’autre Partie;</li>
        <li>faire respecter par leurs salariés, mandataires sociaux et collaborateurs les termes de la présente clause;</li>
        <li>détruire ou, sur demande expresse de la partie propriétaire des informations, lui restituer, dans un délai de trente (30) jours calendaires après la cessation du présent contrat, l’ensemble de ces Informations Confidentielles.</li>
    </ul>

    <h3 id="article-7-dur-e-du-contrat">Article 7 – Durée du contrat</h3>

    <p>Le Contrat est conclu pour une durée indéterminée à compter de sa date de signature. Chaque Partie pourra résilier le Contrat à tout moment, par lettre recommandée avec demande d'avis de réception, moyennant le respect d'un préavis de un (1) mois.</p>

    <h3 id="article-8-r-siliation-du-contrat">Article 8 – Résiliation du Contrat</h3>

    <p>En cas d’inexécution par l’une des Parties des obligations et notamment celles visées aux articles "2.2 Prestations de service : support administratif et juridique", "2.3.2 Garantie de paiement du prix fixe et du prix variable des prestations effectuées par le Prestataire", "3.2 : Communication de documents à ADDWORKING", "4. Procédure de facturation, modalités et délais de paiement du Prestataire", "5.3 Garantie ADDWORKING", "6. Confidentialité", "9.1 Protection des Données à caractère personnel", le Contrat CPS2 pourra être résilié de plein droit, dans les conditions de l’article 1225 du Code Civil, à l’initiative de la partie créancière de l’obligation non exécutée, selon les modalités prévues au présent Contrat.</p>

     <p>A défaut de stipulation fixant un délai différent, la résiliation interviendra dans un délai de quinze (15) jours après réception par la partie défaillante, d’une mise en demeure adressée par lettre recommandée avec accusé de réception restée infructueuse.</p>

     <p>Les Parties conviennent ainsi que la résiliation du Contrat CPS2 interviendra dans les conditions visées ci-dessus, sans préjudice de tous dommages intérêts que la Partie non défaillante pourrait réclamer.</p>

     <p>Conformément aux dispositions de l’article 1230 du Code civil, les Parties conviennent, sans que cette liste soit exhaustive, que les obligations des articles "5.3" et "5.4 Garanties ADDWORKING", et l’article 6 du CPS2 relatives à la Confidentialité, demeureront applicables conformément à la durée indiquée, le cas échéant par chacune de ces clauses.</p>

     <p>La résiliation du CPS2 ne saurait dégager les Parties de leurs obligations nées antérieurement à la résiliation.</p>

     <p>A la date d’effet de la résiliation, ADDWORKING supprimera de sa plateforme web www.addworking.com toute information, mention, référence du Prestataire. Celle-ci ne pourra donc plus être visible par les Prestataires ni accéder à son compte qui sera fermé.</p>

     <p>En cas de résiliation pour inexécution du Prestataire, ADDWORKING se réserve le droit de refuser toute nouvelle demande d’inscription de sa part.</p>

    <h3 id="article-9-protection-donnees-personnelles">Article 9 – Protection des données personnelles</h3>

   <p>ADDWORKING s’oblige à traiter les données personnelles qui lui seront transférées par le Prestataire, en conformité avec toute réglementation en vigueur applicable au traitement de ces données, y compris, sans que cela soit une liste limitative, la loi n°78-17 modifiée dite « Informatique et Libertés », les Directives Européennes 95/46/EC et 2002/58/EC et leurs modifications ultérieures et, à partir du 25 mai 2018, le Règlement (UE) 2016/679 sur la protection des données telles que figurant à l’annexe 1 Traitement des données à caractère personnel du Contrat.</p>

    <p>A ce titre, ADDWORKING garantit, dans le cadre des traitements qu'il effectue :</p>

    <ul>
        <li>la confidentialité, l'intégrité de ces données;</li>
        <li>la sécurité physique et logique des moyens techniques qu'elle utilise et/ou fournit, en particulier contre les risques de divulgation, destruction, corruption, piratage, détournement de ces données par un tiers non habilité.</li>
    </ul>

    <p>ADDWORKING n'utilise ces données qu'à la seule fin de remplir ses obligations au titre du Contrat.</p>

    <p>En tout état de cause, ADDWORKING s’engage à respecter les obligations suivantes et à les faire respecter par son personnel :</p>

    <ul>
        <li>ne pas utiliser les documents et informations contenant des données personnelles traités autrement que pour de la prospection commerciale, de la gestion et du traitement de commande,</li>
        <li>ne pas utiliser les documents et informations contenant des données personnelles traités pour son propre compte ou pour celui d’un tiers,</li>
        <li>ne pas divulguer ces documents ou informations contenant des données personnelles à d’autres personnes, qu’il s’agisse de personnes privées ou publiques, physiques ou morales,</li>
        <li>prendre toutes mesures permettant d’éviter toute utilisation détournée ou frauduleuse des fichiers informatiques en cours d’exécution du contrat,</li>
        <li>prendre toutes mesures de sécurité, notamment matérielles, pour assurer la protection contre toute destruction accidentelle ou illicite, perte accidentelle, altération, diffusion ou accès non autorisés des documents et informations contenant des données personnelles traités pendant la durée du présent contrat, notamment lorsque le traitement des données comporte des transmissions de données dans un réseau, ainsi que contre toute autre forme de traitement illicite ou communication à des personnes non autorisées,</li>
        <li>ne pas transférer, héberger ou réaliser en dehors du territoire de l’Union Européenne ou dans un pays ne disposant pas d’un niveau de protection adéquat en matière de protection des données personnelles tel que défini par la Commission Européenne, le traitement des données personnelles qui lui a été confié dans le cadre de l’exécution du Contrat;</li>
        <li>informer le Prestataire de toute faille de sécurité ayant des conséquences directes ou indirectes sur le traitement des données personnelles et de toute réclamation qui lui serait adressée par toute personne concernée,</li>
        <li>en fin de contrat, procéder à la destruction de tous fichiers manuels ou informatisés stockant les informations saisies, ou, à la demande du Prestataire, à leur restitution.</li>
    </ul>

    <p>Les Parties s’engagent à coopérer avec les autorités de protection des données compétentes, notamment en cas de demande d’information qui pourrait leur être adressée, ou en cas de contrôle.</p>

    <p>ADDWORKING garantit que dans le cadre de l'exécution du Contrat, le ou les Traitement(s) de Données personnelles n'est/ne sont pas effectué(s) en dehors du territoire de l’Union Européenne ou dans un pays ne disposant pas d’un niveau de protection adéquat en matière de protection des données personnelles tel que défini par la Commission Européenne.</p>

    <p>Le Prestataire pourra résilier le Contrat, immédiatement et sans mise en demeure du Contrat sans indemnité en faveur d’ADDWORKING, en cas de non-respect des dispositions précitées. Le Prestataire notifiera la résiliation à ADDWORKING, par lettre recommandée avec accusé de réception.</p>



    <h3 id="article-10-dispositions-diverses">Article 10 – Dispositions diverses</h3>


    <h4 id="10-1">10.1</h4>

    <p>Le présent contrat bénéficie et lie les Parties, leurs successeurs et ayants droit.</p>

    <h4 id="10-2">10.2</h4>

    <p>Dans l’hypothèse où une disposition du présent contrat serait considérée comme nulle, invalide ou inapplicable, par une loi, un règlement ou une décision de justice définitive, elle sera réputée non écrite et les autres dispositions du présent contrat garderont toute leur force et leur portée. Les Parties s’efforceront dans un délai de d'un (1) mois, à compter de l’évènement ayant entraîné la nullité, l’invalidité ou l’inapplicabilité de la clause, de s’accorder sur les termes d’une clause de remplacement équitable tout en respectant l’esprit et l’économie actuelle du présent contrat.</p>

    <h4 id="10-3">10.3</h4>

    <p>Le fait pour l’une des Parties de ne pas se prévaloir ou de tarder à se prévaloir de l’application d’une disposition du présent contrat ne saurait être interprété comme une renonciation à se prévaloir de cette disposition à l’avenir.</p>

     <h4 id="10-4">10.4</h4>

    <p>Pour les besoins de l’exécution du présent contrat, chacune des Parties fait élection de domicile à son adresse figurant en tête du présent contrat ou à toute autre adresse qu’elle notifierait par écrit à l’autre Partie.</p>

     <h4 id="10-5">10.5</h4>

    <p>Le présent contrat est rédigé en langue française.</p>

    <h3 id="article-11-loi-applicable-et-r-glement-des-litiges">Article 11 – Loi applicable et règlement des litiges</h3>

    <h4 id="11-1">11.1</h4>

    <p>Le présent Contrat est soumis au droit français.</p>

    <h4 id="11-2">11.2</h4>

    <p>En cas de litige quant à l’exécution ou l’interprétation du Contrat, celui-ci sera porté devant les Tribunaux de Nanterre, nonobstant pluralité de défendeurs, intervention forcée, notamment appel en garantie. Cette attribution de compétence s'applique également en matière de référé.</p>


    <div style="page-break-after: always;"></div>

    <h2 id="la-charte-des-bonnes-pratiques-addworking">LA CHARTE DES BONNES PRATIQUES ADDWORKING</h2>

    <p><em>ADDWORKING sécurise la gestion de la relation contractuelle entre les Clients et les Prestataires via sa plateforme web originale (www.addworking.com). Elle propose à chacun d’entre eux une série de Prestations de service notamment pour faciliter leur gestion financière, alléger leur charge administrative et réduire leurs risques juridiques.</em></p>

    <p><em>Cette charte a vocation à s’appliquer à toute Prestation de service entre les Clients et les Prestataires, dont la gestion contractuelle, administrative et financière est confiée à ADDWORKING.</em></p>

    <p><em>Elle a notamment pour objet d’encadrer les relations entre les Clients  et les Prestataires, fixer des bonnes pratiques destinées à lutter contre le « faux travail indépendant » et de manière plus générale contre le travail illégal.</em></p>

    <p><b>LE PRESTATAIRE PREND CONNAISSANCE DE CETTE CHARTE ET ADHERE SANS RESERVE A L&#39;ENSEMBLE DES BONNES PRATIQUES QUI Y SONT LISTEES.</b></p>

    <hr>

    <p><b>LES OBLIGATIONS ET BONNES PRATIQUES DU PRESTATAIRE</b> :</p>

    <p>Le Prestataire, entreprise signataire du présent contrat propose ses services et compétences à des Clients dans le cadre d&#39;un contrat de prestations de service.</p>

    <p>Il doit respecter en pratique de nombreuses règles destinées à garantir son indépendance vis à vis du Client.</p>

    <p>Sa responsabilité pénale peut notamment être engagée en cas de dissimulation d&#39;activité ou s&#39;il prête frauduleusement ses salariés à ses Clients.</p>

    <hr>

    <p><b>POUR ANTICIPER AU MIEUX CES RISQUES, LE PRESTATAIRE DOIT RESPECTER LES REGLES ET BONNES PRATIQUES SUIVANTES :</b></p>

    <ul>
        <li><b>avoir</b> une parfaite connaissance des services qu&#39;il propose grâce à une formation adaptée et/ou une expérience d’une durée suffisante.</li>
        <li><b>posséder</b> une couverture responsabilité civile professionnelle.</li>
        <li><b>communiquer</b> à ADDWORKING avant le début de la Prestation, puis tous les 6 mois les documents visés aux articles L. 8222-1 et D8222-5 du code du travail, attestant de son existence et de la régularité de sa situation.</li>
        <li>s&#39;il emploie des salariés, <b>communiquer</b> à ADDWORKING une attestation sur l&#39;honneur de la réalisation du travail par des salariés employés régulièrement au regard des articles L1221-10 (déclaration préalable à l&#39;embauche), L3243-2 et R3243-1 (bulletin de paie) du code du travail.</li>
        <li><b>utiliser</b> le contrat-type de prestations de service proposé par ADDWORKING pour formaliser sa relation contractuelle avec l&#39;Entreprise Utilisatrice.</li>
        <li><b>définir</b> avec précision dans le contrat de prestations de service avec l&#39;Entreprise Utilisatrice son périmètre et ses conditions et délais d&#39;intervention.</li>
        <li><b>évaluer</b> ses tarifs de façon à ce qu&#39;ils couvrent ses charges directes et indirectes (charges sociales, frais, rémunération du chef d&#39;entreprise...) et que l&#39;activité soit rentable.</li>
        <li><b>jouir</b> d’une totale indépendance juridique et opérationnelle vis-à-vis de l&#39;Entreprise Utilisatrice et conserver l’initiative de ses décisions et la gestion de son activité.</li>
        <li><b>refuser</b> des prix trop bas.</li>
        <li><b>refuser</b> l&#39;instauration de tout lien de subordination et de tout pouvoir disciplinaire entre le Client et lui-même.</li>
        <li><b>disposer</b> de plusieurs clients et s&#39;engager à multiplier les clients pour lesquels il intervient, via ADDWORKING notamment, afin de limiter sa dépendance économique à l&#39;égard du Client.</li>
        <li><b>renseigner</b> les questionnaires périodiquement adressés par ADDWORKING et s’assurer que ses AddWorkers y répondent également le cas échéant.</li>
        <li><b>répondre</b> dans les plus brefs délais aux demandes d&#39;information formulées par ADDWORKING.</li>
        <li><b>respecter</b> les dispositions légales en matière de santé et sécurité au travail applicables chez l&#39;Entreprise Utilisatrice.</li>
        <li><b>respecter</b> l&#39;ensemble des obligations de droit du travail et conserver le lien de subordination sur ses propres salariés si le Prestataire confie, sous sa responsabilité, l&#39;exécution des Prestations ou d&#39;une partie des Prestations à un de ses salariés.</li>
        <li><b>identifier</b> les salariés du Prestataire intervenant chez le Client par le port d&#39;un badge au nom de l&#39;entreprise du Prestataire</li>
        <li><b>veiller</b> aux règles gouvernant la mise à disposition de personnel et notamment les dispositions légales prohibant le prêt de main d&#39;œuvre à but lucratif et le marchandage.</li>
        <li><b>informer</b> ADDWORKING de toute difficulté liée à l&#39;application et au respect des bonnes pratiques listées.</li>
    </ul>

    <div style="page-break-after: always;"></div>

    <h3>Fait le {{ date('d/m/Y') }}</h3>

    <table width="100%" cellspacing="15">
        <tr>
            <td width="50%" height="100px" valign="bottom"><b>{{ $vendor->signatories->first()->name }}, {{ $vendor->signatories->first()->pivot->job_title ?: 'Gérant' }}</b></td>
            <td width="50%" height="100px" valign="bottom"><b>Julien Pérona, Président</b></td>
        </tr>
        <tr>
            <td width="50%">Pour le Prestataire :</td>
            <td width="50%">Pour Addworking :</td>
        </tr>
    </table>
@endsection
