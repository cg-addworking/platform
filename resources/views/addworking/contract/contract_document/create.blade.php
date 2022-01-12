@extends('foundation::layout.app.create', ['action' => $contract_document->routes->store])

@section('title', __('addworking.contract.contract_document.create.add_document'))

@section('toolbar')
    @button(__('addworking.contract.contract_document.create.return')."|href:{$contract_document->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    {{ $contract_document->views->breadcrumb(['page' => "create"]) }}
@endsection

@section('form')
    {{ $contract_document->views->form }}

    @button(__('addworking.contract.contract_document.create.create')."|icon:save|type:submit")
@endsection
