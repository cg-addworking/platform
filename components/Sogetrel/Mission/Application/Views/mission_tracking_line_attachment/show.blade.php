@extends('foundation::layout.app.show')

@section('title', __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.show.title'))

@section('toolbar')
    @button(__('components.sogetrel.mission.application.views.mission_tracking_line_attachment.show.return')."|href:{$mission_tracking_line_attachment->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
    {{ $mission_tracking_line_attachment->views->actions }}
@endsection

@section('breadcrumb')
    {{ $mission_tracking_line_attachment->views->breadcrumb(['page' => "show"]) }}
@endsection

@section('tabs')
    @component('bootstrap::tab', ['name' => "summary", 'active' => true])
        {{ __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.show.tab_summary') }}
    @endcomponent

    @component('bootstrap::tab', ['name' => "file"])
        {{ __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.show.tab_file') }}
    @endcomponent
@endsection

@section('content')
    @component('bootstrap::tab.pane', ['name' => "summary", 'active' => true])
        {{ $mission_tracking_line_attachment->views->html }}
    @endcomponent

    @component('bootstrap::tab.pane', ['name' => "file"])
        {{ $mission_tracking_line_attachment->file->views->iframe }}
    @endcomponent
@endsection
