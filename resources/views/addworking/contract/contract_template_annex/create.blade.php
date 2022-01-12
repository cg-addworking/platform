@extends('foundation::layout.app.create', ['action' => $contract_template_annex->routes->store])

@section('title', __('addworking.contract.contract_template_annex.create.add_annex'))

@section('toolbar')
    @button(__('addworking.contract.contract_template_annex.create.return')."|href:{$contract_template_annex->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    {{ $contract_template_annex->views->breadcrumb(['page' => "create"]) }}
@endsection

@section('form')
    {{ $contract_template_annex->views->form }}

    @button(__('addworking.contract.contract_template_annex.create.create')."|icon:save|type:submit")
@endsection
