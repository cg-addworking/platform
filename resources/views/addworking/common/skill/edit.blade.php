@extends('foundation::layout.app.edit', ['action' => route('addworking.common.enterprise.job.skill.update', [$enterprise, $job, $skill])])

@section('title', __('addworking.common.skill.edit.edit_skill')." {$skill->display_name}");

@section('toolbar')
    @button("Retour|href:".route('addworking.common.enterprise.job.skill.show', [$enterprise, $job, $skill])."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.common.skill.edit.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.common.skill.edit.enterprises')."|href:{$skill->job->enterprise->routes->index}")
    @breadcrumb_item("{$skill->job->enterprise->name}|href:{$skill->job->enterprise->routes->show}")
    @breadcrumb_item(__('addworking.common.skill.edit.job')."|href:{$skill->job->routes->index}")
    @breadcrumb_item("{$skill->job->display_name}|href:{$skill->job->routes->show}")
    @breadcrumb_item(__('addworking.common.skill.edit.skills')."|href:{$skill->routes->index}")
    @breadcrumb_item("{$skill->display_name}|href:{$skill->routes->show}")
    @breadcrumb_item(__('addworking.common.skill.edit.edit')."|active")
@endsection

@section('form')
    {{ $skill->views->form }}

    <div class="text-right my-5">
        @button(__('addworking.common.skill.edit.register')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection
