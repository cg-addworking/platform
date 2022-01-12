@extends('foundation::layout.app.create', ['action' => route('addworking.billing.payment_order.store', $enterprise)])

@section('title', "Créer un ordre de paiement")

@section('toolbar')
    @button("Retour|href:".route('addworking.billing.payment_order.index', $enterprise)."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('payment_order::payment_order._breadcrumb', ['page' => "create"])
@endsection

@section('form')
    <fieldset>
        <div class="row">
            <div class="col-md-12">
                @include('payment_order::payment_order._form')
            </div>
        </div>
    </fieldset>
    <div class="text-right my-5">
        @button("Créer l'ordre de paiement|type:submit|color:success|shadow|icon:check")
    </div>
@endsection