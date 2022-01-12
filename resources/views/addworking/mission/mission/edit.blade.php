@extends('foundation::layout.app.create', ['action' => $mission->routes->update, 'enctype' => 'multipart/form-data', 'method' => 'PUT'])

@section('title', __('addworking.mission.mission.edit.edit_mission'))

@section('toolbar')
    @button(__('addworking.mission.mission.edit.return')."|href:{$mission->routes->show}|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.mission.mission.edit.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.mission.mission.edit.mission').'|href:'.$mission->routes->index )
    @breadcrumb_item($mission->label .'|href:'.$mission->routes->show )
    @breadcrumb_item(__('addworking.mission.mission.edit.edit')."|active")
@endsection

@section('form')
    <legend class="mb-3 h5">@icon('handshake') {{ __('addworking.mission.mission.edit.mission_information') }}</legend>

    <div class="row">
        <div class="col-md-12">
            @form_group([
            'name'        => "mission.label" ,
            'value'       => $mission->label,
            'required'    => true,
            'text'        => __('addworking.mission.mission.edit.assignment_purpose'),
            'help'        => __('addworking.mission.mission.edit.project_development_help'),
            ])
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            @form_group([
            'type'        => "select",
            'name'        => "mission.location",
            'value'       => $mission->location,
            'required'    => true,
            'options'     => mission()::getAvailableLocations(),
            'text'        => __('addworking.mission.mission.edit.location'),
            ])
        </div>

        <div class="col-md-6">
            @form_group([
            'name'        => "mission.external_id",
            'value'       => $mission->external_id,
            'text'        => __('mission.mission.external_id'),
            'help'        => __('addworking.mission.mission.edit.identifier_help'),
            ])
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @form_group([
            'type'        => "textarea",
            'name'        => "mission.description",
            'value'       => $mission->description,
            'required'    => true,
            'text'        => "Description",
            'help'        => __('addworking.mission.mission.edit.describe_mission_help'),
            ])
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            @form_group([
            'type'        => "date",
            'name'        => "mission.starts_at",
            'value'       => $mission->starts_at,
            'required'    => true,
            'text'        => __('mission.mission.starts_at'),
            ])
        </div>
        <div class="col-md-4">
            @form_group([
            'type'        => "date",
            'name'        => "mission.ends_at",
            'value'       => $mission->ends_at,
            'text'        => __('mission.mission.ends_at'),
            'required'    => $mission->milestone_type == milestone()::MILESTONE_END_OF_MISSION ? true : false
            ])
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            @form_group([
            'type'        => "select",
            'name'        => "mission.unit",
            'value'       => $mission->unit,
            'options'     => array_trans($mission->getUnits(), 'mission.mission.unit_'),
            'text'        => __('mission.mission.unit'),
            ])
        </div>
        <div class="col-md-4">
            @form_group([
            'type'        => "number",
            'step'        => 1,
            'min'         => 1,
            'name'        => "mission.quantity",
            'value'       => $mission->quantity,
            'text'        => __('mission.mission.quantity'),
            ])
        </div>
        <div class="col-md-4">
            @form_group([
            'type'        => "number",
            'step'        => .01,
            'min'         => 0,
            'name'        => "mission.unit_price",
            'value'       => $mission->unit_price,
            'text'        => __('mission.mission.unit_price')
            ])
        </div>
    </div>

    <div class="p-3 text-right">
        <button type="submit" class="btn btn-success">
            <i class="fa fa-check"></i> @lang('messages.save')
        </button>
        <span class="clearfix"></span>
    </div>
@endsection
