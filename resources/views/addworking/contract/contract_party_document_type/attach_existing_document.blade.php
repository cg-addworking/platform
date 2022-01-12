@extends('foundation::layout.app.create', ['action' => $contract_party_document_type->routes->attach_existing_document_post])

@section('title', __('addworking.contract.contract_party_document_type.attach_existing_document.associate_document'))

@section('toolbar')
    @button(__('addworking.contract.contract_party_document_type.attach_existing_document.return')."|href:{$contract_party_document_type->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    {{ $contract_party_document_type->views->breadcrumb(['page' => "attach-document"])}}
@endsection

@section('form')
    @form_group([
        'text'  => __('addworking.contract.contract_party_document_type.attach_existing_document.document'),
        'type'  => "select",
        'name'  => "contract_party_document_type.document",
        'value' =>  optional(Repository::contractPartyDocumentType()->getDocument($contract_party_document_type))->id,
        'options' => Repository::contractPartyDocumentType()
            ->getAvailableDocuments($contract_party_document_type)
            ->mapWithKeys(fn($doc) => [$doc->id => "{$doc->created_at->format('Y-m-d')} {$doc->documentType->name}"]),
        'required' => true,
    ])

    @button(__('addworking.contract.contract_party_document_type.attach_existing_document.associate')."|icon:link|type:submit")
@endsection
