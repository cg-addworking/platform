@extends('foundation::layout.app.show')

@section('title', "$csv_loader_report")

@section('toolbar')
    @button(__('addworking.common.csv_loader_report.show.return')."|href:{$csv_loader_report->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
    {{ $csv_loader_report->views->actions }}
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.common.csv_loader_report.show.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.common.csv_loader_report.show.csv_load_reports')."|href:{$csv_loader_report->routes->index}")
    @breadcrumb_item("$csv_loader_report|active")
@endsection

@section('tabs')
    <a class="nav-item nav-link active" id="nav-info-tab" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="true">
        @icon('info') {{ __('addworking.common.csv_loader_report.show.general_information') }}
    </a>
    <a class="nav-item nav-link" id="nav-preview-tab" data-toggle="tab" href="#nav-preview" role="tab" aria-controls="nav-preview">
        @icon('eye') {{ __('addworking.common.csv_loader_report.show.preview') }}
    </a>
@endsection

@section('content')
    <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
        {{ $csv_loader_report->views->html }}
    </div>
    <div class="tab-pane fade" id="nav-preview" role="tabpanel" aria-labelledby="nav-preview-tab">
        {{ $csv_loader_report->views->preview }}
    </div>
@endsection
