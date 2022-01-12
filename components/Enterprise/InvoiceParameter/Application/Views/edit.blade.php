@extends('foundation::layout.app.edit', ['action' => route('addworking.enterprise.parameter.update', [$enterprise, $invoice_parameter])])

@section('title', __('enterprise.invoiceParameter.application.views.edit.title', ["number" => $invoice_parameter->getNumber()]))

@section('toolbar')
    @button(__('enterprise.invoiceParameter.application.views._actions.back')."|href:".route('addworking.enterprise.parameter.index', $enterprise)."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('invoice_parameter::_breadcrumb', ['page' => "edit"])
@endsection

@section('form')
    @include('invoice_parameter::_form')

    @button(__('enterprise.invoiceParameter.application.views._form.create')."|type:submit|color:success|shadow|icon:check|mt:2")
@endsection
