@extends('foundation::layout.app.edit', ['action' => $vat_rate->routes->update])

@section('title', "Modifier $vat_rate")

@section('toolbar')
    @button("Retour|href:{$vat_rate->routes->show}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
    <li class="breadcrumb-item"><a href="{{ $vat_rate->routes->index }}">Taux TVA</a></li>
    <li class="breadcrumb-item"><a href="{{ $vat_rate->routes->show }}">{{ $vat_rate->display_name }}</a></li>
    <li class="breadcrumb-item active">Modifier</li>
@endsection

@section('form')
    {{ $vat_rate->views->form }}

    @button("Enregistrer|icon:save|type:submit")
@endsection
