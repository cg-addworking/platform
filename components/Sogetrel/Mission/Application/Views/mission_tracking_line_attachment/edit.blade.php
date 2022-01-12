@extends('foundation::layout.app.edit', ['action' => $mission_tracking_line_attachment->routes->update])

@section('title', __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.edit.title'))

@section('toolbar')
    @button(__('components.sogetrel.mission.application.views.mission_tracking_line_attachment.edit.return')."|href:{$mission_tracking_line_attachment->routes->show}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    {{ $mission_tracking_line_attachment->views->breadcrumb(['page' => "edit"])}}
@endsection

@section('form')
    {{ $mission_tracking_line_attachment->views->form }}

    @button(__('messages.save')."|icon:save|type:submit")
@endsection
