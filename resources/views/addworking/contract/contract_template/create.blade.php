@extends('foundation::layout.app.create', ['action' => $contract_template->routes->store])

@section('title', __('addworking.contract.contract_template.create.create_contract_template'))

@section('toolbar')
    @button(__('addworking.contract.contract_template.create.return')."|href:{$contract_template->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    {{ $contract_template->routes->create(['page' => "create"]) }}
@endsection

@section('form')
    {{ $contract_template->views->form }}

    @button(__('addworking.contract.contract_template.create.create')."|icon:save|type:submit")
@endsection
