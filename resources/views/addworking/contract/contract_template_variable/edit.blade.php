@extends('foundation::layout.app.edit', ['action' => $contract_template_variable->routes->update])

@section('title', __('addworking.contract.contract_template_variable.edit.edit'))

@section('toolbar')
    @button(__('addworking.contract.contract_template_variable.edit.return')."|href:{$contract_template_variable->routes->show}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    {{ $contract_template_variable->views->breadcrumb(['page' => "edit"]) }}
@endsection

@section('form')
    {{ $contract_template_variable->views->form }}

    @button(__('addworking.contract.contract_template_variable.edit.register')."|icon:save|type:submit")
@endsection
