@extends('foundation::layout.app.edit', ['action' => $deadline_type->routes->update])

@section('title', "Modifier {$deadline_type->display_name}")

@section('toolbar')
    @button("Retour|href:{$deadline_type->routes->show}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @breadcrumb_item('Support|href:'.route('dashboard'))
    @breadcrumb_item("Échéance de paiement|href:{$deadline_type->routes->index}")
    @breadcrumb_item("{$deadline_type->display_name}|href:{$deadline_type->routes->show}")
    @breadcrumb_item("Modifier|active")
@endsection

@section('form')
    {{ $deadline_type->views->form }}

    @button("Enregistrer|icon:save|type:submit")
@endsection
