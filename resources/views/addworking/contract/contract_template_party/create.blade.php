@extends('foundation::layout.app.create', ['action' => $contract_template_party->routes->store])

@section('title', __('addworking.contract.contract_template_party.create.add_stakeholder'))

@section('toolbar')
    @button(__('addworking.contract.contract_template_party.create.return')."|href:{$contract_template_party->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    {{ $contract_template_party->views->breadcrumb(['page' => "create"]) }}
@endsection

@section('form')
    {{ $contract_template_party->views->form }}

    @button(__('addworking.contract.contract_template_party.create.create')."|icon:save|type:submit")
@endsection
