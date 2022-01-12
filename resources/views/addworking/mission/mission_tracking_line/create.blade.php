@inject('missionTrackingLineRepository', 'Components\Enterprise\AccountingExpense\Application\Repositories\MissionTrackingLineRepository')

@extends('foundation::layout.app.create', ['action' => $mission_tracking_line->routes->store, 'enctype' => 'multipart/form-data'])

@section('title', __('addworking.mission.mission_tracking_line.create.mission_monitoring_new'))

@section('toolbar')
    @button(__('messages.return')."|href:{$mission_tracking_line->routes->index}|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    {{ $mission_tracking_line->views->breadcrumb(['page' => "create"]) }}
@endsection

@section('form')
    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('info') {{ __('addworking.mission.mission_tracking_line.create.general_information') }}</legend>

        <div class="row">
            <div class="col-md-6">
                @form_group([
                    'type'        => "text",
                    'name'        => "line.label",
                    'required'    => false,
                    'text'        => __('addworking.mission.mission_tracking_line.create.line_label'),
                ])
            </div>

            <div class="col-md-6">
                @form_group([
                    'type'        => "select",
                    'name'        => "line.accounting_expense",
                    'options'     => $missionTrackingLineRepository->getAvailableAccountingExpenses($mission_tracking_line->missionTracking()->first()),
                    'required'    => true,
                    'text'        => __('addworking.mission.mission_tracking_line.create.accounting_expense'),
                ])
            </div>

            <div class="col-md-4">
                @form_group([
                    'name'        => "line.unit_price",
                    'type'        => "number",
                    'step'        =>  "any",
                    'required'    => true,
                    'text'        => __('addworking.mission.mission_tracking_line.create.unit_price'),
                ])
            </div>

            <div class="col-md-4">
                @form_group([
                    'type'        => "select",
                    'name'        => "line.unit",
                    'options'     => array_trans(mission()::getAvailableUnits(), 'mission.mission.'),
                    'required'    => true,
                    'text'        => __('addworking.mission.mission_tracking_line.create.unit'),
                ])
            </div>

            <div class="col-md-4">
                @form_group([
                    'type'        => "number",
                    'name'        => "line.quantity",
                    'required'    => true,
                    'step'        => 0.01,
                    'text'        => __('addworking.mission.mission_tracking_line.create.amount'),
                ])
            </div>
        </div>
    </fieldset>

    <div class="text-right my-5">
        @button(__('messages.save')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection
