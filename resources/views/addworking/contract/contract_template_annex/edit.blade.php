@extends('foundation::layout.app.edit', ['action' => $contract_template_annex->routes->update])

@section('title', __('addworking.contract.contract_template_annex.edit.edit'))

@section('toolbar')
    @button(__('addworking.contract.contract_template_annex.edit.return')."|href:{$contract_template_annex->routes->show}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    {{ $contract_template_annex->views->breadcrumb(['page' => "edit"]) }}
@endsection

@section('form')
    {{ $contract_template_annex->views->form }}

    @button("Enregistrer|icon:save|type:submit")
@endsection
