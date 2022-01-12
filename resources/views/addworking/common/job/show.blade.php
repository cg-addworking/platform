@extends('foundation::layout.app.show')

@section('title', $job->display_name)

@section('toolbar')
    @button(__('addworking.common.job.show.return')."|href:".route('addworking.common.enterprise.job.index', $enterprise)."|icon:arrow-left|color:secondary|outline|sm")
    {{ $job->views->actions }}
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.common.job.show.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.common.job.show.enterprises').'|href:'.route('enterprise.index') )
    @breadcrumb_item($enterprise->name .'|href:'.route('enterprise.show', $enterprise) )
    @breadcrumb_item(__('addworking.common.job.show.job').'|href:'.route('addworking.common.enterprise.job.index', $enterprise) )
    @breadcrumb_item($job->display_name ."|active")
@endsection

@section('content')
    {{ $job->views->html }}
@endsection
