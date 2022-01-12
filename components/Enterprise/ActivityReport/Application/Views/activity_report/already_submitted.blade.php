@extends('foundation::layout.app.show')

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

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="alert alert-danger">
                Le suivi d’activité de votre entreprise a déjà été renseigné.<br/>
                Merci !
            </div>
        </div>
    </div>
@endsection
