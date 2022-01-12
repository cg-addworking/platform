@extends('foundation::layout.app.edit', ['action' => $contract_annex->routes->update])

@section('title', __('addworking.contract.contract_annex.edit.edit'))

@section('toolbar')
    @button(__('addworking.contract.contract_annex.edit.return')."|href:{$contract_annex->routes->show}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    {{ $contract_annex->view->breadcrumb(['page' => "edit"]) }}
@endsection

@section('form')
    {{ $contract_annex->views->form }}

    @button(__('addworking.contract.contract_annex.edit.register')."|icon:save|type:submit")
@endsection
