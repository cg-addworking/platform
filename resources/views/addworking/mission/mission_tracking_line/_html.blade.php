@component('bootstrap::attribute', ['label' => __('addworking.mission.mission_tracking_line._html.label')])
    {{ $mission_tracking_line->label }}
@endcomponent

@component('bootstrap::attribute', ['label' => __('addworking.mission.mission_tracking_line._html.accounting_expense')])
    {{ optional($mission_tracking_line->accountingExpense()->first())->getDisplayName() ?? 'n/a' }}
@endcomponent

@component('bootstrap::attribute', ['label' => __('addworking.mission.mission_tracking_line._html.amout')])
    @money($mission_tracking_line->amount)<br>
    <small>
        {{ $mission_tracking_line->quantity }} {{ $mission_tracking_line->unit }}
        x {{$mission_tracking_line->unit_price . "€"}}
    </small>
@endcomponent

@component('bootstrap::attribute', ['label' => __('addworking.mission.mission_tracking_line._html.validation')])
    @bool($mission_tracking_line->validation_customer)
    {{ __('addworking.mission.mission_tracking_line._html.validation_customer') }}<br>

    @bool($mission_tracking_line->validation_vendor)
    {{ __('addworking.mission.mission_tracking_line._html.validation_vendro') }}
@endcomponent

@if($mission_tracking_line->reason_for_rejection)
    @component('bootstrap::attribute', ['label' => __('addworking.mission.mission_tracking_line._html.reason_for_rejection')])
        {{ $mission_tracking_line->reason_for_rejection }}
    @endcomponent
@endif
