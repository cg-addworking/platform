@extends('foundation::layout.app.show')

@section('title', __('addworking.user.onboarding_process.show.onboarding_process'))

@section('toolbar')
    @button(__('addworking.user.onboarding_process.show.return')."|href:".route('support.user.onboarding_process.index')."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.user.onboarding_process.show.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.user.onboarding_process.show.onboarding_process').'|href:'.route('support.user.onboarding_process.index') )
    @breadcrumb_item(__('addworking.user.onboarding_process.show.onboarding')."|active")
@endsection

@section('tabs')
    <a class="nav-item nav-link active" id="nav-info-tab" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="true">{{ __('addworking.user.onboarding_process.show.general_information') }}</a>
@endsection

@section('content')
    <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
        <div class="row">
            {{ $onboarding_process->views->html }}
        </div>
    </div>
@endsection
