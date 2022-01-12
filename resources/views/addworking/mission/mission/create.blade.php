@extends('foundation::layout.app.create', ['action' => route('mission.store')])

@section('title', __('addworking.mission.mission.create.create_mission'))

@section('toolbar')
    @button(__('addworking.mission.mission.create.return')."|href:".route('mission.index')."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.mission.mission.create.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.mission.mission.create.mission').'|href:'.route('mission.index') )
    @breadcrumb_item(__('addworking.mission.mission.create.create')."|active")
@endsection

@section('form')
    <fieldset class="mt-2 pt-2">
        <legend class="text-primary h5">@icon('building') {{ __('addworking.mission.mission.create.affected_companies') }}</legend>

            <div class="row">
                <div class="col-md-6">
                    @form_group([
                        'type'        => "select",
                        'name'        => "vendor.id",
                        'value'       => $mission->vendor->id,
                        'options'     => $vendors,
                        'required'    => true,
                        'selectpicker' => true,
                        'search'       => true,
                        'text'        => __('mission.mission.vendor'),
                        'readonly'    => $mission->vendor->exists,
                    ])
                </div>
                <div class="col-md-6">
                    @form_group([
                        'type'        => "select",
                        'name'        => "customer.id",
                        'value'       => $mission->customer->id,
                        'options'     => $customers,
                        'required'    => true,
                        'selectpicker' => true,
                        'search'       => true,
                        'text'        => __('mission.mission.customer'),
                        'readonly'    => $mission->customer->exists,
                    ])
                </div>
            </div>
    </fieldset>

    <fieldset class="mt-2 pt-2">
        <legend class="text-primary h5">@icon('info') {{ __('addworking.mission.mission.create.general_information') }}</legend>

        <div class="row">
            <div class="col-md-12">
                {{ $mission->views->form }}
            </div>
        </div>
    </fieldset>

    <div class="text-right my-5">
        @button(__('addworking.mission.mission.create.create_the_mission')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection
