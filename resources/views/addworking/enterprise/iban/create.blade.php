@extends('foundation::layout.app.create', ['action' => route('enterprise.iban.store', $enterprise), 'enctype' => "multipart/form-data"])

@section('title', __('addworking.enterprise.iban.create.company_iban')." $enterprise->name")

@section('toolbar')
    @button(__('addworking.enterprise.iban.create.return')."|href:".route('enterprise.show', $enterprise)."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.iban.create.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.enterprise.iban.create.enterprise').'|href:'.route('enterprise.index') )
    @breadcrumb_item(title_case($enterprise->name) .'|href:'.route('enterprise.show', $enterprise) )
    @breadcrumb_item("IBAN|active")
@endsection

@section('form')
    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('info') {{ __('addworking.enterprise.iban.create.general_information') }}</legend>

        {{ $iban->views->form }}
    </fieldset>

    <div class="text-right my-5">
        @button(__('addworking.enterprise.iban.create.record')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection
