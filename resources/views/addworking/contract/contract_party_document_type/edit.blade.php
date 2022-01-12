@extends('foundation::layout.app.edit', ['action' => $contract_party_document_type->routes->update])

@section('title', __('addworking.contract.contract_party_document_type.edit.edit'))

@section('toolbar')
    @button(__('addworking.contract.contract_party_document_type.edit.return')."|href:{$contract_party_document_type->routes->show}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    {{ $contract_party_document_type->views->breadcrumb(['page' => "edit"]) }}
@endsection

@section('form')
    {{ $contract_party_document_type->views->form }}

    @button(__('addworking.contract.contract_party_document_type.edit.register')."|icon:save|type:submit")
@endsection
