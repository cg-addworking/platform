@extends('foundation::layout.app.show')

@section('title', "{$contract_template_variable}")

@section('toolbar')
    @button(__('addworking.contract.contract_template_variable.show.return')."|href:{$contract_template_variable->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
    {{ $contract_template_variable->views->actions }}
@endsection

@section('breadcrumb')
    {{ $contract_template_variable->views->breadcrumb(['page' => "show"]) }}
@endsection

@section('content')
    {{ $contract_template_variable->views->html }}
@endsection
