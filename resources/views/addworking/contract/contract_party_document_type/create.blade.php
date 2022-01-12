@extends('foundation::layout.app.create', ['action' => $contract_party_document_type->routes->store])

@section('title', __('addworking.contract.contract_party_document_type.create.add_required_document'))

@section('toolbar')
    @button(__('addworking.contract.contract_party_document_type.create.return')."|href:{$contract_party_document_type->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
    @can('index', App\Models\Addworking\Enterprise\DocumentType::class)
        @button(__('addworking.contract.contract_party_document_type.create.types_of_document')."|href:{$contract_party_document_type->contractParty->contract->enterprise->documentTypes()->make()->routes->index}|icon:external-link-alt|color:secondary|outline|sm")
    @endcan
@endsection

@section('breadcrumb')
    {{ $contract_party_document_type->views->breadcrumb(['page' => "create"])}}
@endsection

@section('form')
    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('info') {{ __('addworking.contract.contract_party_document_type.create.type_of_document') }}</legend>

        @form_group([
            'text' => __('addworking.contract.contract_party_document_type.create.type_of_document'),
            'type' => "select",
            'name' => "contract_party_document_type.document_type",
            'value' => optional($contract_party_document_type->documentType)->id,
            'options' => Repository::contractPartyDocumentType()
                ->getAvailableDocumentTypes($contract_party_document_type)
                ->pluck('display_name', 'id')
                ->sort(),
            'required' => true,
            'selectpicker' => true,
            'search' => true,
        ])
    </fieldset>

    {{ $contract_party_document_type->views->form }}

    @button(__('addworking.contract.contract_party_document_type.create.create')."|icon:save|type:submit")
@endsection
