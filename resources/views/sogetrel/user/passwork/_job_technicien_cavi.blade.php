<div class="row">
    <div class="col-md-12">
        <hr>
        <h3>{{ __('sogetrel.user.passwork._job_technicien_cavi.title') }}</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.technicien_cavi.network_parameters",
            'value'    => array_get($passwork->data, 'technicien_cavi.network_parameters'),
            'values'   => [1 => "Oui", 0 => "Non"],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_technicien_cavi.network_parameters') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.technicien_cavi.parameters_active_equipment",
            'value'    => array_get($passwork->data, 'technicien_cavi.parameters_active_equipment'),
            'values'   => [1 => "Oui", 0 => "Non"],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_technicien_cavi.parameters_active_equipment') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.technicien_cavi.installation_and_parameter_of_motiring_software",
            'value'    => array_get($passwork->data, 'technicien_cavi.installation_and_parameter_of_motiring_software'),
            'values'   => [1 => "Oui", 0 => "Non"],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_technicien_cavi.installation_and_parameter_of_motiring_software') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.technicien_cavi.post_of_cable_cpa",
            'value'    => array_get($passwork->data, 'technicien_cavi.post_of_cable_cpa'),
            'values'   => [1 => "Oui", 0 => "Non"],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_technicien_cavi.post_of_cable_cpa') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.technicien_cavi.terminals_cfa",
            'value'    => array_get($passwork->data, 'technicien_cavi.terminals_cfa'),
            'values'   => [1 => "Oui", 0 => "Non"],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_technicien_cavi.terminals_cfa') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.technicien_cavi.post_camera",
            'value'    => array_get($passwork->data, 'technicien_cavi.post_camera'),
            'values'   => [1 => "Oui", 0 => "Non"],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_technicien_cavi.post_camera') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.technicien_cavi.post_material",
            'value'    => array_get($passwork->data, 'technicien_cavi.post_material'),
            'values'   => [1 => "Oui", 0 => "Non"],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_technicien_cavi.post_material') }}
            @endslot
        @endcomponent
    </div>    
</div>
