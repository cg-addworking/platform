@extends('foundation::layout.app.edit', ['action' => route('edenred.common.code.average_daily_rate.update', [$code, $average_daily_rate])])

@section('title', __('edenred.common.average_daily_rate.edit.change_code_rate')." {$code->code} ".__('edenred.common.average_daily_rate.edit.for')." {$average_daily_rate->vendor->name}");

@section('toolbar')
    @button(__('edenred.common.average_daily_rate.edit.return')."|href:".route('edenred.common.code.average_daily_rate.show', [$code, $average_daily_rate])."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('edenred.common.average_daily_rate.edit.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('edenred.common.average_daily_rate.edit.codes').'|href:'.route('edenred.common.code.index') )
    @breadcrumb_item($code->code .'|href:'.route('edenred.common.code.show', $code) )
    @breadcrumb_item(__('edenred.common.average_daily_rate.edit.average_daily_rate').'|href:'.route('edenred.common.code.average_daily_rate.index', $code) )
    @breadcrumb_item($average_daily_rate->vendor->name .'|href:'.route('edenred.common.code.average_daily_rate.show', [$code, $average_daily_rate]) )
    @breadcrumb_item(__('edenred.common.average_daily_rate.edit.edit')."|active")
@endsection

@section('form')
    {{ $average_daily_rate->views->form }}

    <div class="text-right my-5">
        @button(__('edenred.common.average_daily_rate.edit.register')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection
