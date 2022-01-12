@extends('foundation::layout.app.show')

@section('title', __('edenred.common.average_daily_rate.show.average_daily_code_rate')." {$code->code} ".__('edenred.common.average_daily_rate.show.for')." {$average_daily_rate->vendor->name}")

@section('toolbar')
    @button(__('edenred.common.average_daily_rate.show.return')."|href:".route('edenred.common.code.average_daily_rate.index', $code)."|icon:arrow-left|color:secondary|outline|sm")
    {{ $average_daily_rate->views->actions }}
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('edenred.common.average_daily_rate.show.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('edenred.common.average_daily_rate.show.codes').'|href:'.route('edenred.common.code.index') )
    @breadcrumb_item($code->code .'|href:'.route('edenred.common.code.show', $code) )
    @breadcrumb_item(__('edenred.common.average_daily_rate.show.average_daily_rate').'|href:'.route('edenred.common.code.average_daily_rate.index', $code) )
    @breadcrumb_item($average_daily_rate->vendor->name ."|active")
@endsection

@section('content')
    {{ $average_daily_rate->views->html }}
@endsection
