@component('bootstrap::attribute', ['icon' => "star", 'label' => __('addworking.user.onboarding_process._html.field'), 'class' => "col-md-12"])
    {{ optional($onboarding_process->enterprise)->name }}
@endcomponent

@component('bootstrap::attribute', ['icon' => "user", 'label' => __('addworking.user.onboarding_process._html.user'), 'class' => "col-md-8"])
    {{ user($onboarding_process->user_id)->views->link }}
@endcomponent

@component('bootstrap::attribute', ['icon' => "building", 'label' => __('addworking.user.onboarding_process._html.enterprise'), 'class' => "col-md-4"])
    {{ user($onboarding_process->user_id)->enterprise->views->link }}
@endcomponent

@component('bootstrap::attribute', ['icon' => "step-forward", 'label' => __('addworking.user.onboarding_process._html.step_in_process'), 'class' => "col-md-8"])
    {{ $onboarding_process->getCurrentStep()->getDisplayName() }}
@endcomponent

@component('bootstrap::attribute', ['icon' => "check", 'label' => __('addworking.user.onboarding_process._html.onboarding_completed'), 'class' => "col-md-4"])
    @bool($onboarding_process->complete)
@endcomponent

@component('bootstrap::attribute', ['icon' => "calendar", 'label' => __('addworking.user.onboarding_process._html.creation_date'), 'class' => "col-md-8"])
    {{ date_iso_to_date_fr($onboarding_process->created_at) }}
@endcomponent

@component('bootstrap::attribute', ['icon' => "calendar", 'label' => __('addworking.user.onboarding_process._html.completion_date'), 'class' => "col-md-4"])
    {{ date_iso_to_date_fr($onboarding_process->completed_at) }}
@endcomponent
