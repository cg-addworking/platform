@extends('foundation::layout.app.create', ['action' => $referential->routes->store, 'enctype' => 'multipart/form-data'])

@section('title', __('everial.mission.referential.create.new_repo_mission'))

@section('toolbar')
    @button(__('everial.mission.referential.create.return')."|href:{$referential->routes->index}|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('everial.mission.referential.create.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('everial.mission.referential.create.referential_missions').'|href:'.$referential->routes->index )
    @breadcrumb_item(__('everial.mission.referential.create.create')."|active")
@endsection

@section('form')
   {{ $referential->views->form }}

    <div class="text-right my-5">
        @button(__('everial.mission.referential.create.save')."|type:submit|color:success|shadow|icon:save")
    </div>
@endsection
