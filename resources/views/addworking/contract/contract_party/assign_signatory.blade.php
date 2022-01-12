@extends('foundation::layout.app.edit', ['action' => $contract_party->routes->assign_signatory_put])

@section('title', __('addworking.contract.contract_party.assign_signatory.edit'))

@section('toolbar')
    @button(__('addworking.contract.contract_party.assign_signatory.return')."|href:{$contract_party->routes->show}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    {{ $contract_party->views->breadcrumb(['page' => "edit"]) }}
@endsection

@section('form')
    {{ $contract_party->views->assign_signatory }}

    @button(__('addworking.contract.contract_party.assign_signatory.assign')."|icon:save|type:submit")
@endsection
