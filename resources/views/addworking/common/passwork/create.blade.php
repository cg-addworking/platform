@extends('foundation::layout.app.create', ['action' => route('addworking.common.enterprise.passwork.store', $enterprise)])

@section('title', __('addworking.common.passwork.create.create_new_passwork'))

@section('toolbar')
    @button(__('addworking.common.passwork.create.return')."|href:".route('addworking.common.enterprise.passwork.index', $enterprise)."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.common.passwork.create.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.common.passwork.create.enterprises').'|href:'.route('enterprise.index') )
    @breadcrumb_item($enterprise->name .'|href:'.route('enterprise.show', $enterprise) )
    @breadcrumb_item(__('addworking.common.passwork.create.passwork').'|href:'.route('addworking.common.enterprise.passwork.index', $enterprise) )
    @breadcrumb_item(__('addworking.common.passwork.create.create_passwork')."|active")
@endsection

@section('form')
    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('info') {{ __('addworking.common.passwork.create.general_information') }}</legend>

        @form_group([
            'text'        => __('addworking.common.passwork.create.client'),
            'type'        => "select",
            'name'        => "customer.id",
            'value'       => optional($passwork)->customer_id,
            'options'     => optional($passwork)->getAvailableCustomers(),
        ])
    </fieldset>

    <div class="text-right my-5">
        @button(__('addworking.common.passwork.create.continue')."|type:submit|color:success|shadow|icon:arrow-right")
    </div>
@endsection
