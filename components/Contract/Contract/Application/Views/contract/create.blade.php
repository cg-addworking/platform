@extends('foundation::layout.app.create', ['action' => isset($contract_parent) ? route('contract.amendment.store', $contract_parent) : route('support.contract.store') . (!is_null($mission) ? "?mission=".$mission->id : ''), 'enctype' => "multipart/form-data"])

@section('title', isset($contract_parent) ?
    __('components.contract.contract.application.views.contract.create_amendment.title') :
    __('components.contract.contract.application.views.contract.create.title')
)

@section('toolbar')
    @button(__('components.contract.contract.application.views.contract.create.return')."|href:".route('contract.index')."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('contract::contract._breadcrumb', ['page' => "create"])
@endsection

@section('form')
    @if(!isset($contract_parent))
        @include('contract::contract._form', ['page' => 'create'])
    @else
        @include('contract::contract.amendment._form_with_model', ['page' => 'create'])
    @endif

    @button(__('components.contract.contract.application.views.contract.create.create')."|type:submit|color:success|shadow|icon:check")
@endsection
