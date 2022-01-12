<div class="row">
    <div class="col-md-12">
        <hr>
        <h3>{{ __('sogetrel.user.passwork._job_optical_network_maintenance.title') }}</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.optical_network_maintenance.network_setting",
            'value'    => array_get($passwork->data, 'optical_network_maintenance.network_setting'),
            'values'   => [1 => __('sogetrel.user.passwork._job_optical_network_maintenance.yes'), 0 => __('sogetrel.user.passwork._job_optical_network_maintenance.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_optical_network_maintenance.label_1') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.optical_network_maintenance.configuration_of_active_equipment",
            'value'    => array_get($passwork->data, 'optical_network_maintenance.configuration_of_active_equipment'),
            'values'   => [1 => __('sogetrel.user.passwork._job_optical_network_maintenance.yes'), 0 => __('sogetrel.user.passwork._job_optical_network_maintenance.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_optical_network_maintenance.label_2') }}
            @endslot
        @endcomponent
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @component('components.form.group', [
            'type'     => "select",
            'name'     => "passwork.data.optical_network_maintenance.configuration_of_the_physical_medium",
            'value'    => array_get($passwork->data, 'optical_network_maintenance.configuration_of_the_physical_medium'),
            'values'   => [1 => __('sogetrel.user.passwork._job_optical_network_maintenance.yes'), 0 => __('sogetrel.user.passwork._job_optical_network_maintenance.no')],
        ])
            @slot('label')
                {{ __('sogetrel.user.passwork._job_optical_network_maintenance.label_3') }}
            @endslot
        @endcomponent
    </div>
</div>
