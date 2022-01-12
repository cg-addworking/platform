@extends('layouts.contract')

@section('content')
    <center>
        @unless (config('app.env') == 'local')
            <img src="{{ asset('img/logo_addworking_vertical.png') }}" alt="Addworking Logo" width="15%">
        @endunless

        <h1>CONTRAT DE COMMISSIONNEMENT ET DE PRESTATIONS DE SERVICE</h1>
        <h1><i>Intitulé « CPS2 »</i></h1>

        <h1>PRESTATAIRE ADDWORKING</h1>
    </center>

    <hr>

    <h2>Entre les soussignés :</h2>

    <table width="100%" cellspacing="15">
        <tr>
            <td width="45%" height="250px" valign="top">
                <p>
                    <b>{{ $vendor->name }}</b>, @lang("enterprise.enterprise.{$vendor->legalForm->name}"), {{ ($address = $vendor->addresses->first()) ? "dont le siège social est situé {$address}, " : "" }}{{ $vendor->identification_number ? "immatriculée au Registre du Commerce et des Sociétés de {$vendor->registration_town} sous le numéro {$vendor->identification_number}," : "en cours de création," }} représentée par {{ $vendor->legalRepresentatives->first()->name }} agissant en sa qualité de {{ ucwords($vendor->legalRepresentatives->first()->pivot->job_title ?: "Gérant") }}. E-mail {{ strtolower($vendor->legalRepresentatives->first()->email) }}.
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

    <p><b>ADDWORKING</b> est une société de services sécurisant la gestion de la relation contractuelle entre les entreprises donneurs d’ordre (ci-après « le Client ») et les prestataires (ci-après « le Prestataire ») via sa plateforme web originale (www.addworking.com). Elle propose à chacun d’entre eux une série de prestations de service notamment pour faciliter leur gestion financière, alléger leur charge administrative et réduire leurs risques juridiques.</p>

    <p>ADDWORKING propose également un service de mise en relation entre le Client et le Prestataire.</p>

    <p><b>« Le Prestataire »</b> : entreprise signataire du présent contrat et inscrite sur le site www.addworking.com, qui propose ses services au Client via la plateforme web mise en œuvre par ADDWORKING.</p>

    <p><b>« L’AddWorker »</b> : la ressource du Prestataire en charge de la réalisation de la prestation de service chez le Client.</p>

    <p><b>En signant le présent Contrat et en cochant la case à cet effet, le Prestataire accepte pleinement et sans réserve l’ensemble des termes du présent contrat.</b></p>

    <p><b>« Le Client »</b> : entreprise inscrite sur le site web www.addworking.com, en vue de conclure des Contrats de Prestations de Service avec le Prestataire, via la plateforme web d&#39;ADDWORKING.</p>

    <p><b>« Le Contrat de Prestations de Service » ou CPS3</b> : contrat conclu en ligne entre le Client et le Prestataire suite à leur rencontre grâce à l’entremise de la plateforme web mise en œuvre par ADDWORKING ou suite à la reprise de la gestion commerciale de leur relation contractuelle par ADDWORKING pour l’exécution d’une mission par le Prestataire pour le Client.</p>

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

    <p>Le Prestataire devra identifier sur son compte www.addworking.com, ses ressources « AddWorkers » en mission chez le Client. Le Prestataire aura la possibilité de renseigner les compétences de ses AddWorkers à travers le Passwork dont il pourra, le cas échéant, en déléguer l’accès pour une complétude faite directement par l’Addworker. Si le Prestataire souhaite confier à ADDWORKING la gestion de ses AddWorkers non-salariés, il devra valider le CPS1.</p>

    <h5 id="2-2-2-contrat-de-prestations-de-service-cps3-">2.2.2 Contrat de Prestations de Service (CPS3) :</h5>

    <p>ADDWORKING édite et gère le CPS3 conclu entre le Client et le Prestataire.</p>

    <h5 id="2-2-3-aide-et-suivi-administratif-pour-la-prestation-de-service-">2.2.3 Aide et suivi administratif pour la Prestation de service :</h5>

    <p>ADDWORKING aide à la certification administrative de l’entreprise du Prestataire. Elle l’assiste pour réunir et fournir les pièces administratives et légales nécessaires pour effectuer les Prestations de service auprès du Client. Il s’agit des attestations permettant de s’assurer que le Prestataire est régulièrement constitué et satisfait à ses obligations déclaratives et de paiement auprès des organismes sociaux notamment ceux visés à l&#39;article 3.2. ADDWORKING vérifie l&#39;authenticité desdites attestations.</p>

    <p>ADDWORKING établit et met à la disposition du Prestataire un compte entreprise personnalisé avec un suivi administratif, business, financier et juridique et réalisation de statistiques.</p>

    <h5 id="2-2-4-police-d-assurance-">2.2.4 Police d&#39;assurance :</h5>

    <p>Le Prestataire peut souscrire via ADDWORKING une police d&#39;assurance offerte à compter de la date de signature du 1er CPS3 à condition d’y être éligible selon les conditions particulières attachées au CPS3. Cette police d&#39;assurance n&#39;est valable que pour les Prestations réalisées via ADDWORKING dans le cadre de CPS3.</p>

    <h5 id="2-2-5-alertes-">2.2.5 Alertes :</h5>

    <p>En cas de situation à risque détectée, de non-conformité administrative du Prestataire ou de situation de mono clientèle détectées par ADDWORKING, cette dernière mettra tout en œuvre pour alerter le Prestataire, dans les meilleurs délais dès qu’elle en aura connaissance, de l’absence de multiplicité de missions et/ou la non-conformité administrative.</p>

    <p>Conformément à l’article 5 du présent Contrat, ADDWORKING exclut toute responsabilité pour les dommages directs ou indirects résultant de l’exécution de cette Alerte qui s’entend comme une simple obligation de moyen.</p>

    <h5 id="2-2-6-facturation-">2.2.6 Facturation :</h5>

    <p>Dans le cas où le Client a choisi l'option de Facturation proposée par ADDWORKING : ADDWORKING éditera, au nom et pour le compte du Prestataire, ses factures émises au titre du ou des CPS3, à l’attention d’ADDWORKING. La facture sera éditée au nom et pour le compte du Prestataire par ADDWORKING chaque fin de mois. Pour le Prix variable, la facture sera éditée trois (3) jours après communication à ADDWORKING par le Client du montant facturable.</p>

    <h4 id="2-3-cession-de-cr-ance-et-garantie-de-paiement">2.3 Cession de créance et garantie de paiement (dans le cas où le Client a choisi l'option de Facturation proposée par ADDWORKING)</h4>

    <h5 id="2-3-1-cession-de-cr-ance-addworking">2.3.1 Cession de créance à ADDWORKING</h5>

    <p>Le Prestataire subroge ADDWORKING dans ses droits vis-à-vis du Client en lui cédant sa créance à l’égard de cette dernière au titre du ou des CPS3, créance correspondant au « Prix total » tel que défini à l’article 3.1 dudit Contrat.</p>

    <p>En signant le CPS1, le Client a expressément accepté cette cession de créance et s’est engagé à payer le prix total convenu aux termes de l’article 3.1 de chaque CPS3 conclu avec un Prestataire entre les mains d’ADDWORKING, elle-même engagée à reverser ce prix, au Prestataire.</p>

    <h5 id="2-3-2-garantie-de-paiement-du-prix-fixe-des-prestations-effectu-es-par-le-prestataire">2.3.2 Garantie de paiement du Prix fixe des Prestations effectuées par le Prestataire</h5>

    <p>ADDWORKING s’engage, selon les modalités et délais ci-après convenus, à payer au Prestataire le Prix fixe convenu avec le Client à l’article 3.1 du CPS3 et aux conditions particulières attachées, en contrepartie de l’exécution de sa mission.</p>

    <p>ADDWORKING est donc le seul créancier du Prestataire à qui il garantit le paiement du Prix fixe des Prestations qu’il aura effectuées conformément au CPS3 conclu avec le Client, et conformément aux termes du présent Contrat.</p>

    <p>Si le Prestataire qui a commencé l’exécution de sa mission, reçoit une mise en demeure de la part d’ADDWORKING de suspendre immédiatement ses Prestations en raison du non-paiement par le Client entre les mains d’ADDWORKING de l’échéance prévue dans les délais impartis, le Prestataire est tenu de s’exécuter et d’interrompre sans délai ses Prestations.</p>

    <p>Aucun paiement n’est dû par ADDWORKING pour des Prestations effectuées par le Prestataire à la suite d’une injonction expresse adressée par ADDWORKING de les interrompre.</p>

    <p>Le Prix variable tel qu&#39;arrêté aux conditions particulières attachées au CPS3 n&#39;est pas garanti par ADDWORKING.</p>

    <h3 id="article-3-obligations-du-prestataire">Article 3 – Obligations du Prestataire</h3>

    <h4 id="3-1-paiement-d-une-commission-addworking">3.1 Paiement d’une Commission à ADDWORKING</h4>

    <p><b><em>Cas N°1 :</em></b>  <em>applicable dans le cas où le Prestataire a été référencé directement par le Client</em></p>

    <p>Lorsque la conclusion du CPS3 résulte d'un référencement direct du Prestataire par le Client, les Prestations de service fournies au Prestataire par ADDWORKING dans le cadre du présent Contrat sont gratuites.</p>

    <p><b><em>Cas N° 2 :</em></b> <em>applicable dans le cas où le Prestataire est proposé au Client par ADDWORKING</em></p>

    <p>Lorsque la conclusion du CPS3 résulte d’une mise en relation du Prestataire avec le Client par ADDWORKING, le Prestataire versera à ADDWORKING, en contrepartie des Prestations de services fournies, une Commission correspondant à 5% du Prix Total HT convenu avec le Client, précisé à l’article 3 du CPS3 conclu entre ces deux dernières parties (ci après : Commission »).</p>

    <h4 id="3-2-communication-de-documents-addworking">3.2 Communication de documents à ADDWORKING</h4>

    <p>Le Prestataire remettra à ADDWORKING, pour lui-même ainsi que pour ses AddWorkers non-salariés en mission pour le Client, à la date de signature du présent contrat et selon la fréquence prévue par la loi, notamment les documents suivants :</p>

    <ul>
        <li>une attestation de fourniture de déclarations sociales émanant de l’organisme de protection sociale chargé du recouvrement des cotisations et des contributions sociales lui incombant et datant de moins de six (6) mois appelée attestation de vigilance;</li>
        <li>un extrait de l’inscription au Registre du Commerce et des Sociétés (K ou K bis) ou un extrait d’inscription au répertoire SIRENE;</li>
        <li>un récépissé de dépôt de déclaration auprès d’un centre de formalités des entreprises pour les personnes physiques ou morales en cours d’inscription;</li>
    </ul>

    <p>ADDWORKING se réserve la possibilité de solliciter tout document complémentaire.</p>

    <p>La communication de ces documents est une condition préalable à la conclusion de tout CPS3.</p>

    <p>Le défaut de communication et/ou d&#39;authenticité desdits documents autorise ADDWORKING à résilier le présent contrat sans délai avec les conséquences visées à l&#39;article 8.2 du présent contrat.</p>

    <h4 id="3-3-obligations-g-n-rales-li-es-au-bon-fonctionnement-du-site-www-addworking-com">3.3 Obligations générales liées au bon fonctionnement du site www.addworking.com</h4>

    <p>Le Prestataire s’engage à réaliser toutes les déclarations et formalités nécessaires à son activité, ainsi qu’à satisfaire à toutes ses obligations légales, sociales, administratives et fiscales et à toutes les obligations spécifiques qui lui incombe, le cas échéant en application du droit français dont il dépend, dans le cadre de son activité et de l’utilisation du site web d&#39;ADDWORKING.</p>

    <p>En cas de demande, le Prestataire s’engage à fournir, sans délai, à ADDWORKING tout justificatif prouvant qu’il remplit les conditions énoncées dans le présent article.</p>

    <p>Le Prestataire et ses AddWorkers s&#39;engagent en outre à répondre dans un délai de 48 heures à toute demande d&#39;information d&#39;ADDWORKING et à compléter tout questionnaire de suivi remis par ADDWORKING dans le même délai, le non respect de ces obligations étant susceptible d&#39;être sanctionné dans les conditions visées à l&#39;article 8.2.3 du présent contrat.</p>

    <h3 id="article-4-proc-dure-de-facturation-modalit-s-et-d-lais-de-paiement-du-prestataire">Article 4 – Procédure de facturation, modalités et délais de paiement du Prestataire (dans le cas où le Client a choisi l'option de Facturation proposée par ADDWORKING)</h3>

    <h4 id="4-1-paiement-du-prix-fixe-minor-de-l-ventuelle-commission">4.1 Paiement du Prix fixe minoré de l&#39;éventuelle Commission</h4>

    <p>Lorsqu’une Provision est convenue aux conditions particulières au CPS3, les paiements des échéances mensuelles à concurrence du pourcentage de la mission effectuée (conformément aux conditions particulières attachées au CPS3) diminué de l&#39;éventuelle Commission s’effectueront dans un délai de cinq (5) jours ouvrables suivant le dernier jour calendaire du mois civil. A défaut de Provision convenue aux conditions particulières au CPS3, le délai de paiement au Prestataire est de cinq (5) jours ouvrables suivant le paiement du Prix par le Client à ADDWORKING.</p>

    <p>Le démarrage des Prestations est conditionné au versement par le Client à ADDWORKING de la Provision, convenue, le cas-échéant, à l&#39;article 3.2 du CPS3 et aux conditions particulières attachées et ne pourra pas intervenir avant d’avoir reçu l’email confirmant la réception de la Provision par ADDWORKING, conformément à l’article 2.2 du CPS3.</p>

    <p>Le paiement de la Provision par le Client à ADDWORKING est une condition essentielle du CPS3 dont la non réception par ADDWORKING dans le délai précisé aux conditions particulières attachées au CPS3 précédant le début des Prestations entraine, sauf CPS3 et paiement afférent urgents expressément autorisés par ADDWORKING, la résolution rétroactive de plein de droit dudit contrat.</p>

    <p>Pour les CPS3 dont la durée est inférieure à un (1) mois, le montant de la Provision correspond au montant total du Prix fixe convenu.</p>

    <p>Dans ce cas, ADDWORKING paiera le Prestataire du montant du Prix fixe convenu, déduction faite du montant de la Commission due à ADDWORKING, dans un délai maximum de 5 jours ouvrables suivant la fin de la mission.</p>

    <h4 id="4-2-paiement-du-prix-variable-minor-de-la-commission">4.2 Paiement du Prix variable minoré de l&#39;éventuelle Commission</h4>

    <p>ADDWORKING paiera le Prestataire du montant du Prix variable, diminué de l&#39;éventuelle Commission, convenu aux conditions particulières attachées au CPS3, dans un délai maximum de 5 jours ouvrables suivant le paiement effectué par le Client.</p>

    <h3 id="article-5-responsabilit-exclusion-et-limitation">Article 5 – Responsabilité - exclusion et limitation</h3>

    <h4 id="5-1">5.1</h4>

    <p>Chaque Partie assume sa propre et entière responsabilité civile et commerciale envers les dommages causés directement ou indirectement par ses matériels et/ou son personnel aux tiers.</p>

    <h4 id="5-2">5.2</h4>

    <p>ADDWORKING ne pourra nullement être tenue responsable du fait des conséquences directes ou indirectes de l’exécution, de l’inexécution ou de la mauvaise exécution du CPS3 entre le Client et le Prestataire</p>

    <p>De plus, ADDWORKING se dégage de toute responsabilité en cas de requalification en contrat de travail et/ou de poursuites pour travail illégal, pour quelque cause que ce soit dès lors que les Alertes prévues à l’article 2.2.4 du Présent Contrat ont été adressées au Prestataire.</p>

    <h4 id="5-3">5.3</h4>

    <p>La responsabilité d’ADDWORKING sera limitée aux dommages matériels directs causés au Prestataire qui résulteraient de fautes directement imputables à ADDWORKING dans l’exécution du contrat. ADDWORKING n’est pas tenue de réparer les conséquences dommageables des fautes commises par le Prestataire ou le Client ou des tiers, en rapport avec l’exécution du contrat. En aucune circonstance, ADDWORKING ne sera tenue d’indemniser les dommages immatériels ou indirects, et notamment les pertes d’exploitation, de profit, d’une chance, préjudice commercial, manque à gagner. La responsabilité civile d’ADDWORKING, toutes causes confondues à l’exception des dommages corporels et de la faute lourde, est limitée à une somme plafonnée à la valeur facturée et encaissée par celle-ci au titre des Commissions prévues au présent Contrat.</p>

    <h3 id="article-6-confidentialit-">Article 6 – Confidentialité</h3>

    <p>Tant pendant la durée du présent contrat que deux (2) ans après sa cessation, les informations, données et documents de toute nature (commerciaux, financiers, techniques, industriels, etc.) des Parties, et notamment celles relatives aux activités, savoir-faire, secrets de fabrication ou secrets d’affaires, communiqués à l’occasion de leurs relations précontractuelles ou de l’exécution du présent contrat, ou dont leurs salariés, mandataires ou collaborateurs auraient eu connaissance, sont strictement confidentiels (ci-après dénommées les « Informations Confidentielles »), quelles qu’en soient leur forme, à l’exclusion de celles qui étaient notoirement et publiquement divulguées ou déjà connues, à charge pour la Partie destinataire d’en apporter la preuve.</p>

    <p>En conséquence, chaque Partie s’engage expressément à :</p>

    <ul>
        <li>respecter le caractère confidentiel des Informations Confidentielles et à prendre toutes mesures utiles pour empêcher la divulgation, directe ou indirecte, à toute personne autre que celles qui en ont impérativement et directement besoin aux fins du présent contrat, sauf autorisation écrite et préalable de l’autre Partie;</li>
        <li>faire respecter par leurs salariés, mandataires sociaux et collaborateurs les termes de la présente clause;</li>
        <li>détruire ou, sur demande expresse de la partie propriétaire des informations, lui restituer, dans un délai de trente (30) jours calendaires après la cessation du présent contrat, l’ensemble de ces Informations Confidentielles.</li>
    </ul>

    <h3 id="article-7-dur-e-du-contrat">Article 7 – Durée du contrat</h3>

    <p>Le présent contrat est conclu à durée indéterminée. Il entre en vigueur à la date de sa signature et reste pleinement applicable tant que le Prestataire fournit des Prestations au Client, et dans le cadre de la conclusion par celui-ci de tout CPS3 avec le Client visée au présent contrat via ADDWORKING.</p>

    <h3 id="article-8-r-siliation-du-contrat">Article 8 – Résiliation du Contrat</h3>

    <h4 id="8-1-r-siliation-ordinaire">8.1 Résiliation ordinaire</h4>

    <p>Pour quelque motif que ce soit, chacune des parties est en droit de mettre un terme au présent Contrat en respectant un préavis qui ne saurait être inférieur à 3 mois.
    La résiliation doit être notifiée à l’autre partie par email avec accusé de réception.
    Une telle résiliation ne peut pas avoir lieu pendant qu’un ou plusieurs CPS3 entre le Client et le Prestataire est/sont en cours d’exécution. Ce n’est qu’à l’issue du dernier CPS3 en cours que la notification de la résiliation avec un préavis minimum de trois mois peut avoir lieu.</p>

    <h4 id="8-2-r-siliation-imm-diate">8.2 Résiliation immédiate</h4>

    <p>Le défaut de réponse aux Alertes, demandes d&#39;informations formulées ou questionnaires transmis par ADDWORKING est susceptible d&#39;entrainer la résiliation immédiate du présent contrat assortie d’une pénalité à charge du Prestataire correspondant à 50% du Prix des Prestations effectuées dont 35% reversé au Client et 15% conservé par ADDWORKING.
    Les mises en relation répétées par ADDWORKING du Prestataire avec des Clients non suivies d&#39;un CPS3 et de manière générale l&#39;utilisation abusive des services d&#39;ADDWORKING par le Prestataire pour contracter directement avec des Clients sont également susceptibles d&#39;entrainer la résiliation immédiate du présent contrat.</p>

    <h4 id="8-3-effets-de-la-r-siliation">8.3 Effets de la Résiliation</h4>

    <p>A la date d’effet de la résiliation, ADDWORKING supprimera de sa plateforme web www.addworking.com toute information, mention, référence du Prestataire. Celui-ci ne pourra donc plus être visible par les Clients ni accéder à son compte qui sera fermé.</p>

    <div style="page-break-after: always;"></div>

    <h3 id="article-9-dispositions-diverses">Article 9 – Dispositions diverses</h3>

    <h4 id="9-1-informatique-et-libert-s">9.1 Informatique et libertés</h4>

    <p>Les informations collectées sur le site feront l&#39;objet d&#39;un traitement informatisé.
    Elles sont essentiellement utilisées par ADDWORKING à des fins de gestion et de traitement des commandes et de prospection commerciale. Conformément aux dispositions de la loi du 6 janvier 1978 relative à l&#39;informatique, aux fichiers et aux libertés, le Prestataire bénéficie d&#39;un droit d&#39;accès, de rectification, d&#39;opposition et de suppression sur ses données personnelles.</p>

    <p>Ces droits peuvent être exercés par une modification directement en ligne ou en s&#39;adressant à :
    ADDWORKING, Service Réclamation, à l’adresse figurant dans les conditions générales d’utilisation du site www.addworking.com.</p>

    <h4 id="9-2">9.2</h4>

    <p>Le présent contrat bénéficie et lie les Parties, leurs successeurs et ayants droit.</p>

    <h4 id="9-3">9.3</h4>

    <p>Dans l’hypothèse où une disposition du présent contrat serait considérée comme nulle, invalide ou inapplicable, par une loi, un règlement ou une décision de justice définitive, elle sera réputée non écrite et les autres dispositions du présent contrat garderont toute leur force et leur portée. Les Parties s’efforceront dans un délai de d&#39;un (1) mois, à compter de l’évènement ayant entraîné la nullité, l’invalidité ou l’inapplicabilité de la clause, de s’accorder sur les termes d’une clause de remplacement équitable tout en respectant l’esprit et l’économie actuelle du présent contrat.</p>

    <h4 id="9-4">9.4</h4>

    <p>Le fait pour l’une des Parties de ne pas se prévaloir ou de tarder à se prévaloir de l’application d’une disposition du présent contrat ne saurait être interprété comme une renonciation à se prévaloir de cette disposition à l’avenir.</p>

    <h4 id="9-5">9.5</h4>

    <p>Pour les besoins de l’exécution du présent contrat, chacune des Parties fait élection de domicile à son adresse figurant en tête du présent contrat ou à toute autre adresse qu’elle notifierait par écrit à l’autre Partie.</p>

    <h4 id="9-6">9.6</h4>

    <p>Le présent contrat est rédigé en langue française.</p>

    <h3 id="article-10-loi-applicable-et-r-glement-des-litiges">Article 10 – Loi applicable et règlement des litiges</h3>

    <h4 id="10-1">10.1</h4>

    <p>Le présent Contrat est soumis au droit français.</p>

    <h4 id="10-2">10.2</h4>

    <p>Les Parties tenteront d’abord de régler amiablement tout différend relatif à l&#39;interprétation et/ou à l&#39;exécution du Contrat. La Partie la plus diligente soumettra le différend, par lettre recommandée avec demande d&#39;avis de réception visant le présent article à l’autre Partie. Les deux Parties se réuniront afin de trouver une solution amiable dans le délai de trente (30) jours suivant la notification de leur différend.</p>

    <h4 id="10-3">10.3</h4>

    <p>Dans le cas où aucun accord amiable n’aurait pu être trouvé dans un de trente (30) jours à compter de la notification du différend par la Partie la plus diligente, celui-ci sera porté devant les Tribunaux de Paris, nonobstant pluralité de défendeurs, intervention forcée, notamment appel en garantie. Cette attribution de compétence s&#39;applique également en matière de référé.</p>

    <div style="page-break-after: always;"></div>

    <h2 id="la-charte-des-bonnes-pratiques-addworking">LA CHARTE DES BONNES PRATIQUES ADDWORKING</h2>

    <p><em>ADDWORKING sécurise la gestion de la relation contractuelle entre les Clients et les Prestataires via sa plateforme web originale (www.addworking.com). Elle propose à chacun d’entre eux une série de Prestations de service notamment pour faciliter leur gestion financière, alléger leur charge administrative et réduire leurs risques juridiques.</em></p>

    <p><em>Cette charte a vocation à s’appliquer à toute Prestation de service entre les Clients et  les Prestataires, dont la gestion contractuelle, administrative et financière est confiée à ADDWORKING.</em></p>

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
