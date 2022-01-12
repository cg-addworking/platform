@inject('missionTrackingLineRepository', 'Components\Enterprise\AccountingExpense\Application\Repositories\MissionTrackingLineRepository')

@extends('foundation::layout.app.create', ['action' => $line->routes->update, 'method' => 'POST', 'enctype' => 'multipart/form-data'])

@section('title', __('addworking.mission.mission_tracking_line.edit.modify_mission_tracking'))

@section('toolbar')
    @button(__('addworking.mission.mission_tracking_line.edit.return')."|href:".route('mission.tracking.show', [$mission, $tracking])."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.mission.mission_tracking_line.edit.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.mission.mission_tracking_line.edit.mission').'|href:'.$mission->routes->index )
    @breadcrumb_item($mission .'|href:'.$mission->routes->show )
    @breadcrumb_item(__('addworking.mission.mission_tracking_line.edit.mission_monitoring').'|href:'.$tracking->routes->index )
    @breadcrumb_item($tracking .'|href:'.$tracking->routes->show )
    @breadcrumb_item(__('addworking.mission.mission_tracking_line.edit.lines').'|href:'.$line->routes->index )
    @breadcrumb_item($line .'|href:'.$line->routes->show )
    @breadcrumb_item(__('addworking.mission.mission_tracking_line.edit.edit')."|active")
@endsection

@section('form')
    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('info') {{ __('addworking.mission.mission_tracking_line.edit.general_information') }}</legend>

        <div class="row">
            <div class="col-md-6">
                @form_group([
                    'text'        => __('addworking.mission.mission_tracking_line.edit.line_label'),
                    'type'        => "text",
                    'name'        => "line.label",
                    'required'    => false,
                    'value'       => $line->label,
                ])
            </div>

            <div class="col-md-6">
                @form_group([
                    'type'        => "select",
                    'name'        => "line.accounting_expense",
                    'options'     => $missionTrackingLineRepository->getAvailableAccountingExpenses($line->missionTracking()->first()),
                    'text'        => __('addworking.mission.mission_tracking_line.create.accounting_expense'),
                    'value'       => optional($line->accountingExpense()->first())->getId(),
                ])
            </div>

            <div class="col-md-4">
                @form_group([
                    'text'        => __('addworking.mission.mission_tracking_line.edit.unit_price'),
                    'type'        => "number",
                    'step'        =>  "any",
                    'name'        => "line.unit_price",
                    'required'    => true,
                    'value'       => $line->unit_price,
                ])
            </div>

            <div class="col-md-4">
                @form_group([
                    'text'        => __('addworking.mission.mission_tracking_line.edit.unit'),
                    'type'        => "select",
                    'name'        => "line.unit",
                    'options'     => array_trans(mission()::getAvailableUnits(), 'mission.mission.'),
                    'required'    => true,
                    'value'       => $line->unit,
                ])
            </div>

            <div class="col-md-4">
                @form_group([
                    'text'        => __('addworking.mission.mission_tracking_line.edit.amount'),
                    'type'        => "number",
                    'name'        => "line.quantity",
                    'required'    => true,
                    'step'        => 0.01,
                    'min'         => 0,
                    'value'       => $line->quantity,
                ])
            </div>
        </div>
    </fieldset>

    <div class="text-right my-5">
        @button(__('addworking.mission.mission_tracking_line.edit.modify_row')."|type:submit|color:warning|shadow|icon:pen")
    </div>
@endsection
