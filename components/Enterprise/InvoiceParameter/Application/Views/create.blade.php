@extends('foundation::layout.app.create', ['action' => route('addworking.enterprise.parameter.store', $enterprise), 'enctype' => "multipart/form-data"])

@section('title', __('enterprise.invoiceParameter.application.views.create.title'))

@section('toolbar')
    @button(__('enterprise.invoiceParameter.application.views._actions.back')."|href:".route('addworking.enterprise.parameter.index', $enterprise)."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('invoice_parameter::_breadcrumb', ['page' => "create"])
@endsection

@section('form')
    @include('invoice_parameter::_form')

    @button(__('enterprise.invoiceParameter.application.views._form.create')."|type:submit|color:success|shadow|icon:check|mt:2")
@endsection
