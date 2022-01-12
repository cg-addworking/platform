@extends('foundation::layout.app.create', ['action' => route('addworking.common.enterprise.job.skill.store', [$enterprise, $job])])

@section('title', __('addworking.common.skill.create.create_new_skill'));

@section('toolbar')
    @button(__('addworking.common.skill.create.return')."|href:".route('addworking.common.enterprise.job.skill.index', [$enterprise, $job])."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.common.skill.create.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.common.skill.create.enterprises')."|href:{$skill->job->enterprise->routes->index}")
    @breadcrumb_item("{$skill->job->enterprise->name}|href:{$skill->job->enterprise->routes->show}")
    @breadcrumb_item(__('addworking.common.skill.create.job')."|href:{$skill->job->routes->index}")
    @breadcrumb_item("{$skill->job->display_name}|href:{$skill->job->routes->show}")
    @breadcrumb_item(__('addworking.common.skill.create.skills')."|href:{$skill->routes->index}")
    @breadcrumb_item(__('addworking.common.skill.create.create_skill')."|active")
@endsection

@section('form')
    {{ $skill->views->form }}

    <div class="text-right my-5">
        @button(__('addworking.common.skill.create.create')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection
