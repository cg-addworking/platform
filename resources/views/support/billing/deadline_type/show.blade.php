@extends('foundation::layout.app.show')

@section('title', $deadline_type->display_name)

@section('toolbar')
    @button("Retour|href:{$deadline_type->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
    {{ $deadline_type->views->actions }}
@endsection

@section('breadcrumb')
    @breadcrumb_item('Support|href:'.route('dashboard'))
    @breadcrumb_item("Échéance de paiement|href:{$deadline_type->routes->index}")
    @breadcrumb_item("{$deadline_type->display_name}|active")
@endsection

@section('content')
    {{ $deadline_type->views->html }}
@endsection
