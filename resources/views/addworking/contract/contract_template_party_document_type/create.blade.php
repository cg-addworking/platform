@extends('foundation::layout.app.create', ['action' => $contract_template_party_document_type->routes->store])

@section('title', __('addworking.contract.contract_template_party_document_type.create.add_document_to_provide'))

@section('toolbar')
    @button(__('addworking.contract.contract_template_party_document_type.create.return')."|href:{$contract_template_party_document_type->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    {{ $contract_template_party_document_type->views->breadcrumb(['page' => "create"]) }}
@endsection

@section('form')
    @include("addworking.contract.contract_template_party_document_type._form")

    @button(__('addworking.contract.contract_template_party_document_type.create.create')."|icon:save|type:submit")
@endsection
