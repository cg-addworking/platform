<div class="row">
    <div class="col-md-12">
        <hr>
        <h3>{{ __('sogetrel.user.passwork._job_cpe_technician.technician_intervation') }}</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'   => "select",
            'name'   => "passwork.data.cpe_technician.level",
            'value'  => array_get($passwork->data, 'cpe_technician.level'),
            'values' => [
                'beginner'  => __('sogetrel.user.passwork._job_cpe_technician.beginner'),
                'confirmed' => __('sogetrel.user.passwork._job_cpe_technician.confirmed'),
                'expert'    => __('sogetrel.user.passwork._job_cpe_technician.expert'),
            ]
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_cpe_technician.label_1') }}
            @endslot

            @slot('help')
                {{ __('sogetrel.user.passwork._job_cpe_technician.help_1') }}
                {{ __('sogetrel.user.passwork._job_cpe_technician.help_2') }}
                {{ __('sogetrel.user.passwork._job_cpe_technician.help_3') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.cpe_technician.installation_rules_commissioning",
            'value'    => array_get($passwork->data, 'cpe_technician.installation_rules_commissioning'),
            'values'   => [1 => "Oui", 0 => "Non"],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_cpe_technician.label_2') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.cpe_technician.wiring_installation_commissioning",
            'value'    => array_get($passwork->data, 'cpe_technician.wiring_installation_commissioning'),
            'values'   => [1 => "Oui", 0 => "Non"],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_cpe_technician.label_3') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.cpe_technician.measurements_with_specific_devices",
            'value'    => array_get($passwork->data, 'cpe_technician.measurements_with_specific_devices'),
            'values'   => [1 => "Oui", 0 => "Non"],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_cpe_technician.label_4') }}
            @endslot
        @endcomponent
    </div>
</div>
