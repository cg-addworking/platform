@extends('foundation::layout.app.edit', ['action' => $contract_party->routes->update])

@section('title', __('addworking.contract.contract_party.edit.edit'))

@section('toolbar')
    @button(__('addworking.contract.contract_party.edit.return')."|href:{$contract_party->routes->show}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    {{ $contract_party->views->breadcrumb(['page' => "edit"]) }}
@endsection

@section('form')
    {{ $contract_party->views->form }}

    @button(__('addworking.contract.contract_party.edit.register')."|icon:save|type:submit")
@endsection
