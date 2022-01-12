@extends('foundation::layout.app.create', ['action' => route('support.user.onboarding_process.store')])

@section('title', __('addworking.user.onboarding_process.create.create_new_onboaring_process'));

@section('toolbar')
    @button(__('addworking.user.onboarding_process.create.return')."|href:".route('support.user.onboarding_process.index')."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.user.onboarding_process.create.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.user.onboarding_process.create.onboarding_process').'|href:'.route('support.user.onboarding_process.index') )
    @breadcrumb_item(__('addworking.user.onboarding_process.create.create')."|active")
@endsection

@section('form')
    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('info') {{ __('addworking.user.onboarding_process.create.general_information') }}</legend>

        <div class="row">
            <div class="col-md-12">
                @form_group([
                    'text'         => __('addworking.user.onboarding_process.create.user'),
                    'type'         => "select",
                    'name'         => "onboarding_process.user",
                    'options'      => user()::orderBy('lastname')->get()->pluck('name', 'id'),
                    'required'     => true,
                    'selectpicker' => true,
                    'search'       => true,
                ])
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @form_group([
                    'text'      => __('addworking.user.onboarding_process.create.onboarding_completed'),
                    'type'      => "switch",
                    'name'      => "onboarding_process.complete",
                ])
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @form_group([
                    'text'     => __('addworking.user.onboarding_process.create.concerned_domain'),
                    'type'     => "select",
                    'name'     => "onboarding_process.enterprise",
                    'options'  => onboarding_process()::getAvailableEnterprises(),
                    'required' => true,
                ])
            </div>
        </div>

    </fieldset>

    <div class="text-right my-5">
        @button(__('addworking.user.onboarding_process.create.record')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection
