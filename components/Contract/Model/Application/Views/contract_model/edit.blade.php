@extends('foundation::layout.app.edit', ['action' => route('support.contract.model.update', $contract_model)])

@section('title', __('components.contract.model.application.views.contract_model.edit.title', ["number" => $contract_model->getNumber()]))

@section('toolbar')
    @button("Retour|href:".route('support.contract.model.show', $contract_model)."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('contract_model::contract_model._breadcrumb', ['page' => "edit"])
@endsection

@section('form')
    @include('contract_model::contract_model._form')

    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('handshake') {{ __('components.contract.model.application.views.contract_model.create.parties') }}</legend>

        @foreach($contract_model->getParties() as $contract_model_party)
            <input type="hidden" name="contract_model[parties][{{$contract_model_party->getId()}}]" value="{{$contract_model_party->getId()}}">
            @form_group([
                'text'        => __('components.contract.model.application.views.contract_model.edit.party', ['number' => $contract_model_party->getOrder()]),
                'type'        => "text",
                'name'        => "contract_model.parties.{$contract_model_party->getId()}",
                'value'        => optional($contract_model_party)->getDenomination(),
                'required'    => true,
            ])
        @endforeach
    </fieldset>

    @button(__('components.contract.model.application.views.contract_model.edit.edit')."|type:submit|color:success|shadow|icon:check")
@endsection



