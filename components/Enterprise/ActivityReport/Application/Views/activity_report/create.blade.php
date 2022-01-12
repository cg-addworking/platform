@inject('enterpriseRepository', 'Components\Enterprise\Enterprise\Application\Repositories\EnterpriseRepository')

@extends('foundation::layout.app.create', ['action' => route('addworking.enterprise.activity_report.store', $enterprise), 'enctype' => "multipart/form-data"])

@section(
    'title',
    __('addworking.components.enterprise.activity_report.application.views.activity_report.create.title', ['start_date' => $start_date, 'end_date' => $end_date])
)

@section('toolbar')
    @button(__('addworking.components.enterprise.activity_report.application.views.activity_report.create.return')."|href:".route('dashboard')."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    {{ $activity_report->views->breadcrumb(['page' => "create"]) }}
@endsection

@section('form')
    <fieldset>
        <div class="row">
            <div class="col-md-12">
                @include('activity_report::activity_report._form')
            </div>
        </div>
    </fieldset>

    @button(__('addworking.components.enterprise.activity_report.application.views.activity_report.create.create')."|type:submit|color:success|shadow|icon:check")
@endsection
