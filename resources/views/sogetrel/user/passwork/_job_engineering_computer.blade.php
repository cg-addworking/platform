<div class="row">
    <div class="col-md-12">
        <hr>
        <h3>{{ __('sogetrel.user.passwork._job_engineering_computer.title') }}</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.engineering_computer.installation_and_maintenance_operations",
            'value'    => array_get($passwork->data, 'engineering_computer.installation_and_maintenance_operations'),
            'values'   => [1 => "Oui", 0 => "Non"],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_engineering_computer.installation_and_maintenance_operations') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.engineering_computer.diagnosis_and_troubleshooting",
            'value'    => array_get($passwork->data, 'engineering_computer.diagnosis_and_troubleshooting'),
            'values'   => [1 => "Oui", 0 => "Non"],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_engineering_computer.diagnosis_and_troubleshooting') }}
            @endslot
        @endcomponent
    </div>
</div>
