@form_group([
    'horizontal'  => true,
    'text'       => __('addworking.user.onboarding_process._form.user'),
    'type'        => "select",
    'name'        => "onboarding_process.user",
    'options'     => user()::orderBy('lastname')->get()->pluck('name', 'id'),
    'required'    =>  true
])

@form_group([
    'text'       => __('addworking.user.onboarding_process._form.onboarding_completed'),
    'id'          => "select_onboarding_process_complete",
    'horizontal'  => true,
    'required'    => true,
    'type'        => "select",
    'name'        => "onboarding_process.complete",
    'options'      => [1 => 'Oui', 0 => 'Non'],
])

@form_group([
    'horizontal'  => true,
    'type'        => "select",
    'name'        => "onboarding_process.enterprise",
    'id'          => "enterprise",
    'options'      => onboarding_process()::getAvailableEnterprises(),
    'required'    => false,
    'text'       => __('addworking.user.onboarding_process._form.concern_domain'),
    'required'    =>  true
])
