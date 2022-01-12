<div class="row">
    @component('bootstrap::attribute', ['class' => "col-md-4", 'icon' => "info", 'label' => __('edenred.common.average_daily_rate._html.code')])
        <a href="{{ route('edenred.common.code.show', $average_daily_rate->code) }}">{{ $average_daily_rate->code->code }}</a>
    @endcomponent

    @component('bootstrap::attribute', ['class' => "col-md-4", 'icon' => "info", 'label' => __('edenred.common.average_daily_rate._html.service_provider')])
        {{ $average_daily_rate->vendor->views->link }}
    @endcomponent

    @attribute($average_daily_rate->rate.'|class:col-md-4|icon:info|label:'.__('edenred.common.average_daily_rate._html.rate'))
</div>
