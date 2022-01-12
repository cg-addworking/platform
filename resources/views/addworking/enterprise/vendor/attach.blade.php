@extends('layout.app.create', ['action' => route('addworking.enterprise.vendor.attach.store', $enterprise)])

@section('title', __('addworking.enterprise.vendor.attach.referencing_providers')." $enterprise->name")

@section('toolbar')
    @button(__('addworking.enterprise.vendor.attach.return')."|href:".route('enterprise.show', $enterprise)."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('addworking.enterprise.vendor.attach.dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('enterprise.index') }}">Entreprises</a></li>
    <li class="breadcrumb-item"><a href="{{ route('enterprise.show', $enterprise) }}">{{ title_case($enterprise->name) }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('addworking.enterprise.vendor.attach.referencing_providers') }}</li>
@endsection

@section('form')
    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('info') {{ __('addworking.enterprise.vendor.attach.general_information') }}</legend>
        <div class="col-md-12">
            @form_group([
                'type'         => "select",
                'options'      => $vendors,
                'name'         => "vendor.id.",
                'text'         => __('addworking.enterprise.vendor.attach.list_prestataries'),
                'required'     => true,
                'selectpicker' => true,
                'search'       => true,
                'multiple'     => true,
            ])
        </div>
    </fieldset>

    <div class="text-right my-5">
        @button(__('addworking.enterprise.vendor.attach.record')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection
