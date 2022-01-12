@extends('foundation::layout.app.edit', ['action' => $contract_template->routes->update])

@section('title', __('addworking.contract.contract_template.edit.edit'))

@section('toolbar')
    @button(__('addworking.contract.contract_template.edit.return')."|href:{$contract_template->routes->show}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    {{ $contract_template->views->breadcrumb(['page' => "edit"]) }}
@endsection

@section('form')
    {{ $contract_template->views->form }}

    @button(__('addworking.contract.contract_template.edit.register')."|icon:save|type:submit")
@endsection
