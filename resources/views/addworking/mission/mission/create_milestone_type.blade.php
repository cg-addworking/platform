@extends('foundation::layout.app.create', ['action' => route('mission.store_milestone_type', $mission)])

@section('title', __('addworking.mission.mission.create_milestone_type.define_tracking_mode'))

@section('toolbar')
    @button(__('addworking.mission.mission.create_milestone_type.return')."|href:".route('mission.index')."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.mission.mission.create_milestone_type.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.mission.mission.create_milestone_type.mission').'|href:'.route('mission.index'))
    @breadcrumb_item(__('addworking.mission.mission.create_milestone_type.define_tracking_mode')."|active")
@endsection

@section('form')
    <fieldset class="mt-2 pt-2">
        <legend class="text-primary h5">@icon('handshake') {{ __('addworking.mission.mission.create_milestone_type.mission_information') }}</legend>

        <div class="row">
            <div class="col-md-6">
                @form_group([
                    'type'        => "date",
                    'name'        => "mission.starts_at",
                    'value'       => $mission->starts_at,
                    'required'    => true,
                    'text'        => __('mission.mission.starts_at'),
                ])
            </div>
            <div class="col-md-6">
                @form_group([
                    'type'        => "date",
                    'name'        => "mission.ends_at",
                    'value'       => $mission->ends_at,
                    'text'        => __('mission.mission.ends_at'),
                    'required'    => false,
                ])
            </div>
            <div class="col-md-12">
                @form_group([
                    'type'        => "select",
                    'name'        => "mission.milestone_type",
                    'value'       => $mission->milestone_type ?? milestone()::MILESTONE_END_OF_MISSION,
                    'options'     => array_trans(array_mirror(milestone()::getAvailableMilestoneTypes()), 'mission.milestone.type.'),
                    'text'        => __('addworking.mission.mission.create_milestone_type.tracking_mode'),
                    'required'    => true,
                ])
            </div>
        </div>
    </fieldset>

    <div class="text-right my-5">
        @button(__('addworking.mission.mission.create_milestone_type.create')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection
