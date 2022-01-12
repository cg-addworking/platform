@extends('foundation::layout.app.create', ['action' => $contract_party_document_type->routes->attach_new_document_post, 'enctype' => "multipart/form-data"])

@section('title', __('addworking.contract.contract_party_document_type.attach_new_document.associate_document'))

@section('toolbar')
    @button(__('addworking.contract.contract_party_document_type.attach_new_document.return')."|href:{$contract_party_document_type->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    {{ $contract_party_document_type->views->breadcrumb(['page' => "attach-document"])}}
@endsection

@section('form')
    @form_group([
        'text'  => __('addworking.contract.contract_party_document_type.attach_new_document.document'),
        'type'  => "file",
        'name'  => "contract_party_document_type.document",
        'required' => true,
    ])

    @button(__('addworking.contract.contract_party_document_type.attach_new_document.create_and_associate')."|icon:link|type:submit")
@endsection
