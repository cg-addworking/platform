@extends('foundation::layout.app.create', ['action' => route('edenred.common.code.average_daily_rate.store', $code)])

@section('title', __('edenred.common.average_daily_rate.create.create_average_daily_rate_for')." {$code->code}");

@section('toolbar')
    @button(__('edenred.common.average_daily_rate.create.return')."|href:".route('edenred.common.code.average_daily_rate.index', $code)."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('edenred.common.average_daily_rate.create.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('edenred.common.average_daily_rate.create.codes').'|href:'.route('edenred.common.code.index') )
    @breadcrumb_item($code->code .'|href:'.route('edenred.common.code.show', $code) )
    @breadcrumb_item(__('edenred.common.average_daily_rate.create.average_daily_rate').'|href:'.route('edenred.common.code.average_daily_rate.index', $code) )
    @breadcrumb_item(__('edenred.common.average_daily_rate.create.create_average_daily_rate')."|active")
@endsection

@section('form')
    {{ $average_daily_rate->views->form }}

    <div class="text-right my-5">
        @button(__('edenred.common.average_daily_rate.create.create')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection
