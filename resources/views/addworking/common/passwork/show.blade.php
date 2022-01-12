@extends('foundation::layout.app.show')

@section('title', __('addworking.common.passwork.show.passwork')." {$passwork->customer->name}")

@section('toolbar')
    @button(__('addworking.common.passwork.show.return')."|href:".route('addworking.common.enterprise.passwork.index', $enterprise)."|icon:arrow-left|color:secondary|outline|sm")
    {{ $passwork->views->actions }}
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.common.passwork.show.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.common.passwork.show.enterprises').'|href:'.route('enterprise.index') )
    @breadcrumb_item($enterprise->name .'|href:'.route('enterprise.show', $enterprise) )
    @breadcrumb_item(__('addworking.common.passwork.show.passworks').'|href:'.route('addworking.common.enterprise.passwork.index', $enterprise) )
    @breadcrumb_item($passwork->customer->name ."|active")
@endsection

@section('content')
    {{ $passwork->views->html }}
@endsection
