@extends('foundation::layout.app.edit', ['action' => route('addworking.common.enterprise.job.update', [$enterprise, $job])])

@section('title', __('addworking.common.job.edit.edit_job')." {$job->display_name}");

@section('toolbar')
    @button(__('addworking.common.job.edit.return')."|href:".route('addworking.common.enterprise.job.show', [$enterprise, $job])."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.common.job.edit.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.common.job.edit.enterprises').'|href:'.route('enterprise.index'))
    @breadcrumb_item($enterprise->name .'|href:'.route('enterprise.show', $enterprise))
    @breadcrumb_item(__('addworking.common.job.edit.job').'|href:'.route('addworking.common.enterprise.job.index', $enterprise))
    @breadcrumb_item("{$job->display_name}|href:{$job->routes->view}")
    @breadcrumb_item(__('addworking.common.job.edit.edit')."|active")
@endsection

@section('form')
    {{ $job->views->form }}

    <div class="text-right my-5">
        @button(__('addworking.common.job.edit.register')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection
