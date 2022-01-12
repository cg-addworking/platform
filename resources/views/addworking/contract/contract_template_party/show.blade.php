@extends('foundation::layout.app.show')

@section('title', "{$contract_template_party}")

@section('toolbar')
    @button(__('addworking.contract.contract_template_party.show.return')."|href:{$contract_template_party->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
    {{ $contract_template_party->views->actions }}
@endsection

@section('breadcrumb')
    {{ $contract_template_party->views->breadcrumb(['page' => "show"]) }}
@endsection

@section('content')
    {{ $contract_template_party->views->html }}
@endsection
