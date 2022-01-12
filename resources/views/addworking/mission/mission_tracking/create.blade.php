@extends('foundation::layout.app.create', ['action' => route('mission.tracking.store', $mission), 'enctype' => 'multipart/form-data'])

@section('title', __('addworking.mission.mission_tracking.create.mission_followup'))

@section('toolbar')
    @button(__('addworking.mission.mission_tracking.create.return')."|href:{$tracking->routes->index}|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.mission.mission_tracking.create.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item('Missions|href:'.$mission->routes->index )
    @breadcrumb_item($mission->label .'|href:'.$mission->routes->show )
    @breadcrumb_item(__('addworking.mission.mission_tracking.create.mission_monitoring').'|href:'.$tracking->routes->index )
    @breadcrumb_item(__('addworking.mission.mission_tracking.create.create')."|active")
@endsection

@section('form')
    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('info') {{ __('addworking.mission.mission_tracking.create.general_information') }}</legend>
        <div class="row">
            <div class="col-md-12">
                @form_group([
                    'text'     => __('addworking.mission.mission_tracking.create.period_concerned'),
                    'type'     => "select",
                    'name'     => "milestone.id",
                    'options'  => $mission->milestones->sortByDesc('ends_at')->pluck('label', 'id'),
                    'required' => true,
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @form_group([
                    'text'        => "Description",
                    'type'        => "textarea",
                    'name'        => "tracking.description",
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @form_group([
                'text'        => "Identifiant externe",
                'type'        => "text",
                'name'        => "tracking.external_id",
                'required'    => false,
                'placeholder' => __('addworking.mission.mission_tracking.create.order_attached_help')
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @form_group([
                'text'        => "Label",
                'type'        => "text",
                'name'        => "line.label",
                'required'    => true,
                'placeholder' => __('addworking.mission.mission_tracking.create.mission_followup_ref')
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                @form_group([
                'type'        => "number",
                'step'        =>  "any",
                'name'        => "line.unit_price",
                'text'        => __('addworking.mission.mission_tracking.create.unit_price'),
                'value'       =>  milestone()::MILESTONE_END_OF_MISSION === $mission->milestone_type ? $mission->unit_price : 0,
                ])
            </div>

            <div class="col-md-4">
                @form_group([
                'type'        => "select",
                'name'        => "line.unit",
                'options'     => array_trans(mission()::getAvailableUnits(), 'mission.mission.'),
                'text'        => __('addworking.mission.mission_tracking.create.unit'),
                'value'       => milestone()::MILESTONE_END_OF_MISSION === $mission->milestone_type ? $mission->unit : null,
                ])
            </div>

            <div class="col-md-4">
                @form_group([
                'type'        => "number",
                'name'        => "line.quantity",
                'step'        => 0.01,
                'min'         => 0,
                'text'        => __('addworking.mission.mission_tracking.create.amount'),
                'value'       => milestone()::MILESTONE_END_OF_MISSION === $mission->milestone_type ? $mission->quantity : 0,
                ])
            </div>
        </div>

        @can('chooseNotification', mission_tracking())
            <div class="row">
                <div class="col-md-12">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" value="1" name="tracking.vendor">
                            {{ __('addworking.mission.mission_tracking.create.notify_provider') }}
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" value="1" name="tracking.customer">
                            {{ __('addworking.mission.mission_tracking.create.notify_customer') }}
                        </label>
                    </div>
                </div>
            </div>
        @endcan
    </fieldset>

    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('info') {{ __('addworking.mission.mission_tracking.create.addtional_files') }}</legend>
        <div class="row">
            <div class="col-md-12">
                @form_group([
                    'type'        => "file",
                    'name'        => "tracking.file.",
                    'accept'      => 'application/pdf',
                    'multiple'    => true,
                ])
            </div>
        </div>
    </fieldset>

    <div class="text-right my-5">
        @button(__('addworking.mission.mission_tracking.create.record')."|type:submit|color:success|shadow|icon:save")
    </div>
@endsection
