@extends('foundation::layout.app.create', ['action' => route('addworking.common.enterprise.job.store', $enterprise)])

@section('title', __('addworking.common.job.create.create_new_skill'));

@section('toolbar')
    @button(__('addworking.common.job.create.return')."|href:".route('addworking.common.enterprise.job.index', $enterprise)."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.common.job.create.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.common.job.create.enterprises').'|href:'.route('enterprise.index') )
    @breadcrumb_item($enterprise->name .'|href:'.route('enterprise.show', $enterprise) )
    @breadcrumb_item(__('addworking.common.job.create.job').'|href:'.route('addworking.common.enterprise.job.index', $enterprise) )
    @breadcrumb_item(__('addworking.common.job.create.create_skill')."|active")
@endsection

@section('form')
    {{ $job->views->form }}

    <div class="text-right my-5">
        @button(__('addworking.common.job.create.register')."|type:submit|color:success|shadow|icon:check")
        @button(__('addworking.common.job.create.save_create_again')."|type:submit|color:success|shadow|icon:undo")
    </div>
@endsection
