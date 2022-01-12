@extends('foundation::layout.app.edit', ['action' => $contract->routes->update, 'enctype' => "multipart/form-data"])

@section('title', __('addworking.contract.contract.edit.edit'))

@section('toolbar')
    @button(__('addworking.contract.contract.edit.return')."|href:{$contract->routes->show}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    {{ $contract->views->breadcrumb(['page' => "edit"]) }}
@endsection

@section('form')
    @can('updateStatus', $contract)
        <fieldset class="mt-5 pt-2">
            <legend class="text-primary h5">@icon('list-alt') {{ __('addworking.contract.contract.edit.status') }}</legend>

            @form_group([
                'text' => __('addworking.contract.contract.edit.status'),
                'type' => "select",
                'name' => "contract.status",
                'value' => $contract->status,
                'options' => array_map('ucfirst', Repository::contract()->getAvailableStatuses($contract, true)),
                'required' => true,
            ])
        </fieldset>
    @endcan

    @can('updateFile', $contract)
        <fieldset class="mt-5 pt-2">
            <legend class="text-primary h5">@icon('file') {{ __('addworking.contract.contract.edit.contract') }}</legend>

            @form_group([
                'type'     => "file",
                'name'     => "contract.file",
                'text'     => __('addworking.contract.contract.edit.contract'),
            ])
        </fieldset>
    @endcan

    {{ $contract->views->form }}

    @button(__('addworking.contract.contract.edit.register')."|icon:save|type:submit")
@endsection
