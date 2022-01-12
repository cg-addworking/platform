@extends('foundation::layout.app.show')

@section('title', "{$contract_party}")

@section('toolbar')
    @button(__('addworking.contract.contract_party.show.return')."|href:{$contract_party->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
    {{ $contract_party->views->actions }}
@endsection

@section('breadcrumb')
    {{ $contract_party->views->breadcrumb(['page' => "show"]) }}
@endsection

@section('content')
    {{ $contract_party->views->html }}
@endsection
