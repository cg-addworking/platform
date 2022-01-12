@extends('layouts.app')

@section('id', 'customer-contact')

@section('content')
<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-10" style="font-size: 17px;">
                    <h1>Bienvenue chez ADDWORKING !</h1>
                    <p>
                        Votre entreprise est confrontée à la gestion d’indépendants, de prestataires ou de sous-traitants ?
                    </p>
                    <ol>
                        <li>Vous souhaitez réduire vos coûts en digitalisant l’ensemble des processus entre vos ressources non-salariées et votre entreprise ?</li>
                        <li>Vous souhaitez réduire vos risques juridiques, tel que le travail illégal ou encore le risque de requalification ?</li>
                    </ol>
                    <p>
                        Nous mettons à votre disposition notre plateforme « Ready To Work » permettant de réduire vos coûts de gestion d’au moins 30%, de supprimer votre risque de travail illégal et de réduire considérablement votre risque de requalification.
                    </p>
                    <p>
                        Afin de vous réserver un accueil personnalisé, nous vous offrons 2 possibilités pour vous présenter en détail notre solution :
                    </p>
                    <ul>
                        <li>Vous nous proposez un créneau d’appel téléphonique à <a href="mailto:patrick@addworking.com">patrick@addworking.com</a></li>
                        <li>Vous pouvez nous contacter directement au <b>01 85 09 60 60</b> : Océane, Patrick ou Julien.</li>
                    </ul>
                    <p>
                        A très vite !<br>
                        L’équipe ADDWORKING
                    </p>

                    <a href="https://www.linkedin.com/company/9245276/" target="_blank">
                        <i class="fa fa-linkedin-square fa-3x" aria-hidden="true"></i>
                    </a>
                    <a href="https://fr-fr.facebook.com/addworking.fr/" target="_blank">
                        <i class="fa fa-facebook-official fa-3x" aria-hidden="true"></i>
                    </a>
                    <a href="https://twitter.com/addworking" target="_blank">
                        <i class="fa fa-twitter-square fa-3x" aria-hidden="true"></i>
                    </a>
                    <br>
                    <a href="http://www.parisandco.paris/" target="_blank">
                        <img src="{{ asset('img/cartouche_paris_and_co.png') }}" alt="Paris&Co" style="width: 10%">
                    </a>
                    <a href="http://www.sncf-developpement.fr" target="_blank">
                        <img src="{{ asset('img/logo_entrepreneur_soutenu_sncf.png') }}" alt="SNCF" style="width: 14%">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection