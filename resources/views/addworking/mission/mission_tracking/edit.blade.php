@extends('foundation::layout.app.create', ['action' => $tracking->routes->update, 'enctype' => 'multipart/form-data', 'method' => 'PUT'])

@section('title', __('addworking.mission.mission_tracking.edit.edit_mission_tracking'))

@section('toolbar')
    @button(__('addworking.mission.mission_tracking.edit.return')."|href:{$tracking->routes->show}|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.mission.mission_tracking.edit.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item('Missions|href:'.$mission->routes->index )
    @breadcrumb_item(__('addworking.mission.mission_tracking.edit.mission_followup').'|href:'.$mission->routes->show )
    @breadcrumb_item(__('addworking.mission.mission_tracking.edit.mission_monitoring').'|href:'.$tracking->routes->index )
    @breadcrumb_item(__('addworking.mission.mission_tracking.edit.edit')."|active")
@endsection

@section('form')
    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('info') {{ __('addworking.mission.mission_tracking.edit.general_information') }}</legend>
        <div class="row">
            <div class="col-md-12">
                @form_group([
                    'text'     => __('addworking.mission.mission_tracking.edit.period_concerned'),
                    'type'     => "select",
                    'name'     => "milestone.id",
                    'options'  => $mission->milestones->pluck('label', 'id'),
                    'required' => true,
                    'value'    => $tracking->milestone->id,
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @form_group([
                    'text'        => "Description",
                    'type'        => "textarea",
                    'name'        => "tracking.description",
                    'value'       => $tracking->description,
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @form_group([
                'text'        => __('addworking.mission.mission_tracking.edit.external_identifier'),
                'type'        => "text",
                'name'        => "tracking.external_id",
                'required'    => false,
                'value'       => $tracking->external_id,
                'placeholder' => __('addworking.mission.mission_tracking.edit.order_attached_help')
                ])
            </div>
        </div>
    </fieldset>

    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('info') {{ __('addworking.mission.mission_tracking.edit.addtional_files') }}</legend>
        <div class="row">
            <div class="col-md-12">
                @forelse($tracking->attachments()->get() as $file)
                    <p>
                        {{ $file->views->summary }}
                    </p>
                @empty
                    <p>n/a</p>
                @endforelse

                @form_group([
                    'type'        => "file",
                    'name'        => "tracking.file.",
                    'value'       => $tracking->hasAttachments() ? $tracking->attachments()->first()->id : '',
                    'multiple'    => true,
                ])
            </div>
        </div>
    </fieldset>

    <div class="text-right my-5">
        @button(__('addworking.mission.mission_tracking.edit.record')."|type:submit|color:warning|shadow|icon:pen")
    </div>
@endsection
