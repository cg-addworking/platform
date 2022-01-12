@extends('foundation::layout.app.show')

@section('title', "{$contract_variable}")

@section('toolbar')
    @button(__('addworking.contract.contract_variable.show.return')."|href:{$contract_variable->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
    {{ $contract_variable->views->actions }}
@endsection

@section('breadcrumb')
    {{ $contract_variable->views->breadcrumb(['page' => "show"]) }}
@endsection

@section('content')
    {{ $contract_variable->views->html }}
@endsection
