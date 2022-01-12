@extends('foundation::layout.app.show')

@section('title', $skill->display_name)

@section('toolbar')
    @button(__('addworking.common.skill.show.return')."|href:".route('addworking.common.enterprise.job.skill.index', [$enterprise, $job])."|icon:arrow-left|color:secondary|outline|sm")
    {{ $skill->views->actions }}
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.common.skill.show.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.common.skill.show.enterprises')."|href:{$skill->job->enterprise->routes->index}")
    @breadcrumb_item("{$skill->job->enterprise->name}|href:{$skill->job->enterprise->routes->show}")
    @breadcrumb_item(__('addworking.common.skill.show.job')."|href:{$skill->job->routes->index}")
    @breadcrumb_item("{$skill->job->display_name}|href:{$skill->job->routes->show}")
    @breadcrumb_item(__('addworking.common.skill.show.skills')."|href:{$skill->routes->index}")
    @breadcrumb_item("{$skill->display_name}|active")
@endsection

@section('content')
    {{ $skill->views->html }}
@endsection
