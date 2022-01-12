@extends('foundation::layout.app.create', ['action' => $vat_rate->routes->store])

@section('title', "Créer un taux de TVA")

@section('toolbar')
    @button("Retour|href:{$vat_rate->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
    <li class="breadcrumb-item"><a href="{{ $vat_rate->routes->index }}">Taux TVA</a></li>
    <li class="breadcrumb-item">Taux TVA</li>
    <li class="breadcrumb-item active">Créer</li>
@endsection

@section('form')
    {{ $vat_rate->views->form }}

    @button("Créer|icon:save|type:submit")
@endsection
