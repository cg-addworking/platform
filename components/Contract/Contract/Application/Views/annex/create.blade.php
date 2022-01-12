@extends('foundation::layout.app.create', ['action' => route('support.annex.store', $annex), 'enctype' => "multipart/form-data"])

@section('title', __('components.contract.contract.application.views.annex.create.title'))

@section('toolbar')
    @button(__('components.contract.contract.application.views.annex.create.return')."|href:".route('support.annex.create', $annex)."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('contract::annex._breadcrumb', ['page' => "create"])
@endsection

@section('form')
    @include('contract::annex._form')

    @button(__('components.contract.contract.application.views.annex.create.submit')."|type:submit|color:success|shadow|icon:check")
@endsection