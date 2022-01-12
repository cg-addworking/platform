@extends('foundation::layout.app.create', ['action' => $contract_addendum->routes->store_addendum(['contract' => $contract_addendum->parent]), 'enctype' => "multipart/form-data"])

@section('title', "Créer un avenant")

@section('toolbar')
    @button("Retour|href:{$contract_addendum->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    {{ $contract_addendum->views->breadcrumb(['page' => "create"]) }}
@endsection

@section('form')
    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('file') Contrat</legend>

        @form_group([
            'type'     => "file",
            'name'     => "contract.file",
            'text'     => "Contrat",
            'required' => true,
        ])
    </fieldset>

    {{ $contract_addendum->views->form }}

    @button("Créer|icon:save|type:submit")
@endsection
