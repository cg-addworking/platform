@extends('foundation::layout.app.edit', ['action' => $contract_document->routes->update])

@section('title', __('addworking.contract.contract_document.edit.edit'))

@section('toolbar')
    @button(__('addworking.contract.contract_document.edit.return')."|href:{$contract_document->routes->show}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    {{ $contract_document->views->breadcrumb(['page' => "edit"]) }}
@endsection

@section('form')
    {{ $contract_document->views->form }}

    @button(__('addworking.contract.contract_document.edit.register')."|icon:save|type:submit")
@endsection
