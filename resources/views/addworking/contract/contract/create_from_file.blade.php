@extends('foundation::layout.app.create', ['action' => $contract->routes->createFromExistingFilePost, 'enctype' => "multipart/form-data"])

@section('title', __('addworking.contract.contract.create_from_file.create_contract'))

@section('toolbar')
    @button(__('addworking.contract.contract.create_from_file.return')."|href:{$contract->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    {{ $contract->views->breadcrumb(['page' => "create"]) }}
@endsection

@section('form')
    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('file') {{ __('addworking.contract.contract.create_from_file.contract') }}</legend>

        @form_group([
            'type'     => "file",
            'name'     => "contract.file",
            'text'     => __('addworking.contract.contract.create_from_file.contract'),
            'required' => true,
        ])
    </fieldset>

    {{ $contract->views->form }}

    @button(__('addworking.contract.contract.create_from_file.create')."|icon:save|type:submit")
@endsection
