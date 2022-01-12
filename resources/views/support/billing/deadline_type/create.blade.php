@extends('foundation::layout.app.create', ['action' => $deadline_type->routes->store])

@section('title', "Créer uen échéance de paiement")

@section('toolbar')
    @button("Retour|href:{$deadline_type->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @breadcrumb_item('Support|href:'.route('dashboard'))
    @breadcrumb_item("Échéance de paiement|href:{$deadline_type->routes->index}")
    @breadcrumb_item("Créer|active")
@endsection

@section('form')
    {{ $deadline_type->views->form }}

    @button("Créer|icon:save|type:submit")
@endsection
