@extends('foundation::layout.app.create', ['action' => $contract_variable->routes->store])

@section('title', __('addworking.contract.contract_variable.create.add_variable'))

@section('toolbar')
    @button(__('addworking.contract.contract_variable.create.return')."|href:{$contract_variable->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    {{ $contract_variable->views->breadcrumb(['page' => "create"]) }}
@endsection

@section('form')
    {{ $contract_variable->views->form }}

    @button(__('addworking.contract.contract_variable.create.create')."|icon:save|type:submit")
@endsection
