@extends('foundation::layout.app.show')

@section('title', __('enterprise.invoiceParameter.application.views.show.title').$enterprise->name)

@section('toolbar')
    @button(__('enterprise.invoiceParameter.application.views.show.back')."|href:".route('addworking.enterprise.parameter.index', $enterprise)."|icon:arrow-left|color:secondary|outline|sm|mr:2")

    @include('invoice_parameter::_actions')
@endsection

@section('breadcrumb')
    @include('invoice_parameter::_breadcrumb', ['page' => "show"])
@endsection

@section('content')
    @include('invoice_parameter::_html')
@endsection
