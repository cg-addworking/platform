@extends('foundation::layout.app.create', ['action' => route('support.contract.model.party.document_type.store_specific_document', ['contract_model' => $contract_model, 'contract_model_party' => $contract_model_party]), 'enctype' => "multipart/form-data"])

@section('title', __('components.contract.model.application.views.contract_model_document_type.create_specific_document.title', ['number' => $contract_model_party->getOrder(), 'denomination' => $contract_model_party->getDenomination()]))

@section('toolbar')
    @button(__('components.contract.model.application.views.contract_model_document_type.create_specific_document.return')."|href:".route('support.contract.model.party.document_type.index', [$contract_model, $contract_model_party])."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('contract_model::contract_model_document_type._breadcrumb', ['page' => "create"])
@endsection

@section('form')

    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('info') {{ __('components.contract.model.application.views.contract_model_document_type.create_specific_document.general_information') }}</legend>

        @form_group([
            'text'        => __('components.contract.model.application.views.contract_model_document_type.create_specific_document.display_name'),
            'type'        => "text",
            'name'        => "contract_model_document_type.display_name",
            'required'    => true,
        ])

        @form_group([
            'text'        => __('components.contract.model.application.views.contract_model_document_type.create_specific_document.description'),
            'type'        => "textarea",
            'name'        => "contract_model_document_type.description",
        ])

        @form_group([
            'text'        => __('components.contract.model.application.views.contract_model_document_type.create_specific_document.validation_required'),
            'type'        => "select",
            'options'      => [0 => "Non" , 1 => "Oui"],
            'name'        => "contract_model_document_type.validation_required",
            'required'    => true,
        ])

        <div class="form-group mb-3" id="div-file">
            @form_group([
                'type'        => "file",
                'name'        => "contract_model_document_type.document_model",
                'text'        => __('components.contract.model.application.views.contract_model_part._form.file'),
            ])
        </div>

        @button(__('components.contract.model.application.views.contract_model_document_type.create_specific_document.create')."|type:submit|color:success|shadow|icon:check")
    </fieldset>
@endsection
