@extends('foundation::layout.app.create', ['action' => $mission_tracking_line_attachment->routes->store, 'enctype' => "multipart/form-data"])

@section('title', __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.create.title'))

@section('toolbar')
    @button(__('components.sogetrel.mission.application.views.mission_tracking_line_attachment.create.return')."|href:{$mission_tracking_line_attachment->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    {{ $mission_tracking_line_attachment->views->breadcrumb(['page' => "create"]) }}
@endsection

@section('form')
    {{ $mission_tracking_line_attachment->views->period_selector }}
    {{ $mission_tracking_line_attachment->views->form }}

    @button(__('messages.save')."|icon:save|type:submit")
@endsection

