@extends('foundation::layout.app.create', ['action' => $contract->routes->createBlankPost])

@section('title', __('addworking.contract.contract.create_blank.create_contract'))

@section('toolbar')
    @button(__('addworking.contract.contract.create_blank.return')."|href:{$contract->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    {{ $contract->views->breadcrumb(['page' => "create"]) }}
@endsection

@section('form')
    {{ $contract->views->form }}

    @button(__('addworking.contract.contract.create_blank.create')."|icon:save|type:submit")
@endsection
