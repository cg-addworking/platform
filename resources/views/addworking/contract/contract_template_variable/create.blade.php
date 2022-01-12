@extends('foundation::layout.app.create', ['action' => $contract_template_variable->routes->store])

@section('title', __('addworking.contract.contract_template_variable.create.add_variable'))

@section('toolbar')
    @button(__('addworking.contract.contract_template_variable.create.return')."|href:{$contract_template_variable->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    {{ $contract_template_variable->views->breadcrumb(['page' => "create"]) }}
@endsection

@section('form')
    {{ $contract_template_variable->views->form }}

    @button(__('addworking.contract.contract_template_variable.create.create')."|icon:save|type:submit")
@endsection
